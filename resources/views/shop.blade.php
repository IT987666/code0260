@extends('layouts.app')

@section('content')

    <style>
        .dropdown-container {
            position: relative;
            display: none;
            width: 100%;
        }

        .dropdown-content {
            position: absolute;
            width: 100%;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-height: 200px;
            overflow-y: auto;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #f1f1f1;
        }

        .add-to-cart-btn {
            background-color: #20bec6;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        .add-to-cart-btn:hover {
            background-color: #20bec6;
        }

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

        body {
            font-family: Arial, sans-serif;
        }

        .form-container {
            width: 400px;
            border: 1px solid black;
            border-collapse: collapse;
        }

        .form-header {
            background-color: #20bec6;
            color: white;
            font-weight: bold;
            padding: 8px;
        }

        .form-row {
            display: flex;
            border-bottom: 1px solid black;
        }

        .form-row label {
            width: 50%;
            padding: 8px;
            background-color: #F8F8F8;
            border-right: 1px solid black;
        }

        .form-row select,
        .form-row input {
            width: 50%;
            padding: 6px;
            border: none;
        }

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

        .cart-container {
            width: 135%;
            /* تحديد عرض مناسب للجدولين */
            margin: auto;
            /* جعل الجدولين في المنتصف */
            text-align: center;
            margin-left: -15%;
            /* تحريك العنصر نحو اليمين */

        }

        table {
            width: 100%;
            table-layout: fixed;
            /* يجعل الأعمدة تحتفظ بحجم متساوٍ */
        }

        th,
        td {
            white-space: nowrap;
            /* منع النصوص من الانكسار */
            overflow: hidden;
            text-overflow: ellipsis;
            /* إضافة "..." عند النصوص الطويلة */
        }

        td input,
        td textarea {
            width: 90%;
            /* جعل الحقول داخل الجدول متناسبة */
            max-width: 120px;
            /* تحديد حد أقصى للعرض */
        }

        td .description-input {
            width: 90%;
            /* التأكد من أن حقل الوصف لا يمتد خارج الجدول */
            max-width: 250px;
        }

        .cart-container:last-child {
            margin-top: 40px;
            /* إضافة مسافة بين الجدولين */
        }

        @media (max-width: 768px) {
            .cart-container {
                width: 100%;
            }

            table {
                font-size: 12px;
                /* تصغير حجم النصوص على الشاشات الصغيرة */
            }

            td input,
            td textarea {
                max-width: 100px;
            }
        }

        /* ضبط تنسيق العناصر داخل القائمة */
        .dropdown-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            white-space: nowrap;
            /* تأكد من أن النص لا يلتف افتراضيًا */
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            /* تحديد عرض العنصر */
        }

        /* في حال أردت أن يلتف النص على عدة أسطر بدلًا من الاقتصاص */
        .dropdown-item span {
            max-width: 70%;
            /* تحديد أقصى عرض للنص */
            word-wrap: break-word;
            /* السماح للنص بالالتفاف */
            overflow-wrap: break-word;
            font-size: 14px;
            /* تصغير الخط إذا لزم الأمر */
        }

        /* زر الإضافة يبقى بجانب النص دون أن يختفي */
        .add-to-cart-btn {
            flex-shrink: 0;
            /* يمنع الزر من التصغير */
            margin-left: 10px;
            /* إضافة مسافة بين النص والزر */
            padding: 5px 10px;
            font-size: 14px;
        }
    </style>
    <style>
        .spinner {
            width: 60px;
            height: 60px;
            border: 5px solid transparent;
            border-top: 5px solid #ffffff;
            border-radius: 50%;
            animation: spin 1s ease-in-out infinite;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.6);
            position: relative;
        }

        /* تأثير الدوران */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
                border-top-color: #dbdbdbc4;
            }

            50% {
                border-top-color: #20bec6;
            }

            100% {
                transform: rotate(360deg);
                border-top-color: #0c4b64;
            }

        }
    </style>

    <main class="pt-90">
        <section class="shop-main container">

            <!-- Product List -->
            <div class="product-container">
                <h3>Products</h3>
                <input type="text" id="searchBox" placeholder="Search products..." class="custom-input" />

                <div id="dropdownContainer" class="dropdown-container">
                    <div id="productDropdown" class="dropdown-content">
                        @foreach ($products as $product)
                            <div class="dropdown-item" data-id="{{ $product->id }}">
                                <span>{{ $product->name }}</span>
                                <button class="add-to-cart-btn" data-id="{{ $product->id }}">Add</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>



            <!-- Cart Table -->
            <div class="cart-container">
                <div style="height: 22px;"></div>
                <h3>Selected Products</h3>
                <span style="display: block; height: 20px;"></span>
                <div style="height: 50px;"></div>

                <table>
                    <colgroup>
                        <col style="width:30%;"> <!-- المنتج -->
                        <col style="width: 15%;"> <!-- السعر -->
                        <col style="width: 15%;"> <!-- المساحة -->
                        <col style="width: 15%;"> <!-- الكمية -->
                        <col style="width: 20%;"> <!-- المجموع -->
                        <col style="width: 30%;"> <!-- الوصف (أعرض) -->
                        <col style="width: 20%;"> <!-- الإجراءات (أعرض) -->
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Area</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if ($items->count() > 0)
                            @foreach ($items as $item)
                                <tr>
                                    <form method="POST" action="{{ route('cart.item.updateAll', ['rowId' => $item->rowId]) }}">
                                        @csrf
                                        @method('PUT')
                    
                                        <td>{{ $item->name }}</td>
                    
                                        <td>
                                            <input type="number" name="price" value="{{ $item->price }}" step="0.01" min="0" oninput="checkPrice(this)" />
                                        </td>
                    
                                        <td>
                                            <input type="text" name="area" value="{{ $item->options['area'] ?? '' }}" />
                                        </td>
                    
                                        <td>
                                            <input type="number" name="qty" value="{{ $item->qty }}" min="1" />
                                        </td>
                    
                                        <td class="total-price">${{ $item->subTotal() }}</td>
                    
                                        <td>
                                            <textarea name="description" class="description-input" data-row-id="{{ $item->rowId }}">{{ $item->options['description'] }}</textarea>
                                        </td>
                    
                                        <td>
                                            <div class="button-group">
                                                <a href="{{ route('cart.edit', ['rowId' => $item->rowId]) }}" class="btn btn-primary">Edit Specifications</a>
                    
                                                {{-- زر الحذف فقط --}}
                                                </form> {{-- أغلقنا الفورم الأساسي هون قبل زر الحذف --}}
                                                <form method="POST" action="{{ route('cart.item.remove', ['rowId' => $item->rowId]) }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" style="border: none; background: none; color: rgba(32, 190, 198, 0.5); font-size: 20px;">&times;</button>
                                                </form>
                                            </div>
                                        </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 20px;">No items selected.</td>
                            </tr>
                        @endif
                    </tbody>
                    
                    <script>
                        function checkPrice(input) {
                            if (input.value < 0) {
                                input.value = 0;
                            }
                        }
                    </script>
                    
                </table>
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
                                    <input type="number" name="unit_price" id="unitPrice" value="0.00" step="0.01"
                                        min="0" oninput="checkPrice(this)" />
                                </td>

                                <script>
                                    function checkPrice(input) {
                                        if (input.value < 0) {
                                            input.value = 0;
                                        }
                                    }
                                </script>

                                <td>
                                    <input type="number" id="shippingCost" value="0.00" step="0.01" readonly />
                                </td>
                            </tr>
                            <!-- الصف الخاص بإجمالي تكلفة المنتج -->
                            <div style="margin-top: 20px; text-align: right;">
                                <input type="hidden" type="number" id="subtotal" value="0.00" step="0.01"
                                    readonly />
                                <br />

                            </div>
                            <tr>
                                <td colspan="2" style="text-align: left;"><strong>Total Product Cost (USD):</strong>
                                </td>
                                <td colspan="2"><span id="product-total">0.00</span></td>
                            </tr>
                            <!-- الصف الخاص بالإجمالي مع الشحن -->
                            <tr>
                                <td colspan="2" style="text-align: left;"><strong>Total Cost with Shipping
                                        (USD):</strong></td>
                                <td colspan="2"><span id="total-cost">0.00</span></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="form-container">
                        <div class="form-header">Enter Project Information</div>

                        <div class="form-row">
                            <label for="shipping_incoterm">Shipping Incoterm:</label>
                            <select id="shipping_incoterm" name="shipping_incoterm">
                                <option value="">Select Incoterm</option>
                                <option value="EXW">EXW</option>
                                <option value="FCA">FCA</option>
                                <option value="FOB">FOB</option>
                                <option value="CIF">CIF</option>
                                <option value="CFR">CFR</option>
                                <option value="DDP">DDP</option>
                                <option value="DDU">DDU</option>
                            </select>
                        </div>

                        <div class="form-row">
                            <label for="port_name_or_city">Port Name or City:</label>
                            <input type="text" id="port_name_or_city" name="port_name_or_city">
                        </div>


                    </div>

                </form>

            </div>



            <div style="text-align: center; margin-top: 100px;">
                <button type="button" class="btn btn-primary" id="proceedToOrder"
                    @if ($items->count() < 1) disabled @endif style="font-size: 16px; padding: 10px 20px;">
                    Proceed to Order
                </button>
            </div>

            <!-- شاشة التحميل -->
            <div id="loadingScreen"
                style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); align-items: center; justify-content: center; flex-direction: column;">
                <div class="spinner"></div>
                <p style="color: white; font-size: 18px; margin-top: 10px;">Loading, please wait...</p>
            </div>




        </section>
    </main>
