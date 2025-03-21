<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;
use App\Models\ProductOrderSpecification;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
    public function orders()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('user.orders', compact('orders'));
    }

    public function order_details($order_id)
    {
        $order = Order::where('user_id', Auth::user()->id)
            ->where('id', $order_id)
            ->first();

        if ($order) {
            $orderItems = OrderItem::where('order_id', $order->id)
                ->orderBy('id')
                ->paginate(12);

            $transaction = Transaction::where('order_id', $order->id)
                ->first();
 
            return view('user.order-details', compact('order', 'orderItems', 'transaction' ));
        } else {
            return redirect()->route('login');
        }


    }

    public function order_cancel(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = "canceled";
        $order->canceled_date = Carbon::now();
        $order->save();
        return back()->with('status', "Order has been cancelled successfully!");
    }


    public function editOrder($order_id)
    {
        $order = Order::findOrFail($order_id);
        $orderItems = $order->orderItems;
        return view('user.order-edit', compact('order', 'orderItems'));
    }


    public function updateOrder(Request $request, $order_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'subtotal' => 'required|numeric|min:0',
'status' => 'required|string|in:ordered,delivered,canceled,offer_sent,offer_signed,downpayment_received,in_production,pending_final_payment,final_payment_received,shipped,cancelled',
            'note' => 'nullable|string',
            'order_images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'items.*.quantity' => 'required|integer|min:1',
             'items.*.specifications.*.paragraphs' => 'nullable|string',
            'items.*.specifications.*.images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $order = Order::findOrFail($order_id);

        $order->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'subtotal' => $request->input('subtotal'),
            'status' => $request->input('status'),
            'note' => $request->input('note'),
            'extra' => $request->input('extra'),
        ]);

        $order->save();
        if ($request->hasFile('order_images')) {
            $uploadedImages = [];
            foreach ($request->file('order_images') as $image) {
                $path = $image->store('orders/images', 'public');
                $uploadedImages[] = $path;
            }
            $existingImages = json_decode($order->images, true) ?? [];
            $order->images = json_encode(array_merge($existingImages, $uploadedImages));
            $order->save();
        }

        foreach ($request->input('items') as $itemId => $itemData) {
            $item = OrderItem::findOrFail($itemId);

            $item->update([
                'quantity' => $itemData['quantity'],
                'custom_specifications' => json_encode($itemData['specifications']),
            ]);

            foreach ($itemData['specifications'] as $specIndex => $specData) {
                $specId = $specData['id'] ?? null;

                if ($specId) {
                    $spec = ProductOrderSpecification::findOrFail($specId);

                    $spec->name = $specData['name'];
                     $spec->paragraphs = $specData['paragraphs'];

                    if ($request->hasFile("items.$itemId.specifications.$specIndex.images")) {
                        $uploadedSpecImages = [];
                        foreach ($request->file("items.$itemId.specifications.$specIndex.images") as $image) {
                            $path = $image->store('orders/specifications', 'public');
                            $uploadedSpecImages[] = $path;
                        }

                        $existingSpecImages = json_decode($spec->images, true) ?? [];
                        $spec->images = json_encode(array_merge($existingSpecImages, $uploadedSpecImages));
                    }

                    $spec->save();
                }
            }
        }

         return redirect()->route('user.orders')->with('success', 'Order updated successfully.');

    }


    public function deleteOrderImage(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);

        $imageToDelete = $request->input('image');
        $images = json_decode($order->images, true);

        if (($key = array_search($imageToDelete, $images)) !== false) {
            unset($images[$key]);
            Storage::disk('public')->delete($imageToDelete);
        }

        $order->images = json_encode(array_values($images));
        $order->save();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
    }

    public function deleteSpecificationImage(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
            'spec_id' => 'required|integer|exists:product_order_specifications,id',
        ]);

        $spec = ProductOrderSpecification::findOrFail($request->spec_id);
        $images = json_decode($spec->images, true);

        if (($key = array_search($request->image, $images)) !== false) {
            unset($images[$key]);
            $spec->images = json_encode(array_values($images));
            $spec->save();

            Storage::disk('public')->delete($request->image);

            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
    }
    public function exportExcel()
    {
        $orders = Order::with('orderItems')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // تعيين رؤوس الأعمدة
        $sheet->setCellValue('A1', 'ID Number');
        $sheet->setCellValue('B1', 'Client Name');
        $sheet->setCellValue('C1', 'Phone');
        $sheet->setCellValue('D1', 'Total');
        $sheet->setCellValue('E1', 'Status');
        $sheet->setCellValue('F1', 'Order Date');
        $sheet->setCellValue('G1', 'Total Items');
        $sheet->setCellValue('H1', 'Notes');

        $row = 2;
        foreach ($orders as $order) {
            $sheet->setCellValue('A' . $row, $order->id);
            $sheet->setCellValue('B' . $row, $order->name);
            $sheet->setCellValueExplicit('C' . $row, $order->phone, DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $row, $order->subtotal);
            $sheet->setCellValue('E' . $row, ucfirst(str_replace('_', ' ', $order->status)));
            $sheet->setCellValue('F' . $row, $order->created_at);
            $sheet->setCellValue('G' . $row, $order->orderItems->count());
            $sheet->setCellValue('H' . $row, $order->note);
            $row++;
        }

        $filename = "orders_" . date('Y-m-d') . ".xlsx";
        $writer = new Xlsx($spreadsheet);
        
        // إرسال الملف للتنزيل
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $writer->save('php://output');
    }
 
    

}
