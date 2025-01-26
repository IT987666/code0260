@extends('layouts.app')

@section('content')
    <style>
        /* General Styles */
        body {

            padding-top: 20px;
            /* Adds space at the top of the body content */

        }

        header {
            margin-bottom: 20px;
            /* Added spacing below the header */
        }

        .container {
            gap: 20px;
            margin: 20px;
        }

        .product-container,
        .cart-summary {
            flex: 1;
            /* border: 1px solid #e5e5e5; */
            border-radius: 8px;
            padding: 20px;
            /* background-color: #f9f9f9; */
            /* box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); */
        }

        .cart-container {
            flex: 2;
        }

        .shop-main.container {
            display: flex;

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
        /* Button Group Styling */
        .button-group {
            display: flex;
            gap: 6px;
            /* Reduces spacing between the buttons */
            justify-content: center;
            /* Centers the buttons within the cell */
            align-items: center;
            /* Aligns buttons vertically */
        }

        /* Smaller Buttons */
        .btn {
            padding: 6px 10px;
            /* Smaller padding for a compact size */
            font-size: 12px;
            /* Reduces font size */
            border-radius: 4px;
            /* Slightly rounded corners */
            transition: all 0.3s ease;
        }

        .btn-danger {
            background-color: #ff4d4d;
            color: white;
        }

        .btn-danger:hover {
            background-color: #e60000;
            transform: scale(1.05);
        }

        .btn-primary {
            background-color: #20bec6;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1ea9b4;
            transform: scale(1.05);
        }


        /* Cart Summary */
        .cart-summary h3 {
            text-align: center;
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
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

        /* Add spacing to main content */
        main.pt-90 {
            margin-top: 80px;
            /* Resolves header overlap */
        }
    </style>

    <main class="pt-90">
        <section class="shop-main container">
            <!-- Product List -->
            <div class="product-container">
                <h3>Products</h3>
                <table>
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                  <td class="product-name">
                             {{$product->name}}
                        </a>
                    </td> 
                                <td>
                                    <form name="addtocart-form" method="post" action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $product->id }}" />
                                        <input type="hidden" name="quantity" value="1" />
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Cart Table -->
            <div class="cart-container">
                <h3>Selected Products</h3>
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
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('cart.price.update', ['rowId' => $item->rowId]) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="price" value="{{ $item->price }}"
                                                step="0.01" />
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('cart.qty.update', ['rowId' => $item->rowId]) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="qty" value="{{ $item->qty }}"
                                                min="1" />
                                        </form>
                                    </td>
                                    <td>${{ $item->subTotal() }}</td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('cart.description.update', ['rowId' => $item->rowId]) }}">
                                            @csrf
                                            @method('PUT')
                                            <textarea name="description">{{ $item->description }}</textarea>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="button-group">
                                            <form method="POST"
                                                action="{{ route('cart.item.remove', ['rowId' => $item->rowId]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger">Remove</button>
                                            </form>
                                            <a href="{{ route('cart.edit', ['rowId' => $item->rowId]) }}"
                                                class="btn btn-primary">Edit Specifications</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="text-align: center; margin-top: 20px;">
                        <a href="{{ route('cart.checkout') }}" class="btn btn-primary"
                            style="font-size: 16px; padding: 10px 20px;">
                            Proceed to order
                        </a>
                    </div>
                @else
                    <p>No items selected.</p>
                @endif
            </div>
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
