<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\ProductOrderSpecification;
use App\Models\ShippingDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $items = Cart::instance('cart')->content();
        return view('cart', compact('products', 'items'));
    }
    public function add_to_cart(Request $request)
    {
        $product = Product::with('specifications')->find($request->id);

        if (!$product) {
            return redirect()->back()->withErrors('The product does not exist.');
        }

        $price = $request->price ?? 0.00;

        $specifications = $product->specifications->map(function ($spec) {
            return [
                'name' => $spec->name,
                'title' => $spec->title,
                'paragraphs' => $spec->paragraphs,
                'images' => is_string($spec->images) ? json_decode($spec->images, true) : $spec->images,
            ];
        })->toArray();

        // Generate a unique identifier for this cart item (even if it's the same product)
        $uniqueIdentifier = uniqid();

        Cart::instance('cart')->add([
            'id' => $request->id,
            'name' => $product->name,
            'qty' => $request->quantity,
            'price' => $price,
            'options' => [
                'unique_key' => $uniqueIdentifier, // Force a unique option to make the item distinct
                'description' => $product->description,
                'stock_status' => $product->stock_status,
                'featured' => $product->featured,
                'specifications' => $specifications,
                'status' => $product->status,
                'companies_responsibilities' => $product->companies_responsibilities,
                'customers_responsibilities' => $product->customers_responsibilities,
            ],
        ])->associate('App\Models\Product');
        Log::info(Cart::instance('cart')->content());
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }



    public function duplicateItem($rowId)
    {
        $item = Cart::instance('cart')->get($rowId);

        if (!$item) {
            return redirect()->back()->withErrors('The item does not exist in the cart.');
        }

        // إنشاء Row ID فريد للمنتج الجديد
        $uniqueRowId = uniqid($item->id . '_');

        Cart::instance('cart')->add([
            'id' => $item->id,
            'rowId' => $uniqueRowId,

            'name' => $item->name,
            'qty' => $item->qty,
            'price' => $item->price,
            'options' => array_merge($item->options->toArray(), ['unique_key' => $uniqueRowId]),
        ]);

        return redirect()->back()->with('success', 'Product duplicated successfully!');
    }


    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = max($product->qty - 1, 1); // Prevents quantity from dropping below 1
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }

    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    public function calculateDiscount()
    {
        $discount = 0;

        if (Session::has('coupon')) {
            $discount = Session::get('coupon')['type'] == 'fixed' ?
                Session::get('coupon')['value'] : (Cart::instance('cart')->subtotal() * Session::get('coupon')['value']) / 100;
        }

        $subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $discount;
        $totalAfterDiscount = $subtotalAfterDiscount;

        Session::put('discounts', [
            'discount' => number_format($discount, 2, '.', ''),
            'subtotal' => number_format($subtotalAfterDiscount, 2, '.', ''),
            'tax' => 0,
            'total' => number_format($totalAfterDiscount, 2, '.', '')
        ]);
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();
        return view('checkout', compact('address'));
    }

    public function place_an_order(Request $request)
    {
        $user_id = Auth::user()->id;

        $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'country' => 'required',
        ]);



        // Save the address
        $address = new Address();
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->email = $request->email;

        $address->country = $request->country;
        $address->user_id = $user_id;
        $address->isdefault = false;
        $address->save();

        return redirect()->route('shop.index');
    }

    public function setAmountforCheckout()
    {
        if (!Cart::instance('cart')->content()->count() > 0) {
            Session::forget('checkout');
            return;
        }

        // تنظيف القيم وإزالة الفواصل
        $cartTotal = str_replace(',', '', Cart::instance('cart')->subtotal());

        $subtotal = floatval($cartTotal);
        $discount = Session::has('discounts') ? floatval(Session::get('discounts')['discount']) : 0;
        $total = $subtotal - $discount; // حساب المجموع النهائي

        // طباعة القيم للتأكد


        // تخزين القيم بعد التحقق
        Session::put('checkout', [
            'discount' => $discount,
            'subtotal' => $subtotal,
            'tax' => 0,
            'total' => $total
        ]);
    }





    private function generateReferenceCode()
    {
        // الحصول على تاريخ اليوم
        $date = Carbon::now()->format('ymd');

        // تحديد كود نوع المنتج بناءً على الاسم أو معايير أخرى
        //$productType = $this->getProductCodeByName($request->name);

        // الحصول على كود الفئة من قاعدة البيانات بناءً على الـ category_id
        // الحصول على الكود من المنتج
        foreach (Cart::instance('cart')->content() as $item) {
            $product = Product::find($item->id);


            $categoryCode = $product->code;
        }
        // الحصول على رقم الموظف
        $employeeId = str_pad(Auth::user()->id, 3, '0', STR_PAD_LEFT);

        // تحديد الرقم التسلسلي
        $sequence = Order::whereDate('created_at', Carbon::today())->count() + 1;
        $sequenceFormatted = str_pad($sequence, 3, '0', STR_PAD_LEFT);

        // صياغة الريفرنس كود الأساسي ليشمل كود الفئة
        $baseReferenceCode = "{$date}-{$categoryCode}-{$employeeId}-{$sequenceFormatted}";
        $referenceCode = $baseReferenceCode;

        $counter = 1;

        // التأكد من أن الكود فريد
        while (Order::where('reference_code', $referenceCode)->exists()) {
            $referenceCode = "{$baseReferenceCode}-{$counter}";
            $counter++;
        }

        return $referenceCode;
    }



    public function order(Request $request)
    {
        $user_id = Auth::user()->id;
        $order = Order::where('user_id', $user_id)->latest()->first(); // جلب آخر طلب
        $address = Address::query()->where('user_id', $user_id)->latest()->first();

        // جلب العناصر الموجودة في الكارت
        $cartItems = Cart::instance('cart')->content();

        $companiesResponsibilities = [];
        $customersResponsibilities = [];

        foreach ($cartItems as $item) {
            $product = Product::query()->find($item->id);

            if ($product) {
                $companiesResponsibilities[] = $product->companies_responsibilities;
                $customersResponsibilities[] = $product->customers_responsibilities;
            }
        }



        return view('order', compact('order', 'cartItems', 'address', 'companiesResponsibilities', 'customersResponsibilities'));
    }




    public function submitOrder(Request $request)
    {

        $user_id = Auth::user()->id;
        $old_order_id = Order::query()->where('user_id', $user_id)->latest()->first()->id;
        $address = Address::query()->where('user_id', $user_id)->latest()->first();
        $request->validate([
            'extra' => 'required',
            'billing_info' => 'required',
            // 'images' => 'nullable|array',
            // 'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $uploadedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('orders/images', 'public');
                $uploadedImages[] = $path;
            }
        }

        // Save the order
        $order = new Order();
        $order->user_id = $user_id;

        $order->subtotal = 1;
        $order->total = 1;
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->email = $address->email;

        $order->country = $address->country;
        $order->extra = $request->extra;
        $order->billing_info = $request->billing_info;
        $order->images = $uploadedImages ? json_encode($uploadedImages) : null;
        $order->save();



        // Add the transaction
        Transaction::create([
            'user_id' => $user_id,
            'order_id' => $order->id,
            'mode' => $request->mode ?? 'cod',
            'status' => 'pending',
        ]);

        // Extract responsibilities from request
        $customerResponsibilities = $request->input('customer_responsibilities', []);
        $companyResponsibilities = $request->input('company_responsibilities', []);



        // Add order items
        foreach (Cart::instance('cart')->content() as $item) {


            $product = Product::find($item->id);

            // Save the order item
            $orderItem = OrderItem::create([
                'product_id' => $item->id,
                'order_id' => $order->id,
                'price' => $item->price,
                'product_name' => $product->name,
                'quantity' => $item->qty,
                'description' => $item->options['description'] ?? null,
                'custom_specifications' => json_encode($item->options['specifications']), // Serialize the array
                'customers_responsibilities' => $customerResponsibilities[$item->id] ?? null,
                'companies_responsibilities' => $companyResponsibilities[$item->id] ?? null,
            ]);

            $orderItem->save();


            // Save product specifications for the current order item
            foreach ($item->options['specifications'] as $spec) {
                ProductOrderSpecification::create([
                    'name' => $spec['name'] ?? null,
                    'title' => $spec['title'] ?? null,
                    'paragraphs' => $spec['paragraphs'] ?? null,
                    'images' => isset($spec['images']) ? json_encode($spec['images']) : null,
                    'order_item_id' => $orderItem->id,
                    'product_id' => $item->id,
                ]);
            }
        }

        $this->setAmountforCheckout();

        $order->reference_code = $this->generateReferenceCode();
        $order->subtotal = number_format(floatval(Session::get('checkout')['subtotal']), 2, '.', ''); // حفظ الرقم مع تنسيق للأرقام العشرية
        $order->total = floatval(Session::get('checkout')['total']); // Use float directly
        $order->discount = Session::get('checkout')['discount'];
        $order->tax = Session::get('checkout')['tax'];
        $order->save();

        Session::put('old_order_id', $old_order_id);
        Session::put('order_id', $order->id);

        return redirect()->route('cart.order.confirmation');
    }

    public function order_confirmation()
    {
        if (Session::has('order_id')) {
            $order = Order::find(Session::get('order_id'));

            if (!$order) {
                return redirect()->route('shop.index')->with('error', 'Order not found');
            }

            // Fetch order items
            $orderItems = OrderItem::where('order_id', $order->id)->get();

            // Attach specifications and descriptions to order items
            foreach ($orderItems as $item) {
                // Fetch the specifications directly from the `custom_specifications` column
                $item->specifications = json_decode($item->custom_specifications, true);
            }

            $shipping_type = ShippingDetail::query()->where('order_id', Session::get('old_order_id'))->first();
            // Clear session data
            Session::forget(['checkout', 'coupon', 'discounts']);

            return view('order-confirmation', compact('order', 'orderItems', 'shipping_type'));
        }

        return redirect()->route('shop.index');
    }










    public function update_price(Request $request, $rowId)
    {
        // التحقق من صحة المدخلات
        $request->validate([
            'price' => 'required|numeric|min:0'
        ]);

        // الحصول على المنتج في السلة
        $product = Cart::instance('cart')->get($rowId);

        // تحديث السعر
        Cart::instance('cart')->update($rowId, [
            'price' => $request->price,  // تحديث السعر
            'qty' => $product->qty       // الحفاظ على الكمية كما هي
        ]);

        // العودة إلى الصفحة السابقة مع رسالة النجاح
        return redirect()->back()->with('success', 'Price updated successfully!');
    }
    public function update_qty(Request $request, $rowId)
    {
        // التحقق من صحة الكمية
        $validated = $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        // استرجاع العنصر من السلة
        $item = Cart::instance('cart')->get($rowId);

        if (!$item) {
            return redirect()->route('shop.index')->with('error', 'Item not found in the cart');
        }

        // تحديث الكمية في السلة
        Cart::instance('cart')->update($rowId, [
            'qty' => $validated['qty'],
        ]);

        return redirect()->route('shop.index')->with('success', 'Quantity updated successfully!');
    }


    // في CartController
    public function edit_cart_item($rowId)
    {
        // استرجاع العنصر من السلة
        $item = Cart::instance('cart')->get($rowId);

        if (!$item) {
            return redirect()->route('shop.index')->with('error', 'Item not found in the cart');
        }
        // عرض نموذج التعديل
        return view('cart.edit', compact('item'));
    }

    public function update_cart_item(Request $request, $rowId)
    {
        // استرجاع العنصر من السلة
        $item = Cart::instance('cart')->get($rowId);

        if (!$item) {
            return redirect()->route('shop.index')->with('error', 'Item not found in the cart');
        }

        // التحقق من صحة المدخلات (الكمية والسعر)
        $validated = $request->validate([
            'qty' => 'required|integer|min:1',  // التحقق من الكمية
            'price' => 'required|numeric|min:0',  // التحقق من السعر
            'description' => 'nullable|string',  // التحقق من الوصف
            'companies_responsibilities' => 'nullable|string',  // التحقق من الوصف
            'customers_responsibilities' => 'nullable|string',  // التحقق من الوصف
        ]);

        $specifications = $request->specifications;

        if ($specifications && is_array($specifications)) {
            foreach ($specifications as &$spec) {
                if (isset($spec['images']) && is_array($spec['images'])) {
                    $imagePaths = [];
                    foreach ($spec['images'] as $image) {
                        if ($image instanceof \Illuminate\Http\UploadedFile) {
                            $imagePaths[] = $image->store('specifications', 'public');
                        }
                    }
                    $spec['images'] = $imagePaths;
                }
            }
        }

        // احتفظ بالقيم القديمة إذا لم يتم إرسالها في الطلب
        $updatedOptions = array_merge((array)$item->options, [
            'specifications' => $specifications ?? $item->options['specifications'],
            'description' => $validated['description'] ?? $item->options['description'],
            'companies_responsibilities' => $validated['companies_responsibilities'] ?? $item->options['companies_responsibilities'],
            'customers_responsibilities' => $validated['customers_responsibilities'] ?? $item->options['customers_responsibilities'],
        ]);

        Cart::instance('cart')->update($rowId, [
            'qty' => $validated['qty'],
            'rowId' => $rowId,
            'price' => $validated['price'],
            'options' => $updatedOptions,
        ]);

        return redirect()->route('shop.index')->with('success', 'Cart item updated successfully!');
    }



    private function encodeImages($images)
    {
        if (is_array($images)) {
            return json_encode($images);
        }

        return $images;
    }


    public function base64EncodeImage($imagePath)
    {
        if (file_exists($imagePath)) {
            $imageData = file_get_contents($imagePath);
            return 'data:image/png;base64,' . base64_encode($imageData);
        }
        return null;
    }

    /*public function downloadPdf($orderId)
    {
        $order = Order::findOrFail($orderId);

        $orderItems = OrderItem::with('product.specifications')->where('order_id', $order->id)->get();

        $pdf = PDF::loadView('orders.pdf', [
            'order' => $order,
            'orderItems' => $orderItems,
            'base64EncodeImage' => [$this, 'base64EncodeImage']
        ]);


        return $pdf->download('order_' . $order->id . '.pdf');
    }*/

    public function base64EncodeImageA($image)
    {
        // مسار الصورة الكامل
        $fullPath = public_path('storage/' . $image);

        // تحقق إذا كانت الصورة موجودة
        if (file_exists($fullPath)) {
            $imageData = file_get_contents($fullPath);
            return 'data:image/' . pathinfo($fullPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode($imageData);
        }

        // إذا لم تكن الصورة موجودة
        return null;
    }

    public function downloadPdf($orderId)
    {
        // Retrieve the order
        $order = Order::findOrFail($orderId);

        // Fetch order items with product details
        $orderItems = OrderItem::with(['product' => function ($query) {
            $query->select('id', 'name',);
        }])->where('order_id', $order->id)->get();

        // Attach specifications to order items
        foreach ($orderItems as $item) {
            $item->specifications = json_decode($item->custom_specifications, true);
        }

        $shipping_type = ShippingDetail::query()->where('order_id', Session::get('old_order_id'))->first();


        // Generate the PDF
        $pdf = PDF::loadView('orders.pdf', [
            'order' => $order,
            'shipping_type' => $shipping_type,
            'orderItems' => $orderItems,
            'base64EncodeImageA' => [$this, 'base64EncodeImageA'], // Pass the image encoding function
        ]);

        Cart::instance('cart')->destroy();

        return $pdf->download('order_' . $order->id . '.pdf');
    }




    public function updateDescription($rowId, Request $request)
    {
        // التحقق من صحة المدخلات
        $request->validate([
            'description' => 'required|string|max:255'  // التحقق من الوصف
        ]);

        // الحصول على المنتج في السلة
        $product = Cart::instance('cart')->get($rowId);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found in cart.');
        }

        // الاحتفاظ بالقيم الحالية مع تحديث الوصف فقط
        $updatedOptions = $product->options->toArray();
        $updatedOptions['description'] = $request->description;

        // تحديث المنتج في السلة
        Cart::instance('cart')->update($rowId, [
            'options' => $updatedOptions,  // الاحتفاظ بالقيم القديمة مع تحديث الوصف فقط
            'qty' => $product->qty  // الحفاظ على الكمية كما هي
        ]);

        // العودة إلى الصفحة السابقة مع رسالة النجاح
        return redirect()->back()->with('success', 'Description updated successfully!');
    }
    public function updateShipping(Request $request)
    {
        // التحقق من صحة البيانات الواردة
        $request->validate([
            'shipping_type' => 'required|string',
            'shipping_cost' => 'required|numeric|min:0',
        ]);
    
        // تخزين بيانات الشحن في الـ session
        Session::put('shipping_type', $request->shipping_type);
        Session::put('shipping_cost', $request->shipping_cost);
    
        return response()->json(['success' => 'Shipping updated successfully']);
    }
    
    public function store(Request $request)
    {
        // جلب المستخدم الحالي
        $user_id = Auth::user()->id;
    
        // جلب آخر طلب للمستخدم
        $order = Order::where('user_id', $user_id)->latest()->first();
    
        if (!$order) {
            // في حال ما في طلب، يمكنك إعطاء رد مناسب
            return redirect()->back()->withErrors(['message' => 'No orders found for the user']);
        }
    
        // التحقق من صحة البيانات
        $request->validate([
            'shipping_type' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'shipping_cost' => 'required|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
        ]);
    
        // تحديث أو إنشاء تفاصيل الشحن
        $shipping_details = ShippingDetail::updateOrCreate([
            'order_id' => $order->id,
        ], [
            'shipping_type' => $request->shipping_type,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'shipping_cost' => $request->shipping_cost,
            'total_cost' => $request->total_cost,
        ]);
    
        return redirect()->back()->with('shipping_details', $shipping_details);
    }
    
}
