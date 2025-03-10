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
            display: block;
            text-align: center;
            width: 60%;
            /* Adjust width as needed */
            margin: auto;
        }

        .product-container,
        .cart-container {
            width: 100%;
            margin-bottom: 30px;
            /* Adds spacing between product and cart tables */
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
                <input type="text" id="searchBox" placeholder="Search products..." class="custom-input" />

                <select id="productDropdown" class="custom-select">
                    <option value="">Select a product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <style>
                .product-container {
                    width: 100%;
                    max-width: 400px;
                    /* تحديد عرض مناسب */
                    margin: 0 auto;
                    text-align: center;
                }

                .product-title {
                    font-size: 24px;
                    font-weight: bold;
                    margin-bottom: 10px;
                }

                .custom-input,
                .custom-select {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 10px;
                    border: 1px solid #ccc;
                    border-radius: 8px;
                    font-size: 16px;
                    outline: none;
                    transition: 0.3s;
                    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
                }

                .custom-input:focus,
                .custom-select:focus {
                    border-color: #007bff;
                    box-shadow: 2px 2px 15px rgba(0, 123, 255, 0.3);
                }

                .custom-select {
                    cursor: pointer;
                    background: white;
                }
            </style>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    let dropdown = document.getElementById("productDropdown");
                    let searchBox = document.getElementById("searchBox");

                    // عند الكتابة في مربع البحث
                    searchBox.addEventListener("keyup", function() {
                        let query = this.value.toLowerCase();
                        let hasResults = false;

                        for (let option of dropdown.options) {
                            if (option.value === "") continue; // تخطي الخيار الأول (Select a product)
                            let match = option.text.toLowerCase().includes(query);
                            option.style.display = match ? "" : "none"; // إخفاء الخيارات غير المطابقة
                            if (match) hasResults = true;
                        }

                        // فتح القائمة إذا كان هناك نتائج، وإغلاقها إذا لم يكن هناك شيء
                        if (hasResults && query !== "") {
                            dropdown.size = dropdown.options.length; // إظهار الخيارات المتاحة
                            dropdown.style.display = "block"; // تأكد من إظهاره
                        } else {
                            dropdown.size = 1;
                            dropdown.style.display = "none"; // إخفاء القائمة إذا لم تكن هناك نتائج
                        }
                    });

                    // عند فقدان التركيز، يتم إغلاق القائمة
                    searchBox.addEventListener("blur", function() {
                        setTimeout(() => {
                            dropdown.size = 1;
                            dropdown.style.display = "block"; // إبقاؤه طبيعيًا
                        }, 200);
                    });

                    // عند تحديد عنصر من القائمة
                    dropdown.addEventListener("change", function() {
                        searchBox.value = dropdown.options[dropdown.selectedIndex].text; // إدخال الاسم في البحث
                        dropdown.size = 1; // إعادة الحجم الطبيعي
                    });
                });
            </script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    let dropdown = document.getElementById("productDropdown");
                    let searchBox = document.getElementById("searchBox");

                    // تحميل آخر منتج تم تحديده من localStorage
                    let savedProduct = localStorage.getItem("selectedProduct");
                    if (savedProduct) {
                        dropdown.value = savedProduct;
                    }

                    // عند تغيير المنتج المختار
                    dropdown.addEventListener("change", function() {
                        let productId = this.value;
                        if (!productId) return; // تجنب تنفيذ الطلب إذا لم يتم اختيار منتج

                        localStorage.setItem("selectedProduct", productId); // حفظ المنتج المختار

                        fetch("{{ route('cart.add') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                id: productId,
                                quantity: 1
                            })
                        }).then(() => window.location.replace(window.location.href));
                    });

                    // فلترة المنتجات بناءً على البحث
                    searchBox.addEventListener("keyup", function() {
                        let query = this.value.toLowerCase();
                        for (let option of dropdown.options) {
                            if (option.value === "") continue; // تجاوز الخيار الافتراضي
                            option.style.display = option.text.toLowerCase().includes(query) ? "" : "none";
                        }
                    });
                });
            </script>



            <!-- Cart Table -->
            <div class="cart-container">
                <div style="height: 22px;"></div>

                <h3>Selected Products</h3>
                <span style="display: block; height: 20px;"></span>
                <div style="height: 50px;"></div>

                @if ($items->count() > 0)
                    <style>
                        .description-input {
                            width: 300px;
                            /* زيادة العرض حسب الحاجة */
                            height: 100px;
                            /* تحديد ارتفاع الحقل */
                        }

                        /* جعل حقل الكمية أصغر */
                        input[name="qty"] {
                            width: 60px;
                            /* تصغير العرض */
                        }

                        /* تحسين مظهر الجدول */
                        table {
                            width: 100%;
                            /* جعل الجدول يأخذ العرض الكامل */
                        }

                        th,
                        td {
                            padding: 10px;
                            text-align: center;
                        }
                    </style>
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
                                    <td class="total-price">${{ $item->subTotal() }}</td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('cart.description.update', ['rowId' => $item->rowId]) }}"
                                            class="description-form">
                                            @csrf
                                            @method('PUT')
                                            <textarea name="description" class="description-input" data-row-id="{{ $item->rowId }}">{{ $item->options['description'] }}</textarea>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="button-group">

                                            <a href="{{ route('cart.edit', ['rowId' => $item->rowId]) }}"
                                                class="btn btn-primary">Edit Specifications</a>
                                            <form method="POST"
                                                action="{{ route('cart.item.remove', ['rowId' => $item->rowId]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger"
                                                    style="border: none; background: none; color: rgba(32, 190, 198, 0.5); font-size: 20px;">&times;</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No items selected.</p>
                @endif
            </div>
            <div class="cart-container">
                <h3>Shipping Details</h3>
                <form id="shippingForm" action="{{ route('shipping.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="shipping_type" id="shippingTypeInput">
                    <input type="hidden" name="quantity" id="quantityInput">
                    <input type="hidden" name="unit_price" id="unitPriceInput">
                    <input type="hidden" name="shipping_cost" id="shippingCostInput">
                    <input type="hidden" name="total_cost" id="totalCostInput">
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Shipping Type</th>
                            <th>Quantity</th>
                            <th>Unit Price (USD)</th>
                            <th>Shipping Cost (USD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select id="shippingType">
                                    <option value="Shipping not included">Shipping not included</option>
                                    <option value="40' HC Container">40' HC Container</option>
                                    <option value="20' HC Container">20' HC Container</option>
                                    <option value="OT Container">OT Container</option>
                                    <option value="Truck">Truck</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" />
                            </td>
                            <td>
                                <input type="number" name="unit_price" id="unitPrice" value="0.00" step="0.01" />
                            </td>
                            <td>
                                <input type="number" id="shippingCost" value="0.00" step="0.01" readonly />
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div style="margin-top: 20px; text-align: right;">
                    <strong>Subtotal (Products Only) (USD):</strong>
                    <input type="number" id="subtotal" value="0.00" step="0.01" readonly />
                    <br />
                    <strong>Total Product Cost (USD):</strong>
                    <span id="product-total">0.00</span>
                    <br />
                    <strong>Total Cost with Shipping (USD):</strong>
                    <span id="total-cost">0.00</span>
                </div>
            </div>

            <script>
                const quantityInput = document.getElementById('quantity');
                const unitPriceInput = document.getElementById('unitPrice');
                const shippingTypeSelect = document.getElementById('shippingType');
                const shippingCostInput = document.getElementById('shippingCost');
                const productTotalSpan = document.getElementById('product-total');
                const totalCostSpan = document.getElementById('total-cost');
                const subtotalInput = document.getElementById('subtotal');

                function calculateProductSubtotal() {
                    let productTotal = parseFloat(unitPriceInput.value || 0) * parseFloat(quantityInput.value || 1);
                    return productTotal;
                }

                function updateTotalCost(shippingCost = null) {
                    const productTotal = calculateProductSubtotal();
                    const quantity = parseFloat(quantityInput.value) || 1;
                    const shippingUnitPrice = shippingCost !== null ? shippingCost : (parseFloat(shippingTypeSelect.value) || 0);
                    const totalShippingCost = quantity * shippingUnitPrice;

                    shippingCostInput.value = totalShippingCost.toFixed(2);
                    productTotalSpan.textContent = productTotal.toLocaleString('en-US', {
                        minimumFractionDigits: 2
                    });
                    subtotalInput.value = productTotal.toFixed(2);

                    const totalWithShipping = productTotal + totalShippingCost;
                    totalCostSpan.textContent = totalWithShipping.toLocaleString('en-US', {
                        minimumFractionDigits: 2
                    });
                    saveShippingDetails();
                }

                function fetchShippingCost() {
                    const shippingType = shippingTypeSelect.value;
                    fetch("{{ route('shipping.update') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                shipping_type: shippingType
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.shipping_cost !== undefined) {
                                updateTotalCost(data.shipping_cost);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                function saveShippingDetails() {
                    document.getElementById('shippingTypeInput').value = shippingTypeSelect.value;
                    document.getElementById('quantityInput').value = quantityInput.value;
                    document.getElementById('unitPriceInput').value = unitPriceInput.value;
                    document.getElementById('shippingCostInput').value = shippingCostInput.value;
                    document.getElementById('totalCostInput').value = totalCostSpan.textContent.replace(',', '');
                    document.getElementById('shippingForm').submit();
                }

                quantityInput.addEventListener('input', () => updateTotalCost());
                unitPriceInput.addEventListener('input', () => updateTotalCost());
                shippingTypeSelect.addEventListener('input', fetchShippingCost);

                // window.onload = () => {
                //     updateTotalCost();
                // };
            </script>
            {{--  <div class="cart-container">
                <h3>Shipping Details</h3>
                <form id="shippingForm" action="{{ route('shipping.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="shipping_type" id="shippingTypeInput">
                    <input type="hidden" name="quantity" id="quantityInput">
                    <input type="hidden" name="unit_price" id="unitPriceInput">
                    <input type="hidden" name="shipping_cost" id="shippingCostInput">
                    <input type="hidden" name="total_cost" id="totalCostInput">

                    <button type="submit">Save Shipping Details</button>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Shipping Type</th>
                            <th>Quantity</th>
                            <th>Unit Price (USD)</th>
                            <th>Shipping Cost (USD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select id="shippingType">
                                    <option value="0">Shipping not included</option>
                                    <option value="1210">40' HC Container</option>
                                    <option value="850">20' HC Container</option>
                                    <option value="1500">OT Container</option>
                                    <option value="600">Truck</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" />
                            </td>
                            <td>
                                <input type="number" name="unit_price" id="unitPrice" value="0.00" step="0.01" />
                            </td>
                            <td>
                                <input type="number" id="shippingCost" value="0.00" step="0.01" readonly />
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div style="margin-top: 20px; text-align: right;">
                    <strong>Subtotal (Products Only) (USD):</strong>
                    <input type="number" id="subtotal" value="0.00" step="0.01" readonly />
                    <br />
                    <strong>Total Product Cost (USD):</strong>
                    <span id="product-total">0.00</span>
                    <br />
                    <strong>Total Cost with Shipping (USD):</strong>
                    <span id="total-cost">0.00</span>
                </div>
            </div>

            <script>
const quantityInput = document.getElementById('quantity');
const unitPriceInput = document.getElementById('unitPrice');
const shippingTypeSelect = document.getElementById('shippingType');
const shippingCostInput = document.getElementById('shippingCost');
const productTotalSpan = document.getElementById('product-total');
const totalCostSpan = document.getElementById('total-cost');
const subtotalInput = document.getElementById('subtotal');

 function calculateProductSubtotal() {
    let productTotal = 0;
    document.querySelectorAll('.total-price').forEach(item => {
        productTotal += parseFloat(item.textContent.replace('$', '')) || 0;
    });
    return productTotal;
}

 function updateTotalCost(shippingCost = null) {
    const productTotal = calculateProductSubtotal();
    const quantity = parseFloat(quantityInput.value) || 1;
    const shippingUnitPrice = shippingCost !== null ? shippingCost : (parseFloat(unitPriceInput.value) || 0);
    const totalShippingCost = quantity * shippingUnitPrice;

    shippingCostInput.value = totalShippingCost.toFixed(2);
    productTotalSpan.textContent = productTotal.toLocaleString('en-US', { minimumFractionDigits: 2 });
    subtotalInput.value = productTotal.toFixed(2);

    const totalWithShipping = productTotal + totalShippingCost;
    totalCostSpan.textContent = totalWithShipping.toLocaleString('en-US', { minimumFractionDigits: 2 });

    autoSaveShippingDetails();
}

 function fetchShippingCost() {
    const shippingType = shippingTypeSelect.value;

    fetch("{{ route('shipping.update') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ shipping_type: shippingType })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.shipping_cost !== undefined) {
            updateTotalCost(data.shipping_cost);
        }
    })
    .catch(error => console.error('Error:', error));
}

 function autoSaveShippingDetails() {
    const formData = {
        shipping_type: shippingTypeSelect.value,
        quantity: quantityInput.value,
        unit_price: unitPriceInput.value,
        shipping_cost: shippingCostInput.value,
        total_cost: totalCostSpan.textContent.replace(',', '')
    };

    fetch("{{ route('shipping.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log("Shipping details saved successfully!");
        }
    })
    .catch(error => console.error('Error saving shipping details:', error));
}

 const observer = new MutationObserver(() => updateTotalCost());
document.querySelectorAll('.total-price').forEach(element => {
    observer.observe(element, { childList: true });
});

 quantityInput.addEventListener('input', () => updateTotalCost());
unitPriceInput.addEventListener('input', () => updateTotalCost());
shippingTypeSelect.addEventListener('change', fetchShippingCost);

 window.onload = () => {
    updateTotalCost();
};

console.log("Auto-save shipping script loaded!");


            </script> --}}


            <div style="text-align: center; margin-top: 100px;">
                <a href="{{ route('cart.order') }}" class="btn btn-primary" id="proceedToOrder"
                    style="font-size: 16px; padding: 10px 20px;">
                    Proceed to order
                </a>

            </div>
        </section>
    </main>
