@extends('template.main')

@section('title', 'RSS Feed - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description', 'Berlangganan RSS Feed untuk mendapatkan update berita terbaru')

@push('styles')
    <style>
        .rss-hero {
            background: linear-gradient(rgba(255, 140, 66, 0.9), rgba(255, 140, 66, 0.7)),
                url('https://images.unsplash.com/photo-1563986768609-322da13575f3?ixlib=rb-4.0.3') center/cover;
            color: white;
            padding: 100px 0 50px;
            margin-top: -80px;
            padding-top: 160px;
        }

        .rss-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
        }

        .feed-url-box {
            background: #f8f9fa;
            border: 2px dashed var(--primary-green);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            position: relative;
        }

        .feed-url {
            font-family: monospace;
            word-break: break-all;
            color: var(--primary-green);
            font-weight: 600;
        }

        .copy-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .reader-card {
            transition: all 0.3s ease;
            height: 100%;
        }

        .reader-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .step-number {
            width: 40px;
            height: 40px;
            background: var(--accent-orange);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
        }
    </style>
@endpush

@section('content')
    <!-- RSS Hero -->
    <section class="rss-hero text-center">
        <div class="container">
            <div class="rss-icon">
                <i class="bi bi-rss-fill"></i>
            </div>
            <h1 class="display-4 fw-bold mb-4">RSS Feed</h1>
            <p class="lead">Berlangganan untuk mendapatkan update berita terbaru langsung ke RSS reader favorit Anda</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <!-- What is RSS -->
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="h3 mb-4">Apa itu RSS Feed?</h2>
                            <p>RSS (Really Simple Syndication) adalah format standar untuk distribusi konten web. Dengan
                                berlangganan RSS feed kami, Anda akan:</p>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Mendapatkan
                                    notifikasi otomatis setiap ada berita baru</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Membaca semua berita
                                    di satu tempat (RSS reader)</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Tidak perlu
                                    mengunjungi website secara manual</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Hemat waktu dan
                                    tetap update dengan informasi terkini</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How to Subscribe -->
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="text-center mb-4">Cara Berlangganan</h2>

                    <!-- Step 1 -->
                    <div class="d-flex align-items-start mb-4">
                        <div class="step-number">1</div>
                        <div class="flex-grow-1">
                            <h5>Copy URL RSS Feed</h5>
                            <p>Klik tombol "Copy" untuk menyalin URL RSS feed kami:</p>
                            <div class="feed-url-box">
                                <div class="feed-url" id="feedUrl">{{ route('berita.rss') }}</div>
                                <button class="btn btn-sm btn-primary copy-btn" onclick="copyFeedUrl()">
                                    <i class="bi bi-clipboard"></i> Copy
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="d-flex align-items-start mb-4">
                        <div class="step-number">2</div>
                        <div class="flex-grow-1">
                            <h5>Pilih RSS Reader</h5>
                            <p>Pilih salah satu RSS reader di bawah ini atau gunakan aplikasi favorit Anda:</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RSS Readers -->
            <div class="row g-4 mb-5">
                @php
                    $rssUrl = urlencode(route('berita.rss'));
                    $readers = [
                        [
                            'name' => 'Feedly',
                            'icon' => 'bi-rss',
                            'color' => '#2bb24c',
                            'url' => "https://feedly.com/i/subscription/feed/{$rssUrl}",
                            'description' => 'RSS reader populer dengan interface modern',
                        ],
                        [
                            'name' => 'Inoreader',
                            'icon' => 'bi-book',
                            'color' => '#007bc7',
                            'url' => "https://www.inoreader.com/feed/{$rssUrl}",
                            'description' => 'Powerful RSS reader dengan fitur lengkap',
                        ],
                        [
                            'name' => 'NewsBlur',
                            'icon' => 'bi-newspaper',
                            'color' => '#e74c3c',
                            'url' => "https://newsblur.com/?url={$rssUrl}",
                            'description' => 'RSS reader dengan AI filter',
                        ],
                        [
                            'name' => 'The Old Reader',
                            'icon' => 'bi-clock-history',
                            'color' => '#95a5a6',
                            'url' => "https://theoldreader.com/feeds/subscribe?url={$rssUrl}",
                            'description' => 'Simple RSS reader seperti Google Reader',
                        ],
                    ];
                @endphp

                @foreach ($readers as $reader)
                    <div class="col-md-6 col-lg-3">
                        <div class="card reader-card h-100">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="{{ $reader['icon'] }}"
                                        style="font-size: 3rem; color: {{ $reader['color'] }}"></i>
                                </div>
                                <h5 class="card-title">{{ $reader['name'] }}</h5>
                                <p class="card-text small">{{ $reader['description'] }}</p>
                                <a href="{{ $reader['url'] }}" target="_blank" class="btn btn-primary btn-sm">
                                    Subscribe
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Direct Links -->
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h3 class="mb-4">Link Langsung</h3>
                    <div class="btn-group" role="group">
                        <a href="{{ route('berita.rss') }}" target="_blank" class="btn btn-outline-primary">
                            <i class="bi bi-rss-fill me-2"></i>View RSS Feed
                        </a>
                        <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Berita
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function copyFeedUrl() {
            const feedUrl = document.getElementById('feedUrl').textContent;
            navigator.clipboard.writeText(feedUrl).then(() => {
                const btn = event.target.closest('button');
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check"></i> Copied!';
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-success');

                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-primary');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy:', err);
                alert('Gagal menyalin URL');
            });
        }
    </script>
@endpush
