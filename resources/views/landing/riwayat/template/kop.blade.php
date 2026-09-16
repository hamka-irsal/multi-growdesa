<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://db.onlinewebfonts.com/c/a78cfad3beb089a6ce86d4e280fa270b?family=Calibri" rel="stylesheet">
    <title>Document</title>
    <style media="print">
        * {
            margin: 0 !important;
            padding: 0 !important;
            font-family: "calibri" !important;
            letter-spacing: 0.15pt !important;
        }
    
        body {
            width: 100% !important;
            height: 100% !important;
        }
    
        .text {
            text-align: justify !important;
            font-weight: 500 !important;
        }
    
        .kopsurat {
            object-fit: cover !important;
            height: 50px !important; /* Adjust height as needed */
            width: auto !important; /* Maintain aspect ratio */
            margin-top: -5px !important;
            margin-bottom: 1px !important;
        }
    
        @page {
            margin-left: 2.54cm;
            margin-right: 2.54cm;
            width: 33.5cm !important;
            height: 33cm !important;
        }
    
        .css {
            padding-top: 70px !important;
        }
    </style>
    @stack('css')
</head>

<body>
    <div>
        {{-- @php
            $logo = \App\Helpers\TenancyHelper::getLogo();
            $identitasDesa = \App\Helpers\TenancyHelper::getDesaDetails();
            $appUrl = config('app.url');
            $fullUrl = "http://{$identitasDesa->domain}." . parse_url($appUrl, PHP_URL_HOST);
        @endphp --}}
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <!-- Logo di kiri -->
            <div style="flex-shrink: 0; margin-right: 20px;">
                <img src="{{ asset('assets/img/Logo_Jeneponto.png') }}" alt="Logo" style="width: 130px; height: auto;">
            </div>
        
            <!-- Teks di kanan -->
            <div style="text-align: center; flex: 1;">
                <p style="margin-top:0pt; margin-bottom:0pt; line-height:normal">&#xa0;</p>
        
                <p style="font-size: 20px; font-weight: bold; text-transform: uppercase;">
                    PEMERINTAH KABUPATEN {{ strtoupper('JENEPONTO') }}
                </p>
                <p style="font-size: 20px; font-weight: bold; text-transform: uppercase; margin-top:-10px">
                    KECAMATAN {{ strtoupper('BANGKALA BARAT') }}
                </p>
                <p style="font-size: 24px; font-weight: bold; text-transform: uppercase; margin-top:-10px">
                    DESA {{ strtoupper('BARANA') }}
                </p>
                <p style="font-size: 16px; font-weight: bold; margin-top:-5px">
                    Dusun {{ 'Bonto Parang' }}, Desa {{ 'Barana' }}, Kecamatan {{ 'Bangkala Barat' }}, Kab. {{ 'Jeneponto - 9034' }}
                </p>
            </div>
        </div>
        
        <hr style="border: 1px solid #333; margin-top:-5px">
        <p style="margin-top:0pt; margin-bottom:0pt; line-height:normal">&#xa0;</p>
        
        @yield('content')
    </div>
</body>

</html>