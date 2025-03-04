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
            'items.*.specifications.*.title' => 'nullable|string|max:255',
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
                    $spec->title = $specData['title'];
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

        return redirect()->back()->with('success', 'Order updated successfully.');
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
    
         $filename = "orders_" . date('Y-m-d') . ".xls";
    
         $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                .badge { padding: 5px; border-radius: 5px; color: white; }
                .bg-success { background-color: green; }
                .bg-danger { background-color: red; }
                .bg-info { background-color: skyblue; }
                .bg-primary { background-color: blue; }
                .bg-secondary { background-color: gray; }
                .bg-warning { background-color: orange; }
                .bg-dark { background-color: black; }
            </style>
        </head>
        <body>
            <table border="1" style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr>
                        <th>ID Number</th>
                        <th>Client\'s Name</th>
                        <th>Phone</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Total Items</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>';
    
                foreach ($orders as $order) {
                    $statusClass = match ($order->status) {
                        'delivered' => 'bg-success',
                        'canceled', 'cancelled' => 'bg-danger',
                        'offer_sent' => 'bg-info',
                        'offer_signed' => 'bg-primary',
                        'downpayment_received' => 'bg-secondary',
                        'in_production' => 'bg-warning',
                        'pending_final_payment' => 'bg-dark',
                        'final_payment_received' => 'bg-success',
                        'shipped' => 'bg-info',
                        default => 'bg-warning',
                    };
                
                    $html .= "<tr>
                        <td>{$order->id}</td>
                        <td>{$order->name}</td>
                        <td>{$order->phone}</td>
                        <td>\${$order->subtotal}</td>
                        <td><span class='badge {$statusClass}'>" . ucfirst(str_replace('_', ' ', $order->status)) . "</span></td>
                        <td>{$order->created_at}</td>
                        <td>" . $order->orderItems->count() . "</td>
                        <td>" . ($order->note) . "</td>
                    </tr>";
                }
                
        $html .= '</tbody></table></body></html>';
    
         $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Cache-Control" => "no-cache, no-store, must-revalidate",
            "Pragma" => "no-cache",
            "Expires" => "0",
        ];
    
         return response($html, 200, $headers);
    }
    

}
