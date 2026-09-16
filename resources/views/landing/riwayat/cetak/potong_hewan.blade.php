<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Izin Potong</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .line {
            border-top: 3px double black;
            margin-top: 5px;
            margin-bottom: 30px;
        }

        .content {
            font-size: 16px;
            line-height: 1.7;
        }

        .ttd {
            margin-top: 60px;
            float: right;
            text-align: center;
        }

        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
        }
        
        table.main-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table.main-table th, table.main-table td {
            padding: 2px; /* Reduced from 8px to 2px */
            text-align: left;
            vertical-align: top;
        }
        
        .center-text {
            text-align: center;
            font-weight: bold;
            padding: 2px; /* Added to ensure consistency */
        }
        
        .sub-table {
            width: 100%;
            border-collapse: collapse; /* Added to remove internal spacing */
        }
        
        .sub-table td {
            padding: 1px; /* Reduced from 3px to 1px */
            vertical-align: top;
        }
    </style>
</head>

<body>

    <button onclick="window.print()" class="btn-print" style="margin-top:-15px;">🖨️ Cetak</button>

    <div class="header">
        <div class="header" style="display: flex; align-items: center; justify-content: center;">
            <div style="flex-shrink: 0; margin-right: 20px;">
                <img src="{{ asset('assets/img/Logo_Jeneponto.png') }}" alt="Logo"
                    style="width: 100px; height: auto;">
            </div>
            <div style="line-height: 0.8; text-align: center;">
                <h2 style="margin-bottom: 0.2rem; margin-top: 0.2rem;">PEMERINTAH KABUPATEN JENEPONTO</h2>
                <h2 style="margin-bottom: 0.2rem; margin-top: 0.2rem;">KECAMATAN BANGKALA BARAT</h2>
                <h1 style="margin-bottom: 0.2rem; margin-top: 0.2rem;">DESA BARANA</h1>
                <h5 style="margin-bottom: 0.2rem; margin-top: 0.2rem;"><i>Jl. Lapangan Sepak Bola Bonto Jai Dusun Bonto Parang Desa Barana Kode Pos 92532</i></p></h5>
            </div>
        </div>
        <div class="line" style="margin-top:-15px"></div>
        <h3 style="margin-top:-15px"><u>SURAT IZIN POTONG</u></h3>
        <p style="text-align:center; font-size:12pt; margin-top:-15px">Nomor : {{ $surat->no_surat }}</p>
    </div>

    <div class="content">
        <table class="main-table">
            <tr>
                <td colspan="3" class="center-text" style="text-align: center">TENTANG</td>
            </tr>
            <tr>
                <td>Dasar</td>
                <td>:</td>
                <td>
                    <table class="sub-table">
                        <tr>
                            <td style="width: 20px; padding: 1px;">a.</td>
                            <td style="padding: 1px;">Surat Pengantar Kepala Dusun Tombolo Nomor : 01/Dsn-Tombolo /IV/2025 tentang Permohonan Pemberian Izin Potong</td>
                        </tr>
                        <tr>
                            <td style="padding: 1px;">b.</td>
                            <td style="padding: 1px;">Keterangan Kepemilikan Hewan</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="center-text" style="text-align: center">MEMBERI IZIN</td>
            </tr>
            <tr>
                <td>Kepada:</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $surat->penduduk->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $surat->penduduk->nik }}</td>
            </tr>
            <tr>
                <td>Tempat/Tgl. Lahir</td>
                <td>:</td>
                <td>{{ $surat->penduduk->tempat_lahir }}, {{ \Carbon\Carbon::parse($surat->penduduk->tanggal_lahir)->translatedFormat('d-m-Y') }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $surat->penduduk->alamat }}, Kecamatan Bangkala Barat Kabupaten Jeneponto</td>
            </tr>
            <tr>
                <td>Untuk</td>
                <td>:</td>
                <td>{{ $detail->untuk }}</td>
            </tr>
            <tr>
                <td colspan="3">Dengan Ciri Atau Tanda:</td>
            </tr>
            <tr>
                <td>Jenis Hewan</td>
                <td>:</td>
                <td>{{ $detail->jenis_hewan }}</td>
            </tr>
            <tr>
                <td>Warna Bulu</td>
                <td>:</td>
                <td>{{ $detail->warna_bulu }}</td>
            </tr>
            <tr>
                <td>Tanduk</td>
                <td>:</td>
                <td>{{ $detail->tanduk }}</td>
            </tr>
        </table>

        <div style="margin-top: 30px; float: right; text-align: center;">
            <p>Barana, {{ \Carbon\Carbon::parse($surat->created_at)->translatedFormat('d F Y') }}</p>
            <p><b>KEPALA DESA BARANA</b></p>
            
            @if ($persetujuan && $persetujuan->file_ttd)
                <div style="text-align: center; margin-bottom: 0;">
                    <img src="{{ asset('storage/' . $persetujuan->file_ttd) }}" alt="Tanda Tangan"
                        style="width: 100px;">
                </div>
            @endif
            
            <p><strong>HAERUDDIN</strong></p>
        </div>
    </div>

</body>

</html>

<script>
    window.onload = function() {
        window.print();
    };
</script>