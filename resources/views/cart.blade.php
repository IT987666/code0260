@extends('layouts.app')
@section('content')
<style>
    /* Global Styles */
    body {
        font-family: 'Roboto', sans-serif;
    }
    .shop-checkout {
        margin: 40px auto;
        max-width: 1200px;
    }
    .page-title {
        text-align: center;
        font-size: 28px;
        color: #222;
        font-weight: bold;
        margin-bottom: 30px;
    }
    /* Cart Table */
    .cart-table {
        width: 100%;
        border-collapse: collapse;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .cart-table th,
    .cart-table td {
        padding: 15px;
        text-align: center;
        font-size: 16px;
        border: 1px solid #e5e5e5;
    }
    .cart-table th {
        background-color: #20bec6;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
    }
    .cart-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .cart-table td {
        vertical-align: middle;
    }
    .price-input {
        text-align: center;
        width: 100px; /* عرض مناسب للحقل */
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
        display: inline-block;
        margin: 0 auto;
    }
    .price-input:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
    /* إخفاء الأسهم */
    .price-input::-webkit-inner-spin-button, 
    .price-input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    /* Description Area */
    .description-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-width: 500px;
        margin: 0 auto;
    }
    .description-label {
        font-size: 1rem;
        font-weight: bold;
        color: #333;
    }
    .description-input {
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        font-size: 0.9rem;
        transition: border-color 0.3s ease-in-out;
        background-color: #f9f9f9;
        color: #333;
    }
    .description-input:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
    .description-input::placeholder {
        color: #2f2f2f;
        opacity: 1;
    }
    /* Quantity Controls */
    .qty-control {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 120px;
    }
    .qty-control input[type="number"] {
        width: 50px;
        text-align: center;
        border-radius: 4px;
        border: 1px solid #e5e5e5;
        font-size: 16px;
        padding: 5px;
    }
    /* Buttons */
    .btn {
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }
    .btn-primary,
    .btn-info {
        background-color: #20bec6;
        color: white;
    }
    .btn-primary:hover,
    .btn-info:hover {
        background-color: #1ea9b4;
        transform: scale(1.05);
        transition: transform 0.3s ease, background-color 0.3s ease;
    }
    .btn-danger {
        background-color: #000000;
        color: white;
    }
    .btn:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }
    /* Total Section */
    .shopping-cart__totals-wrapper {
        margin-top: 20px;
        padding: 20px;
        border: 1px solid #e5e5e5;
        border-radius: 6px;
        background-color: #f9f9f9;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .shopping-cart__totals-wrapper h3 {
        font-size: 22px;
        margin-bottom: 15px;
        color: #333;
    }
    /* Mobile Button Wrapper */
    .mobile_fixed-btn_wrapper {
        text-align: center;
        margin-top: 30px;
    }
    .mobile_fixed-btn_wrapper a {
        text-decoration: none;
        font-weight: bold;
        padding: 12px 20px;
        background-color: #20bec6;
        color: white;
    }
    /* Table Hover */
    .cart-table th:hover {
        background-color: #1ea9b4;
        border-color: #1ea9b4;
    }
</style>

<main class="pt-90">
    <section class="shop-checkout container">
        <h2 class="page-title">Order</h2>

        <div class="shopping-cart">
            @if ($items->count() > 0)
                <div class="cart-table__wrapper">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Area</th>

                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Product Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td><h4>{{ $item->name }}</h4></td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.price.update', ['rowId' => $item->rowId]) }}" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <input 
                                                type="number" 
                                                name="price" 
                                                value="{{ $item->price }}" 
                                                step="0.01" 
                                                class="price-input" 
                                                onkeydown="if(event.key === 'Enter'){this.form.submit();}">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.area.update', ['rowId' => $item->rowId]) }}" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <input 
                                                type="number" 
                                                name="area" 
                                                value="{{ $item->area }}" 
                                                step="0.01" 
                                                class="price-input" 
                                                onkeydown="if(event.key === 'Enter'){this.form.submit();}">
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.qty.update', ['rowId' => $item->rowId]) }}" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" class="qty-control__number" name="qty" value="{{ $item->qty }}" min="1" onkeydown="if(event.key === 'Enter'){this.form.submit();}" style="width: 60px; text-align: center;">
                                        </form>
                                    </td>
                                    <td>${{ $item->subTotal() }}</td>




                                    <td>
                                        <form method="POST" action="{{ route('cart.description.update', ['rowId' => $item->rowId]) }}" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <div class="description-container">
                                                 <textarea id="description-{{ $item->rowId }}" name="description" placeholder="Insert a description for the product..." class="form-control description-input" rows="3" style="resize: none;" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';" onkeydown="if(event.key === 'Enter'){event.preventDefault(); this.form.submit();}"></textarea>
                                            </div>
                                        </form>
                                    </td>


                                    
                                    <td>
                                        <form method="POST" action="{{ route('cart.item.remove', ['rowId' => $item->rowId]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Remove</button>
                                        </form>
                                        <a href="{{ route('cart.edit', ['rowId' => $item->rowId]) }}" class="btn btn-info">Edit Specifications</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="shopping-cart__totals-wrapper">
                        <div class="mobile_fixed-btn_wrapper">
                            <a href="{{ route('cart.checkout') }}" class="btn btn-primary next-btn">NEXT</a>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-center">No items. <a href="{{ route('shop.index') }}" class="btn btn-info">Create an order</a></p>
            @endif
        </div>
    </section>
</main>
@endsection

@push('scripts')
    <script>
        $(function() {
            $(".qty-control__increase").on("click", function() {
                $(this).closest('form').submit();
            });
            $(".qty-control__reduce").on("click", function() {
                $(this).closest('form').submit();
            });
            $('.remove-cart').on("click", function() {
                $(this).closest('form').submit();
            });
        })
    </script>
@endpush
{{----}}