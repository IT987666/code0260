<?php
public function place_an_order(Request $request)
    {
        $user_id = Auth::user()->id;

        $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'extra' => 'required',
            'billing_info' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $uploadedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('orders/images', 'public');
                $uploadedImages[] = $path;
            }
        }

        // Save the address
        $address = new Address();
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->email = $request->email;

        $address->country = $request->country;
        $address->user_id = $user_id;
        $address->isdefault = false;
        $address->save();

        // Set the checkout amount

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

        // Clear the cart and session
        // Cart::instance('cart')->destroy();
        Session::put('order_id', $order->id);

        return redirect()->route('shop.index');
    }

    public function setAmountforCheckout()
    {
        if (!Cart::instance('cart')->content()->count() > 0) {
            Session::forget('checkout');
            return;
        }

        // Reset checkout session values
        if (Session::has('coupon')) {
            Session::put('checkout', [
                'discount' => number_format(floatval(Session::get('discounts')['discount']), 2, '.', ''),
                'subtotal' => number_format(floatval(Session::get('discounts')['subtotal']), 2, '.', ''),
                'tax' => 0, // Reset taxes to 0
                'total' => number_format(floatval(Session::get('discounts')['total']), 2, '.', '')
            ]);
        } else {
            // If no coupon is applied, calculate without discounts
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => number_format(floatval(Cart::instance('cart')->subtotal()), 2, '.', ''),
                'tax' => 0, // Reset taxes to 0
                'total' => number_format(floatval(Cart::instance('cart')->total()), 2, '.', '')
            ]);
        }
    }