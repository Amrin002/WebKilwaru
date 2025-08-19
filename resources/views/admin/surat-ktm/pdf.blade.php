<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Tidak Mampu</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
        }

        .kop-surat {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
        }

        .kop-surat img {
            width: 80px;
            height: auto;
        }

        .kop-text {
            text-align: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            line-height: 1.2;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .mt-2 {
            margin-top: 1rem;
        }

        .mt-4 {
            margin-top: 2rem;
        }

        .data-surat {
            margin-left: 10%;
        }

        table {
            width: 100%;
            max-width: 600px;
        }

        td {
            vertical-align: top;
            padding: 2px 5px;
        }

        hr {
            margin: 10px 0;
        }

        .signature {
            width: 35%;
            margin-left: auto;
            text-align: center;
        }

        .isi-paragraf {
            text-align: justify;
        }

        .qr-code {
            width: 100px;
            height: 100px;
        }

        /* Placeholder untuk spacing QR code (100px height + margin) */
        .qr-placeholder {
            width: 100px;
            height: 100px;
            margin: 15px auto;
            border: 2px dashed #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #999;
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>

    <div class="kop-surat">
        <img src="{{ public_path('asset/img/logo_sbt.png') }}" alt="Logo SBT">
        <div class="kop-text">
            PEMERINTAH KABUPATEN SERAM BAGIAN TIMUR<br>
            KECAMATAN SERAM TIMUR<br>
            NEGERI KILWARU<br>
            Jln. Rumaniu
        </div>
    </div>

    <hr>

    <div class="center mt-2">
        <strong>SURAT KETERANGAN TIDAK MAMPU</strong><br>
        NO: {{ $surat->nomor_surat ?? '...' }}
    </div>

    <p class="mt-4 isi-paragraf">
        Kepala Pemerintah Negeri Kilwaru, Kecamatan Seram Timur, Kabupaten Seram Bagian Timur,
        menerangkan bahwa:
    </p>

    <table class="data-surat">
        <tr>
            <td width="200">Nama</td>
            <td>: {{ strtoupper($surat->nama) }}</td>
        </tr>
        <tr>
            <td>Tempat/Tgl Lahir</td>
            <td>: {{ $surat->tempat_lahir }}, {{ \Carbon\Carbon::parse($surat->tanggal_lahir)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>: {{ strtoupper($surat->jenis_kelamin) }}</td>
        </tr>
        <tr>
            <td>Status Kawin</td>
            <td>: {{ strtoupper($surat->status_kawin) }}</td>
        </tr>
        <tr>
            <td>Kewarganegaraan</td>
            <td>: {{ strtoupper($surat->kewarganegaraan) }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ strtoupper($surat->alamat) }}</td>
        </tr>
    </table>

    <p class="mt-2 isi-paragraf">
        Bahwa yang bersangkutan benar berasal dari keluarga yang berpenghasilan tidak tetap (keluarga tidak mampu).
        <br>Demikian surat keterangan ini dibuat dan digunakan sebagaimana mestinya.
    </p>

    <div class="signature mt-4">
        <p>Dikeluarkan di: Kilwaru</p>
        <p>Pada Tanggal: {{ $tanggal_dikeluarkan }}</p>
        <p>Kepala Pemerintah Negeri Kilwaru</p>



        {{-- GANTI BAGIAN QR CODE SECTION SAJA --}}

        {{-- QR Code Section - FIXED FOR STORED PNG FILES --}}
        @if (isset($qrCodeBase64) && $qrCodeBase64)
            {{-- QR Code dari file PNG yang tersimpan --}}
            <img src="{{ $qrCodeBase64 }}" alt="QR Code Verifikasi" class="qr-code"
                style="width: 100px; height: 100px; margin: 15px auto; display: block;">
        @elseif($surat->qr_code_path && file_exists(storage_path('app/public/' . $surat->qr_code_path)))
            {{-- Fallback: Baca file QR Code langsung jika ada --}}
            @php
                $qrFile = storage_path('app/public/' . $surat->qr_code_path);
                $qrBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($qrFile));
            @endphp
            <img src="{{ $qrBase64 }}" alt="QR Code Verifikasi" class="qr-code"
                style="width: 100px; height: 100px; margin: 15px auto; display: block;">
        @elseif($surat->nomor_surat)
            {{-- Jika ada nomor surat tapi QR Code belum tersedia --}}
            <div class="qr-placeholder"
                style="width: 100px; height: 100px; margin: 15px auto; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999; background-color: #f9f9f9; text-align: center;">
                <div>
                    QR CODE<br>
                    VERIFIKASI<br>
                    <strong>{{ $surat->nomor_surat }}</strong>
                </div>
            </div>
            <div style="text-align: center; font-size: 10px; margin-top: 5px;">
                QR Code sedang diproses
            </div>
        @else
            {{-- Jika belum ada nomor surat --}}
            <div class="qr-placeholder"
                style="width: 100px; height: 100px; margin: 15px auto; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999; background-color: #f9f9f9; text-align: center;">
                <div>
                    QR CODE<br>
                    AKAN TERSEDIA<br>
                    SETELAH DISETUJUI
                </div>
            </div>
        @endif

        <p><strong>AHMAD BUGIS</strong></p>
    </div>

</body>

</html>
