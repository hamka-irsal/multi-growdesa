@extends('anjungan.riwayat.template.kop')

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
                margin-bottom: 5px;
            }

            .judul-surat h3 {
                margin: 0;
                font-size: 16pt;
                font-weight: bold;
                text-decoration: underline;
                text-transform: uppercase;
            }

            .judul-surat p {
                margin: 3px 0;
                font-weight: bold;
            }

            .isi-surat {
                margin-top: 20px;
                text-align: justify;
                line-height: 1.6;
            }

            .table-identitas {
                margin-top: 10px;
                margin-left: 30px;
                border-collapse: collapse;
                width: 100%;
            }

            .table-identitas td {
                padding: 2px 0;
                vertical-align: top;
            }
        </style>
    @endpush

    <div class="judul-surat">
        <h3>SURAT PENGANTAR</h3>

        <p>
            NOMOR : {{ $surat->no_surat }}
        </p>
    </div>

    <div class="isi-surat">

        <p>
            Yang bertanda tangan di bawah ini, Kepala Desa
            {{ $detail->desa_kelurahan }},
            Kecamatan {{ $detail->kecamatan }},
            Kabupaten {{ $detail->kabupaten_kota }},
            menerangkan dengan sebenarnya bahwa yang bernama di bawah ini :
        </p>

    </div>

    <table class="table-identitas">

        <tr>
            <td width="30">1.</td>
            <td width="180">Nama</td>
            <td width="10">:</td>
            <td>{{ strtoupper($surat->penduduk->nama_lengkap) }}</td>
        </tr>

        <tr>
            <td>2.</td>
            <td>Tempat / Tanggal Lahir</td>
            <td>:</td>
            <td>
                {{ $surat->penduduk->tempat_lahir }},
                {{ \Carbon\Carbon::parse($surat->penduduk->tanggal_lahir)->translatedFormat('d F Y') }}
            </td>
        </tr>

        <tr>
            <td>3.</td>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $surat->penduduk->agama }}</td>
        </tr>

        <tr>
            <td>4.</td>
            <td>Kewarganegaraan</td>
            <td>:</td>
            <td>{{ $surat->penduduk->kewarganegaraan ?? 'Indonesia' }}</td>
        </tr>

        <tr>
            <td>5.</td>
            <td>Status Perkawinan</td>
            <td>:</td>
            <td>{{ $surat->penduduk->status_perkawinan }}</td>
        </tr>

        <tr>
            <td>6.</td>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $surat->penduduk->jenis_pekerjaan }}</td>
        </tr>

        <tr>
            <td>7.</td>
            <td>Pendidikan</td>
            <td>:</td>
            <td>{{ $surat->penduduk->pendidikan }}</td>
        </tr>

        <tr>
            <td>8.</td>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $surat->penduduk->alamat }}</td>
        </tr>

        <tr>
            <td>9.</td>
            <td>Keperluan</td>
            <td>:</td>
            <td>{{ $detail->keperluan_antar }}</td>
        </tr>

        <tr>
            <td>10.</td>
            <td>Keterangan</td>
            <td>:</td>
            <td>
                {{ $detail->keterangan_antar ?? 'Orang tersebut benar warga Desa ' . $detail->desa_kelurahan }}
            </td>
        </tr>

    </table>

    <div style="margin-top:20px; text-align:justify; line-height:1.7;">

        <p>
            Demikian surat pengantar ini dibuat, kepada yang berkepentingan agar
            dapat dipergunakan sebagaimana mestinya.
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
                        <td>{{ $detail->desa_kelurahan }}</td>
                    </tr>

                    <tr>
                        <td>Pada tanggal</td>
                        <td>:</td>
                        <td>
                            {{ \Carbon\Carbon::parse($surat->tanggal_dibuat)->translatedFormat('d F Y') }}
                        </td>
                    </tr>

                </table>

                <div style="margin-top:20px; text-align:center;">

                    <div style="font-weight:bold;">
                        Kepala Desa {{ $detail->desa_kelurahan }}
                    </div>

                    <div style="height:90px; display:flex; justify-content:center; align-items:center;">

                        @if (!empty($persetujuan?->file_ttd))
                            <img src="{{ asset('storage/' . $persetujuan->file_ttd) }}"
                                style="max-height:85px; max-width:140px;" alt="Tanda Tangan">
                        @endif

                    </div>

                    <div style="font-weight:bold; text-decoration:underline; text-transform:uppercase;">
                        {{ strtoupper($persetujuan?->aparat?->nama ?? '............................') }}
                    </div>

                </div>

            </td>

        </tr>

    </table>
@endsection

<script>
    window.onload = function () {
        window.print();
    };
</script>