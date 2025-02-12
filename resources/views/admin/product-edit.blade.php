@extends('layouts.admin')


@section('content')
    <style>
        .specification-item {
            border: 1px solid #dddddd28;
            padding: 10px;
            margin-bottom: 10px;
        }

        .spec-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .remove-icon {
    font-size: 20px; /* حجم الرمز */
    color: #1abc9c; /* اللون الفيروزي */
    font-weight: bold; /* جعله عريضًا */
    display: inline-block;
    margin-left: 5px;
}
.section-title {
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 15px;
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

        #preview-container-$ {
            specificationCounter
        }

        img {
            width: 150px;
            /* Adjust the size as needed */
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .layout-wrap .section-content-right .main-content .main-content-inner .main-content-wrap {
  width: 200%;
  margin: auto;
}
        .specification-content {
            display: block;
        }
    </style>
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Product</h3>
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
                        <div class="text-tiny">Edit Product</div>
                    </li>
                </ul>
            </div>
            <!-- form-edit-product -->
            <form class="tf-section-2 form-edit-product" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.product.update') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $product->id }}" />


                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Product Name <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0"
                            value="{{ old('name', $product->name) }}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title mb-10">companies_responsibilities<span class="tf-color-1">*</span></div>
                        <textarea name="companies_responsibilities" id="companies_responsibilities" class="ckeditor"
                            placeholder="Enter companies responsibilities" tabindex="0" aria-required="true" required="">
                            {!! old(
                                'companies_responsibilities',
                                htmlspecialchars_decode(stripslashes($product->companies_responsibilities)),
                            ) !!}
                        </textarea>
                        <div class="text-tiny">You can use rich text editing for companies' responsibilities.</div>
                    </fieldset>
                    @error('companies_responsibilities')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">customers_responsibilities <span class="tf-color-1">*</span></div>
                        <textarea name="customers_responsibilities" id="customers_responsibilities" class="ckeditor"
                            placeholder="Enter customers responsibilities" tabindex="0" aria-required="true" required="">
                            {!! old(
                                'customers_responsibilities',
                                htmlspecialchars_decode(stripslashes($product->customers_responsibilities)),
                            ) !!}
                        </textarea>
                        <div class="text-tiny">You can use rich text editing for customers' responsibilities.</div>
                    </fieldset>
                    @error('customers_responsibilities')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror


                    <fieldset class="name">
                        <div class="body-title mb-10">Code:<span class="tf-color-1">*</span></div>
                        <input type="text" name="code" maxlength="3" value="{{ old('code', $product->code) }}"
                            required>

                        {{-- <div class="text-tiny">code.</div> --}}
                    </fieldset>
                    @error('code')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="code">

                        <div class="wg-box">
                            <fieldset class="name">
                                <div class="body-title mb-10">Status</div>
                                <div class="select mb-10">
                                    <select name="stock_status">
                                        <option value="active" {{ $product->stock_status == 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="inactive"
                                            {{ $product->stock_status == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>
                            </fieldset>
                            @error('stock_status')
                                <span class="alert alert-danger text-center">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="wg-box">
                            <div class="body-title mb-10">Edite Technical Specification <span class="tf-color-1">*</span>
                            </div>
                            <fieldset class="specifications">
                                <div id="specifications-container">
                                    @foreach ($product->specifications as $specification)
                                        <div class="specification-item" id="specification-{{ $specification->id }}">
                                            <button type="button" class="toggle-specification-btn tf-button w-full"
                                                data-spec-id="{{ $specification->id }}">
                                                Edit {{ $specification->name }}
                                            </button>
                                            <div class="specification-content" id="specification-content-{{ $specification->id }}"
                                                style="display: none;">
                                                <div class="cols gap10">
        
        
        
                                                    <fieldset class="other-info">
                                                        <label for="spec-name-{{ $specification->id }}">Specification Name</label>
                                                        <input type="text" id="spec-name-{{ $specification->id }}"
                                                            name="specifications[{{ $specification->id }}][name]"
                                                            placeholder="Enter specification name"
                                                            value="{{ old('specifications.' . $specification->id . '.name', $specification->name) }}"
                                                            required>
        
                                                        <label for="spec-paragraphs-{{ $specification->id }}">Specification
                                                            Paragraphs</label>
                                                        <textarea name="specifications[{{ $specification->id }}][paragraphs]" id="spec-paragraphs-{{ $specification->id }}"
                                                            class="ckeditor" placeholder="Enter paragraphs">
                                                           {!! $specification['paragraphs'] !!}
                                                        </textarea>
                                                        <label for="spec-image-{{ $specification->id }}">Specification
                                                            Images</label>
                                                        @php
                                                            $images = json_decode($specification->images, true);
                                                        @endphp
                                                        <div class="upload-image mb-16">
                                                            <div id="gallery-preview-{{ $specification->id }}"
                                                                class="gallery-preview">
                                                                @if (is_array($images) && count($images) > 0)
                                                                    @foreach ($images as $image)
                                                                        <div class="gitems">
                                                                            <img src="{{ asset('storage/' . $image) }}"
                                                                                alt="Specification Image">
                                                                            <button type="button" class="remove-old-image-btn"
                                                                                data-image="{{ $image }}">X</button>
                                                                            <input type="hidden"
                                                                                name="specifications[{{ $specification->id }}][existing_images][]"
                                                                                value="{{ $image }}">
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <p>No images available</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @isset($image)
                                                            <input type="hidden"
                                                                name="specifications[{{ $specification->id }}][deleted_images][]"
                                                                value="{{ $image }}" class="deleted-image-input">
                                                        @endisset
                                                        <input type="file"
                                                            name="specifications[{{ $specification->id }}][images][]"
                                                            class="form-control gallery-input"
                                                            data-preview-id="gallery-preview-{{ $specification->id }}" multiple>
                                                            <button type="button" class="remove-specification-btn" data-spec-id="{{ $specification->id }}">
                                                                <span class="remove-icon">×</span> <!-- رمز X فيروزى -->
                                                            </button>
                                                            
        
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
        
                            </fieldset>
        
        
                            <div class="wg-box">
        
                                <fieldset class="specifications">
        
                                    <!-- مكان إضافة الحقول الجديدة -->
                                    <div id="specifications-container">
                                        <!-- الحقول المضافة ديناميكياً ستظهر هنا -->
                                    </div>
                                </fieldset>
        
                                <!-- زر إضافة مواصفات بعد الحقول المضافة -->
                                <button type="button" id="add-specification-btn" class="tf-button" style="margin: 20px auto 50px; display: block;">
                                    Add Specification
                                </button>
                                
                            </div>
                        </div>
                        <div class="cols gap10"> 
                            <button class="tf-button w-full" type="submit">Update Product</button>
                        </div>
                </div>

         



            </form>
            <!-- /form-edit-product -->
        </div>
    </div>
@endsection

@push('scripts')
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script> --}}

    <script>
        $(document).ready(function() {
            // زر إظهار/إخفاء السبيسفكيشنات الفردية
            $(document).on('click', '.toggle-specification-btn ', function() {
                const specId = $(this).data('spec-id');
                const specContent = $(`#specification-content-${specId}`);
                const button = $(this);

                // جلب اسم السبيسفكيشن من الحقل الموجود داخل الـ HTML
                const specName = $(`#spec-name-${specId}`).val();

                if (specContent.is(':visible')) {
                    specContent.slideUp();
                    button.text(`Show ${specName}`); // عرض اسم السبيسفكيشن في الزر
                } else {
                    specContent.slideDown();
                    button.text(`SAVE ${specName}`); // عرض اسم السبيسفكيشن في الزر
                }
            });
            $(document).ready(function() {
                let specificationCounter = 0;
                // حذف الصور القديمة والجديدة
                $(document).on('click', '.remove-old-image-btn', function() {
                    const imageDiv = $(this).closest('.gitems');
                    const imagePath = $(this).data('image'); // The path of the image

                    // Add the image to a hidden input for deletion tracking
                    const specId = $(this).closest('.gallery-preview').attr('id').split('-').pop();
                    $(`#specification-${specId}`).append(`
        <input type="hidden" name="specifications[${specId}][deleted_images][]" value="${imagePath}">
    `);

                    // Remove the image from the UI
                    imageDiv.remove();
                });


                // إزالة قسم المواصفات
                $(document).on('click', '.remove-specification-btn', function() {
                    const specId = $(this).data('spec-id');
                    $(`#specification-${specId}`).remove();
                });



            });

        });


        $(document).on('change', '.gallery-input', function(event) {
            const fileInput = event.target;
            const previewContainerId = fileInput.getAttribute('data-preview-id');
            const previewContainer = document.getElementById(previewContainerId);
            const files = fileInput.files;

            if (files && files.length > 0) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const gItem = document.createElement('div');
                        gItem.className = 'gitems';
                        gItem.innerHTML = `
                    <img src="${e.target.result}" alt="Gallery Image" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                    <button type="button" class="remove-new-image-btn">X</button>
                `;

                        // إزالة الصورة عند النقر على زر الإزالة
                        gItem.querySelector('.remove-new-image-btn').addEventListener('click', () =>
                            gItem.remove());

                        previewContainer.appendChild(gItem);
                    };

                    reader.readAsDataURL(file);
                });
            }
        });
    </script>
