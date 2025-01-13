@extends('layouts.app')
@section('content')
<style>
     .shop-checkout {
        font-family: 'Roboto', sans-serif;
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
        background-color: #20bec6; /* الفيروزي */
        color: white;
        font-weight: bold;
        text-transform: uppercase;
    }

    .cart-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .specification {
        margin: 10px 0;
        text-align: left;
    }

    .specification p {
        margin: 0;
        font-size: 14px;
        color: #666;
    }

    .spec-images img {
        margin: 5px;
        border: 1px solid #ddd;
        border-radius: 6px;
        width: 60px;
        height: 60px;
    }

    .cart-table td {
    vertical-align: middle;
}

.qty-control {
    display: flex;
    justify-content: space-between;   
    align-items: center;
    width: 120px;   
}

.qty-control button {
    width: 35px;   
    height: 35px;   
    border-radius: 50%;   
    font-size: 20px;  
    border: 1px solid #ddd;   
    background-color: #20bec6;   
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.qty-control button:hover {
    background-color: #20bec6;   
}

.qty-control input[type="number"] {
    width: 50px;   
    text-align: center;
    border-radius: 4px;
    border: 1px solid #e5e5e5;
    font-size: 16px;
    padding: 5px;
}


.cart-table th, .cart-table td {
    padding: 15px;
    text-align: center;
}

.cart-table td {
    padding: 10px;
}

.cart-table td .btn {
    padding: 5px 10px;
}

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
        background-color: #20bec6; /* الفيروزي الداكن */
        transform: scale(1.05);
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    .btn-danger {
        background-color: #000000;
        color: white;
    }

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

     .btn:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }

     .cart-table th:hover {
        background-color: #20bec6; 
        border-color: #20bec6;
    }

 .checkout-cart-items td {
    text-align: center;
    vertical-align: middle;  
}

 .description-input {
    width: 100%;
    padding: 5px;
    font-size: 14px;
    border-radius: 4px;
    border: 1px solid #e5e5e5;
}


.shopping-cart__totals-wrapper {
    position: relative;
}

.next-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 16px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
}

.next-btn:hover {
    background-color: #20bec6;
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
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>PRODUCT DESCRIPTION</th>
                                    <th>Action</th>
                                </tr>
                            </thead>      
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <h4>{{ $item->name }}</h4>
                                            {{--<p>Unique Key: {{ $item->options['unique_key'] ?? 'N/A' }}</p> <!-- عرض المفتاح الفريد إذا كان موجوداً -->--}}
                                        </td>
                                        <td>
                                            <span class="shopping-cart__product-price">${{ $item->price }}</span>
                                            <form method="POST" action="{{ route('cart.price.update', ['rowId' => $item->rowId]) }}" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <div class="d-flex align-items-center">
                                                    <input 
                                                        type="number" 
                                                        name="price" 
                                                        value="{{ $item->price }}" 
                                                        step="0.01" 
                                                        class="form-control form-control-sm price-input" 
                                                        style="width: 80px; margin-right: 5px;" 
                                                        onfocus="this.style.width='120px'" 
                                                        onblur="this.style.width='80px'" 
                                                        onkeydown="if(event.key === 'Enter'){this.form.submit();}">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="qty-control">
                                                <form method="POST" action="{{ route('cart.qty.decrease', ['rowId' => $item->rowId]) }}" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit">-</button>
                                                </form>
                                                <form method="POST" action="{{ route('cart.qty.update', ['rowId' => $item->rowId]) }}" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input 
                                                        type="number" 
                                                        class="qty-control__number" 
                                                        name="qty" 
                                                        value="{{ $item->qty }}" 
                                                        min="1" 
                                                        onkeydown="if(event.key === 'Enter'){this.form.submit();}" 
                                                        style="width: 60px; text-align: center;">
                                                </form>
                                                <form method="POST" action="{{ route('cart.qty.increase', ['rowId' => $item->rowId]) }}" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit">+</button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>${{ $item->subTotal() }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('cart.description.update', ['rowId' => $item->rowId]) }}" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <div class="d-flex align-items-center">
                                                    <textarea 
                                                        name="description" 
                                                        class="form-control description-input" 
                                                        rows="3" 
                                                        style="resize: none; width: 100%; min-width: 300px;" 
                                                        oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'" 
                                                        onkeydown="if(event.key === 'Enter'){this.form.submit();}">
                                                        {{ $item->options['description'] }}
                                                    </textarea>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                             <!-- زر التكرار -->
    <form method="POST" action="{{ route('cart.duplicate', ['rowId' => $item->rowId]) }}">
        @csrf
        <button type="submit" class="btn btn-secondary">Duplicate</button>
    </form>
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
                            
                            <div class="shopping-cart__totals-wrapper">
                                <div class="mobile_fixed-btn_wrapper">
                                    <a href="{{ route('cart.checkout') }}" class="btn btn-primary next-btn">NEXT</a>
                                </div>
                            </div>
                        </table>
                    </div>
                @else
                    <p class="text-center">No items  . <a href="{{ route('shop.index') }}"
                            class="btn btn-info">Create an order</a></p>
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