@endsection
@push('scripts')
<script>
    // إذا رجع المستخدم للصفحة من الـ history (يعني عن طريق زر الرجوع)
    window.addEventListener('pageshow', function (event) {
        if (event.persisted || window.performance.getEntriesByType("navigation")[0].type === "back_forward") {
            // Reload الصفحة تلقائياً
            window.location.reload();
        }
    });
</script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let searchBox = document.getElementById("searchBox");
            let dropdownContainer = document.getElementById("dropdownContainer");
            let productDropdown = document.getElementById("productDropdown");

            // إظهار القائمة عند النقر على حقل البحث
            searchBox.addEventListener("focus", function() {
                dropdownContainer.style.display = "block";
            });

            // إخفاء القائمة عند النقر خارجها
            document.addEventListener("click", function(event) {
                if (!dropdownContainer.contains(event.target) && event.target !== searchBox) {
                    dropdownContainer.style.display = "none";
                }
            });

            // البحث داخل القائمة
            searchBox.addEventListener("keyup", function() {
                let query = this.value.toLowerCase();
                let items = productDropdown.getElementsByClassName("dropdown-item");
                let hasResults = false;

                for (let item of items) {
                    let match = item.textContent.toLowerCase().includes(query);
                    item.style.display = match ? "flex" : "none";
                    if (match) hasResults = true;
                }

                // إظهار القائمة فقط إذا كان هناك نتائج
                dropdownContainer.style.display = hasResults ? "block" : "none";
            });

            // إضافة المنتج عند النقر على الزر
            productDropdown.addEventListener("click", function(event) {
                if (event.target.classList.contains("add-to-cart-btn")) {
                    let productId = event.target.getAttribute("data-id");

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
                }
            });
        });
    </script>
    <script>
        const quantityInput = document.getElementById('quantity');
        const unitPriceInput = document.getElementById('unitPrice');
        const shippingTypeSelect = document.getElementById('shippingType');
        const shippingCostInput = document.getElementById('shippingCost');
        const productTotalSpan = document.getElementById('product-total');
        const totalCostSpan = document.getElementById('total-cost');
        const subtotalInput = document.getElementById('subtotal');

        function saveToLocalStorage() {
            const formData = {
                quantity: quantityInput.value,
                unit_price: unitPriceInput.value,
                shipping_type: shippingTypeSelect.value,
                shipping_cost: shippingCostInput.value,
                total_cost: totalCostSpan.textContent.replace(',', ''),
                subtotal: subtotalInput.value
            };
            localStorage.setItem('cartData', JSON.stringify(formData));
        }

        function loadFromLocalStorage() {
            const savedData = JSON.parse(localStorage.getItem('cartData'));
            if (savedData) {
                quantityInput.value = savedData.quantity || "";
                unitPriceInput.value = savedData.unit_price || "";
                shippingTypeSelect.value = savedData.shipping_type || "";
                shippingCostInput.value = savedData.shipping_cost || "";
                subtotalInput.value = savedData.subtotal || "";
                totalCostSpan.textContent = savedData.total_cost || "0.00";
                updateTotalCost();
            }
        }

        function calculateProductSubtotal() {
            let productTotal = 0;
            document.querySelectorAll('.total-price').forEach(item => {
                let price = parseFloat(item.textContent.replace(/[^0-9.]/g, '')) || 0;
                productTotal += price;
            });
            return parseFloat(productTotal.toFixed(2));
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('proceedToOrder').addEventListener('click', function(event) {
                event.preventDefault();
                document.getElementById('shippingTypeInput').value = shippingTypeSelect.value;
                document.getElementById('quantityInput').value = quantityInput.value;
                document.getElementById('unitPriceInput').value = unitPriceInput.value;
                document.getElementById('shippingCostInput').value = shippingCostInput.value;
                document.getElementById('totalCostInput').value = totalCostSpan.textContent.replace(',',
                    '');
                debugger;
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

                const shippingForm = document.getElementById('shippingForm');
                forms.push(fetch(shippingForm.action, {
                    method: "POST",
                    body: new FormData(shippingForm),
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    }
                }));

                Promise.all(forms).then(() => {
                    window.location.href = "{{ route('cart.order') }}";
                });
            });
        });

        function updateTotalCost(shippingCost = null) {
            const productTotal = calculateProductSubtotal();
            const quantity = parseFloat(quantityInput.value) || 1;
            const shippingUnitPrice = shippingCost !== null ? shippingCost : (parseFloat(unitPriceInput.value) || 0);
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

            autoSaveShippingDetails();
            saveToLocalStorage();
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
                .catch(error => console.error('Error saving shipping details:'));
        }

        const observer = new MutationObserver(() => updateTotalCost());
        document.querySelectorAll('.total-price').forEach(element => {
            observer.observe(element, {
                childList: true
            });
        });

        quantityInput.addEventListener('input', () => {
            updateTotalCost();
            saveToLocalStorage();
        });
        unitPriceInput.addEventListener('input', () => {
            updateTotalCost();
            saveToLocalStorage();
        });
        shippingTypeSelect.addEventListener('change', () => {
            fetchShippingCost();
            saveToLocalStorage();
        });

        window.onload = () => {
            loadFromLocalStorage();
            updateTotalCost();
        };

        console.log("Auto-save shipping script loaded!");
        document.addEventListener("DOMContentLoaded", function() {
            if (sessionStorage.getItem('clear_shipping')) {
                clearCartData();
                sessionStorage.removeItem('clear_shipping');
            }
        });

        function clearCartData() {
            localStorage.removeItem('cartData');
            console.log(" done");
        }
    </script>
    <script>
        document.getElementById("proceedToOrder").addEventListener("click", function() {
            let loadingScreen = document.getElementById("loadingScreen");
            loadingScreen.style.display = "flex";
            loadingScreen.style.position = "fixed";

            setTimeout(function() {
                window.location.href = "{{ route('cart.order') }}";
            }, 3000);
        });

        window.onpageshow = function(event) {
            if (event.persisted) {
                let loadingScreen = document.getElementById("loadingScreen");
                loadingScreen.style.display = "none";
            }
        };
    </script>
 
