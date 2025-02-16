@extends('layouts.app')
 
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

    .form-floating label {
        font-size: 14px;
        color: #222;
    }

    .form-floating .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 12px 16px;
        font-size: 16px;
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }

    .form-floating .form-control:focus {
        border-color: #20bec6;
        box-shadow: 0 0 5px rgba(32, 190, 198, 255);
        background-color: #ffffff;
    }

    .form-floating label {
        font-weight: bold;
        font-size: 16px;
        color: #444;
    }

    .form-floating .form-control::placeholder {
        color: #888;
    }

    .btn-primary,
    .btn-info {
        background-color: #20bec6;
        color: white;
        padding: 10px 20px;
        border-radius: 4px;
        font-size: 14px;
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    .btn-primary:hover,
    .btn-info:hover {
        background-color: #20bec6;
        transform: scale(1.05);
    }

    .btn-primary:hover {
        background-color: #20bec6;
        transform: scale(1.05);
    }

    .checkout__totals-wrapper {
        margin-top: 20px;
        padding: 20px;
        border: 1px solid #e5e5e5;
        border-radius: 6px;
        background-color: #f9f9f9;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .order-summary p {
        font-size: 16px;
        color: #333;
    }

    .order-summary strong {
        color: #20bec6;
    }

    .ckeditor {
        height: 150px;
        resize: vertical;
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 10px;
        font-size: 14px;
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }

    .ckeditor:focus {
        border-color: #20bec6;
        box-shadow: 0 0 5px rgba(16, 159, 175, 0.5);
    }

    .btn-primary {
        background-color: #20bec6;
        color: white;
    }

    .form-floating input[type="file"] {
        background-color: #f9f9f9;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        border-radius: 3px;
    }

    .form-floating input[type="file"]:focus {
        border-color: #20bec6;
        box-shadow: 0 0 5px rgba(16, 159, 175, 0.5);
        border-radius: 3px;
    }
    
         .preview-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .preview-container img {
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        /* Style the phone input field with country code dropdown */
        .iti {
            width: 100%;
        }

        .iti .iti__selected-flag {
            border-radius: 8px 0 0 8px;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .iti .iti__input {
            border-radius: 0 8px 8px 0;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            width: calc(100% - 40px);
            transition: all 0.3s ease;
        }

        .iti .iti__input:focus {
            border-color: #20bec6;
            box-shadow: 0 0 5px rgba(32, 190, 198, 0.5);
        }




        .form-floating .form-select {
            width: 100%;
            height: calc(3.5rem + 2px);
            font-size: 16px;
            line-height: 1.5;
            padding: 0.75rem 1.25rem;
        }

        .form-select option {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .form-select:hover,
        .form-select:focus {
            border-color: #20bec6;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .select-dropdown {
            max-height: 300px;
            overflow-y: auto;
            border-radius: 5px;
        }
        .bg-turquoise {
    background-color: #20bec6 !important; /* كود اللون الفيروزي */
    color: white !important; /* لون النص أبيض للتباين */
}

 </style>

@section('content')
    <main class="pt-90">
 
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">

            <form name="checkout-form" action="{{ route('cart.place-order') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row mt-5">


 


                            <div class="col-md-12">
                                <div class="form-group my-3">
                                    <label for="extra">Message *</label>
                                    <textarea class="form-control ckeditor" name="extra" id="extra" rows="5"></textarea>

                                    @error('extra')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>



                            </div>




                            <div class="col-md-12 mt-4">
                                @foreach($cartItems as $item)
                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-header bg-turquoise text-white fw-bold">
                                            {{ $item->name }} <!-- اسم المنتج -->
                                        </div>
                                        
                                        <div class="card-body">
                                            <div class="form-group my-3">
                                                <label for="customer_responsibilities_{{ $item->id }}">Customer's Responsibilities *</label>
                                                <textarea class="form-control ckeditor" name="customer_responsibilities[{{ $item->id }}]" id="customer_responsibilities_{{ $item->id }}">
                                                    {{ old("customer_responsibilities.$item->id", $customer_responsibilities[$item->id] ?? 'No responsibilities listed.') }}
                                                </textarea>
                                                @error("customer_responsibilities.$item->id")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                            
                                            <div class="form-group my-3">
                                                <label for="company_responsibilities_{{ $item->id }}">Company's Responsibilities *</label>
                                                <textarea class="form-control ckeditor" name="company_responsibilities[{{ $item->id }}]" id="company_responsibilities_{{ $item->id }}">
                                                    {{ old("company_responsibilities.$item->id", $company_responsibilities[$item->id] ?? 'No responsibilities listed.') }}
                                                </textarea>
                                                @error("company_responsibilities.$item->id")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            
                            
                            <!-- New Billing Info Section -->
                            <div class="col-md-12 mt-4">
                                <div class="form-group my-3">
                                    <label for="billing_info">Billing Information *</label>
                                    <textarea class="form-control ckeditor" name="billing_info" id="billing_info" rows="5"> </textarea>
                                    @error('billing_info')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                        </div>
                        <div class="checkout__totals-wrapper">
                            <fieldset>
                                <div class="body-title mb-10">Upload Technical Drawings or Images</div>
                                <div class="upload-image mb-16">
                                    <label class="uploadfile" for="images">
                                        <span class="icon"><i class="icon-upload-cloud"></i></span>
                                        <input type="file" id="images" name="images[]" accept="image/*" multiple>
                                    </label>
                                    <div id="preview-container" class="preview-container"></div>
                                </div>
                            </fieldset>
    
                            <!-- Preview of selected images as a grid -->
                            <div id="image-preview" class="my-3"></div>
    
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"
                                    style="background-color: #20bec6; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-size: 16px; cursor: pointer; transition: transform 0.3s ease, background-color 0.3s ease;">
                                    Proceed To Order
                                </button>
                            </div>
                        </div>
                    </div>

                 

            </form>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('images');
            const previewContainer = document.getElementById('preview-container');
            let allFiles = []; // Store all selected files

            function updateFileList() {
                const dataTransfer = new DataTransfer();
                allFiles.forEach(file => dataTransfer.items.add(file));
                imageInput.files = dataTransfer.files;
            }

            function previewImages(event) {
                const newFiles = Array.from(event.target.files); // Convert FileList to array

                // Append new files only if they are not already selected
                newFiles.forEach(file => {
                    if (!allFiles.some(existingFile => existingFile.name === file.name && existingFile
                            .size === file.size)) {
                        allFiles.push(file);
                    }
                });

                renderPreview();
                updateFileList();
            }

            function renderPreview() {
                previewContainer.innerHTML = ''; // Clear existing previews

                allFiles.forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const imageWrapper = document.createElement('div');
                        imageWrapper.style.position = 'relative';
                        imageWrapper.style.display = 'inline-block';
                        imageWrapper.style.margin = '5px';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Image Preview';
                        img.style.maxWidth = '100px';
                        img.style.maxHeight = '100px';
                        img.style.objectFit = 'cover';

                        const deleteButton = document.createElement('button');
                        deleteButton.innerHTML = 'X';
                        deleteButton.style.position = 'absolute';
                        deleteButton.style.top = '5px';
                        deleteButton.style.right = '5px';
                        deleteButton.style.backgroundColor = 'red';
                        deleteButton.style.color = 'white';
                        deleteButton.style.border = 'none';
                        deleteButton.style.padding = '5px';
                        deleteButton.style.cursor = 'pointer';

                        deleteButton.addEventListener('click', function() {
                            allFiles.splice(index, 1); // Remove from the array
                            renderPreview();
                            updateFileList();
                        });

                        imageWrapper.appendChild(img);
                        imageWrapper.appendChild(deleteButton);
                        previewContainer.appendChild(imageWrapper);
                    };

                    reader.readAsDataURL(file);
                });
            }

            imageInput.addEventListener('change', previewImages);
        });




        document.addEventListener('DOMContentLoaded', function() {
    ClassicEditor
        .create(document.querySelector('#extra'))
        .then(editor => {
            let clientName = "{{ $address->name }}"; // جلب اسم العميل من الـ Controller
            let productNames = @json($cartItems->pluck('name')); // جلب أسماء المنتجات من الكارت

            // إذا كانت هناك منتجات، اجمع أسمائها في نص
            let productNamesText = productNames.length > 0 ? productNames.join(', ') : 'Product Name'; // دمج الأسماء أو وضع اسم افتراضي

            editor.setData(`
                Dear <strong>${clientName}</strong>,<br>
                Please find attached the offer for your inquiry along with all sales conditions and technical specifications for <strong>${productNamesText}</strong>.<br>
                We wish this offer would welcome all of your needs.<br><br>
                Best Regards.
            `);
        })
        .catch(error => {
            console.error(error);
        });
});

        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#billing_info'))
                .then(editor => { 
                    let companiesResponsibilities = @json($companiesResponsibilities); // جلب مسؤوليات الشركة من الكارت
                    let customersResponsibilities = @json($customersResponsibilities); // جلب مسؤوليات العميل من الكارت
                    editor.setData(`
<p><strong>Validity:</strong> Offer is valid only for Seven days. All conditions will be revised accordingly after the date is expired.</p>
<p><strong>Pricing:</strong> Given offer is EXW - Istanbul according to Incoterms 2000.</p>
<p><strong>Account holder:</strong> PREFABEX YAPI TEKNOLOJILERI INS SAN VE TIC LTD STI</p>
<p><strong>Bank Name:</strong> ALBARAKA TURK</p>
<p><strong>USD IBAN:</strong> TR72 0020 3000 0370 7695 0000 02</p>
<p><strong>SWIFT CODE:</strong> BTFHTRISXXX</p>

<h3>General Contract Conditions</h3>
<div class="attachment-1-list">
    <ol>
        <li>
            <strong>Payment</strong>
            <ul>
                <li>50% advanced payment, 50% before loading.</li>
            </ul>
        </li>

        <li>
            <strong>Production</strong>
            <ul>
                <li>Production will be completed within 1/3/1900 Month/s since receiving the down payment and order confirmation.</li>
                <li>Production starting date is considered as of the date that the COMPANY receives the advance payment from the CUSTOMER.</li>
                <li>The order becomes definite with the payment done by the CUSTOMER to the COMPANY.</li>
                <li>Delays caused by force majeure such as earthquake, flood, fire and other natural disasters, mobilization, strikes, lockouts, accident or theft during transportation or installation, delays caused by suppliers of raw materials will be added to the deadline.</li>
            </ul>
        </li>

        <li>
            <strong>Assembling</strong>
            <ul>
                <li>Assembling is not included in our price offer.</li>
                <li>Upon customer request, Prefabex can send a few technicians.</li>
                <li>Upon customer request, Prefabex can send a few semi-skilled workers to help the assembling team.</li>
                <li>Customer will pay for technicians/workers flight tickets, accommodation food, transportation and daily fees of 200 USD per technician per day.</li>
                <li>Assembling is expected to be completed within 0 ###.</li>
            </ul>
        </li>

   <li><strong>Customer’s Responsibilities</strong>
                            <ul>
                                <li>${customersResponsibilities ? customersResponsibilities : 'No responsibilities listed.'}</li>
                            </ul>
                        </li>
                        <li><strong>Company’s Responsibilities</strong>
                            <ul>
                                <li>${companiesResponsibilities ? companiesResponsibilities : 'No responsibilities listed.'}</li>
                            </ul>
                        </li>


        <li>
            <strong>Other Conditions</strong>
            <ul>
                <li>CUSTOMER cannot make changes on approved projects or on technical specifications after production begins.</li>
            </ul>
        </li>

        <li>
            <strong>Warranty Coverage</strong>
            <ul>
                <li>The order subject of this offer, will be under warranty of the COMPANY for one (1) year against defects of production. Warranty period will start after the invoice date. In order to get warranty coverage, the CUSTOMER is required to present the invoice. Damage and defects that are related to the customer are not covered in the warranty.</li>
                <li>The COMPANY is not responsible for the problems that may happen because of adding extra works or parts on the product interior and exterior.</li>
                <li>The COMPANY is not responsible for problems that may occur due to relocating the product to another location.</li>
                <li>Stated values for wind resistance are valid on the condition that the product is fixed to the ground. Fixing process is responsibility of the customer.</li>
            </ul>
        </li>

        <li>
            <strong>Disagreement</strong>
            <ul>
                <li>In case of a disagreement, both sides will try their best to solve the issue in an amicable settlement. If the disagreement is not solved within thirty (30) business days, courts of Istanbul are authorized to solve the dispute.</li>
            </ul>
        </li>

    </ol>
</div>
            `);
                })
                .catch(error => {
                    console.error(error);
                });
        });
        document.addEventListener('DOMContentLoaded', function() {
            let productNames = @json($cartItems->pluck('name')->toArray()); // جلب أسماء المنتجات من السلة

            @foreach($cartItems as $item)
                ClassicEditor.create(document.querySelector('#customer_responsibilities_{{ $item->id }}'))
                    .then(editor => {
                        let customersResponsibilities = @json($item->options['customers_responsibilities'] ?? 'No responsibilities listed.');
                        let formattedData = `
                            <ul>
                                     <ul>
                                        <li>${customersResponsibilities}</li>
                                    </ul>
                                
                            </ul>
                        `;
                        editor.setData(formattedData);
                    })
                    .catch(error => console.error(error));

                ClassicEditor.create(document.querySelector('#company_responsibilities_{{ $item->id }}'))
                    .then(editor => {
                        let companiesResponsibilities = @json($item->options['companies_responsibilities'] ?? 'No responsibilities listed.');
                        let formattedData = `
                            <ul>
                                     <ul>
                                        <li>${companiesResponsibilities}</li>
                                    </ul>
                                 
                            </ul>
                        `;
                        editor.setData(formattedData);
                    })
                    .catch(error => console.error(error));
            @endforeach
        });
    </script>

@endpush