@endsection


@push('scripts')
    <script>
        document.querySelectorAll('.description-input').forEach(textarea => {
            textarea.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    this.closest('.description-form').submit();
                }
            });
        });
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
    <script>
        $(document).ready(function() {
            $("input[name='price']").on("input", function() {
                var row = $(this).closest("tr"); // Get the closest table row
                var priceInput = $(this); // The input field
                var price = parseFloat(priceInput.val()) || 0;
                var quantity = parseInt(row.find("input[name='qty']").val()) || 1;
                var total = (price * quantity).toFixed(2); // Calculate total

                row.find(".total-price").text("$" + total); // Update total in UI

                // Send AJAX request to update the price in the database
                $.ajax({
                    url: priceInput.closest("form").attr("action"),
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "PUT",
                        price: price
                    },
                    success: function(response) {
                        console.log("Price updated successfully");
                    },
                    error: function(error) {
                        console.log("Error updating price", error);
                    }
                });
            });

            $("input[name='qty']").on("input", function() {
                var row = $(this).closest("tr"); // Get the closest table row
                var quantityInput = $(this);
                var price = parseFloat(row.find("input[name='price']").val()) || 0;
                var quantity = parseInt(quantityInput.val()) || 1;
                var total = (price * quantity).toFixed(2); // Calculate total

                row.find(".total-price").text("$" + total); // Update total in UI

                // Send AJAX request to update the quantity
                $.ajax({
                    url: quantityInput.closest("form").attr("action"),
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "PUT",
                        qty: quantity
                    },
                    success: function(response) {
                        console.log("Quantity updated successfully");
                    },
                    error: function(error) {
                        console.log("Error updating quantity", error);
                    }
                });
            });
        });
    </script>
@endpush
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // استهداف زر Proceed to Order
            document.getElementById('proceedToOrder').addEventListener('click', function(event) {
                event.preventDefault(); // منع الانتقال مباشرة
                let descriptions = document.querySelectorAll('.description-input');
                let forms = [];

                descriptions.forEach(textarea => {
                    let form = textarea.closest('.description-form');
                    if (form) {
                        forms.push(fetch(form.action, {
                            method: "POST",
                            body: new FormData(form),
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        }));
                    }
                });

                // إرسال جميع البيانات أولاً ثم الانتقال إلى صفحة الطلب
                Promise.all(forms).then(() => {
                    window.location.href = "{{ route('cart.order') }}";
                });
            });
        });
    </script>
@endpush
