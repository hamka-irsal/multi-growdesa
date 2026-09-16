<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Surat</title>

    <style>
        @page {
            margin: 2cm 2.5cm 2cm 2.5cm;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            color: #000;
            line-height: 1.5;
        }

        table {
            border-collapse: collapse;
        }

        .kop {
            width: 100%;
            border-bottom: 3px solid #000;
            border-collapse: collapse;
            margin-bottom: 18px;
            padding-bottom: 8px;
        }

        .kop-logo {
            width: 95px;
            text-align: center;
            vertical-align: middle;
        }

        .kop-logo img {
            width: 80px;
            height: auto;
        }

        .kop-text {
            text-align: center;
            vertical-align: middle;
            line-height: 1.15;
            padding-right: 80px;
            /* agar center optik karena logo di kiri */
        }

        .kop-text div {
            margin: 0;
            padding: 0;
        }

        .kop-text .kabupaten {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .kop-text .kecamatan {
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .kop-text .desa {
            font-size: 19pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 4px;
        }

        .kop-text .alamat {
            font-size: 11pt;
            font-style: italic;
            line-height: 1.2;
        }

        .judul {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .judul h3 {
            margin: 0;
            font-size: 15pt;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .judul p {
            margin-top: 5px;
            font-size: 12pt;
        }

        .isi {
            text-align: justify;
        }

        .ttd {
            width: 100%;
            margin-top: 40px;
        }

        .ttd td {
            vertical-align: top;
        }

        @media print {
            body {
                margin: 0;
            }
        }
    </style>

    @stack('css')

</head>

<body>

    {{-- nanti diganti mengambil dari tabel profil desa --}}
    @php
        $kabupaten = 'Takalar';
        $kecamatan = 'Galesong';
        $desa = 'Galesong Timur';
        $alamat = 'Alamat : Dusun Erang Baji Desa Galesong Timur Kode Pos : 92256';
    @endphp

    <table class="kop">

        <tr>

            <td class="kop-logo">
                <img src="{{ asset('assets/img/logo_takalar.png') }}" alt="Logo Kabupaten Takalar">
            </td>

            <td class="kop-text">

                <div class="kabupaten">
                    PEMERINTAH KABUPATEN {{ strtoupper($kabupaten) }}
                </div>

                <div class="kecamatan">
                    KECAMATAN {{ strtoupper($kecamatan) }}
                </div>

                <div class="desa">
                    DESA {{ strtoupper($desa) }}
                </div>

                <div class="alamat">
                    {{ $alamat }}
                </div>

            </td>

        </tr>

    </table>

    @yield('content')

</body>

</html>