{{-- <script>
    $(document).ready(function () {
        // تحديث السعر في الواجهة فقط (بدون إرسال للباك)
        $("input[name='price'], input[name='qty']").on("input", function () {
            let row = $(this).closest("tr");
            let price = parseFloat(row.find("input[name='price']").val()) || 0;
            let qty = parseInt(row.find("input[name='qty']").val()) || 1;
            let total = (price * qty).toFixed(2);
            row.find(".total-price").text("$" + total);

            // منع السالب
            if (price < 0) {
                row.find("input[name='price']").val(0);
                row.find(".total-price").text("$" + (0 * qty).toFixed(2));
            }
        });

        // عند فقدان التركيز من حقل الوصف، نرسل كل شي للباك مرة وحدة
        $("textarea[name='description']").on("blur", function () {
            let row = $(this).closest("tr");
            let form = row.find("form").first(); // نفترض إنو أول فورم هو المشترك

            let price = parseFloat(row.find("input[name='price']").val()) || 0;
            let qty = parseInt(row.find("input[name='qty']").val()) || 1;
            let area = row.find("input[name='area']").val();
            let description = row.find("textarea[name='description']").val();

            $.ajax({
                url: form.attr("action"),
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "PUT",
                    price: price,
                    qty: qty,
                    area: area,
                    description: description
                },
                success: function (response) {
                    console.log("All data updated successfully on blur");
                },
                error: function (error) {
                    console.log("Error updating data", error);
                }
            });
        });
    });
</script> 

 <script>
    $(document).ready(function () {
        let timers = {};

        $("tr").each(function () {
            const row = $(this);

            // لما المستخدم يطلع من أي عنصر داخل الصف
            row.on("focusout", function () {
                const rowId = row.index();

                // نعمل تايمر صغير لنتأكد إنو فعلاً طلع من الصف
                timers[rowId] = setTimeout(function () {
                    // إذا ولا عنصر بالصف عليه تركيز (focus)
                    if (!row.find(":focus").length) {
                        sendRowData(row);
                    }
                }, 200); // استنى شوي بعد فقدان التركيز
            });

            // إذا رجع فوكس على عنصر داخل الصف قبل الوقت المحدد، نوقف الإرسال
            row.on("focusin", function () {
                const rowId = row.index();
                clearTimeout(timers[rowId]);
            });
        });

        // بس نغير السعر أو الكمية نحدث السعر بالواجهة (ما منبعت شي هون)
        $("input[name='price'], input[name='qty']").on("input", function () {
            let row = $(this).closest("tr");
            let price = parseFloat(row.find("input[name='price']").val()) || 0;
            let qty = parseInt(row.find("input[name='qty']").val()) || 1;
            let total = (price * qty).toFixed(2);
            row.find(".total-price").text("$" + total);

            // منع السالب
            if (price < 0) {
                row.find("input[name='price']").val(0);
                row.find(".total-price").text("$" + (0 * qty).toFixed(2));
            }
        });

        // دالة إرسال القيم
        function sendRowData(row) {
            let form = row.find("form").first();

            let price = parseFloat(row.find("input[name='price']").val()) || 0;
            let qty = parseInt(row.find("input[name='qty']").val()) || 1;
            let area = row.find("input[name='area']").val();
            let description = row.find("textarea[name='description']").val();

            $.ajax({
                url: form.attr("action"),
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "PUT",
                    price: price,
                    qty: qty,
                    area: area,
                    description: description
                },
                success: function (response) {
                    console.log("Row data updated successfully");
                },
                error: function (error) {
                    console.log("Error updating row data", error);
                }
            });
        }
    }); --}}
    <script>
        $(document).ready(function () {
            let timers = {};
            let rowSent = {}; // لتتبع إذا تم الإرسال لكل tr
    
            $("tr").each(function () {
                const row = $(this);
                const rowId = row.index();
                rowSent[rowId] = false;
    
                // لما المستخدم يطلع من أي عنصر داخل الصف
                row.on("focusout", function () {
                    timers[rowId] = setTimeout(function () {
                        if (!row.find(":focus").length) {
                            // إذا ما تم الإرسال من قبل، أرسل
                            if (!rowSent[rowId]) {
                                sendRowData(row, rowId);
                            }
                        }
                    }, 200);
                });
    
                // إلغاء التايمر إذا رجع المستخدم على العنصر بسرعة
                row.on("focusin", function () {
                    clearTimeout(timers[rowId]);
                });
    
                // لما يعدل المستخدم أي شي بعد ما تم إرسال البيانات، نعمل ريلود
                row.find("input, textarea").on("input", function () {
                    if (rowSent[rowId]) {
                        location.reload(); // إعادة تحميل الصفحة
                    }
                });
            });
    
            // تحديث السعر بالواجهة
            $("input[name='price'], input[name='qty']").on("input", function () {
                let row = $(this).closest("tr");
                let price = parseFloat(row.find("input[name='price']").val()) || 0;
                let qty = parseInt(row.find("input[name='qty']").val()) || 1;
                let total = (price * qty).toFixed(2);
                row.find(".total-price").text("$" + total);
    
                if (price < 0) {
                    row.find("input[name='price']").val(0);
                    row.find(".total-price").text("$" + (0 * qty).toFixed(2));
                }
            });
    
            // دالة إرسال البيانات
            function sendRowData(row, rowId) {
                let form = row.find("form").first();
    
                let price = parseFloat(row.find("input[name='price']").val()) || 0;
                let qty = parseInt(row.find("input[name='qty']").val()) || 1;
                let area = row.find("input[name='area']").val();
                let description = row.find("textarea[name='description']").val();
    
                $.ajax({
                    url: form.attr("action"),
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "PUT",
                        price: price,
                        qty: qty,
                        area: area,
                        description: description
                    },
                    success: function (response) {
                        console.log("Row data updated successfully");
                        rowSent[rowId] = true; // حط علامة إنه هالصف أُرسل
                    },
                    error: function (error) {
                        console.log("Error updating row data", error);
                    }
                });
            }
        });
    </script>
    
