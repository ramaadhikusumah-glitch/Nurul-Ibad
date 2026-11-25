@php
    $c = config('pesantren');

    // Link WhatsApp
    $wa = fn ($no, $msg) => 'https://wa.me/' . $no . '?text=' . rawurlencode($msg);
    $waPanitia = $wa($c['wa_panitia'], 'Assalamu’alaikum Warahmatullahi Wabarakatuh, saya ingin konsultasi pendaftaran santri baru di ' . $c['nama'] . '.');
    $pesanDaftar = "Assalamu'alaikum, saya ingin mendapatkan informasi mengenai pendaftaran santri baru " . $c['nama'] . ' Tahun Ajaran ' . $c['tahun'] . '.';
    $waDaftar = $wa($c['wa_panitia'], $pesanDaftar);

    // Foto: kembalikan URL kalau file ada di /public, kalau tidak null
    $img = fn ($path) => ($path && file_exists(public_path($path))) ? asset($path) : null;

    // Inisial untuk placeholder foto orang
    $inisial = fn ($nama) => collect(explode(' ', preg_replace('/^(KH\.|Ust\.)\s*/', '', $nama)))
        ->take(2)->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');

    // Avatar bulat: foto asli atau inisial
    $avatar = function ($nama, $path, $size = 'h-28 w-28', $text = 'text-2xl') use ($img, $inisial) {
        $url = $img($path);
        if ($url) {
            return new Illuminate\Support\HtmlString('<img src="' . e($url) . '" alt="' . e($nama) . '" loading="lazy" class="' . $size . ' rounded-full object-cover object-top ring-4 ring-white shadow-lg">');
        }
        return new Illuminate\Support\HtmlString('<div class="' . $size . ' grid place-items-center rounded-full bg-gradient-to-br from-pine-600 to-pine-800 ' . $text . ' font-extrabold text-gold-300 ring-4 ring-white shadow-lg">' . e($inisial($nama)) . '</div>');
    };

    $logo = $img($c['logo']);
    $heroFoto = $img($c['hero']['foto']);
    $galeri = collect($c['galeri'])->map(fn ($g) => $g + ['url' => $img($g['foto'])]);
    $adaGaleri = $galeri->contains(fn ($g) => $g['url']);

    $menu = [
        ['profil', 'Profil & Sanad'], ['lingkungan', 'Lingkungan'], ['it', 'Bimbingan IT'],
        ['asatidz', 'Dewan Asatidz'], ['humas', 'Tim Humas'], ['infaq', 'Infaq & Pendaftaran'], ['lokasi', 'Lokasi'],
    ];

    $ikonWa = '<svg viewBox="0 0 32 32" class="h-5 w-5" fill="currentColor"><path d="M16 3a13 13 0 0 0-11 19.8L3 29l6.4-2A13 13 0 1 0 16 3zm0 23.6a10.5 10.5 0 0 1-5.4-1.5l-.4-.2-3.8 1.2 1.2-3.7-.3-.4A10.6 10.6 0 1 1 16 26.6zm5.8-7.9c-.3-.2-1.9-.9-2.2-1s-.5-.2-.7.2-.8 1-1 1.2-.4.2-.7.1a8.600 8.600 0 0 1-4.300-3.700c-.3-.6.300-.5.900-1.700.1-.2 0-.4 0-.5l-1-2.300c-.2-.6-.5-.5-.7-.5h-.6a1.200 1.200 0 0 0-.9.400 3.700 3.700 0 0 0-1.200 2.800 6.400 6.400 0 0 0 1.300 3.400 14.700 14.700 0 0 0 5.600 4.900c2.100.9 2.900 1 3.900.8a3.300 3.300 0 0 0 2.200-1.600 2.700 2.700 0 0 0 .2-1.600c-.1-.1-.3-.2-.6-.4z"/></svg>';
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $c['nama'] }} – PSB {{ $c['tahun'] }} | {{ $c['lokasi'] }}</title>
    <meta name="description" content="Penerimaan santri baru putra {{ $c['tahun'] }} di {{ $c['nama'] }}, Lubang Buaya, Cipayung, {{ $c['lokasi'] }}. Mengaji Kitab Kuning, mengenal dasar komputer. Binaan terbatas {{ $c['kuota'] }}.">
    @if ($logo)<link rel="icon" href="{{ $logo }}">@endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'], arab: ['Amiri', 'serif'] },
                colors: {
                    pine: { 50:'#f0f7f3', 100:'#dcede3', 200:'#b9dbc7', 500:'#2f7d57', 600:'#256646', 700:'#1d5139', 800:'#163e2c', 900:'#0e2a1e' },
                    gold: { 300:'#ecd28a', 400:'#e2bf5e', 500:'#d4a93a', 600:'#b88c24' },
                }
            } }
        }
    </script>
    <style>
        .pattern {
            background-image:
                radial-gradient(circle at 15% 20%, rgba(212,169,58,.18), transparent 40%),
                radial-gradient(circle at 85% 75%, rgba(47,125,87,.35), transparent 45%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Cpath d='M30 0l8 22 22 8-22 8-8 22-8-22L0 30l22-8z' fill='none' stroke='%23ffffff' stroke-opacity='.06'/%3E%3C/svg%3E");
        }
        .fade-up { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s ease; }
        .fade-up.show { opacity: 1; transform: none; }
        section[id] { scroll-margin-top: 110px; }
        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible { outline: 2px solid #ecd28a; outline-offset: 2px; }
        @media (prefers-reduced-motion: reduce) { .fade-up { opacity: 1; transform: none; transition: none; } }
    </style>
</head>
<body class="overflow-x-clip bg-white pb-16 font-sans text-slate-700 antialiased sm:pb-0">

    {{-- TOP BAR --}}
    <div class="bg-pine-800 text-xs text-white sm:text-sm">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-center gap-x-6 gap-y-1 px-4 py-2 sm:justify-between">
            <span><strong class="text-gold-300">PSB {{ $c['tahun'] }}</strong> · Penerimaan Santri Baru — Khusus Putra (Binaan Terbatas {{ $c['kuota'] }})</span>
            <span class="flex items-center gap-4">
                <span class="hidden text-white/80 md:inline">Pengasuhan Intensif & Suasana Kekeluargaan</span>
                <a href="{{ $waPanitia }}" target="_blank" rel="noopener" class="font-semibold text-gold-300 hover:underline">WhatsApp Panitia →</a>
            </span>
        </div>
    </div>

    {{-- NAVBAR --}}
    <header class="sticky top-0 z-50 bg-pine-900/95 text-white shadow-lg backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-4 py-3 sm:px-5">
            <a href="#beranda" class="flex min-w-0 items-center gap-2.5 sm:gap-3">
               @if ($logo)
                    <img src="{{ $logo }}" alt="Logo {{ $c['nama'] }}" class="h-11 w-11 flex-none rounded-full bg-white object-contain p-0.5 ring-2 ring-gold-500/60">
                    @else
                        <span class="grid h-11 w-11 flex-none place-items-center rounded-full bg-gold-500 font-arab text-xl text-pine-900">ن</span>
                    @endif 
                <span class="min-w-0 leading-tight">
                    <span class="flex items-center gap-1.5 whitespace-nowrap text-sm font-extrabold sm:text-base">{{ strtoupper($c['singkat']) }} <span class="rounded bg-gold-500 px-1.5 py-0.5 text-xs font-bold text-pine-900 align-middle">PUTRA</span></span>
                    <span class="block truncate text-xs text-white/75">Pondok Pesantren • {{ $c['lokasi'] }}</span>
                </span>
            </a>
            <nav class="hidden items-center justify-center gap-1 whitespace-nowrap text-[13px] font-medium text-white/90 xl:flex 2xl:gap-2" aria-label="Navigasi utama">
                @foreach ($menu as [$id, $label])
                    <a href="#{{ $id }}" data-nav-link class="rounded-lg px-2.5 py-2 transition hover:bg-white/10 hover:text-gold-300 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-pine-900">{{ $label }}</a>
                @endforeach
            </nav>
            <div class="flex flex-none items-center gap-2">
                <a href="{{ $waDaftar }}" target="_blank" rel="noopener" class="hidden whitespace-nowrap rounded-full bg-gold-500 px-4 py-2 text-[13px] font-bold text-pine-900 shadow-sm ring-1 ring-gold-300/60 transition hover:bg-gold-400 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-pine-900 sm:inline-flex sm:items-center xl:px-5">Daftar PSB Online</a>
                <button id="menuBtn" type="button" class="grid h-10 w-10 flex-none place-items-center rounded-lg ring-1 ring-white/20 transition hover:bg-white/10 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-pine-900 xl:hidden" aria-label="Buka menu" aria-controls="mobileMenu" aria-expanded="false">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
        <nav id="mobileMenu" class="hidden max-h-[70vh] overflow-y-auto border-t border-white/10 bg-pine-900/95 px-4 pb-5 pt-2 text-sm shadow-inner backdrop-blur sm:px-5 xl:hidden" aria-label="Navigasi seluler">
            <div class="mx-auto max-w-6xl space-y-1">
                @foreach ($menu as [$id, $label])
                    <a href="#{{ $id }}" data-nav-link class="block rounded-xl px-3 py-2.5 text-white/85 transition hover:bg-white/10 hover:text-gold-300 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-pine-900">{{ $label }}</a>
                @endforeach
                <a href="{{ $waDaftar }}" target="_blank" rel="noopener" class="mt-3 flex items-center justify-center rounded-full bg-gold-500 px-5 py-3 font-bold text-pine-900 shadow-sm transition hover:bg-gold-400 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-pine-900">Daftar PSB Online</a>
            </div>
        </nav>
    </header>

    {{-- HERO --}}
    <section id="beranda" class="pattern relative overflow-hidden bg-pine-900 pb-20 pt-10 text-white">
        <div class="mx-auto grid max-w-6xl items-center gap-10 px-5 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,0.8fr)] lg:gap-12">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold ring-1 ring-white/15">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span> {{ $c['nama'] }} • Khusus Putra
                </span>
                <h1 class="mt-4 max-w-xl text-3xl font-extrabold leading-[1.15] text-balance sm:text-4xl xl:text-[2.5rem]">
                    Membina Akhlak & Kemandirian <span class="text-gold-400">Santri Putra:</span> Mengaji Kitab Kuning, Mengenal Dasar Komputer.
                </h1>
                <p class="mt-4 max-w-xl text-base leading-7 text-white/80">{{ $c['hero']['deskripsi'] }}</p>

                <ul class="mt-5 grid max-w-xl gap-x-6 gap-y-3 text-[15px] sm:grid-cols-2">
                    @foreach ($c['hero']['poin'] as $p)
                        <li class="flex gap-2"><span class="mt-0.5 grid h-5 w-5 flex-none place-items-center rounded-full bg-gold-500 text-xs font-bold text-pine-900">✓</span><span class="text-white/90">{{ $p }}</span></li>
                    @endforeach
                </ul>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ $waDaftar }}" target="_blank" rel="noopener" class="rounded-full bg-gold-500 px-7 py-3.5 text-center font-bold text-pine-900 shadow-lg transition hover:-translate-y-0.5 hover:bg-gold-400 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-pine-900">Formulir Pendaftaran Santri →</a>
                    <a href="{{ $waPanitia }}" target="_blank" rel="noopener" class="rounded-full border border-white/30 px-7 py-3.5 text-center font-semibold transition hover:bg-white/10 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-pine-900">Konsultasi WhatsApp Panitia</a>
                </div>
                <p class="mt-3 max-w-xl text-xs text-white/75">{{ $c['hero']['catatan'] }}</p>
            </div>

            <div class="relative">
                <div class="absolute -inset-3 rounded-[2rem] bg-gold-500/20 blur-2xl"></div>
                <div class="relative overflow-hidden rounded-[2rem] bg-pine-800 shadow-2xl ring-1 ring-white/15">
                    <div class="relative aspect-[4/3]">
                        @if ($heroFoto)
                            <button type="button" data-lightbox="{{ $heroFoto }}" data-caption="Lingkungan Pondok Pesantren" aria-label="Perbesar foto lingkungan pondok" class="group absolute inset-0 block h-full w-full cursor-pointer overflow-hidden text-left focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-gold-300">
                                <img src="{{ $heroFoto }}" alt="Lingkungan {{ $c['nama'] }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <span class="absolute inset-0 bg-gradient-to-t from-pine-900/80 via-transparent to-transparent"></span>
                                <span class="absolute right-4 top-4 grid h-8 w-8 place-items-center rounded-full bg-black/40 text-white ring-1 ring-white/25 backdrop-blur transition group-hover:bg-black/60">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4M11 8v6M8 11h6"/></svg>
                                </span>
                            </button>
                        @else
                            <div class="grid h-full place-items-center bg-gradient-to-br from-pine-600 to-pine-800 text-center">
                                <div><p class="font-arab text-7xl text-gold-300">نور العباد</p><p class="mt-3 text-sm text-white/70">Foto lingkungan pondok</p></div>
                            </div>
                            <span class="absolute inset-0 bg-gradient-to-t from-pine-900/80 via-transparent to-transparent"></span>
                        @endif
                        <span class="pointer-events-none absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-bold uppercase tracking-wider text-pine-800">{{ $c['lokasi'] }}</span>
                        <p class="pointer-events-none absolute bottom-4 left-5 font-bold">Lingkungan Pondok Pesantren</p>
                    </div>
                    <div class="grid grid-cols-3 divide-x divide-white/10 bg-pine-900/60 text-center">
                        @foreach ($c['statistik'] as $s)
                            <div class="px-2 py-4">
                                <p class="text-xs uppercase tracking-wider text-white/75">{{ $s['label'] }}</p>
                                <p class="mt-0.5 text-sm font-extrabold text-gold-400">{{ $s['angka'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="button" id="komputerCard" class="relative z-10 mt-5 flex w-full max-w-md cursor-pointer items-start gap-3 rounded-2xl bg-white p-4 text-left text-pine-800 shadow-xl ring-1 ring-pine-100 transition hover:-translate-y-0.5 hover:shadow-xl focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-pine-900 sm:mt-6 sm:p-5">
                    <span class="grid h-10 w-10 flex-none place-items-center rounded-xl bg-pine-800 text-lg">💻</span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold">{{ $c['hero']['kartu_komputer']['judul'] }}</p>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">{{ $c['hero']['kartu_komputer']['isi'] }}</p>
                        <span class="mt-2 block text-right text-[11px] font-bold text-gold-600">Lihat detail →</span>
                    </div>
                </button>
            </div>
        </div>
        <svg class="absolute bottom-0 left-0 w-full text-white" viewBox="0 0 1440 80" preserveAspectRatio="none" fill="currentColor"><path d="M0 80V40c240 40 480 40 720 10S1200 0 1440 30v50z"/></svg>
    </section>

    {{-- PROFIL & SANAD --}}
    <section id="profil" class="py-12 lg:py-16">
        <div class="mx-auto max-w-6xl px-5">
            <div class="grid items-start gap-12 lg:grid-cols-2">
                <div class="fade-up">
                    <p class="text-sm font-bold uppercase tracking-widest text-gold-600">{{ $c['profil']['label'] }}</p>
                    <h2 class="mt-2 text-3xl font-extrabold leading-tight text-pine-800 sm:text-3xl">{{ $c['profil']['judul'] }}</h2>
                    @foreach ($c['profil']['paragraf'] as $para)
                        <p class="mt-5 max-w-2xl text-base leading-relaxed">{{ $para }}</p>
                    @endforeach

                    <figure class="mt-8 flex gap-5 rounded-2xl border-l-4 border-gold-500 bg-pine-50 p-6">
                        <div class="hidden flex-none sm:block">{{ $avatar('KH. Muhammad Syakrim, BA', $c['profil']['foto'], 'h-20 w-20', 'text-xl') }}</div>
                        <div>
                            <blockquote class="italic text-pine-800">“{{ $c['profil']['kutipan'] }}”</blockquote>
                            <figcaption class="mt-3 text-sm font-semibold text-gold-600">— {{ $c['profil']['sumber'] }}</figcaption>
                        </div>
                    </figure>
                </div>

                <div class="fade-up">
                    <p class="text-sm font-bold uppercase tracking-widest text-gold-600">Nilai Pengasuhan Santri</p>
                    <h3 class="mt-2 text-xl font-extrabold text-pine-800">Empat Karakter Utama Santri</h3>
                    <div class="mt-6 space-y-4">
                        @foreach ($c['karakter'] as $i => $k)
                            <div class="flex gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-pine-100 transition hover:-translate-y-0.5 hover:shadow-lg">
                                <span class="grid h-11 w-11 flex-none place-items-center rounded-xl bg-pine-100 font-extrabold text-pine-700">{{ $i + 1 }}</span>
                                <div>
                                    <h4 class="font-bold text-pine-800">{{ $k['judul'] }}</h4>
                                    <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $k['isi'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- LINGKUNGAN (GALERI FOTO) --}}
    <section id="lingkungan" class="bg-pine-50 py-12 lg:py-16">
        <div class="mx-auto max-w-6xl px-5">
            <div class="fade-up mx-auto max-w-2xl text-center">
                <p class="text-sm font-bold uppercase tracking-widest text-gold-600">Lingkungan Pondok</p>
                <h2 class="mt-2 text-3xl font-extrabold text-pine-800 sm:text-3xl">Rumah kedua yang aman dan menenangkan</h2>
                <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-slate-600">Lihat suasana asrama, sarana ibadah, dan lingkungan belajar santri di {{ $c['nama'] }}.</p>
            </div>
            <div class="mt-12 grid grid-cols-2 gap-4 md:grid-cols-3">
                @foreach ($galeri as $i => $g)
                    @if ($g['url'])
                        <button type="button" data-lightbox="{{ $g['url'] }}" data-caption="{{ $g['caption'] }}"
                                class="fade-up group relative overflow-hidden rounded-2xl shadow-sm ring-1 ring-pine-100 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 {{ $i === 0 ? 'col-span-2 aspect-[16/10] md:col-span-2 md:row-span-2 md:aspect-auto' : 'aspect-[4/3]' }}">
                            <img src="{{ $g['url'] }}" alt="{{ $g['caption'] }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-pine-900/80 to-transparent p-3 text-left text-sm font-semibold text-white">{{ $g['caption'] }}</span>
                        </button>
                    @elseif (! $adaGaleri)
                        <div class="fade-up grid aspect-[4/3] place-items-center rounded-2xl border-2 border-dashed border-pine-200 bg-white text-center text-sm text-pine-600">
                            <div><p class="text-3xl">🖼️</p><p class="mt-2 font-semibold">{{ $g['caption'] }}</p><p class="text-xs text-slate-500">{{ $g['foto'] }}</p></div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="fade-up mt-8 text-center">
                <a href="https://www.instagram.com/ponpes.nurulibad/" target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center gap-2 rounded-full bg-pine-800 px-6 py-3 text-sm font-bold text-gold-300 shadow-sm transition hover:-translate-y-0.5 hover:bg-pine-700 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-pine-50">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
                    Lihat kegiatan di Instagram @ponpes.nurulibad
                </a>
            </div>
        </div>
    </section>

    {{-- BIMBINGAN IT --}}
    <section id="it" class="py-12 lg:py-16">
        <div class="mx-auto max-w-6xl px-5">
            <div class="fade-up mx-auto max-w-3xl text-center">
                <p class="text-sm font-bold uppercase tracking-widest text-gold-600">{{ $c['it']['label'] }}</p>
                <h2 class="mt-2 text-3xl font-extrabold text-pine-800 sm:text-3xl">{{ $c['it']['judul'] }}</h2>
                <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-slate-600">{{ $c['it']['isi'] }}</p>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-5">
                <div class="fade-up rounded-3xl bg-pine-800 p-8 text-white lg:col-span-2">
                    <div class="grid h-12 w-12 place-items-center rounded-xl bg-gold-500 text-2xl">💻</div>
                    <h3 class="mt-5 text-xl font-extrabold">{{ $c['it']['porsi_judul'] }}</h3>
                    <p class="mt-3 text-sm leading-relaxed text-white/80">{{ $c['it']['porsi_isi'] }}</p>
                    <ul class="mt-5 space-y-3 text-sm">
                        @foreach ($c['it']['porsi_poin'] as $p)
                            <li class="flex gap-3"><span class="mt-0.5 grid h-5 w-5 flex-none place-items-center rounded-full bg-gold-500 text-xs font-bold text-pine-900">✓</span><span>{{ $p }}</span></li>
                        @endforeach
                    </ul>
                    <a href="{{ $wa($c['wa_panitia'], $c['humas']['orang'][1]['pesan']) }}" target="_blank" rel="noopener" class="mt-6 inline-block text-sm font-bold text-gold-300 hover:underline">Tanya Ust. Rifki seputar multimedia & IT santri →</a>
                </div>
                <div class="grid gap-6 sm:grid-cols-2 lg:col-span-3">
                    @foreach ($c['it']['poin'] as $p)
                        <div class="fade-up group rounded-2xl bg-white p-6 shadow-sm ring-1 ring-pine-100 transition hover:-translate-y-1 hover:shadow-xl">
                            <div class="grid h-12 w-12 place-items-center rounded-xl bg-pine-100 text-2xl transition group-hover:bg-gold-300">{{ $p['ikon'] }}</div>
                            <h3 class="mt-4 font-bold text-pine-800">{{ $p['judul'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $p['isi'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- DEWAN ASATIDZ --}}
    <section id="asatidz" class="bg-pine-50 py-12 lg:py-16">
        <div class="mx-auto max-w-6xl px-5">
            <div class="fade-up mx-auto max-w-3xl text-center">
                <p class="text-sm font-bold uppercase tracking-widest text-gold-600">Dewan Masyayikh & Pimpinan Yayasan</p>
                <h2 class="mt-2 text-3xl font-extrabold text-pine-800 sm:text-3xl">{{ $c['dewan']['judul'] }}</h2>
                <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-slate-600">{{ $c['dewan']['isi'] }}</p>
            </div>

            <div class="mx-auto mt-12 grid max-w-4xl gap-6 md:grid-cols-2">
                @foreach ($c['dewan']['pimpinan'] as $u)
                    <div class="fade-up rounded-3xl bg-white p-8 text-center shadow-sm ring-2 ring-pine-100 transition duration-300 ease-out hover:shadow-xl focus-within:shadow-xl {{ $loop->first ? 'hover:ring-pine-700 focus-within:ring-pine-700' : 'hover:ring-pine-500 focus-within:ring-pine-500' }}">
                        <div class="relative mx-auto w-fit">
                            {{ $avatar($u['nama'], $u['foto'], 'h-36 w-36', 'text-4xl') }}
                            <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-full bg-pine-800 px-3 py-1 text-xs font-bold text-white">{{ $u['badge'] }}</span>
                        </div>
                        <h3 class="mt-7 text-xl font-extrabold text-pine-800">{{ $u['nama'] }}</h3>
                        <p class="mt-1 text-sm font-semibold text-pine-600">{{ $u['peran'] }}</p>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $u['isi'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="fade-up mt-14 flex items-center gap-4">
                <span class="h-px flex-1 bg-pine-200"></span>
                <span class="rounded-full bg-white px-5 py-2 text-xs font-bold uppercase tracking-wider text-pine-800 ring-1 ring-pine-200">Asatidz Pengampu Pendidikan Santri</span>
                <span class="h-px flex-1 bg-pine-200"></span>
            </div>

            <div class="mx-auto mt-10 grid max-w-4xl gap-6 md:grid-cols-2">
                @foreach ($c['dewan']['asatidz'] as $u)
                    <div class="fade-up rounded-3xl bg-white p-7 text-center shadow-sm ring-1 ring-pine-100 transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="mx-auto w-fit">{{ $avatar($u['nama'], $u['foto'], 'h-28 w-28', 'text-3xl') }}</div>
                        <h3 class="mt-5 text-lg font-extrabold text-pine-800">{{ $u['nama'] }}</h3>
                        <p class="mt-1 inline-block rounded-full bg-pine-100 px-3 py-1 text-xs font-bold text-pine-700">{{ $u['peran'] }}</p>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $u['isi'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TIM HUMAS --}}
    <section id="humas" class="pattern bg-pine-900 py-12 lg:py-16 text-white">
        <div class="mx-auto max-w-6xl px-5">
            <div class="fade-up mx-auto max-w-3xl text-center">
                <p class="text-sm font-bold uppercase tracking-widest text-gold-400">Tim Layanan & Komunikasi</p>
                <h2 class="mt-2 text-3xl font-extrabold sm:text-3xl">{{ $c['humas']['judul'] }}</h2>
                <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-white/75">{{ $c['humas']['isi'] }}</p>
            </div>
            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @foreach ($c['humas']['orang'] as $h)
                    <div class="fade-up flex flex-col rounded-3xl bg-white p-7 text-slate-700 shadow-xl">
                        <div class="flex items-center gap-4">
                            {{ $avatar($h['nama'], $h['foto'], 'h-16 w-16', 'text-lg') }}
                            <div>
                                <span class="rounded-full bg-pine-100 px-2.5 py-0.5 text-xs font-bold text-pine-700">{{ $h['badge'] }}</span>
                                <h3 class="mt-1 font-extrabold text-pine-800">{{ $h['nama'] }}</h3>
                                <p class="text-xs text-slate-500">Akrab disapa: {{ $h['sapaan'] }}</p>
                            </div>
                        </div>
                        <p class="mt-4 flex-1 text-sm leading-relaxed text-slate-600">{{ $h['isi'] }}</p>
                        <div class="mt-4 flex items-center justify-between border-t border-pine-100 pt-4 text-xs text-slate-500">
                            <span>🕗 {{ $c['humas']['jam'] }}</span>
                            <span class="font-bold text-pine-800">{{ $h['hp'] }}</span>
                        </div>
                        <a href="{{ $wa($h['wa'], $h['pesan']) }}" target="_blank" rel="noopener"
                           class="mt-4 inline-flex items-center justify-center gap-2 rounded-full bg-pine-800 px-5 py-3 text-sm font-bold text-white transition hover:bg-pine-700">
                            {!! $ikonWa !!} Chat WhatsApp {{ $h['sapaan'] }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- INFAQ & PENDAFTARAN --}}
    <section id="infaq" class="py-12 lg:py-16">
        <div class="mx-auto max-w-6xl px-5">
            <div class="fade-up mx-auto max-w-3xl text-center">
                <p class="text-sm font-bold uppercase tracking-widest text-gold-600">{{ $c['infaq']['label'] }}</p>
                <h2 class="mt-2 text-3xl font-extrabold text-pine-800 sm:text-3xl">{{ $c['infaq']['judul'] }}</h2>
                <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-slate-600">{{ $c['infaq']['isi'] }}</p>
            </div>
            <div class="mt-12 grid gap-6 md:grid-cols-2">
                @foreach ($c['infaq']['kartu'] as $k)
                    <div class="fade-up flex flex-col rounded-3xl bg-pine-50 p-8 ring-1 ring-pine-100">
                        <div class="grid h-12 w-12 place-items-center rounded-xl bg-white text-2xl shadow-sm">{{ $k['ikon'] }}</div>
                        <h3 class="mt-5 text-xl font-extrabold text-pine-800">{{ $k['judul'] }}</h3>
                        <p class="text-sm font-semibold text-gold-600">{{ $k['sub'] }}</p>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $k['isi'] }}</p>
                        <ul class="mt-4 flex-1 space-y-2 text-sm">
                            @foreach ($k['poin'] as $p)
                                <li class="flex gap-3"><span class="mt-0.5 grid h-5 w-5 flex-none place-items-center rounded-full bg-pine-700 text-xs text-white">✓</span><span>{{ $p }}</span></li>
                            @endforeach
                        </ul>
                        <a href="{{ $wa($c['wa_panitia'], $k['pesan']) }}" target="_blank" rel="noopener"
                           class="mt-6 inline-flex items-center justify-center gap-2 rounded-full {{ $loop->first ? 'bg-pine-800 text-white hover:bg-pine-700' : 'border border-pine-800 text-pine-800 hover:bg-pine-800 hover:text-white' }} px-6 py-3.5 text-sm font-bold transition">
                            {!! $ikonWa !!} {{ $k['tombol'] }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ALUR + FORMULIR PSB --}}
    <section id="daftar" class="bg-pine-50 py-12 lg:py-16">
        <div class="mx-auto max-w-6xl px-5">
            <div class="fade-up mx-auto max-w-3xl text-center">
                <p class="text-sm font-bold uppercase tracking-widest text-gold-600">{{ $c['psb']['label'] }}</p>
                <h2 class="mt-2 text-3xl font-extrabold text-pine-800 sm:text-3xl">{{ $c['psb']['judul'] }}</h2>
                <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-slate-600">{{ $c['psb']['isi'] }}</p>
            </div>

            <div class="mt-12 grid items-start gap-10 lg:grid-cols-2">
                <ol class="space-y-4">
                    @foreach ($c['psb']['langkah'] as $i => $a)
                        <li class="fade-up flex gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-pine-100">
                            <span class="grid h-11 w-11 flex-none place-items-center rounded-full bg-gold-500 font-extrabold text-pine-900">{{ $i + 1 }}</span>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-gold-600">Langkah {{ $i + 1 }}</p>
                                <p class="font-bold text-pine-800">{{ $a['judul'] }}</p>
                                <p class="mt-0.5 text-sm text-slate-600">{{ $a['isi'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>

                @php $in = 'w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-pine-500 focus:ring-2 focus:ring-pine-100'; @endphp
                <form id="psbForm" class="fade-up space-y-4 rounded-3xl bg-white p-7 shadow-xl ring-1 ring-pine-100">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-lg font-extrabold text-pine-800">Formulir Pendaftaran Awal (Online)</h3>
                            <p class="text-xs text-slate-500">Data akan diteruskan langsung ke WhatsApp Panitia PSB (Ust. Rifki)</p>
                        </div>
                        <span class="rounded-full bg-pine-100 px-3 py-1 text-xs font-bold text-pine-700">Khusus Putra</span>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-pine-800">Nama Lengkap Calon Santri (Putra) *</label>
                        <input name="nama" required autocomplete="name" aria-describedby="error-nama" class="{{ $in }}" placeholder="Contoh: Muhammad Fatih">
                        <p id="error-nama" data-error-for="nama" class="mt-1 hidden text-xs font-medium text-red-600" aria-live="polite"></p>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-pine-800">Nama Orang Tua / Wali *</label>
                        <input name="wali" required autocomplete="name" aria-describedby="error-wali" class="{{ $in }}" placeholder="Contoh: Bapak H. Abdullah">
                        <p id="error-wali" data-error-for="wali" class="mt-1 hidden text-xs font-medium text-red-600" aria-live="polite"></p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-pine-800">Nomor WhatsApp Aktif *</label>
                            <input name="hp" type="tel" inputmode="tel" autocomplete="tel" required aria-describedby="error-hp" class="{{ $in }}" placeholder="081234567890">
                            <p id="error-hp" data-error-for="hp" class="mt-1 hidden text-xs font-medium text-red-600" aria-live="polite"></p>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-pine-800">Usia / Tingkat Saat Ini *</label>
                            <select name="tingkat" required aria-describedby="error-tingkat" class="{{ $in }}">
                                @foreach ($c['psb']['tingkat'] as $t)<option>{{ $t }}</option>@endforeach
                            </select>
                            <p id="error-tingkat" data-error-for="tingkat" class="mt-1 hidden text-xs font-medium text-red-600" aria-live="polite"></p>
                        </div>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-pine-800">Kota / Wilayah Tempat Tinggal</label>
                        <input name="kota" class="{{ $in }}" placeholder="Contoh: Jakarta Timur, Bekasi, Depok, dll">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-pine-800">Catatan / Rencana Silaturahmi Langsung</label>
                        <textarea name="catatan" rows="3" class="{{ $in }}" placeholder="Tuliskan jika ingin mengatur jadwal survei asrama atau ada pertanyaan seputar mukim santri"></textarea>
                    </div>
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-full bg-[#25D366] py-3.5 font-bold text-white shadow-lg transition hover:brightness-110 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                        {!! $ikonWa !!} Kirim Data Awal via WhatsApp Panitia
                    </button>
                    <p class="text-center text-xs text-slate-500">{{ $c['nama'] }} menjaga amanah data dan privasi calon santri.</p>
                </form>
            </div>
        </div>
    </section>

    {{-- LOKASI --}}
    <section id="lokasi" class="py-12 lg:py-16">
        <div class="mx-auto max-w-6xl px-5">
            <div class="fade-up mx-auto max-w-3xl text-center">
                <p class="text-sm font-bold uppercase tracking-widest text-gold-600">Kontak & Lokasi Pesantren</p>
                <h2 class="mt-2 text-3xl font-extrabold text-pine-800 sm:text-3xl">{{ $c['kunjungan']['judul'] }}</h2>
                <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-slate-600">{{ $c['kunjungan']['isi'] }}</p>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-2">
                <div class="fade-up space-y-5 rounded-3xl bg-pine-50 p-8 ring-1 ring-pine-100">
                    <div>
                        <p class="text-sm font-bold text-pine-800">📍 Alamat Lengkap</p>
                        <p class="mt-1 text-slate-600">{{ $c['alamat'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-pine-800">🕗 Kunjungan</p>
                        <p class="mt-1 text-slate-600">{{ $c['jam_kunjungan'] }}</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ $c['maps_arah'] }}" target="_blank" rel="noopener" class="rounded-full bg-pine-800 px-6 py-3 text-sm font-bold text-white transition hover:bg-pine-700">Petunjuk Arah</a>
                        <a href="{{ $c['maps_link'] }}" target="_blank" rel="noopener" class="rounded-full border border-pine-800 px-6 py-3 text-sm font-bold text-pine-800 transition hover:bg-pine-800 hover:text-white">Buka Google Maps</a>
                    </div>
                    <div class="border-t border-pine-100 pt-5">
                        <p class="text-sm font-bold text-pine-800">Layanan Kontak WhatsApp Panitia & Humas</p>
                        <ul class="mt-3 space-y-2 text-sm">
                            @foreach ($c['humas']['orang'] as $h)
                                <li class="flex items-center justify-between gap-3 rounded-xl bg-white px-4 py-3 ring-1 ring-pine-100">
                                    <span><strong class="text-pine-800">{{ $h['nama'] }}</strong><br><span class="text-xs text-slate-500">{{ $h['badge'] }} · {{ $h['hp'] }}</span></span>
                                    <a href="{{ $wa($h['wa'], $h['pesan']) }}" target="_blank" rel="noopener" aria-label="Chat {{ $h['nama'] }}" class="grid h-10 w-10 flex-none place-items-center rounded-full bg-[#25D366] text-white transition hover:brightness-110">{!! $ikonWa !!}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="fade-up overflow-hidden rounded-3xl shadow ring-1 ring-pine-100">
                    <iframe title="Peta lokasi {{ $c['nama'] }}" class="h-full min-h-[360px] w-full" loading="lazy" src="{{ $c['maps_embed'] }}"></iframe>
                    <div class="flex flex-wrap items-center justify-between gap-2 bg-white px-5 py-3 text-xs text-slate-600">
                        <span>{{ $c['akses'] }}</span>
                        <span class="rounded-full bg-pine-100 px-3 py-1 font-bold text-pine-700">Khusus Santri Putra</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-pine-900 text-white/70">
        <div class="mx-auto grid max-w-6xl gap-10 px-5 py-14 md:grid-cols-3">
            <div>
                <div class="flex items-center gap-3">
                    @if ($logo)<img src="{{ $logo }}" alt="" class="h-12 w-12 object-contain">@endif
                    <p class="font-extrabold text-white">{{ $c['nama'] }}</p>
                </div>
                <p class="mt-3 text-sm text-gold-300">Khusus Santri Putra • Kapasitas Terbatas ({{ $c['kuota'] }})</p>
                <p class="mt-3 text-sm leading-relaxed">Lembaga pendidikan pesantren khusus santri putra yang berfokus pada kajian Kitab Kuning, tahfidz, dan literasi komputer, dengan daya tampung binaan terbatas agar bimbingan berlangsung intensif dan penuh kekeluargaan.</p>
                <p class="mt-3 text-sm">Didirikan oleh: Almaghfurlah KH. Muhammad Syakrim, BA</p>
            </div>
            <div>
                <p class="font-bold text-white">Navigasi Halaman</p>
                <ul class="mt-3 space-y-2 text-sm">
                    @foreach ($menu as [$id, $label])<li><a href="#{{ $id }}" class="hover:text-gold-300">{{ $label }}</a></li>@endforeach
                    <li><a href="#daftar" class="hover:text-gold-300">Alur Pendaftaran (PSB)</a></li>
                </ul>
            </div>
            <div>
                <p class="font-bold text-white">Sekretariat & Hubungan Masyarakat</p>
                <p class="mt-3 text-sm leading-relaxed">{{ $c['alamat'] }}</p>
                <ul class="mt-3 space-y-1 text-sm">
                    @foreach ($c['humas']['orang'] as $h)<li>{{ $h['sapaan'] }}: {{ $h['hp'] }}</li>@endforeach
                </ul>
                <p class="mt-3 text-sm">Pelayanan Silaturahmi: Setiap Hari {{ $c['jam_kunjungan'] }}</p>
                <button id="bagikanWa" type="button"
                        class="mt-5 inline-flex items-center justify-center gap-2 rounded-full bg-gold-500 px-5 py-2.5 text-sm font-bold text-pine-900 shadow-sm transition hover:bg-gold-400 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-pine-900">
                    {!! $ikonWa !!} Bagikan ke WhatsApp
                </button>
            </div>
        </div>
        <div class="border-t border-white/10 py-5 text-center text-xs">
            © {{ date('Y') }} {{ $c['nama'] }}. Hak Cipta Dilindungi Undang-Undang. • Khusus Santri Putra • Kapasitas Terbatas ({{ $c['kuota'] }})
        </div>
    </footer>

    {{-- BILAH TOMBOL MOBILE --}}
    <div class="fixed inset-x-0 bottom-0 z-40 flex gap-3 border-t border-white/10 bg-pine-900/95 px-4 py-3 shadow-lg backdrop-blur sm:hidden">
        <a href="#daftar" class="flex-1 rounded-full bg-gold-500 px-5 py-3 text-center text-sm font-bold text-pine-900 shadow-sm transition hover:bg-gold-400 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-pine-900">Daftar PSB</a>
        <a href="{{ $waPanitia }}" target="_blank" rel="noopener" class="flex flex-1 items-center justify-center gap-2 rounded-full bg-[#25D366] px-5 py-3 text-center text-sm font-bold text-white shadow-sm transition hover:brightness-110 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-pine-900">
            {!! $ikonWa !!} WhatsApp
        </a>
    </div>

    {{-- KEMBALI KE ATAS --}}
    <button id="backToTop" type="button" aria-label="Kembali ke atas"
            class="fixed bottom-36 right-5 z-40 hidden h-10 w-10 place-items-center rounded-full bg-pine-800 text-gold-300 shadow-lg ring-1 ring-white/15 transition hover:-translate-y-0.5 hover:bg-pine-700 focus-visible:ring-2 focus-visible:ring-gold-300 sm:bottom-24">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 15l6-6 6 6"/></svg>
    </button>

    {{-- WA MENGAMBANG --}}
    <a href="{{ $waPanitia }}" target="_blank" rel="noopener" aria-label="Chat WhatsApp Panitia"
       class="fixed bottom-20 right-5 z-40 grid h-14 w-14 place-items-center rounded-full bg-[#25D366] text-white shadow-xl transition hover:scale-110 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 sm:bottom-5">
        <span class="scale-125">{!! $ikonWa !!}</span>
    </a>

    {{-- LIGHTBOX --}}
    <div id="lightbox" class="fixed inset-0 z-[60] hidden touch-pan-y items-center justify-center bg-black/85 p-4 opacity-0 transition-opacity duration-200 ease-out motion-reduce:transition-none" role="dialog" aria-modal="true" aria-labelledby="lbCap">
        <div class="absolute inset-x-0 top-0 flex items-center justify-between px-4 py-4">
            <span id="lbCount" class="rounded-full bg-white/10 px-3 py-1 text-sm font-semibold tabular-nums text-white/90" aria-live="polite"></span>
            <button id="lbClose" type="button" data-modal-close class="grid h-10 w-10 place-items-center rounded-full bg-white/10 text-2xl text-white transition hover:bg-white/20 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-black/50" aria-label="Tutup">×</button>
        </div>
        <button id="lbPrev" type="button" aria-label="Foto sebelumnya" class="absolute left-3 top-1/2 z-10 grid h-11 w-11 -translate-y-1/2 place-items-center rounded-full bg-white/10 text-white backdrop-blur transition hover:bg-white/20 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-black/50 sm:left-6">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
        </button>
        <figure data-modal-panel class="max-h-[85vh] max-w-4xl scale-95 overflow-y-auto transition-transform duration-200 ease-out motion-reduce:transition-none">
            <img id="lbImg" src="" alt="" class="mx-auto max-h-[75vh] rounded-xl object-contain">
            <figcaption id="lbCap" class="mt-3 text-center text-sm text-white/80"></figcaption>
        </figure>
        <button id="lbNext" type="button" aria-label="Foto berikutnya" class="absolute right-3 top-1/2 z-10 grid h-11 w-11 -translate-y-1/2 place-items-center rounded-full bg-white/10 text-white backdrop-blur transition hover:bg-white/20 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2 focus-visible:ring-offset-black/50 sm:right-6">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>

    {{-- MODAL DETAIL BIMBINGAN IT --}}
    <div id="itModal" class="fixed inset-0 z-[70] hidden items-center justify-center bg-black/60 p-4 opacity-0 backdrop-blur-sm transition-opacity duration-200 ease-out motion-reduce:transition-none" role="dialog" aria-modal="true" aria-labelledby="itModalTitle">
        <div data-modal-panel class="relative max-h-[85vh] w-full max-w-lg scale-95 overflow-y-auto rounded-3xl bg-white p-6 text-pine-800 shadow-2xl ring-1 ring-pine-100 transition-transform duration-200 ease-out motion-reduce:transition-none sm:p-8">
            <button type="button" data-modal-close aria-label="Tutup detail bimbingan IT" class="absolute right-4 top-4 grid h-9 w-9 place-items-center rounded-full bg-pine-50 text-xl text-pine-800 transition hover:bg-pine-100 focus-visible:ring-2 focus-visible:ring-gold-300">×</button>
            <div class="grid h-12 w-12 place-items-center rounded-xl bg-pine-100 text-2xl">💻</div>
            <h2 id="itModalTitle" class="mt-4 pr-10 text-xl font-extrabold text-pine-800">{{ $c['it']['porsi_judul'] }}</h2>
            <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $c['it']['porsi_isi'] }}</p>
            <ul class="mt-5 space-y-3 text-sm">
                @foreach ($c['it']['porsi_poin'] as $p)
                    <li class="flex gap-3"><span class="mt-0.5 grid h-5 w-5 flex-none place-items-center rounded-full bg-gold-500 text-xs font-bold text-pine-900">✓</span><span>{{ $p }}</span></li>
                @endforeach
            </ul>
            <div class="mt-6 flex flex-wrap gap-3 border-t border-pine-100 pt-5">
                <a href="#it" data-tutup-it class="rounded-full bg-pine-800 px-5 py-3 text-center text-sm font-bold text-white shadow-sm transition hover:bg-pine-700 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2">Lihat Program Bimbingan IT</a>
                <a href="{{ $wa($c['wa_panitia'], $c['humas']['orang'][1]['pesan']) }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-full bg-gold-500 px-5 py-3 text-center text-sm font-bold text-pine-900 shadow-sm transition hover:bg-gold-400 focus-visible:ring-2 focus-visible:ring-gold-300 focus-visible:ring-offset-2">{!! $ikonWa !!} Tanya Ust. Rifki</a>
            </div>
        </div>
    </div>

    <script>
        // Menu mobile
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const closeMenu = () => {
            mobileMenu.classList.add('hidden');
            menuBtn.setAttribute('aria-expanded', 'false');
        };
        menuBtn.addEventListener('click', () => {
            const open = mobileMenu.classList.toggle('hidden') === false;
            menuBtn.setAttribute('aria-expanded', String(open));
        });
        mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));
        window.addEventListener('resize', () => { if (window.innerWidth >= 1280) closeMenu(); });

        // Scrollspy navigasi
        const navLinks = document.querySelectorAll('[data-nav-link]');
        const spySections = Array.from(navLinks)
            .map((link) => document.querySelector(link.getAttribute('href')))
            .filter(Boolean);
        const updateActiveNav = () => {
            let activeId = '';
            spySections.forEach((section) => {
                if (section.getBoundingClientRect().top <= 140) { activeId = section.id; }
            });
            navLinks.forEach((link) => {
                const active = link.getAttribute('href') === '#' + activeId;
                const diMobileMenu = Boolean(link.closest('#mobileMenu'));
                link.classList.toggle('text-gold-300', active);
                link.classList.toggle('bg-white/10', active);
                link.classList.toggle('text-white/90', !active && !diMobileMenu);
                link.classList.toggle('text-white/85', !active && diMobileMenu);
                if (active) { link.setAttribute('aria-current', 'location'); } else { link.removeAttribute('aria-current'); }
            });
        };
        window.addEventListener('scroll', updateActiveNav, { passive: true });
        window.addEventListener('resize', updateActiveNav);
        updateActiveNav();

        // Tombol kembali ke atas
        const backToTop = document.getElementById('backToTop');
        const updateBackToTop = () => {
            const tampil = window.scrollY > 600;
            backToTop.classList.toggle('hidden', !tampil);
            backToTop.classList.toggle('grid', tampil);
        };
        window.addEventListener('scroll', updateBackToTop, { passive: true });
        updateBackToTop();
        backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

        // Animasi muncul saat scroll
        const io = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('show'); io.unobserve(e.target); } });
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-up').forEach(el => io.observe(el));

        // Modal: perilaku bersama
        const kurangiGerak = window.matchMedia('(prefers-reduced-motion: reduce)');
        const modalTerakhir = { trigger: null };
        let timerTutupModal = null;

        const bukaModal = (modal, trigger) => {
            if (timerTutupModal) { clearTimeout(timerTutupModal); timerTutupModal = null; }
            modalTerakhir.trigger = trigger || null;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                const panel = modal.querySelector('[data-modal-panel]');
                if (panel) { panel.classList.remove('scale-95'); panel.classList.add('scale-100'); }
            });
            const tombolTutup = modal.querySelector('[data-modal-close]');
            if (tombolTutup) { tombolTutup.focus(); }
        };
        const tutupModal = (modal, setelah) => {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            const panel = modal.querySelector('[data-modal-panel]');
            if (panel) { panel.classList.remove('scale-100'); panel.classList.add('scale-95'); }
            timerTutupModal = setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
                const trigger = modalTerakhir.trigger;
                modalTerakhir.trigger = null;
                timerTutupModal = null;
                if (trigger) { trigger.focus(); }
                if (typeof setelah === 'function') { setelah(); }
            }, kurangiGerak.matches ? 0 : 200);
        };

        // Modal detail bimbingan IT
        const itModal = document.getElementById('itModal');
        const komputerCard = document.getElementById('komputerCard');
        komputerCard.addEventListener('click', () => bukaModal(itModal, komputerCard));
        itModal.querySelector('[data-modal-close]').addEventListener('click', () => tutupModal(itModal));
        itModal.addEventListener('click', e => { if (e.target === itModal) { tutupModal(itModal); } });
        itModal.querySelector('[data-tutup-it]').addEventListener('click', e => {
            e.preventDefault();
            tutupModal(itModal, () => document.getElementById('it').scrollIntoView({ behavior: 'smooth' }));
        });

        // Lightbox galeri
        const lb = document.getElementById('lightbox');
        const lbImg = document.getElementById('lbImg');
        const lbCap = document.getElementById('lbCap');
        const lbCount = document.getElementById('lbCount');
        const lbFigure = lb.querySelector('figure');
        const lbButtons = Array.from(document.querySelectorAll('[data-lightbox]'));
        const lbFoto = lbButtons.map(b => ({ url: b.dataset.lightbox, caption: b.dataset.caption }));
        let lbIndex = 0;

        const tampilkanFoto = () => {
            const f = lbFoto[lbIndex];
            lbImg.src = f.url;
            lbImg.alt = f.caption;
            lbCap.textContent = f.caption;
            lbCount.textContent = (lbIndex + 1) + ' / ' + lbFoto.length;
        };
        const bukaLb = (index, trigger) => {
            lbIndex = (index + lbFoto.length) % lbFoto.length;
            tampilkanFoto();
            if (lb.classList.contains('hidden')) { bukaModal(lb, trigger); }
        };
        const closeLb = () => { if (!lb.classList.contains('hidden')) { tutupModal(lb); } };
        const lbPrev = () => bukaLb(lbIndex - 1);
        const lbNext = () => bukaLb(lbIndex + 1);

        lbButtons.forEach((b, i) => b.addEventListener('click', () => bukaLb(i, b)));
        document.getElementById('lbPrev').addEventListener('click', lbPrev);
        document.getElementById('lbNext').addEventListener('click', lbNext);
        document.getElementById('lbClose').addEventListener('click', closeLb);
        lb.addEventListener('click', e => {
            if (e.target === lb || e.target === lbFigure) { closeLb(); }
        });
        let sentuhX = null, sentuhY = null;
        lb.addEventListener('touchstart', e => {
            sentuhX = e.changedTouches[0].screenX;
            sentuhY = e.changedTouches[0].screenY;
        }, { passive: true });
        lb.addEventListener('touchend', e => {
            if (sentuhX === null) { return; }
            const geserX = e.changedTouches[0].screenX - sentuhX;
            const geserY = e.changedTouches[0].screenY - sentuhY;
            sentuhX = null; sentuhY = null;
            if (Math.abs(geserX) < 50 || Math.abs(geserX) < Math.abs(geserY)) { return; }
            if (geserX > 0) { lbPrev(); } else { lbNext(); }
        }, { passive: true });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                if (!itModal.classList.contains('hidden')) { tutupModal(itModal); }
                else if (!lb.classList.contains('hidden')) { closeLb(); }
                return;
            }
            if (lb.classList.contains('hidden')) { return; }
            if (e.key === 'ArrowLeft') { lbPrev(); }
            else if (e.key === 'ArrowRight') { lbNext(); }
        });

        // Validasi formulir PSB
        const psbForm = document.getElementById('psbForm');
        const pesanValidasi = {
            nama: 'Nama lengkap calon santri wajib diisi.',
            wali: 'Nama orang tua / wali wajib diisi.',
            hp: 'Nomor WhatsApp aktif wajib diisi dengan benar.',
            tingkat: 'Usia / tingkat saat ini wajib dipilih.',
        };
        psbForm.querySelectorAll('[required]').forEach((field) => {
            const error = psbForm.querySelector('[data-error-for="' + field.name + '"]');
            const bersihkanError = () => {
                if (error) { error.classList.add('hidden'); }
                field.removeAttribute('aria-invalid');
            };
            field.addEventListener('invalid', () => {
                if (!error) { return; }
                error.textContent = field.validity.typeMismatch
                    ? 'Gunakan format nomor yang benar, contoh: 081234567890.'
                    : pesanValidasi[field.name];
                error.classList.remove('hidden');
                field.setAttribute('aria-invalid', 'true');
            });
            field.addEventListener('input', bersihkanError);
            field.addEventListener('change', bersihkanError);
        });

        // Formulir -> WhatsApp Panitia
        psbForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const d = Object.fromEntries(new FormData(e.target));
            const teks =
`Assalamu’alaikum Warahmatullahi Wabarakatuh Ust. Rifki, saya ingin mendaftarkan calon santri PSB {{ $c['tahun'] }} (Khusus Putra).

Nama calon santri: ${d.nama}
Orang tua/wali: ${d.wali}
No. WhatsApp: ${d.hp}
Usia/tingkat: ${d.tingkat}
Kota/wilayah: ${d.kota || '-'}
Catatan: ${d.catatan || '-'}`;
            window.open('https://wa.me/{{ $c['wa_panitia'] }}?text=' + encodeURIComponent(teks), '_blank');
        });

        // Bagikan halaman ke WhatsApp
        document.getElementById('bagikanWa').addEventListener('click', () => {
            const teks = '{{ $c['nama'] }} — PSB {{ $c['tahun'] }}. ' + window.location.href;
            window.open('https://wa.me/?text=' + encodeURIComponent(teks), '_blank');
        });
    </script>
</body>
</html>