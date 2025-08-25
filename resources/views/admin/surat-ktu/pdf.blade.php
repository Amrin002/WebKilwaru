<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Tempat Usaha</title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10.5pt;
            margin: 0;
            padding: 1cm;
            line-height: 1.2;
        }

        .kop-surat {
            display: flex;
            align-items: center;
            position: relative;
            margin-bottom: 5px;
        }

        .kop-surat img {
            width: 65px;
            height: auto;
        }

        .kop-text {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            width: 100%;
            font-weight: bold;
            line-height: 1.1;
        }

        hr {
            border: 1px solid #000;
            margin: 6px 0;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .mt-1 {
            margin-top: 5px;
        }

        .mt-2 {
            margin-top: 1rem;
        }

        .data-surat {
            margin-left: 5%;
            margin-top: 9px;
            width: 100%;
        }

        table {
            width: 100%;
            font-size: 11pt;
        }

        td {
            vertical-align: top;
            padding: 1px 3px;
        }

        .signature {
            width: 35%;
            margin-left: auto;
            text-align: center;
            margin-top: 20px;
        }

        .isi-paragraf {
            text-align: justify;
        }

        .qr-code {
            width: 90px;
            height: 90px;
            margin-top: 5px;
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

    <div class="center mt-2 bold">
        SURAT KETERANGAN TEMPAT USAHA<br>
        NO: {{ $surat->nomor_surat ?? '...' }}
    </div>

    <p class="mt-2 isi-paragraf">
        Yang bertanda tangan di bawah ini, Kepala Pemerintah Negeri Akat Fadedo, Kecamatan Seram Timur,
        Kabupaten Seram Bagian Timur, dengan ini menerangkan bahwa:
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
            <td>Kewarganegaraan</td>
            <td>: {{ strtoupper($surat->kewarganegaraan) }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>: {{ strtoupper($surat->agama) }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: {{ strtoupper($surat->pekerjaan) }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ strtoupper($surat->alamat) }}</td>
        </tr>
    </table>

    <p class="mt-1 isi-paragraf">
        Berdasarkan Register Penduduk, benar yang bersangkutan adalah warga Negeri Akat Fadedo yang
        berdomisili di Dusun Akat Fadedo serta membuka/mempunyai usaha sebagai berikut:
    </p>

    <table class="data-surat">
        <tr>
            <td width="200">Nama Tempat Usaha</td>
            <td>: {{ strtoupper($surat->nama_usaha) }}</td>
        </tr>
        <tr>
            <td>Jenis Usaha</td>
            <td>: <span class="bold">"{{ strtoupper($surat->jenis_usaha) }}"</span></td>
        </tr>
        <tr>
            <td>Alamat Tempat Usaha</td>
            <td>: {{ strtoupper($surat->alamat_usaha) }}</td>
        </tr>
        <tr>
            <td>Pemilik Tempat Usaha</td>
            <td>: {{ strtoupper($surat->pemilik_usaha) }}</td>
        </tr>
    </table>

    <p class="mt-1">Demikian surat keterangan ini dibuat dan digunakan sebagaimana mestinya.</p>

    <div class="signature">
        <p>Dikeluarkan di: Fadedo</p>
        <p>Pada Tanggal: {{ $tanggal_dikeluarkan }}</p>
        <p>Kepala Pemerintah Negeri Administratif Akat Fadedo</p>

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

        <p class="bold">AHMAD BUGIS</p>
    </div>

</body>

</html>
