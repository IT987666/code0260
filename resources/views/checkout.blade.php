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
</style>

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Enter Customer Information</h2>

            <form name="checkout-form" action="{{ route('cart.place.an.order') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h4>Customer DETAILS</h4>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="name" required="">
                                    <label for="name">Full Name *</label>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" id="phone" name="phone" required="">
                                    <label for="phone">Phone Number *</label>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <select class="form-select" id="country" name="country" required="">
                                        <option value="" disabled selected>Select Country</option>

                                    </select>
                                    <label for="country">Country *</label>
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="email" class="form-control" name="email" required="">
                                    <label for="email">Email *</label>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-group my-3">
                                    <label for="extra">Message *</label>
                                    <textarea class="form-control ckeditor" name="extra" id="extra" rows="5"></textarea>

                                    @error('extra')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
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
                                Order Confirmation
                            </button>
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
            let allFiles = []; // Array to store all selected files

            function previewImages(event) {
                // Get newly selected files
                const newFiles = event.target.files;

                // Append new files to the existing files
                allFiles = [...allFiles, ...newFiles];

                // Clear the preview container
                previewContainer.innerHTML = '';

                // Loop through all files and display them in preview
                for (let i = 0; i < allFiles.length; i++) {
                    const file = allFiles[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // Create container for each image with delete button
                        const imageWrapper = document.createElement('div');
                        imageWrapper.style.position = 'relative';
                        imageWrapper.style.display = 'inline-block';
                        imageWrapper.style.margin = '5px';

                        // Create the image element
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Image Preview';
                        img.style.maxWidth = '100px';
                        img.style.maxHeight = '100px';
                        img.style.objectFit = 'cover';

                        // Create the delete button
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

                        // Append the image and the delete button to the wrapper
                        imageWrapper.appendChild(img);
                        imageWrapper.appendChild(deleteButton);

                        // Append the image wrapper to the preview container
                        previewContainer.appendChild(imageWrapper);

                        // Add delete functionality
                        deleteButton.addEventListener('click', function() {
                            // Remove the image from the preview container
                            previewContainer.removeChild(imageWrapper);

                            // Remove the file from the allFiles array
                            allFiles = allFiles.filter((f, index) => index !== i);

                            // Update the file input with the remaining files
                            const dataTransfer = new DataTransfer();
                            allFiles.forEach(file => {
                                dataTransfer.items.add(file);
                            });
                            imageInput.files = dataTransfer.files;
                        });
                    };

                    reader.readAsDataURL(file);
                }
            }

            // Listen for changes in the file input
            imageInput.addEventListener('change', previewImages);
        });
        document.addEventListener('DOMContentLoaded', () => {
            const countrySelect = document.querySelector('#country');

            [...countrySelect.options].forEach(option => {
                option.title = option.textContent;
            });
        });




        // إضافة رمز الدولة تلقائيًا عند اختيار الدولة
        document.getElementById('country').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const countryCode = selectedOption.getAttribute('data-code');
            const phoneInput = document.getElementById('phone');

            if (countryCode) {
                phoneInput.value = countryCode + ' ';
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#extra'))
                .then(editor => {
                    editor.setData(`
Dear -------- ,<br>
Please find attached the offer for your inquiry along with all sales conditions and technical specifications for <strong>----------</strong>.<br>
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

        <li>
            <strong>Customer’s Responsibilities</strong>
            <ul>
                <li>Heating and cooling systems</li>
                <li>Water heaters and boilers</li>
                <li>Outer connections for electricity and plumbing</li>
                <li>Obtaining all legal permits</li>
                <li>Customs clearance and taxes in country of destination</li>
                <li>Transportation from port of destination to site</li>
                <li>Any electric, plumbing works outside borders of the buildings (including water tanks and main site networks)</li>
                <li>Concrete slab according to the plan provided by the company</li>
                <li>Crane, forklift, scaffolding</li>
                <li>Securing the goods at the site from theft and inside closed area to protect them from weather conditions</li>
                <li>Earthing and grounding</li>
                <li>Electricity at the worksite</li>
                <li>Clear out the assembly area after work is completed</li>
                <li>Preparation of assembling site before products arrive at the port at the country of destination</li>
                <li>Any task or item that is not listed under company's responsibilities</li>
            </ul>
        </li>

        <li>
            <strong>Company’s Responsibilities</strong>
            <ul>
                <li>The building structure including wall panels, metal parts and roof</li>
                <li>All doors and Windows</li>
                <li>Plumbing and sanitaryware (inside the building)</li>
                <li>Electric network and fittings (inside the building)</li>
                <li>Walls and roof sandwich panel</li>
                <li>Paint</li>
                <li>Packaging, loading and transportation</li>
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
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const countrySelect = document.getElementById("country");

            fetch('https://restcountries.com/v3.1/all')
                .then(response => response.json())
                .then(data => {
                    const sortedCountries = data.sort((a, b) =>
                        a.name.common.localeCompare(b.name.common)
                    );

                    sortedCountries.forEach(country => {
                        const dialCode = country.idd?.root + (country.idd?.suffixes ? country.idd
                            .suffixes[0] : "");
                        if (dialCode) {
                            const option = document.createElement("option");
                            option.value = country.cca2;
                            option.textContent = `${country.name.common} (${dialCode})`;
                            option.setAttribute("data-code", dialCode);
                            countrySelect.appendChild(option);
                        }
                    });
                })
                .catch(error => console.error('Error fetching countries:', error));
        });
    </script>
    <style>
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
    </style>
@endpush
