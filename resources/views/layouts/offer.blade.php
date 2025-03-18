<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title', 'Default Title')</title>

    <style>
        /* التنسيقات العامة */
        body {
            font-family: 'Times New Roman', serif;
            margin: 40px;
            line-height: 1.6;
            color: #000;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        th {
            font-weight: bold;
        }

        h3 {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px 12px;
            text-align: left;
        }

        .intro-table th {
            width: 100px;
        }

        .extra {
            margin-top: 30px;
        }

        .attachments-list {
            list-style-type: none;
            padding-left: 0;
        }

        .attachments-list li::before {
            content: "- ";
        }

        .page-break {
            page-break-after: always;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .manager-signature {
            text-align: right;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 50px;
            text-align: left;
        }

        .logo {
            width: 120px;
            height: auto;
        }

        @page {
            margin-top: 50px;
            margin-bottom: 60px;
        } 

        .price-offer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .price-offer-table th {
            background-color: #20bec6;
            color: black;
            text-align: center;
        }

        .price-offer-table th:first-child {
            width: 50%;
        }

        .price-offer-table th,
        .price-offer-table td {
            border: 1px solid #000;
            padding: 8px 12px;
        }

        .price-offer-table td {
            text-align: center;
        }

        .attachment-1-list ul {
            list-style-type: disc;
        }

        .product-name {
            font-family: "sans-serif";
            font-weight: bolder;
            padding: 4px 80px;
            font-variant: small-caps;
            background-color: #20bec6;
            color: #fff;
            text-align: center;
            font-size: 16px;
            line-height: 100%;

        }



        .product-image-container {
            text-align: center;
            margin: 20px 0;
            clear: both;
        }

        .product-image {
            clear: both;

            max-width: 80%;
            max-height: 250px;
            object-fit: contain;
            display: block;
            margin: 10px auto;
            border: 1px solid #fff;
            padding: 5px;
        }
    </style>
    <style>
        /* Adjusting the logo size and spacing */
        .logo {
            width: 170px; /* Increased the width */
            height: auto;
     margin-top:    -20px;    /* المسافة من الأعلى */
    margin-bottom: -20px; /* المسافة من الأسفل */
     margin-right: 60px;  /* المسافة من اليمين */
     margin-left: 30px; /* حرك اللوجو أكثر نحو اليمين */



        }
        .background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw; /* عرض الشاشة بالكامل */
    height: 100vh; /* ارتفاع الشاشة بالكامل */
    background: url('{{ public_path('images/logo/enhanced_photo.png') }}') no-repeat center center;
    background-size: contain; /* أو جرّب cover */
    opacity: 0.1; /* يمكنك تعديل الشفافية حسب الحاجة */
    z-index: -1;
}


        header {
            position: fixed;
            top: -10;
            left: -10;
            right: -10;
            height: 80px; /* Increased height of header to match the logo size */
            text-align: left;
            margin-bottom: 40px; /* Added space after header */
        }
    </style>
    
</head>

<body>
    <header>
        <img src="{{ public_path('images/logo/logo.png') }}" alt="Company Logo" class="logo">
    </header>
    <div class="background"></div>

    <div class="container">
        @yield('intro')
    </div>

    <div class="page-break"></div>

    <div class="container">
        @yield('priceOffer')
    </div>

    <div class="page-break"></div>

    <div class="container">
        @yield('technicalSpecification')
    </div>

    <div class="page-break"></div>

    <div class="container">
        @yield('technicalDrawingOrImage')
    </div>

    @stack('scripts')
</body>

</html>