</script>

@endpush
@push('scripts')
    <script>
        document.getElementById('proceedToOrder').addEventListener('click', function(event) {
            event.preventDefault();

            // تحديث الحقول المخفية الخاصة بالشحن
            document.getElementById('shippingTypeInput').value = document.getElementById('shippingType').value;
            document.getElementById('quantityInput').value = document.getElementById('quantity').value;
            document.getElementById('unitPriceInput').value = document.getElementById('unitPrice').value;
            document.getElementById('shippingCostInput').value = document.getElementById('shippingCost').value;
            document.getElementById('totalCostInput').value = document.getElementById('total-cost').textContent
                .replace(',', '');

            let descriptions = document.querySelectorAll('.description-input');
            let forms = [];

            descriptions.forEach(textarea => {
                let form = textarea.closest('.description-form');
                if (form) {
                    forms.push(fetch(form.action, {
                        method: "POST",
                        body: new FormData(form),
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    }));
                }
            });

            const shippingForm = document.getElementById('shippingForm');
            forms.push(fetch(shippingForm.action, {
                method: "POST",
                body: new FormData(shippingForm),
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            }));

            // إرسال جميع البيانات ثم الانتقال إلى صفحة الطلب
            Promise.all(forms).then(() => {
                window.location.href = "{{ route('cart.order') }}";
            });
        });
    </script>
@endpush
