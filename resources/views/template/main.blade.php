<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Website Resmi Desa Kilwaru')</title>

    <!-- Meta Description -->
    <meta name="description" content="@yield('description', 'Website resmi Desa Kilwaru, Kecamatan Seram Timur, Kabupaten Seram Bagian Timur, menyajikan informasi lengkap tentang profil desa, sejarah, serta struktur pemerintahan desa. Melalui situs ini, Anda dapat mengenal lebih dekat kehidupan masyarakat Desa Kilwaru, serta berbagai potensi yang ada di desa ini. Temukan informasi mengenai program-program pembangunan dan kegiatan yang berlangsung di desa yang penuh dengan nilai sejarah dan budaya lokal.')">

    <!-- Meta Keywords -->
<!--     <meta name="keywords" content="@yield(
        'keywords',
        'Kilwaru, Desa Kilwaru, desa kilwaru, kilwaru, Kilwaru Website, Website Desa, sejarah desa kilwaru, profil desa kilwaru, pemerintahan desa kilwaru, kepala desa kilwaru, BPD kilwaru, RT RW kilwaru, penduduk kilwaru, demografi kilwaru, wisata kilwaru, potensi desa kilwaru, ekonomi kilwaru, pertanian kilwaru, perikanan kilwaru, UMKM kilwaru, budaya kilwaru, adat istiadat kilwaru, tradisi kilwaru, provinsi maluku, desa di maluku, pemerintah desa, pelayanan publik, administrasi desa, data desa, statistik desa, program desa, pembangunan desa, dana desa, APBDes, BUMDes, posyandu, PKK, karang taruna, lembaga desa, informasi desa kilwaru, berita desa kilwaru, pengumuman desa kilwaru, layanan desa kilwaru, surat desa kilwaru, izin desa kilwaru, kependudukan kilwaru, kartu keluarga kilwaru, KTP kilwaru, akta kelahiran kilwaru, surat keterangan kilwaru, surat domisili kilwaru, surat tidak mampu kilwaru, SKCK kilwaru, surat nikah kilwaru, legalisir dokumen kilwaru, maluku tengah, kecamatan, kelurahan kilwaru, kode pos kilwaru, alamat desa kilwaru, kontak desa kilwaru, telepon desa kilwaru, email desa kilwaru, lokasi desa kilwaru, maps desa kilwaru, peta desa kilwaru, geografis kilwaru, batas wilayah kilwaru, luas wilayah kilwaru, iklim kilwaru, cuaca kilwaru, topografi kilwaru, pariwisata kilwaru, objek wisata kilwaru, destinasi wisata kilwaru, pantai kilwaru, gunung kilwaru, hutan kilwaru, sungai kilwaru, danau kilwaru, air terjun kilwaru, kuliner kilwaru, makanan khas kilwaru, restoran kilwaru, warung kilwaru, hotel kilwaru, penginapan kilwaru, homestay kilwaru, akomodasi kilwaru, transportasi kilwaru, akses jalan kilwaru, terminal kilwaru, bandara kilwaru, pelabuhan kilwaru, fasilitas umum kilwaru, sekolah kilwaru, SD kilwaru, SMP kilwaru, SMA kilwaru, madrasah kilwaru, pendidikan kilwaru, guru kilwaru, siswa kilwaru, puskesmas kilwaru, posyandu kilwaru, dokter kilwaru, bidan kilwaru, kesehatan kilwaru, rumah sakit kilwaru, apotek kilwaru, masjid kilwaru, gereja kilwaru, tempat ibadah kilwaru, pasar kilwaru, toko kilwaru, bank kilwaru, ATM kilwaru, kantor pos kilwaru, internet kilwaru, wifi kilwaru, listrik kilwaru, air bersih kilwaru, sanitasi kilwaru, kebersihan kilwaru, sampah kilwaru, lingkungan kilwaru, gotong royong kilwaru, kerja bakti kilwaru, musyawarah desa kilwaru, rapat desa kilwaru, pemilihan kepala desa kilwaru, pilkades kilwaru, demokrasi desa kilwaru, partisipasi masyarakat kilwaru, transparansi desa kilwaru, akuntabilitas desa kilwaru, good governance kilwaru, inovasi desa kilwaru, digitalisasi desa kilwaru, smart village kilwaru, teknologi desa kilwaru, website resmi desa kilwaru, portal desa kilwaru, sistem informasi desa kilwaru, aplikasi desa kilwaru, online service desa kilwaru, e-government desa kilwaru, pelayanan online kilwaru, pendaftaran online kilwaru, covid-19 kilwaru, protokol kesehatan kilwaru, vaksinasi kilwaru, bantuan sosial kilwaru, BLT kilwaru, bantuan pemerintah kilwaru, program bantuan kilwaru, kemiskinan kilwaru, kesejahteraan kilwaru, pemberdayaan masyarakat kilwaru, koperasi kilwaru, simpan pinjam kilwaru, kredit usaha kilwaru, modal usaha kilwaru, wirausaha kilwaru, entrepreneur kilwaru, startup desa kilwaru, festival kilwaru, event kilwaru, kegiatan desa kilwaru, lomba desa kilwaru, kompetisi kilwaru, prestasi kilwaru, penghargaan desa kilwaru, desa terbaik kilwaru, desa mandiri kilwaru, desa sejahtera kilwaru, desa maju kilwaru, desa modern kilwaru, desa digital kilwaru, Indonesia'
    )"> -->
    <!-- AFTER: Focus & Spesifik -->
    <meta name="keywords" content="desa kilwaru, kilwaru maluku, website desa kilwaru, desa kilwaru seram timur">
    <!-- Meta tags tambahan untuk SEO -->
    <meta name="author" content="Pemerintah Desa Kilwaru">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Indonesian">
    <meta name="geo.region" content="ID-81">
    <meta name="geo.placename" content="Kilwaru, Maluku">

    <!-- Open Graph Meta Tags untuk media sosial -->
    <meta property="og:title" content="@yield('og_title', 'Desa Kilwaru - Website Resmi')">
    <meta property="og:description" content="@yield('og_description', 'Website resmi Desa Kilwaru, Maluku. Informasi lengkap tentang profil desa, sejarah, pemerintahan, dan potensi wisata.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    {{-- <meta property="og:image" content="{{ asset('images/logo-kilwaru.png') }}"> --}}
    <meta property="og:site_name" content="Desa Kilwaru">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Desa Kilwaru - Website Resmi')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Website resmi Desa Kilwaru, Maluku.')">
    {{-- <meta name="twitter:image" content="{{ asset('images/logo-kilwaru.png') }}"> --}}

    <!-- Meta tags khusus untuk desa -->
    <meta name="dc.title" content="Desa Kilwaru">
    <meta name="dc.subject" content="Pemerintahan Desa, Pelayanan Publik, Informasi Desa">
    <meta name="dc.creator" content="Pemerintah Desa Kilwaru">
    <meta name="dc.publisher" content="Pemerintah Desa Kilwaru">
    <meta name="dc.type" content="Text">
    <meta name="dc.format" content="text/html">
    <meta name="dc.language" content="id">
    <meta name="dc.coverage" content="Kilwaru, Maluku, Indonesia">

    <!-- Favicons -->
    <!-- Favicon utama (ICO) -->
    <link rel="icon" type="image/x-icon" href="{{ asset('asset/img/logo_sbt.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/img/logo_sbt.png') }}">

    <!-- Favicon untuk berbagai ukuran -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('asset/img/logo_sbt.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('asset/img/logo_sbt.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('asset/img/logo_sbt.png') }}">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('asset/img/logo_sbt.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('asset/img/logo_sbt.png') }}">

    <!-- Android Chrome -->
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('asset/img/logo_sbt.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('asset/img/logo_sbt.png') }}">

    <!-- Microsoft Tiles -->
    <meta name="msapplication-TileImage" content="{{ asset('asset/img/logo_sbt.png') }}">
    <meta name="msapplication-TileColor" content="#ffffff">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- CSS Bootstrap & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    @include('template.style')

    <!-- RSS Feed -->
    <link rel="alternate" type="application/rss+xml" title="{{ config('app.village_name') }} - Berita RSS"
        href="{{ route('berita.rss') }}">

    <!-- Sitemap -->
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('berita.sitemap') }}">

    <!-- Additional styles -->
    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    @include('template.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('template.footer')

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @include('template.js')

    <!-- Additional Scripts -->
    @stack('scripts')
</body>

</html>
