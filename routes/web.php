<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AuthAdmin;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Middleware\RedirectIfNotAuthenticated;

Auth::routes();
Route::delete('/order/{order_id}/image', [UserController::class, 'deleteOrderImage'])->name('order.image.delete');
Route::delete('/specification/image/delete', [UserController::class, 'deleteSpecificationImage'])->name('specification.image.delete');

Route::middleware([RedirectIfNotAuthenticated::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
});
Route::get('/manage-items', [ShopController::class, 'index'])->name('shop.index');
Route::get('/manage-item/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');



Route::get('/task-list', [CartController::class, 'index'])->name('cart.index');
Route::post('/task-list/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('/task-list/increase-quantity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.qty.increase');
Route::put('/task-list/decrease-quantity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.qty.decrease');
Route::put('/task-list/update-price/{rowId}', [CartController::class, 'update_price'])->name('cart.price.update');
Route::put('task-list/qty/update/{rowId}', [CartController::class, 'update_qty'])->name('cart.qty.update');
Route::post('/task-list/duplicate/{rowId}', [CartController::class, 'duplicateItem'])->name('cart.duplicate');

Route::delete('/task-list/remove/{rowId}', [CartController::class, 'remove_item'])->name('cart.item.remove');
Route::delete('/task-list/clear', [CartController::class, 'empty_cart'])->name('cart.empty');


// في ملف routes/web.php
Route::get('task-list/{rowId}/edit', [CartController::class, 'edit_cart_item'])->name('cart.edit');
Route::prefix('task-list')->group(function () {
    Route::put('update/{rowId}', [CartController::class, 'update_cart_item'])->name('cart.update');
    Route::put('specifications/update/{rowId}', [CartController::class, 'update_specifications'])->name('cart.specifications.update');
});

Route::get('/order/{orderId}/download-pdf', [CartController::class, 'downloadPdf'])->name('order.downloadPdf');

Route::put('/task-list/description/update/{rowId}', [CartController::class, 'updateDescription'])->name('cart.description.update');



Route::get('/submit-tasks', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/place-a-request', [CartController::class, 'place_an_order'])->name('cart.place.an.order');
Route::get('/request-confirmation', [CartController::class, 'order_confirmation'])->name('cart.order.confirmation');
Route::get('/order', [CartController::class, 'order'])->name('cart.order');
Route::post('/submit-order', [CartController::class, 'submitOrder'])->name('cart.place-order');

Route::get('/search', [HomeController::class, 'search'])->name('home.search');


Route::middleware(['auth'])->group(function () {

    Route::post('/admin/orders/update-note', [AdminController::class, 'updateNote'])->name('admin.orders.updateNote');


    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');

    Route::get('/account-orders', [UserController::class, 'orders'])->name('user.orders');

    Route::get('/user/order/edit/{order_id}', [UserController::class, 'editOrder'])->name('user.order.edit');
    Route::put('/user/order/update/{order_id}', [UserController::class, 'updateOrder'])->name('user.order.update');


    Route::get('/account-orders/{order_id}/details', [UserController::class, 'order_details'])->name('user.order.details');
    Route::put('/account-orders/cancel-order', [UserController::class, 'order_cancel'])->name('user.order.cancel');
});

Route::middleware(['auth', AuthAdmin::class])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])->name("admin.index");


    Route::post('/admin/generate-reference-code', [AdminController::class, 'generateReferenceCodeAjax'])->name('admin.generate.reference.code');




    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/add', [AdminController::class, 'product_add'])->name('admin.product.add');
    Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    Route::get('/admin/product/edit/{id}', [AdminController::class, 'product_edit'])->name('admin.product.edit');
    Route::put('/admin/product/update', [AdminController::class, 'product_update'])->name('admin.product.update');
    Route::delete('/admin/product/{id}/delete', [AdminController::class, 'product_delete'])->name('admin.product.delete');




    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');


    Route::get('/admin/order/{order_id}/details', [AdminController::class, 'order_details'])->name('admin.order.details');
    Route::put('/admin/order/update-status', [AdminController::class, 'update_order_status'])->name('admin.order.status.update');





    Route::get('/orders/export/pdf', [AdminController::class, 'exportPdf'])->name('orders.export.pdf');


    Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');
    Route::get('/admin/orders/search', action: [AdminController::class, 'search_order'])->name('admin.orders.search');
    Route::get('/orders/export/excel', [UserController::class, 'exportExcel'])->name('orders.export.excel');

    Route::get('/admin/order/{id}/generate-pdf', [AdminController::class, 'generateOrderPDF'])->name('admin.order.generate.pdf');
});
