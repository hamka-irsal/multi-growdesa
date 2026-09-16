<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Kehilangan</title>
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
        <h3 style="margin-top:-15px"><u>SURAT KETERANGAN USAHA</u></h3>
        <p style="text-align:center; font-size:12pt; margin-top:-15px">Nomor : {{ $surat->no_surat }}</p>
    </div>

    <div class="content">
        <p style="margin-bottom: 0.5rem;">Yang bertanda tangan di bawah ini:</p>

        <table style="margin-left: 20px; margin-bottom: 1rem;">
            <tr>
                <td style="width: 150px;">Nama</td>
                <td>: {{ 'HAERUDDIN' }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>: {{ 'KEPALA DESA' }}</td>
            </tr>
        </table>

        <p style="margin-bottom: 0.5rem;">Menerangkan Dengan sesungguhnya bahwa:</p>

        <table>
            <tr>
                <td>Nama</td>
                <td>&nbsp;&nbsp;</td>
                <td style="text-transform: uppercase;">: {{ $surat->penduduk->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>&nbsp;&nbsp;</td>
                <td>: {{ $surat->penduduk->nik }}</td>
            </tr>
            <tr>
                <td>Tempat/Tanggal Lahir</td>
                <td>&nbsp;&nbsp;</td>
                <td style="text-transform: uppercase;">: {{ $surat->penduduk->tempat_lahir }},
                    {{ \Carbon\Carbon::parse($surat->penduduk->tanggal_lahir)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>&nbsp;&nbsp;</td>
                <td style="text-transform: uppercase;">: {{ $detail->penduduk->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <td>Barang/Dokumen Yang Hilang</td>
                <td>&nbsp;&nbsp;</td>
                <td style="text-transform: uppercase;">: {{ $detail->barang_hilang }}</td>
            </tr>
            <tr>
                <td>Waktu dan Tempat Kehilangan</td>
                <td>&nbsp;&nbsp;</td>
                <td style="text-transform: uppercase;">: {{ $detail->waktu_hilang }}, {{ $detail->tempat_hilang }}</td>
            </tr>
        </table>
    
        <br>
    
        <div>
            <p>Bahwa yang bersangkutan telah melaporkan kehilangan tersebut kepada pihak desa, dan surat ini dapat digunakan
                sebagai dasar pelaporan lebih lanjut ke pihak berwenang. Demikian surat ini dibuat untuk dipergunakan sebagaimana mestinya.</p><br>
        </div>

        <td style="text-align: right; vertical-align: top; width: 50%;">
            <p style="font-size:12pt; text-align: right;">Barana,
                {{ \Carbon\Carbon::parse($surat->created_at)->translatedFormat('d F Y') }}</p>
            <p style="font-size:12pt; text-transform: uppercase; text-align: right;"><b>KEPALA DESA
                    {{ $detail->penduduk->desa_kelurahan }}</b></p>
            @if ($persetujuan && $persetujuan->file_ttd)
                <div style="text-align: right; margin-bottom: 0;">
                    <img src="{{ asset('storage/' . $persetujuan->file_ttd) }}" alt="Tanda Tangan"
                        style="width: 100px;">
                </div>
            @endif
            <p style="font-size:12pt; text-align: right; margin-top: 0;"><strong>{{ 'HAERUDDIN' }}</strong></p>
        </td>
    </div>

</body>

</html>

<script>
    window.onload = function() {
        window.print();
    };
</script>
