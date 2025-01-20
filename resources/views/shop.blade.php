@extends('layouts.app')

@section('content')
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .table-container {
            flex: 3;
        }

        .cart-summary {
            flex: 1;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 20px;
        }

        .cart-summary h3 {
            text-align: center;
            font-size: 22px;
            color: #333;
        }

        .cart-summary ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .cart-summary ul li {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border: 1px solid #e5e5e5;
        }

        th {
            background-color: #20bec6;
            color: white;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Buttons */
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #20bec6;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1ea9b4;
            transform: scale(1.05);
        }

        /* Add margin to the main content to move it down */
        main.pt-90 {
            margin-top: 60px;
            /* Adds margin to the top, moving the content down */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .cart-summary {
                position: static;
                margin-top: 20px;
            }
        }
    </style>

    <main class="pt-90">
        <section class="shop-main container d-flex pt-4 pt-xl-5
">
            <!-- Main Content -->
            <div class="table-container">
                <!-- Products Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td>
                                    <form name="addtocart-form" method="post" action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $product->id }}" />
                                        <input type="hidden" name="quantity" value="1" />
                                        <input type="hidden" name="name" value="{{ $product->name }}" />
                                        <!-- إضافة مفتاح فريد -->
                                        <input type="hidden" name="unique_key" value="{{ uniqid() }}" />
                                        <button type="submit" class="btn btn-primary">Add Product</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Cart Table -->
                @if ($items->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>
                                        <h4>{{ $item->name }}</h4>
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('cart.price.update', ['rowId' => $item->rowId]) }}"
                                            style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="price" value="{{ $item->price }}" step="0.01"
                                                class="price-input"
                                                onkeydown="if(event.key === 'Enter'){this.form.submit();}">
                                        </form>
                                    </td>

                                    <td>
                                        <form method="POST"
                                            action="{{ route('cart.qty.update', ['rowId' => $item->rowId]) }}"
                                            style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" class="qty-control__number" name="qty"
                                                value="{{ $item->qty }}" min="1"
                                                onkeydown="if(event.key === 'Enter'){this.form.submit();}"
                                                style="width: 60px; text-align: center;">
                                        </form>
                                    </td>
                                    <td>${{ $item->subTotal() }}</td>




                                    <td>
                                        <form method="POST"
                                            action="{{ route('cart.description.update', ['rowId' => $item->rowId]) }}"
                                            style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <div class="description-container">
                                                <textarea id="description-{{ $item->rowId }}" name="description" placeholder="Insert a description for the product..."
                                                    class="form-control description-input" rows="3" style="resize: none;"
                                                    oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';"
                                                    onkeydown="if(event.key === 'Enter'){event.preventDefault(); this.form.submit();}"></textarea>
                                            </div>
                                        </form>
                                    </td>



                                    <td>
                                        <form method="POST"
                                            action="{{ route('cart.item.remove', ['rowId' => $item->rowId]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Remove</button>
                                        </form>
                                        <a href="{{ route('cart.edit', ['rowId' => $item->rowId]) }}"
                                            class="btn btn-info">Edit Specifications</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Sidebar -->
            <aside class="cart-summary">
                <h3>Cart Summary</h3>
                <ul>
                    <li><span>Total Items:</span><span>{{ $items->count() }}</span></li>
                    <li><span>Total Price:</span><span>$ {{ $items->sum('subTotal') }}</span></li>
                </ul>
                <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
            </aside>
        </section>
    </main>
@endsection


@push('scripts')
    <script>
        document.getElementById('orderby').addEventListener('change', function() {
            this.form.submit();
        });

        $(function() {
            // Handle page size change
            $("#pagesize").on("change", function() {
                $("#size").val($("#pagesize option:selected").val());
                $("#frmfilter").submit();
            });

            // Handle sorting order change
            $("#orderby").on("change", function() {
                $("#order").val($("#orderby option:selected").val());
                $("#frmfilter").submit();
            });

            // Handle category filtering
            $("input[name='categories']").on("change", function() {
                var categories = "";
                $("input[name='categories']:checked").each(function() {
                    if (categories === "") {
                        categories += $(this).val();
                    } else {
                        categories += "," + $(this).val();
                    }
                });
                $("#hdnCategories").val(categories);
                $("#frmfilter").submit();
            });

            // Handle price range changes
            $("[name='price_range']").on("change", function() {
                var min = $(this).val().split(',')[0];
                var max = $(this).val().split(',')[1];
                $("#hdnMinPrice").val(min);
                $("#hdnMaxPrice").val(max);
                setTimeout(() => {
                    $("#frmfilter").submit();
                }, 2000);
            });
        });


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
