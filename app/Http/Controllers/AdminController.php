<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use App\Models\ProductSpecification;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public $timestamps = false;

    public function index()
    {
        $sort = request('sort', 'desc'); // الافتراضي هو الأحدث أولًا
        $orders = Order::orderBy('created_at', $sort)->get()->take(10);


        $dashboardDatas = DB::select("
        SELECT
            SUM(total) AS TotalAmount,
            SUM(IF(status='ordered', total, 0)) AS TotalOrderedAmount,
            SUM(IF(status='delivered', total, 0)) AS TotalDeliveredAmount,
            SUM(IF(status='canceled', total, 0)) AS TotalCanceledAmount,
            COUNT(*) AS Total,
            SUM(IF(status='ordered', 1, 0)) AS TotalOrdered,
            SUM(IF(status='delivered', 1, 0)) AS TotalDelivered,
            SUM(IF(status='canceled', 1, 0)) AS TotalCanceled

        FROM orders
    ");
        $monthlyDatas = DB::select("SELECT M.id As MonthNo, M.name As MonthName,
    IFNULL(D.TotalAmount,0) As TotalAmount,
    IFNULL(D.TotalOrderedAmount,0) As TotalOrderedAmount,
    IFNULL(D.TotalDeliveredAmount,0) As TotalDeliveredAmount,
    IFNULL(D.TotalCanceledAmount,0) As TotalCanceledAmount FROM month_names M
    LEFT JOIN (Select DATE_FORMAT(created_at, '%b') As MonthName,
    MONTH(created_at) As MonthNo,
    sum(total) As TotalAmount,
    sum(if(status='ordered', total, 0)) As TotalorderedAmount,
    sum(if(status='delivered', total, 0)) As TotalDeliveredAmount,
    sum(if(status='canceled', total,0)) As TotalCanceledAmount
    From orders WHERE YEAR(created_at)=YEAR (NOW()) GROUP BY YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
    Order By MONTH(created_at)) D On D.MonthNo=M.id");

        $AmountM = implode(',', collect($monthlyDatas)->pluck('TotalAmount')->toArray());
        $OrderedAmountM = implode(',', collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
        $DeliveredAmountM = implode(',', collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
        $CanceledAmountM = implode(',', collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());
        $TotalAmount = collect($monthlyDatas)->sum('TotalAmount');
        $TotalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
        $TotalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');

        return view('admin.index', compact(
            'orders',
            'dashboardDatas',
            'AmountM',
            'OrderedAmountM',
            'DeliveredAmountM',
            'CanceledAmountM',
            'TotalAmount',
            'TotalOrderedAmount',
            'TotalDeliveredAmount',
            'TotalCanceledAmount'
        ));
    }


    public function products()

    {

        $products = Product::orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.products', compact('products'));
    }

    public function product_add()

    {
        $product = Product::orderBy('created_at', 'DESC')->first();

        return view('admin.product-add', compact('product'));
    }



    public function product_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'stock_status' => 'required|in:active,inactive',
            'description' => 'nullable',
            'companies_responsibilities' => 'nullable',
            'customers_responsibilities' => 'nullable',
            'code' => 'required|unique:products,code', // ضمان تفرد الكود
            'featured' => 'nullable|boolean',
        ]);

        // إيجاد أصغر ID متاح
        $minAvailableId = DB::table('products')
            ->select(DB::raw('COALESCE(MIN(id + 1), 1) as id'))
            ->whereRaw('id + 1 NOT IN (SELECT id FROM products)')
            ->value('id');

        // إنشاء المنتج
        $product = new Product();
        $product->id = $minAvailableId;
        $product->name = $request->name;
        $product->companies_responsibilities = $request->companies_responsibilities;
        $product->customers_responsibilities = $request->customers_responsibilities;
        $product->code = $request->code;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured ?? false;
        $product->adding_date = now();
        $product->save();

        // حفظ المواصفات
        if ($request->has('specifications')) {
            foreach ($request->specifications as $spec) {
                $specification = new ProductSpecification();
                $specification->product_id = $product->id;
                $specification->name = $spec['name'];
                $specification->title = $spec['title'] ?? null;

                // حفظ الجمل الموصوفة
                if (isset($spec['paragraphs'])) {
                    $specification->paragraphs = $spec['paragraphs'];
                }

                // حفظ الصور
                $images = [];
                if (isset($spec['images'])) {
                    foreach ($spec['images'] as $image) {
                        $imageName = $image->store('products/specifications', 'public'); // تخزين الصورة في storage/app/public/products/specifications
                        $images[] = $imageName; // حفظ المسار بالنسبة لـ storage
                    }
                }
                $specification->images = json_encode($images);
                $specification->save();
            }
        }

        return redirect()->route('admin.products')->with('status', 'Product added successfully');
    }



    public function product_edit($id)
    {
        $product = Product::find($id);
        $specifications = ProductSpecification::where('product_id', $id)->get();

        return view('admin.product-edit', compact('product', 'specifications'));
    }
    public function product_update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stock_status' => 'required|in:active,inactive',
            'description' => 'nullable',
            'companies_responsibilities' => 'nullable',
            'customers_responsibilities' => 'nullable',
            'code' => 'nullable',  
            'featured' => 'nullable|boolean',
            'specifications.*.id' => 'nullable|integer|exists:product_specifications,id',
            'specifications.*.name' => 'required|string|max:255',
            'specifications.*.title' => 'nullable|string|max:255',
            'specifications.*.paragraphs' => 'nullable',
            'specifications.*.images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specifications.*.existing_images.*' => 'nullable|string', // for existing images
        ]);

        // Update the product
        $product = Product::findOrFail($request->id);
        $product->name = $request->name;
        $product->companies_responsibilities = $request->companies_responsibilities;
        $product->customers_responsibilities = $request->customers_responsibilities;
        $product->code = $request->code;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured ?? false;
        $product->save();

        // Update specifications
        $specifications = $request->specifications;
        $updatedSpecIds = [];

        if ($specifications && is_array($specifications)) {
            foreach ($specifications as $id => $spec) {
                if (is_numeric($id)) {
                    $specification = ProductSpecification::findOrFail($id);
                } else {
                    $specification = new ProductSpecification();
                    $specification->product_id = $product->id;
                }

                $specification->name = $spec['name'];
                $specification->title = $spec['title'] ?? null;
                $specification->paragraphs = $spec['paragraphs'] ?? null;

                // Handle images
                $existingImages = $specification->images ? json_decode($specification->images, true) : [];
                $newImages = [];
                $imagesToDelete = [];

                if (isset($spec['images']) && is_array($spec['images'])) {
                    // Upload new images
                    foreach ($spec['images'] as $image) {
                        if ($image instanceof \Illuminate\Http\UploadedFile) {
                            $newImages[] = $image->store('products/specifications', 'public');
                        }
                    }
                }

                // Check for images that are marked for deletion
                if (isset($spec['existing_images']) && is_array($spec['existing_images'])) {
                    // Keep only the images that are still marked as existing and delete the rest
                    $imagesToDelete = array_diff($existingImages, $spec['existing_images']);
                } else {
                    // If no existing images are provided, delete all
                    $imagesToDelete = $existingImages;
                }

                // Delete images that are no longer needed
                foreach ($imagesToDelete as $image) {
                    // Delete from the storage
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }


                // Merge the new images with the existing ones, keeping only the ones not deleted
                $specification->images = json_encode(array_merge(array_diff($existingImages, $imagesToDelete), $newImages));

                $specification->save();
                $updatedSpecIds[] = $specification->id;
            }
        }

        // Optionally, delete specifications not included in the updated IDs
        ProductSpecification::where('product_id', $product->id)
            ->whereNotIn('id', $updatedSpecIds)
            ->delete();
            return redirect()->route('admin.products')->with('success', 'Product updated successfully');

     }






    public function product_delete($id)
    {
        $product = Product::find($id);
        if (File::exists(public_path('uploads/products') . '/' . $product->image)) {
            File::delete(public_path('uploads/products') . '/' . $product->image);
        }
        if (File::exists(public_path('uploads/products/thumbnails') . '/' . $product->image)) {
            File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
        }
        foreach (explode(',', $product->images) as $ofile) {
            if (File::exists(public_path('uploads/products') . '/' . $ofile)) {
                File::delete(public_path('uploads/products') . '/' . $ofile);
            }
            if (File::exists(public_path('uploads/products/thumbnails') . '/' . $ofile)) {
                File::delete(public_path('uploads/products/thumbnails') . '/' . $ofile);
            }
        }
        $product->delete();
        return redirect()->route('admin.products')->with('status', 'Product has been deleted successfully!');
    }


    public function orders()
    {
        $sort = request('sort', 'desc'); // الافتراضي هو الأحدث أولًا
        $orders = Order::orderBy('created_at', $sort)->paginate(10000000);


        return view('admin.orders', compact('orders')); // تمرير المتغير إلى الـ View
    }

    public function updateNote(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'note' => 'nullable|string',
        ]);

        $order = Order::findOrFail($request->order_id);
        $order->note = $request->note;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Note updated successfully.']);
    }



    public function order_details($order_id)
    {
        $order = Order::find($order_id);

        $orderItems = OrderItem::where('order_id', $order_id)
            ->orderBy('id')
            ->paginate(12);
        // جلب عناصر الطلب مع مواصفات المنتج


        return view('admin.order-details', compact('order', 'orderItems'));
    }


    public function update_order_status(Request $request)
    {
        // Find the order by ID
        $order = Order::find($request->order_id);

        // Check if the order exists
        if (!$order) {
            return back()->withErrors(['status' => 'Order not found.']);
        }

        // Update order status
        $order->status = $request->order_status;

        // Set the respective dates based on the status
        if ($request->order_status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } elseif ($request->order_status == 'canceled') {
            $order->canceled_date = Carbon::now();
        }

        // Save the updated order
        $order->save();

        // If the order is delivered, update the transaction status
        if ($request->order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            if ($transaction) {
                $transaction->status = 'approved';
                $transaction->save();
            }
        }
        return redirect()->route('admin.orders')->with('status', 'Status changed successfully!');

     }









    public function search(Request $request)
    {
        $query = $request->input('query');

        $results = Product::where('name', 'LIKE', "%{$query}%")->limit(50)->get();

        return response()->json($results);
    }



    public function search_order(Request $request)
    {
        $query = $request->input('query');

        // البحث عن الأوامر باستخدام اسم العميل فقط
        $results = Order::where('name', 'LIKE', "%{$query}%")
            ->limit(50)  // تحديد الحد الأقصى للنتائج
            ->get();

        return response()->json($results);  // إرجاع النتائج بتنسيق JSON
    }



    // دالة جديدة للحصول على كود نوع المنتج بناءً على الاسم


    public function exportPdf()
    {
        $orders = Order::with('orderItems')->get(); // جلب الطلبات مع المنتجات
         $pdf = Pdf::loadView('admin.pdf', compact('orders'))->setPaper('a4', 'landscape');

        return $pdf->download('orders_report.pdf'); // تحميل الـ PDF
    }


  
    public function order_delete($id)
    {
        $order = Order::find($id);
    
        if ($order) {
             
             $order->delete();
            return redirect()->route('admin.orders')->with('status', 'Order has been deleted successfully!');
        }
    
        return redirect()->route('admin.orders')->with('error', 'Order not found');
    }
    

}
