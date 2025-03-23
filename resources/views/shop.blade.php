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
             height: 100px;
         }

         input[name="qty"] {
            width: 60px;
         }

         table {
            width: 100%;
         }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        /* General Styles */
        body {

            padding-top: 20px;
 
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
             margin: auto;
             text-align: center;
            margin-left: -15%;  

        }

        table {
            width: 100%;
            table-layout: fixed;
         }

        th,
        td {
            white-space: nowrap;
             overflow: hidden;
            text-overflow: ellipsis;
         }

        td input,
        td textarea {
            width: 90%;
             max-width: 120px;
         }

        td .description-input {
            width: 90%;
             max-width: 250px;
        }

        .cart-container:last-child {
            margin-top: 40px;
         }

        @media (max-width: 768px) {
            .cart-container {
                width: 100%;
            }

            table {
                font-size: 12px;
             }

            td input,
            td textarea {
                max-width: 100px;
            }
        }

         .dropdown-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            white-space: nowrap;
             overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
         }

         .dropdown-item span {
            max-width: 70%;
             word-wrap: break-word;
             overflow-wrap: break-word;
            font-size: 14px;
         }

         .add-to-cart-btn {
            flex-shrink: 0;
             margin-left: 10px;
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
                <col style="width:30%;"> 
                <col style="width: 15%;"> 
                <col style="width: 15%;"> 
                <col style="width: 15%;">
                <col style="width: 20%;">
                <col style="width: 30%;"> 
                <col style="width: 20%;"> 
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
                            <td>{{ $item->name }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.price.update', ['rowId' => $item->rowId]) }}">
                                    @csrf
                                    @method('PUT')
                                     <input type="number" name="price" value="{{ $item->price }}" step="0.01" min="0" oninput="checkPrice(this)" />

<script>
    function checkPrice(input) {
        if (input.value < 0) {
            input.value = 0;
        }
    }
</script>

                                </form>
                            </td>
    
                            <td>
                                <form method="POST" action="{{ route('cart.area.update', ['rowId' => $item->rowId]) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="area" data-row-id="{{ $item->rowId }}" value="{{ $item->options['area'] }}">
                                </form>
                            </td>
                            
    
                            <td>
                                <form method="POST" action="{{ route('cart.qty.update', ['rowId' => $item->rowId]) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="qty" value="{{ $item->qty }}" min="1" />
                                </form>
                            </td>
                            <td class="total-price">${{ $item->subTotal() }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.description.update', ['rowId' => $item->rowId]) }}" class="description-form">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="description" class="description-input" data-row-id="{{ $item->rowId }}">{{ $item->options['description'] }}</textarea>
                                </form>
                            </td>
                            <td>
                                <div class="button-group">
                                    <a href="{{ route('cart.edit', ['rowId' => $item->rowId]) }}" class="btn btn-primary" id="editButton">Edit Specifications</a>
                                    <form method="POST" action="{{ route('cart.item.remove', ['rowId' => $item->rowId]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" style="border: none; background: none; color: rgba(32, 190, 198, 0.5); font-size: 20px;">&times;</button>
                                    </form>
                                    <script>
                                        let isProcessing = false;  // متغير لتتبع حالة العمليات الجارية
                            
                                        function disableButtons() {
                                            document.querySelectorAll('.btn').forEach(button => {
                                                button.disabled = true;
                                            });
                                        }
                            
                                        function enableButtons() {
                                            document.querySelectorAll('.btn').forEach(button => {
                                                button.disabled = false;
                                            });
                                        }
                            
                                        // Disable edit button until all operations are finished
                                        function toggleEditButton() {
                                            const editButton = document.getElementById('editButton');
                                            if (isProcessing) {
                                                editButton.disabled = true;  // تعطيل زر التعديل
                                            } else {
                                                editButton.disabled = false;  // تفعيل زر التعديل
                                            }
                                        }
                            
                                        document.addEventListener("DOMContentLoaded", function() {
                                            // تعطيل زر الحذف عندما تكون هناك عملية جارية
                                            document.querySelectorAll("form[action*='cart.item.remove']").forEach(form => {
                                                form.addEventListener("submit", function(event) {
                                                    if (isProcessing) {
                                                        event.preventDefault();  // منع الإرسال إذا كانت هناك عملية جارية
                                                        alert("يرجى الانتظار حتى تكتمل العملية الحالية.");
                                                    } else {
                                                        isProcessing = true;
                                                        disableButtons();  // تعطيل الأزرار أثناء العملية
                                                        toggleEditButton();  // تعطيل زر التعديل
                                                    }
                                                });
                                            });
                            
                                            // تعطيل زر التعديل عندما تكون هناك عملية جارية
                                            document.querySelectorAll("a[href*='cart.edit']").forEach(link => {
                                                link.addEventListener("click", function(event) {
                                                    if (isProcessing) {
                                                        event.preventDefault();  // منع التفاعل إذا كانت هناك عملية جارية
                                                        alert("يرجى الانتظار حتى تكتمل العملية الحالية.");
                                                    } else {
                                                        isProcessing = true;
                                                        disableButtons();  // تعطيل الأزرار أثناء العملية
                                                        toggleEditButton();  // تعطيل زر التعديل
                                                    }
                                                });
                                            });
                                        });
                            
                                        // تمكين الأزرار بعد انتهاء العملية (إذا كنت تستخدم AJAX، ضع هذا في الـ success callback)
                                        window.addEventListener("load", function() {
                                            isProcessing = false;
                                            enableButtons();
                                            toggleEditButton();  // تفعيل زر التعديل بعد انتهاء العمليات
                                        });
                                    </script>
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
                                    <input type="number" name="unit_price" id="unitPrice" value="0.00" step="0.01" min="0" oninput="checkPrice(this)" />
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
                <button type="button" class="btn btn-primary" id="proceedToOrder" @if ($items->count() < 1) disabled @endif
                    style="font-size: 16px; padding: 10px 20px;">
                    Proceed to Order
                </button>
            </div>

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
 document.addEventListener("DOMContentLoaded", function () {
    let searchBox = document.getElementById("searchBox");
    let dropdownContainer = document.getElementById("dropdownContainer");
    let productDropdown = document.getElementById("productDropdown");

    searchBox.addEventListener("focus", function () {
        dropdownContainer.style.display = "block";
    });

    document.addEventListener("click", function (event) {
        if (!dropdownContainer.contains(event.target) && event.target !== searchBox) {
            dropdownContainer.style.display = "none";
        }
    });

    searchBox.addEventListener("keyup", debounce(function () {
        let query = this.value.toLowerCase();
        let items = productDropdown.getElementsByClassName("dropdown-item");
        let hasResults = false;

        for (let item of items) {
            let match = item.textContent.toLowerCase().includes(query);
            item.style.display = match ? "flex" : "none";
            if (match) hasResults = true;
        }

        dropdownContainer.style.display = hasResults ? "block" : "none";
    }, 200));

    productDropdown.addEventListener("click", async function (event) {
        if (event.target.classList.contains("add-to-cart-btn")) {
            let productId = event.target.getAttribute("data-id");
            let button = event.target;
            
            // تعطيل الزر أثناء الإضافة
            button.disabled = true;
            button.textContent = "Adding...";

            try {
                let response = await fetch("{{ route('cart.add') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: productId,
                        quantity: 1
                    })
                });

                if (response.ok) {
                    // ✅ تحسين إعادة تحميل الصفحة بدون إعادة تحميل الكاش
                    window.location.reload(true); 
                } else {
                    console.error("Error adding to cart:", response.statusText);
                }
            } catch (error) {
                console.error("Error:", error);
            } finally {
                button.disabled = false;
                button.textContent = "Add";
            }
        }
    });

    function debounce(func, delay) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(this, args), delay);
        };
    }
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
        subtotal: subtotalInput.value,
        shipping_incoterm: document.getElementById('shipping_incoterm').value,
        port_name_or_city: document.getElementById('port_name_or_city').value
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
        document.getElementById('totalCostInput').value = totalCostSpan.textContent.replace(',', '');

        let descriptions = document.querySelectorAll('.description-input');
        let forms = [];
        descriptions.forEach(textarea => {
            let form = textarea.closest('.description-form');
            if (form) {
                forms.push(fetch(form.action, {
                    method: "POST",
                    body: new FormData(form),
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }));
            }
        });

        const shippingForm = document.getElementById('shippingForm');
        forms.push(fetch(shippingForm.action, {
            method: "POST",
            body: new FormData(shippingForm),
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
    productTotalSpan.textContent = productTotal.toLocaleString('en-US', { minimumFractionDigits: 2 });
    subtotalInput.value = productTotal.toFixed(2);

    const totalWithShipping = productTotal + totalShippingCost;
    totalCostSpan.textContent = totalWithShipping.toLocaleString('en-US', { minimumFractionDigits: 2 });

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
        total_cost: totalCostSpan.textContent.replace(',', ''),
        shipping_incoterm: document.getElementById('shipping_incoterm').value,
        port_name_or_city: document.getElementById('port_name_or_city').value
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

quantityInput.addEventListener('input', () => { updateTotalCost(); saveToLocalStorage(); });
unitPriceInput.addEventListener('input', () => { updateTotalCost(); saveToLocalStorage(); });
shippingTypeSelect.addEventListener('change', () => { fetchShippingCost(); saveToLocalStorage(); });

window.onload = () => {
    loadFromLocalStorage();
    updateTotalCost();
};

console.log("Auto-save shipping script loaded!");
document.addEventListener("DOMContentLoaded", function () {
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
@endpush
@push('scripts')
<script>
$(document).ready(function() {
    let isProcessing = false;   

     function disableButtons() {
        $(".btn").prop("disabled", true);
    }

     function enableButtons() {
        $(".btn").prop("disabled", false);
    }

     function toggleUpdateButton() {
        let price = $("input[name='price']").val().trim();
        let qty = $("input[name='qty']").val().trim();
        
         if (price !== "" && qty !== "") {
            $(".update-btn").prop("disabled", false);  
        } else {
            $(".update-btn").prop("disabled", true);
        }
    }

    $("input[name='price']").on("input", function() {
        var row = $(this).closest("tr");
        var priceInput = $(this);
        var price = parseFloat(priceInput.val()) || 0;
        var quantity = parseInt(row.find("input[name='qty']").val()) || 1;
        var total = (price * quantity).toFixed(2); 

        row.find(".total-price").text("$" + total); 

        $.ajax({
            url: priceInput.closest("form").attr("action"),
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                _method: "PUT",
                price: price
            },
            success: function(response) {
             },
            error: function(error) {
             }
        });

        toggleUpdateButton();  // تحقق من تفعيل الزر
    });

    $("input[name='qty']").on("input", function() {
        var row = $(this).closest("tr");
        var quantityInput = $(this);
        var price = parseFloat(row.find("input[name='price']").val()) || 0;
        var quantity = parseInt(quantityInput.val()) || 1;
        var total = (price * quantity).toFixed(2); 

        row.find(".total-price").text("$" + total); 

        $.ajax({
            url: quantityInput.closest("form").attr("action"),
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                _method: "PUT",
                qty: quantity
            },
            success: function(response) {
                console.log("✅ Quantity updated successfully");
            },
            error: function(error) {
                console.log("❌ Error updating quantity", error);
            }
        });

        toggleUpdateButton();  // تحقق من تفعيل الزر
    });

    $("input[name='area']").on("blur", function() {
        if (isProcessing) return;

        isProcessing = true;
        disableButtons();

        var areaInput = $(this);
        var form = areaInput.closest("form");
        var formData = new FormData(form[0]);

        $.ajax({
            url: form.attr("action"),
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
            },
            success: function(response) {
                 setTimeout(() => location.reload(), 50); // Reload فورًا بعد نجاح الطلب
                isProcessing = false;
                enableButtons();
            },
            error: function(error) {
                 isProcessing = false;
                enableButtons();
            }
        });
    });

    $(".description-input").on("blur", function() {
        if (isProcessing) return;

        isProcessing = true;
        disableButtons();

        var descInput = $(this);
        var form = descInput.closest("form");
        var formData = new FormData(form[0]);

        $.ajax({
            url: form.attr("action"),
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
            },
            success: function(response) {
                 setTimeout(() => location.reload(), 50); // Reload فورًا بعد نجاح الطلب
                isProcessing = false;
                enableButtons();
            },
            error: function(error) {
                 isProcessing = false;
                enableButtons();
            }
        });
    });
});

    
    
 
 $(document).ready(function() {
    $("#proceedToOrder").on("click", function(event) {
        event.preventDefault(); 

        let requests = []; 

        $("input[name='price'], input[name='area']").each(function() {
            let input = $(this);
            input.trigger("input"); 
        });

        $(".description-input").each(function() {
            let form = $(this).closest(".description-form");
            if (form.length) {
                let formData = new FormData(form[0]);
                let request = fetch(form.attr("action"), {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
                    }
                }).catch(error => console.error("❌ خطأ في حفظ الوصف:", error));

                requests.push(request);
            }
        });

       
$("input[name='area']").each(function() {
    let areaInput = $(this);
    let form = areaInput.closest("form");
    let formData = new FormData(form[0]);

    let request = fetch(form.attr("action"), {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
        }
    }).catch(error => console.error("❌ خطأ في تحديث Area:", error));

    requests.push(request);
});

        $("#shippingTypeInput").val($("#shippingType").val());
        $("#quantityInput").val($("#quantity").val());
        $("#unitPriceInput").val($("#unitPrice").val());
        $("#shippingCostInput").val($("#shippingCost").val());
        $("#totalCostInput").val($("#total-cost").text().replace(',', ''));
      formData.set('shipping_incoterm', document.getElementById('shipping_incoterm').value);
    formData.set('port_name_or_city', document.getElementById('port_name_or_city').value);

        let shippingRequest = fetch($("#shippingForm").attr("action"), {
            method: "POST",
            body: new FormData($("#shippingForm")[0]),
            headers: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
            }
        }).catch(error => console.error("❌", error));

        requests.push(shippingRequest);

        Promise.all(requests).finally(() => {
            window.location.href = "{{ route('cart.order') }}"; 
        });
    });
});

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
@endpush
