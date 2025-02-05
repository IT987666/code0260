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
        padding-top: 40px;
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
                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="email" class="form-control" name="email" required="">
                                    <label for="email">Email *</label>
                                    @error('email')
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


                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" id="phone" name="phone" required="">
                                    <label for="phone">Phone Number *</label>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="checkout__totals-wrapper">


                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #20bec6; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-size: 16px; cursor: pointer; transition: transform 0.3s ease, background-color 0.3s ease;">
                                Substantiation
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
        // إضافة رمز الدولة تلقائيًا عند اختيار الدولة
        document.getElementById('country').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const countryCode = selectedOption.getAttribute('data-code');
            const phoneInput = document.getElementById('phone');

            if (countryCode) {
                phoneInput.value = countryCode + ' ';
            }
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
