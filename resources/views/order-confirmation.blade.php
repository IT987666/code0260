@extends('layouts.app')
@section('content')

    <style>
        .btn-primary {
            background-color: #20bec6;
            color: white;
        }

        .btn-primary:hover {
            background-color: #20bec6;
            transform: scale(1.05);
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .checkout__pdf-button {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .order-info__item span {
            word-wrap: break-word;
            word-break: break-word;
        }

        <style>.btn-primary:hover {
            background-color: #20bec6;
            transform: scale(1.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid rgb(126, 126, 126);
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>

    </style>

    <main class="pt-90">
        <section class="shop-checkout container">
            <div class="order-complete">
                <div class="order-complete__message">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M52.9743 35.7612C52.9743 35.3426 ..." fill="white" />
                    </svg>
                    <h3>The order is complete and prepared for printing.
                    </h3>
                </div>

                <div class="order-info">
                    <div class="order-info__item">
                        <label>Date</label>
                        <span>{{ $order->created_at }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>Total</label>
                        <span>${{ $shipping_type->total_cost ?? 0 }}</span>
                    </div>
                </div>


                <div class="checkout__totals-wrapper">
                    <div class="checkout__totals">
                        <h3>Order Details</h3>

                        <!-- Table showing product names and subtotals -->
                        <table class="checkout-cart-items">
                            <thead>
                                <tr>
                                    <th>PRODUCT</th>
                                    <th>SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name }} x {{ $item->quantity }}</td>
                                        <td class="text-right">${{ $item->price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Order subtotal -->
                        <table class="checkout-totals">
                            <tbody>
                                <tr>
                                    <th>TOTAL</th>
                                    <td class="text-right">${{ $order->subtotal }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Display Extras -->
                        @if (!empty($order->extra))
                            <div class="order-extras">
                                <ul>
                                    <li>
                                        {!! $order->extra !!}
                                    </li>
                                </ul>
                            </div>
                        @endif

                        @if (!empty($order->billing_info))
                            <div class="order-extras">
                                <ul>
                                    <li>
                                        {!! $order->billing_info !!}
                                    </li>
                                </ul>
                            </div>
                        @endif

                        <h3>Product Specifications</h3>
                        <table class="checkout-cart-items">
                            <thead>
                                <tr>
                                    <th>PRODUCT</th>
                                    <th>SPECIFICATIONS</th>
                                    <th>SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach ($orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name }} x {{ $item->quantity }}</td>
                                        <td>
                                            @if (!empty($item->specifications))
                                                @foreach ($item->specifications as $spec)
                                                    <div class="specification">
                                                        <strong>{{ $spec['name'] ?? 'Specification' }}:</strong>

                                                        <!-- Display paragraphs -->
                                                        @if (!empty($spec['paragraphs']))
                                                            <p>{!! $spec['paragraphs'] !!}</p>
                                                        @endif

                                                        <!-- Display images -->
                                                        @if (!empty($spec['images']))
                                                            <div class="spec-images">
                                                                @foreach ($spec['images'] as $image)
                                                                    <img src="{{ asset('storage/' . $image) }}"
                                                                        alt="spec image" width="100" height="100"
                                                                        style="margin-right: 10px;">
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @else
                                                <p>No specifications available.</p>
                                            @endif
                                        </td>
                                        <td class="text-right">${{ $item->price }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <strong>Description:</strong>
                                            <p>{{ $item->description }}</p>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                        @if ($shipping_type)
                            <h3>Shipping Type</h3>
                            <table class="checkout-cart-items">
                                <thead>
                                    <tr>
                                        <th>shipping type</th>
                                        <th>Incoterm</th>
                                        <th>Port/City</th>
                                        <th>quantity</th>
                                        <th>unit price</th>
                                        <th>shipping cost</th>
                                        <th>total cost</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $shipping_type->shipping_type ?? 0 }}</td>
                                        <td>{{ $shipping_type->shipping_incoterm ?? '-' }}</td>
                                        <td>{{ $shipping_type->port_name_or_city ?? '-' }}</td>
                                        <td class="text-right">
                                            {{ $shipping_type->quantity ?? 0 }}
                                        </td>
                                        <td class="text-right">
                                            {{ $shipping_type->unit_price ?? 0 }}
                                        </td>
                                        <td class="text-right">
                                            {{ $shipping_type->shipping_cost ?? 0 }}
                                        </td>
                                        <td class="text-right">{{ $shipping_type->total_cost ?? 0 }}</td>

                                    </tr>


                                </tbody>

                            </table>
                        @endif

                        <div class="order-images">
                            <h3>Order Images</h3>
                            <div class="image-gallery">
                                @if (!empty($order->images))
                                    @foreach (json_decode($order->images) as $image)
                                        <img src="{{ asset('storage/' . $image) }}" alt="Order Image" width="100"
                                            height="100" style="margin-right: 10px;">
                                    @endforeach
                                @else
                                    <p>No images uploaded for this order.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Images -->


            <!-- Download PDF Button at the end -->
            <div class="checkout__pdf-button mt-4 text-center">
                <a href="{{ route('order.downloadPdf', ['orderId' => $order->id]) }}" class="btn btn-primary"
                    id="downloadPdfButton"
                    style="background-color: #20bec6; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-size: 16px; text-decoration: none; transition: transform 0.3s ease, background-color 0.3s ease;"
                    onclick="disableButton(event)">
                    Download Order PDF
                </a>
            </div>

            @if(session('clear_shipping'))
            <script>
                sessionStorage.setItem('clear_shipping', 'true');
            </script>
        @endif
        
        </section>
    </main>
@endsection
 @push('scripts')
    <script>
        function disableButton(event) {
            const button = event.currentTarget;

            button.style.pointerEvents = 'none';
            button.style.opacity = '0.6';

            button.innerHTML = 'Processing...';
        }
        document.addEventListener("DOMContentLoaded", function () {
     if (sessionStorage.getItem('clear_shipping')) {
        clearCartData();
        sessionStorage.removeItem('clear_shipping');   
    }

     document.getElementById('downloadPdfButton').addEventListener('click', function () {
        sessionStorage.setItem('clear_shipping', 'true');   
    });
});

// دالة لحذف بيانات الشحن من localStorage
function clearCartData() {
    localStorage.removeItem('cartData');
    console.log("done");
}

    </script>
    
@endpush
 