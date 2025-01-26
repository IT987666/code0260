<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query('size') ? $request->query('size') : 12;
        $o_column = "";
        $o_order = "";
        $order = $request->query('order') ? $request->query('order') : -1;
    
        // ترتيب النتائج حسب الخيارات
        switch ($order) {
            case 1:
                $o_column = 'created_at';
                $o_order = 'DESC';
                break;
            case 2:
                $o_column = 'created_at';
                $o_order = 'ASC';
                break;
            case 3:
                $o_column = 'sale_price';
                $o_order = 'ASC';
                break;
            case 4:
                $o_column = 'sale_price';
                $o_order = 'DESC';
                break;
            default:
                $o_column = 'id';
                $o_order = 'DESC';
        }
    
        // جلب قائمة المنتجات
        $products = Product::orderBy($o_column, $o_order)->paginate($size);
    
        // جلب بيانات السلة
        $items = Cart::instance('cart')->content();
    
        // تمرير البيانات إلى العرض
        return view('shop', compact('products', 'size', 'order', 'items'));
    }
    


    public function product_details($product_slug)
    {
        // استعلام المنتج بناءً على الـ slug مع تحميل المواصفات
        $product = Product::with('specifications')
            ->where('slug', $product_slug)
            ->first();

        // الحصول على منتجات أخرى مشابهة
        $rproducts = Product::where('slug', '<>', $product_slug)->get()->take(8);

        return view('details', compact('product', 'rproducts'));
    }
}
