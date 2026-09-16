@extends('admin.surat.template.kop')

@section('content')
    @push('css')
        <style>
            body {
                font-family: "Times New Roman", serif;
                font-size: 12pt;
            }

            .judul-surat {
                text-align: center;
                margin-top: -8px;
                margin-bottom: 8px;
            }

            .judul-surat h3 {
                margin: 0;
                font-size: 16pt;
                font-weight: bold;
                text-decoration: underline;
                text-transform: uppercase;
            }

            .judul-surat p {
                margin-top: 3px;
                font-weight: bold;
            }

            .isi-surat {
                margin-top: 18px;
                text-align: justify;
                line-height: 1.6;
            }

            .table-identitas {
                width: 100%;
                margin-top: 10px;
                margin-left: 35px;
                border-collapse: collapse;
            }

            .table-identitas td {
                padding: 2px 0;
                vertical-align: top;
                font-weight: normal;
            }

            .ttd-table {
                width: 100%;
                margin-top: 20px;
                border-collapse: collapse;
            }

            .ttd-table td {
                vertical-align: top;
            }
        </style>
    @endpush

    <div class="judul-surat">

        <h3>SURAT KETERANGAN KEHILANGAN</h3>

        <p>
            NOMOR : {{ $surat->no_surat }}
        </p>

    </div>

    <div class="isi-surat">

        <p>
            Yang bertanda tangan di bawah ini,
            A.n Kepala Desa {{ $detail->desa_kelurahan }},
            Kecamatan {{ $detail->kecamatan }},
            Kabupaten {{ $detail->kabupaten_kota }},
            menerangkan bahwa :
        </p>

    </div>

    <table class="table-identitas">

        <tr>
            <td width="180">Nama</td>
            <td width="15">:</td>
            <td>{{ strtoupper($surat->penduduk->nama_lengkap) }}</td>
        </tr>

        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $surat->penduduk->nik }}</td>
        </tr>

        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $surat->penduduk->jenis_kelamin }}</td>
        </tr>

        <tr>
            <td>Tempat / Tanggal Lahir</td>
            <td>:</td>
            <td>
                {{ $surat->penduduk->tempat_lahir }},
                {{ \Carbon\Carbon::parse($surat->penduduk->tanggal_lahir)->translatedFormat('d F Y') }}
            </td>
        </tr>

        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $surat->penduduk->jenis_pekerjaan }}</td>
        </tr>

        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $surat->penduduk->agama }}</td>
        </tr>

        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $surat->penduduk->alamat }}</td>
        </tr>

        <tr>
            <td>Status Perkawinan</td>
            <td>:</td>
            <td>{{ $surat->penduduk->status_perkawinan }}</td>
        </tr>

    </table>

    <div style="margin-top:15px; text-align:justify; line-height:1.8;">

        <p>
            Benar yang namanya tersebut di atas adalah penduduk
            Desa {{ $detail->desa_kelurahan }},
            menyatakan bahwa telah kehilangan/tercecer
            <strong>{{ strtoupper($detail->barang_hilang) }}</strong>.

            Surat keterangan ini dikeluarkan untuk keperluan
            <strong>{{ $detail->keperluan_kepengurusan }}</strong>.
        </p>

        <p>
            Demikian surat ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
        </p>

    </div>

    <table style="width:100%; margin-top:20px;">

        <tr>

            <td style="width:55%;"></td>

            <td style="width:45%;">

                <table style="width:100%; border-collapse:collapse;">

                    <tr>
                        <td width="100">Dikeluarkan di</td>
                        <td width="10">:</td>
                        <td>
                            {{ $penduduk?->desa_kelurahan ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td>Pada tanggal</td>
                        <td>:</td>
                        <td>
                            {{ \Carbon\Carbon::parse($surat->tanggal_dibuat)->translatedFormat('d F Y') }}
                        </td>
                    </tr>

                </table>

                <div style="margin-top: 20px; text-align: center;">

                    <div style="font-weight: bold;">
                        {{ $persetujuan?->jabatan ?? 'Kepala Desa' }}
                        {{ $detail->desa_kelurahan }}
                    </div>

                    <div style="
        height: 90px;
        text-align: center;
    ">
                        @if (!empty($persetujuan?->file_ttd))
                            <img src="{{ public_path('storage/' . ltrim($persetujuan->file_ttd, '/')) }}"
                                alt="Tanda Tangan"
                                style="
                max-height: 85px;
                max-width: 140px;
                width: auto;
                height: auto;
            ">
                        @endif
                    </div>

                    <div
                        style="
        font-weight: bold;
        text-decoration: underline;
        text-transform: uppercase;
    ">
                        {{ strtoupper($persetujuan?->aparat?->nama ?? '............................') }}
                    </div>

                </div>
            </td>

        </tr>

    </table>

@endsection

<script>
    window.onload = function() {
        window.print();
    };
</script>