@endpush
@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            let specificationCounter = 0;

            // تهيئة محرر النصوص
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
            // إضافة قسم مواصفات جديد
            $('#add-specification-btn').on('click', function() {
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
                        <textarea name="specifications[${specificationCounter}][paragraphs]" id="spec-paragraphs-${specificationCounter}" placeholder="Enter paragraphs"></textarea>
                    </div>
                  <div class="specification-gallery">
  <fieldset>
    <label for="specifications[${specificationCounter}][images]">Images</label>

    <div class="gallery-preview" id="preview-container-${specificationCounter}">
        <!-- سيتم عرض الصور الحالية هنا -->
        @php
            $images = isset($specification['images']) ? (is_array($specification['images']) ? $specification['images'] : json_decode($specification['images'], true)) : [];
        @endphp


    </div>
    <input type="file"
           name="specifications[${specificationCounter}][images][]"
           id="gFile-${specificationCounter}"
           class="form-control modern-input"
           accept="image/*"
           multiple>

</fieldset>

</div> 

                 </div>
          <button type="button" class="tf-button w-full toggle-specification-btn1" data-spec-id="${specificationCounter}" style="margin: 0 auto; display: block;">SAVE</button>

            </div>`;

                $('#specifications-container').append(newSpecification);
                initializeTextEditor(`#spec-paragraphs-${specificationCounter}`);

                // تحديث النص الظاهر بناءً على إدخال اسم المواصفات
                $(`#spec-name-${specificationCounter}`).on('input', function() {
                    const name = $(this).val() || `Specification ${specificationCounter}`;
                    $(`#specification-label-${specificationCounter}`).text(name);
                });
                // تهيئة CKEditor للسبيسفكيشن الجديد
                // ClassicEditor.create($(
                //     `textarea[name='specifications[new_${specificationCounter}][paragraphs]']`)[0]);
            });

            // إظهار/إخفاء قسم المواصفات
 // حذف المواصفة عند الضغط على زر ✖
 $(`#specification-${specificationCounter} .remove-specification-btn`).on('click', function() {
            $(`#specification-${specificationCounter}`).remove();
        });

 
             // معاينة الصور
            $(document).on('change', 'input[type="file"]', function(event) {
                if (event.target && event.target.id.startsWith('gFile-')) {
                    const fileInput = event.target;
                    const previewContainerId = fileInput.id.replace('gFile-', 'preview-container-');
                    const previewContainer = document.getElementById(previewContainerId);
                    const files = fileInput.files;

                    previewContainer.innerHTML = ''; // Clear existing previews
                    if (files && files.length > 0) {
                        Array.from(files).forEach(file => {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const gItem = document.createElement('div');
                                gItem.className = 'gitems';
                                gItem.innerHTML = `
                        <img src="${e.target.result}" alt="Preview Image" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                        <button type="button" class="remove-old-image-btn">X</button>
                    `;
                                gItem.querySelector('.remove-old-image-btn').addEventListener(
                                    'click', () => gItem.remove());
                                previewContainer.appendChild(gItem);
                            };
                            reader.readAsDataURL(file);
                        });
                    } else {
                        previewContainer.innerHTML = '<p>No images selected</p>';
                    }
                }
            });

            // إظهار/إخفاء قسم المواصفات
            $(document).on('click', '.toggle-specification-btn1', function() { //////////
                const specId = $(this).data('spec-id');
                const specContent = $(`#specification-${specId} .specification-content`);
                const button = $(this);
                // إضافة الكلاس tf-button للتأكد من أن الزر يتبع التنسيق الصحيح
                button.addClass('tf-button w-full');

                // جلب اسم السبيسفكيشن من الحقل الموجود داخل الـ HTML
                const specName = $(`#spec-name-${specId}`).val();

                if (specContent.is(':visible')) {
                    specContent.slideUp();
                    button.text(`Show ${specName}`); // عرض اسم السبيسفكيشن في الزر
                } else {
                    specContent.slideDown();
                    button.text(`SAVE ${specName}`); // عرض اسم السبيسفكيشن في الزر
                }
            });


            // إزالة قسم المواصفات
            $(document).on('click', '.remove-old-image-btn', function() {
                const image = $(this).data('image');
                const specId = $(this).closest('.gallery-preview').attr('id').split('-').pop();
                $(this).closest('.gitems').remove();

                $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', `specifications[${specId}][deleted_images][]`)
                    .val(image)
                    .appendTo(`#specification-${specId}`);
            });


            // تهيئة محرر النصوص للمواصفات
            initializeTextEditor('textarea[name^="specifications"]');
        });

        document.addEventListener('DOMContentLoaded', function() {
            // تهيئة CKEditor لحقل Company’s responsibilities
            ClassicEditor
                .create(document.querySelector('#companies_responsibilities'))
                .catch(error => console.error(error));

            // تهيئة CKEditor لحقل Customer’s responsibilities
            ClassicEditor
                .create(document.querySelector('#customers_responsibilities'))
                .catch(error => console.error(error));
        });
    </script>
@endpush
