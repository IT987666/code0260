@extends('layouts.admin')
@section('content')
    <style>
        .specification-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }

        .spec-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }



        #preview-container-$ {
            specificationCounter
        }

        img {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .specification-content {
            display: block;
        }
    </style>
    <style>
        .tf-button:hover {
            color: var(--Main);
            background-color: #FFF;
        }

        .tf-button:hover span {
            color: #FFF !important;
        }

        .tf-button i {
            font-size: 20px;
        }

        .tf-button.style-1 {
            color: var(--Main);
            background-color: var(--White);
        }

        .tf-button.style-1:hover {
            color: #FFF;
            background-color: var(--Main);
        }

        .tf-button.style-2 {
            color: #575864;
            background-color: #FFF;
            border-color: var(--Input);
        }

        .tf-button.style-2:hover {
            color: #FFF;
            background-color: var(--Main);
        }

        .tf-button.w208 {
            width: 208px;
        }

        .tf-button.w230 {
            width: 230px;
        }

        .tf-button.w180 {
            width: 180px;
        }

        .tf-button.w128 {
            width: 128px;
        }

        .tf-button-funtion {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid var(--Input);
            border-radius: 12px;
            padding: 14px 21px;
            cursor: pointer;
        }

        .tf-button-funtion i {
            color: var(--Body-Text);
            font-size: 20px;
        }

        .tf-button-funtion div {
            color: var(--Body-Text);
        }
        .add-new-section {
    border: 2px dashed #ccc; /* خط متقطع لتمييز القسم */
    padding: 20px;
    background-color: #f9f9f9; /* خلفية مختلفة */
    border-radius: 10px;
}

.wg-box:not(:first-child) {
    margin-top: 40px; /* تباعد بين الأقسام */
    padding-top: 20px;
    border-top: 2px solid #ddd; /* خط فاصل بين الأقسام */
}
.layout-wrap .section-content-right .main-content .main-content-inner .main-content-wrap {
  width: 200%;
  margin: auto;
}
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Add Product</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.products') }}">
                            <div class="text-tiny">Products</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Add product</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.product.store') }}">

                @csrf
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0"
                            value="{{ old('name') }}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Company’s responsibilities <span class="tf-color-1">*</span></div>
                        <textarea id="companies-responsibilities-editor" name="companies_responsibilities"></textarea>
                    </fieldset>
 
                    <fieldset class="name">
                        <div class="body-title mb-10">Customer’s responsibilities <span class="tf-color-1">*</span></div>
                        <textarea id="customers-responsibilities-editor" name="customers_responsibilities"></textarea>
                    </fieldset>

                    <fieldset>
                         <div class="body-title mb-10">Code <span class="tf-color-1">*</span></div>

                        <input type="text" name="code" maxlength="3" value="{{ old('code') }}" required>
                        @error('code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </fieldset>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Status</div>
                            <div class="select mb-10">
                                <select class="" name="stock_status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </fieldset>
                        @error('stock_status')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="wg-box"style="margin-bottom: 50px;">
                        <fieldset class="specifications">
                            <div class="body-title mb-10">Technical Specifications <span class="tf-color-1">*</span></div>
                            <div id="specifications-container">
                                <!-- Dynamic specifications will be added here -->
                            </div>
                        </fieldset>
                        <button type="button" id="add-specification-btn" class="tf-button" data-bs-toggle="modal"
                        data-bs-target="#addSpecificationModal" 
                        style="margin-top: 20px; display: block; margin-left: auto; margin-right: auto; text-align: center;">
                        Add Specification
                    </button>
                    
                    </div>

                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Add Product</button>
                    </div>
                </div>
             
            </form>
      
            <!-- /form-add-product -->
        </div>
        <!-- /main-content-wrap -->
    </div>
    <!-- /main-content-wrap -->
@endsection
@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>

    <script>
      $(document).ready(function() {
    let specificationCounter = 0;

    // تهيئة محرر النصوص CKEditor 5
    const initializeTextEditor = (selector) => {
        $(selector).each(function() {
            if (!$(this).data('ckeditor-initialized')) {
                ClassicEditor.create(this)
                    .then(editor => {
                        editor.setData($(this).val());
                        editor.model.document.on('change:data', () => {
                            $(this).val(editor.getData());
                        });
                        $(this).data('ckeditor-initialized', true);
                    })
                    .catch(error => console.error(error));
            }
        });
    };

    $(document).ready(function() {
        $(".ckeditor").each(function() {
            var content = $(this).val();
            ClassicEditor.create(this)
                .then(editor => {
                    editor.setData(content);
                    editor.model.document.on('change:data', () => {
                        console.log(editor.getData());
                    });
                })
                .catch(error => console.error(error));
        });
    });

    // إضافة قسم جديد للمواصفات
    $('#add-specification-btn').on('click', function() {
        $('.specification-content').slideUp(); 

$('.toggle-specification-btn').text(function() {
    return "Show " + ($(this).data('spec-name') || "Specification");
});
        specificationCounter++;
        const newSpecification = `
            <div class="specification-item" id="specification-${specificationCounter}">
             <div class="spec-header" style="display: flex; justify-content: space-between; align-items: center;">
    <span id="specification-label-${specificationCounter}" style="font-weight: bold;">Specification ${specificationCounter}</span>
    <button type="button" class="remove-specification-btn" data-spec-id="${specificationCounter}" 
        style="background: none; color: #40E0D0; border: none; cursor: pointer; font-size: 20px; font-weight: bold;">✖
    </button>
</div>

                <div class="specification-content">
                    <div class="specification-name">
                        <label for="spec-name-${specificationCounter}">Specification Name:</label>
                        <input type="text" name="specifications[${specificationCounter}][name]" id="spec-name-${specificationCounter}" placeholder="Enter specification name" required>
                    </div>
                    <div class="specification-paragraphs">
                        <label for="spec-paragraphs-${specificationCounter}">Specification Paragraphs:</label>
                        <textarea name="specifications[${specificationCounter}][paragraphs]" id="spec-paragraphs-${specificationCounter}" class="ckeditor"></textarea>
                    </div>
                    <div class="specification-gallery">
                        <fieldset>
                                    <label for="specifications[${specificationCounter}][images]">Images</label>
                                    <div class="gallery-preview" id="preview-container-${specificationCounter}">
                                        <!-- سيتم عرض الصور الحالية هنا -->
                                        @foreach ($specification['images'] ?? [] as $image)
                                            <div class="gitems">
                                                <img src="{{ asset('storage/' . $image) }}" alt="Specification Image">
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="file" name="specifications[${specificationCounter}][images][]" id="gFile-${specificationCounter}" class="form-control modern-input" accept="image/*" multiple>
                                </fieldset>
                    </div>
                 </div>
<button type="button" id="save-specification-btn" class="tf-button w-full toggle-specification-btn" data-spec-id="${specificationCounter}" data-spec-name="" style="margin: 0 auto; display: block; width: 600px !important;">SAVE</button>
            </div>`;

        $('#specifications-container').append(newSpecification);
        initializeTextEditor(`#spec-paragraphs-${specificationCounter}`);

       /* $(`#spec-name-${specificationCounter}`).on('input', function() {
            const name = $(this).val() || `Specification ${specificationCounter}`;
            $(`#specification-label-${specificationCounter}`).text(name);
        });*/
        $(`#spec-name-${specificationCounter}`).on('input', function() {
    const name = $(this).val() || `Specification ${specificationCounter}`;
    $(`#specification-label-${specificationCounter}`).text(name);
    $(`#save-specification-btn[data-spec-id="${specificationCounter}"]`).data('spec-name', name);
});

          // حذف المواصفة عند الضغط على زر ✖
          $(`#specification-${specificationCounter} .remove-specification-btn`).on('click', function() {
            $(`#specification-${specificationCounter}`).remove();
        });
    });

            // إظهار/إخفاء قسم المواصفات
           /* $(document).on('click', '.toggle-specification-btn', function() {
                const specId = $(this).data('spec-id');
                const specContent = $(`#specification-${specId} .specification-content`);
                const button = $(this);
                const specName = $(`#spec-name-${specId}`).val() || `Specification ${specId}`;

                // إضافة الكلاس tf-button للتأكد من أن الزر يتبع التنسيق الصحيح
                button.addClass('tf-button');

                // توسيط الزر عند النقر
                button.css({
                    'margin': '0 auto',
                    'display': 'block'
                });

                if (specContent.is(':visible')) {
                    specContent.slideUp();
                    button.text(`Show ${specName}`);
                } else {
                    specContent.slideDown();
                    button.text(`SAVE ${specName}`);
                }
            });*/ 
           /* $(document).on('click', '.toggle-specification-btn', function() {
    const specId = $(this).data('spec-id');
    const specContent = $(`#specification-${specId} .specification-content`);
    const button = $(this);
    const specName = button.data('spec-name') || `Specification ${specId}`;

    button.addClass('tf-button');
    button.css({ 'margin': '0 auto', 'display': 'block' });

    if (specContent.is(':visible')) {
        specContent.slideUp();
        button.text(`Show ${specName}`);
    } else {
        specContent.slideDown();
        button.text(`SAVE ${specName}`);
    }
});*/
$(document).on('click', '.toggle-specification-btn', function() {
    const specId = $(this).data('spec-id');
    const specContent = $(`#specification-${specId} .specification-content`);
    const button = $(this);
    const specName = button.data('spec-name') || `Specification ${specId}`;

    // إغلاق جميع المواصفات الأخرى
    $('.specification-content').slideUp();
    $('.toggle-specification-btn').text(function() {
        return "Show " + ($(this).data('spec-name') || "Specification");
    });

    // إذا كانت المواصفة نفسها مفتوحة، تسكرها، غير هيك تفتحها
    if (specContent.is(':visible')) {
        specContent.slideUp();
        button.text(`Show ${specName}`);
    } else {
        specContent.slideDown();
        button.text(`SAVE ${specName}`);
    }
});



            // Store selected files
            let selectedFiles = {};

            $(document).on('change', 'input[type="file"]', function(event) {
                console.log(event.target.files); // Debugging

                if (event.target && event.target.id.startsWith('gFile-')) {
                    const fileInput = event.target;
                    const previewContainerId = fileInput.id.replace('gFile-', 'preview-container-');
                    const previewContainer = document.getElementById(previewContainerId);
                    const files = Array.from(fileInput.files); // Convert FileList to Array

                    if (!selectedFiles[previewContainerId]) {
                        selectedFiles[previewContainerId] = [];
                    }

                    let dataTransfer = new DataTransfer();

                    if (files.length > 0) {
                        files.forEach(file => {
                            if (!selectedFiles[previewContainerId].some(f => f.name === file
                                    .name)) {
                                selectedFiles[previewContainerId].push(file);

                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const gItem = document.createElement('div');
                                    gItem.className = 'gitems';
                                    gItem.innerHTML = `
                            <img src="${e.target.result}" alt="Preview Image" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                            <button type="button" class="delete-image-btn" data-preview-container="${previewContainerId}" data-file-name="${file.name}">x</button>
                        `;
                                    previewContainer.appendChild(gItem);
                                };
                                reader.readAsDataURL(file);
                            }
                        });

                        // Add all selected files to DataTransfer
                        selectedFiles[previewContainerId].forEach(file => dataTransfer.items.add(file));
                        fileInput.files = dataTransfer.files; // Update input files
                    } else {
                        previewContainer.innerHTML = '<p>No images selected</p>';
                    }
                }
            });

            // Handle image deletion
            $(document).on('click', '.delete-image-btn', function() {
                const previewContainerId = $(this).data('preview-container');
                const fileName = $(this).data('file-name');

                // Remove from the preview
                $(this).parent().remove();

                // Remove from the selectedFiles array
                selectedFiles[previewContainerId] = selectedFiles[previewContainerId].filter(file => file
                    .name !== fileName);

                // Update the input field's files
                const fileInput = document.getElementById(previewContainerId.replace('preview-container-',
                    'gFile-'));
                let dataTransfer = new DataTransfer();
                selectedFiles[previewContainerId].forEach(file => dataTransfer.items.add(file));

                fileInput.files = dataTransfer.files; // Update input field

                // If no files left, clear input
                if (selectedFiles[previewContainerId].length === 0) {
                    fileInput.value = ''; // Reset input
                }
            });


            // إزالة قسم المواصفات
            $(document).on('click', '.remove-specification-btn', function() {
                const specId = $(this).data('spec-id');
                $(`#specification-${specId}`).remove();
            });

    initializeTextEditor('textarea[name^="specifications"]');
});

        document.addEventListener('DOMContentLoaded', function() {
            // تهيئة CKEditor لحقل Company’s responsibilities
            ClassicEditor
                .create(document.querySelector('#companies-responsibilities-editor'))
                .catch(error => console.error(error));

            // تهيئة CKEditor لحقل Customer’s responsibilities
            ClassicEditor
                .create(document.querySelector('#customers-responsibilities-editor'))
                .catch(error => console.error(error));
        });
    </script>
@endpush
