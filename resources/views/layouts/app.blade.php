<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('seo')

    @hasSection('seo')
    @else
        <x-seo />
    @endif

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon-192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="theme-color" content="#0f2444">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- AOS Animate On Scroll -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#2b6cb0',
                            900: '#1a365d',
                        },
                        brand: {
                            dark:   '#0f2444',
                            main:   '#1a56db',
                            light:  '#3b82f6',
                            accent: '#dc2626',
                            gold:   '#f59e0b',
                        },
                        amber: {
                            50:  '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    backdropBlur: {
                        xs: '2px',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            color: #1a202c;
            background: #f8fafc;
        }

        /* ===== Custom scrollbar ===== */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #1a56db, #0f2444); border-radius: 3px; }

        /* ===== Sticky header with glass effect ===== */
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 100;
            transition: all 0.3s ease;
        }
        .sticky-header.scrolled .glass-nav {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0,0,0,0.12);
        }

        /* ===== Top bar gradient ===== */
        .topbar-gradient {
            background: linear-gradient(135deg, #0f2444 0%, #1a56db 60%, #0f2444 100%);
        }

        /* ===== Nav underline animation ===== */
        .nav-link-anim {
            position: relative;
        }
        .nav-link-anim::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: white;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link-anim:hover::after,
        .nav-link-anim.active::after {
            width: 80%;
        }

        /* ===== Hover zoom on product images ===== */
        .img-zoom-wrap { overflow: hidden; }
        .img-zoom-wrap img { transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .img-zoom-wrap:hover img { transform: scale(1.08); }

        /* ===== Pulse animation for floating buttons ===== */
        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.6); }
            70%  { box-shadow: 0 0 0 12px rgba(220, 38, 38, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
        }
        @keyframes pulse-ring-blue {
            0%   { box-shadow: 0 0 0 0 rgba(0, 104, 255, 0.6); }
            70%  { box-shadow: 0 0 0 12px rgba(0, 104, 255, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 104, 255, 0); }
        }
        .animate-pulse-ring { animation: pulse-ring 2s infinite; }
        .animate-pulse-ring-blue { animation: pulse-ring-blue 2s infinite; }

        /* ===== Line clamp utilities ===== */
        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        /* ===== Section divider wave ===== */
        .wave-divider {
            overflow: hidden;
            line-height: 0;
        }
        .wave-divider svg {
            display: block;
            width: 100%;
        }

        /* ===== Glassmorphism card ===== */
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* ===== Gradient text ===== */
        .gradient-text {
            background: linear-gradient(135deg, #1a56db, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ===== Section header decoration ===== */
        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 1rem;
            background: linear-gradient(135deg, rgba(26,86,219,0.1), rgba(59,130,246,0.1));
            border: 1px solid rgba(26,86,219,0.2);
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #1a56db;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* ===== Swiper customization ===== */
        .swiper-pagination-bullet {
            background: rgba(255,255,255,0.5) !important;
            opacity: 1 !important;
            width: 8px !important;
            height: 8px !important;
            transition: all 0.3s !important;
        }
        .swiper-pagination-bullet-active {
            background: white !important;
            width: 32px !important;
            border-radius: 4px !important;
        }
        .swiper-button-next, .swiper-button-prev {
            width: 44px !important;
            height: 44px !important;
            background: rgba(255,255,255,0.15) !important;
            border-radius: 50% !important;
            backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(255,255,255,0.3) !important;
            transition: all 0.3s !important;
        }
        .swiper-button-next:hover, .swiper-button-prev:hover {
            background: rgba(255,255,255,0.3) !important;
        }
        .swiper-button-next::after, .swiper-button-prev::after {
            font-size: 14px !important;
            color: white !important;
            font-weight: 900 !important;
        }

        /* ===== Animated background pattern ===== */
        @keyframes bg-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animated-gradient {
            background-size: 200% 200%;
            animation: bg-shift 8s ease infinite;
        }

        /* ===== Floating tooltip ===== */
        .tooltip-wrap { position: relative; }
        .tooltip-wrap .tooltip {
            position: absolute;
            right: calc(100% + 12px);
            top: 50%;
            transform: translateY(-50%);
            background: #1a202c;
            color: white;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }
        .tooltip-wrap .tooltip::after {
            content: '';
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-left-color: #1a202c;
        }
        .tooltip-wrap:hover .tooltip { opacity: 1; }

        /* ===== Page transition ===== */
        body { animation: fadeInPage 0.4s ease; }
        @keyframes fadeInPage {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== Dropdown enhancement ===== */
        .cat-dropdown-item {
            position: relative;
            overflow: hidden;
        }
        .cat-dropdown-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: #1a56db;
            transform: scaleY(0);
            transition: transform 0.2s;
        }
        .cat-dropdown-item:hover::before { transform: scaleY(1); }

        /* ===== Footer gradient ===== */
        .footer-gradient {
            background: linear-gradient(180deg, #0a1628 0%, #0f2444 40%, #0a1628 100%);
        }

        /* ===== Divider with icon ===== */
        .divider-icon {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .divider-icon::before,
        .divider-icon::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
        }

        /* ===== Section header with orange left border ===== */
        .section-header {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1a365d;
            padding-left: 16px;
            border-left: 4px solid #f59e0b;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            line-height: 1.3;
        }

        /* ===== Premium product card ===== */
        .product-card {
            transition: all 0.3s ease;
            border: 1px solid #f1f5f9;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border-color: #fbbf24;
        }

        /* ===== Orange accent tab ===== */
        .tab-amber.active {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 4px 12px rgba(245,158,11,0.35);
        }

        /* ===== Partner logo card ===== */
        .partner-logo-card {
            transition: all 0.3s ease;
            filter: grayscale(100%);
            opacity: 0.6;
        }
        .partner-logo-card:hover {
            filter: grayscale(0%);
            opacity: 1;
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }

        /* ===== Stats bar compact ===== */
        .stats-bar-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
        }

        /* ===== Feature card on white ===== */
        .feature-card-white {
            background: #f0f4ff;
            border: 1px solid #e0e7ff;
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        .feature-card-white:hover {
            background: #e0e7ff;
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(26,54,93,0.1);
        }

        /* ===== Promotional banner ===== */
        .promo-banner {
            background: linear-gradient(135deg, #1a365d 0%, #1d4ed8 45%, #d97706 100%);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-50">

{{-- ======================== HEADER ======================== --}}
<header class="sticky-header" id="main-header"
    x-data="{ mobileOpen: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20; document.getElementById('main-header').classList.toggle('scrolled', window.scrollY > 20); })">

    {{-- Top Bar --}}
    <div class="topbar-gradient text-white py-1.5 text-xs">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-5 text-blue-200">
                <a href="mailto:sale@viamsemicon.com" class="flex items-center gap-1.5 hover:text-white transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                    sale@viamsemicon.com
                </a>
                <span class="hidden sm:flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                    251 Đường Dục Tú, Đông Anh, Hà Nội
                </span>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-1.5 text-xs">
                    <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                    <span class="text-blue-200">Hỗ trợ T2-T7: 8:00-18:00</span>
                </div>
                <a href="tel:0886160579" class="flex items-center gap-1.5 text-white font-bold hover:text-yellow-300 transition-colors bg-white/10 rounded-full px-3 py-0.5">
                    <svg class="w-3.5 h-3.5 text-red-400 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                    0886 160 579
                </a>
            </div>
        </div>
    </div>

    {{-- Main Header --}}
    <div class="glass-nav bg-white transition-all duration-300 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-4">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex-shrink-0 group">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="Viam Semicon" class="h-12 w-auto transition-transform group-hover:scale-105">
                @else
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-brand-main to-brand-dark rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-black text-lg">V</span>
                        </div>
                        <div class="flex flex-col leading-tight">
                            <span class="text-xl font-black text-brand-dark tracking-tight">VIAM</span>
                            <span class="text-xs font-semibold text-brand-main tracking-widest uppercase">Semicon</span>
                        </div>
                    </div>
                @endif
            </a>

            {{-- Search Box --}}
            <div class="flex-1 max-w-xl mx-auto hidden md:block">
                <form action="{{ route('products.index') }}" method="GET" class="flex group">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Tìm kiếm thiết bị đo lường, RF cable, robot..."
                        class="flex-1 px-4 py-2.5 text-sm border-2 border-gray-200 border-r-0 rounded-l-xl focus:outline-none focus:border-brand-main transition-colors bg-gray-50 focus:bg-white"
                    >
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-brand-main to-brand-light text-white rounded-r-xl hover:from-brand-dark hover:to-brand-main transition-all flex items-center gap-2 font-medium shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span class="hidden lg:inline text-sm">Tìm kiếm</span>
                    </button>
                </form>
            </div>

            {{-- Hotline (desktop) --}}
            <div class="hidden lg:flex flex-col items-end flex-shrink-0">
                <span class="text-xs text-gray-400 uppercase tracking-widest font-medium">Hotline hỗ trợ</span>
                <a href="tel:0886160579" class="text-2xl font-black text-brand-accent hover:text-red-700 transition-colors flex items-center gap-1.5 leading-none mt-0.5">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                    0886 160 579
                </a>
            </div>

            {{-- Mobile Menu Button --}}
            <button @click="mobileOpen = !mobileOpen" class="md:hidden ml-auto p-2 text-gray-600 hover:text-brand-dark rounded-lg hover:bg-gray-100 transition-colors" aria-label="Menu">
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    {{-- Navigation Bar --}}
    <nav class="bg-gradient-to-r from-brand-dark via-brand-main to-brand-dark text-white hidden md:block shadow-lg">
        <div class="max-w-7xl mx-auto px-4 flex items-stretch">

            {{-- Categories Mega Dropdown --}}
            <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                <button :class="open ? 'bg-white/20' : ''"
                    class="flex items-center gap-2.5 px-5 py-3.5 bg-black/20 font-bold text-sm hover:bg-white/20 transition-all duration-200 h-full border-r border-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <span class="hidden sm:inline tracking-wide">DANH MỤC SẢN PHẨM</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                </button>

                <div x-show="open" x-cloak
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute top-full left-0 w-80 bg-white text-gray-800 shadow-2xl rounded-b-2xl z-50 overflow-hidden border-t-3"
                    style="border-top: 3px solid #1a56db;">
                    @if(isset($navCategories) && $navCategories->count())
                        @foreach($navCategories as $cat)
                        <a href="{{ route('products.category', $cat->slug) }}"
                           class="cat-dropdown-item flex items-center gap-3 px-5 py-3 hover:bg-blue-50 transition-colors text-sm border-b border-gray-50 last:border-0">
                            @if($cat->image)
                                <img src="{{ Storage::url($cat->image) }}" alt="{{ $cat->name }}" class="w-8 h-8 object-cover rounded-lg">
                            @else
                                <span class="w-8 h-8 bg-gradient-to-br from-brand-main to-brand-dark rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg>
                                </span>
                            @endif
                            <span class="font-medium">{{ $cat->name }}</span>
                            <svg class="w-3.5 h-3.5 text-gray-300 ml-auto flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        @endforeach
                    @else
                        <a href="{{ route('products.index') }}" class="cat-dropdown-item flex items-center gap-3 px-5 py-3 hover:bg-blue-50 transition-colors text-sm">Tất cả sản phẩm</a>
                    @endif
                    <div class="bg-gradient-to-r from-brand-dark to-brand-main">
                        <a href="{{ route('products.index') }}" class="flex items-center justify-center gap-2 px-5 py-3 text-white font-semibold text-sm hover:bg-white/10 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Xem tất cả sản phẩm
                        </a>
                    </div>
                </div>
            </div>

            {{-- Main Nav Links --}}
            @php
                $navLinks = [
                    ['label' => 'Trang chủ',  'route' => 'home'],
                    ['label' => 'Giới thiệu', 'route' => 'about'],
                    ['label' => 'Sản phẩm',   'route' => 'products.index'],
                    ['label' => 'Tin tức',     'route' => 'posts.index'],
                    ['label' => 'Tuyển dụng',  'route' => 'recruitment'],
                    ['label' => 'Liên hệ',     'route' => 'contact'],
                ];
            @endphp
            @foreach($navLinks as $link)
                @php
                    $isActive = false;
                    try { $isActive = request()->routeIs($link['route']) || request()->routeIs($link['route'].'*'); } catch(\Exception $e) {}
                @endphp
                <a href="{{ route($link['route']) }}"
                   class="nav-link-anim px-4 py-3.5 text-sm font-semibold hover:bg-white/10 transition-colors relative {{ $isActive ? 'active bg-white/10' : '' }} tracking-wide">
                    {{ $link['label'] }}
                </a>
            @endforeach

            {{-- Right side: quick call --}}
            <div class="ml-auto flex items-center px-4">
                <a href="tel:0886160579" class="flex items-center gap-1.5 text-xs font-semibold bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded-full transition-colors">
                    <svg class="w-3.5 h-3.5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                    Gọi ngay
                </a>
            </div>
        </div>
    </nav>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen" x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-y-4 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        class="md:hidden bg-white border-t border-gray-100 shadow-2xl">

        {{-- Mobile Search --}}
        <div class="p-4 border-b border-gray-100 bg-gray-50">
            <form action="{{ route('products.index') }}" method="GET" class="flex">
                <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..."
                    class="flex-1 px-4 py-2.5 text-sm border-2 border-gray-200 border-r-0 rounded-l-xl focus:outline-none focus:border-brand-main bg-white">
                <button class="px-4 py-2.5 bg-brand-main text-white rounded-r-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </form>
        </div>

        <div class="divide-y divide-gray-50">
            @foreach($navLinks as $link)
            <a href="{{ route($link['route']) }}" @click="mobileOpen = false"
               class="flex items-center justify-between px-5 py-4 text-gray-700 hover:bg-blue-50 hover:text-brand-main font-medium transition-colors">
                {{ $link['label'] }}
                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            @endforeach
        </div>

        <div class="p-4 bg-gray-50 border-t border-gray-100 space-y-2">
            <a href="tel:0886160579" class="flex items-center justify-center gap-2 w-full py-3.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-black text-lg shadow-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                0886 160 579
            </a>
        </div>
    </div>
</header>

{{-- ======================== MAIN CONTENT ======================== --}}
<main>
    @yield('content')
</main>

{{-- ======================== CTA BANNER (before footer) ======================== --}}
@hasSection('no-cta')
@else
<section class="relative overflow-hidden py-16" style="background: linear-gradient(135deg, #0f2444 0%, #1a56db 50%, #0f2444 100%);">
    {{-- Animated blobs --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-blue-300 opacity-10 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-4xl mx-auto px-4 text-center text-white">
        <div class="section-badge mb-5 bg-white/10 border-white/20 text-white mx-auto w-fit">
            Sẵn sàng hợp tác
        </div>
        <h2 class="text-3xl md:text-4xl font-black mb-4 leading-tight">
            Cần báo giá hay tư vấn kỹ thuật?
        </h2>
        <p class="text-blue-200 text-lg mb-8 max-w-2xl mx-auto">
            Đội ngũ chuyên gia Viam Semicon sẵn sàng hỗ trợ bạn 24/7. Liên hệ ngay để nhận báo giá tốt nhất.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 px-8 py-4 bg-white text-brand-dark font-black rounded-2xl hover:bg-blue-50 transition-colors shadow-xl text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Gửi yêu cầu báo giá
            </a>
            <a href="tel:0886160579"
               class="inline-flex items-center gap-2 px-8 py-4 bg-brand-accent text-white font-black rounded-2xl hover:bg-red-700 transition-colors shadow-xl text-base animate-pulse-ring">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                0886 160 579
            </a>
        </div>
    </div>
</section>
@endif

{{-- ======================== FOOTER ======================== --}}
<footer class="footer-gradient text-white">
    {{-- Wave top --}}
    <div class="wave-divider" style="margin-top: -1px;">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 30L48 25C96 20 192 10 288 13.3C384 16.7 480 33.3 576 36.7C672 40 768 30 864 23.3C960 16.7 1056 13.3 1152 16.7C1248 20 1344 30 1392 35L1440 40V60H0V30Z" fill="#0a1628"/>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 pt-8 pb-14">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

            {{-- Column 1: Company Info --}}
            <div class="lg:col-span-1">
                <div class="mb-6">
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="Viam Semicon" class="h-12 w-auto brightness-0 invert mb-2">
                    @else
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-10 h-10 bg-gradient-to-br from-brand-main to-brand-light rounded-xl flex items-center justify-center">
                                <span class="text-white font-black text-lg">V</span>
                            </div>
                            <div class="flex flex-col leading-tight">
                                <span class="text-2xl font-black tracking-tight text-white">VIAM</span>
                                <span class="text-xs font-semibold text-blue-300 tracking-widest uppercase">Semicon</span>
                            </div>
                        </div>
                    @endif
                </div>

                <p class="text-gray-400 text-sm leading-relaxed mb-5">
                    Nhà phân phối thiết bị đo lường, robot vận chuyển và RF Cable & Adapters hàng đầu Việt Nam. Cam kết sản phẩm chính hãng, chất lượng cao.
                </p>

                <ul class="space-y-3 text-sm text-gray-300">
                    <li class="flex gap-3 items-start">
                        <div class="w-7 h-7 bg-brand-main/30 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-blue-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                        </div>
                        <span>Số 251 Đường Dục Tú, Xã Dục Tú, Huyện Đông Anh, Hà Nội</span>
                    </li>
                    <li class="flex gap-3 items-center">
                        <div class="w-7 h-7 bg-brand-accent/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                        </div>
                        <span>
                            <a href="tel:0886160579" class="hover:text-white transition-colors font-semibold text-white">0886 160 579</a>
                        </span>
                    </li>
                    <li class="flex gap-3 items-center">
                        <div class="w-7 h-7 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                        </div>
                        <a href="mailto:sale@viamsemicon.com" class="hover:text-white transition-colors">sale@viamsemicon.com</a>
                    </li>
                </ul>

                {{-- Social Icons --}}
                <div class="flex gap-2.5 mt-6">
                    <a href="#" class="w-9 h-9 bg-white/8 border border-white/10 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:border-blue-600 transition-all" aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://zalo.me/0886160579" class="w-9 h-9 bg-white/8 border border-white/10 rounded-xl flex items-center justify-center hover:bg-blue-400 hover:border-blue-400 transition-all" aria-label="Zalo">
                        <span class="text-xs font-black">Za</span>
                    </a>
                    <a href="#" class="w-9 h-9 bg-white/8 border border-white/10 rounded-xl flex items-center justify-center hover:bg-red-500 hover:border-red-500 transition-all" aria-label="YouTube">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.495 6.205a3.007 3.007 0 00-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 00.527 6.205a31.247 31.247 0 00-.522 5.805 31.247 31.247 0 00.522 5.783 3.007 3.007 0 002.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 002.088-2.088 31.247 31.247 0 00.5-5.783 31.247 31.247 0 00-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Column 2: Products --}}
            <div>
                <h3 class="font-black text-base mb-5 flex items-center gap-2">
                    <span class="w-6 h-0.5 bg-brand-main"></span>
                    Sản phẩm
                </h3>
                <ul class="space-y-2.5 text-sm text-gray-400">
                    @if(isset($navCategories) && $navCategories->count())
                        @foreach($navCategories->take(8) as $cat)
                        <li>
                            <a href="{{ route('products.category', $cat->slug) }}" class="hover:text-white transition-colors flex items-center gap-2 group">
                                <svg class="w-3.5 h-3.5 text-brand-main flex-shrink-0 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                {{ $cat->name }}
                            </a>
                        </li>
                        @endforeach
                    @else
                        @foreach(['Thiết bị đo lường', 'Robot vận chuyển', 'RF Cable & Adapters', 'Linh kiện điện tử', 'IC vi mạch', 'Transistor'] as $item)
                        <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors flex items-center gap-2 group"><svg class="w-3.5 h-3.5 text-brand-main flex-shrink-0 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>{{ $item }}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>

            {{-- Column 3: Policies --}}
            <div>
                <h3 class="font-black text-base mb-5 flex items-center gap-2">
                    <span class="w-6 h-0.5 bg-brand-main"></span>
                    Chính sách
                </h3>
                <ul class="space-y-2.5 text-sm text-gray-400">
                    @foreach([
                        ['Chính sách bảo mật', '/trang/chinh-sach-bao-mat'],
                        ['Chính sách vận chuyển', '/trang/chinh-sach-van-chuyen'],
                        ['Chính sách đổi trả', '/trang/chinh-sach-doi-tra'],
                        ['Quy định sử dụng', '/trang/quy-dinh-su-dung'],
                    ] as [$label, $url])
                    <li><a href="{{ url($url) }}" class="hover:text-white transition-colors flex items-center gap-2 group"><svg class="w-3.5 h-3.5 text-brand-main flex-shrink-0 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>{{ $label }}</a></li>
                    @endforeach
                </ul>

                <h3 class="font-black text-base mb-4 mt-7 flex items-center gap-2">
                    <span class="w-6 h-0.5 bg-brand-main"></span>
                    Hỗ trợ
                </h3>
                <ul class="space-y-2.5 text-sm text-gray-400">
                    <li><a href="{{ route('about') }}" class="hover:text-white transition-colors flex items-center gap-2 group"><svg class="w-3.5 h-3.5 text-brand-main flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Giới thiệu công ty</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors flex items-center gap-2 group"><svg class="w-3.5 h-3.5 text-brand-main flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Liên hệ</a></li>
                    <li><a href="{{ route('posts.index') }}" class="hover:text-white transition-colors flex items-center gap-2 group"><svg class="w-3.5 h-3.5 text-brand-main flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Tin tức</a></li>
                    <li><a href="{{ route('recruitment') }}" class="hover:text-white transition-colors flex items-center gap-2 group"><svg class="w-3.5 h-3.5 text-brand-main flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>Tuyển dụng</a></li>
                </ul>
            </div>

            {{-- Column 4: Contact CTA --}}
            <div>
                <h3 class="font-black text-base mb-5 flex items-center gap-2">
                    <span class="w-6 h-0.5 bg-brand-main"></span>
                    Liên hệ ngay
                </h3>

                <div class="glass-card rounded-2xl p-5 mb-5">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                        <span class="text-sm font-semibold text-blue-200">Đang online — hỗ trợ ngay</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-4 leading-relaxed">Chuyên gia kỹ thuật sẵn sàng tư vấn sản phẩm và báo giá nhanh.</p>
                    <a href="tel:0886160579" class="block text-center py-3 bg-gradient-to-r from-brand-accent to-red-700 text-white rounded-xl font-black text-lg hover:from-red-700 hover:to-red-800 transition-all shadow-lg mb-2">
                        0886 160 579
                    </a>
                    <a href="{{ route('contact') }}" class="block text-center py-2.5 border border-white/20 text-gray-300 rounded-xl font-medium text-sm hover:bg-white/10 transition-colors">
                        Gửi tin nhắn
                    </a>
                </div>

                <p class="text-xs text-gray-500 text-center">T2-T7: 8:00 - 18:00</p>
            </div>
        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} <strong class="text-gray-400">Viam Semicon</strong>. Tất cả quyền được bảo lưu.</p>
            <div class="flex items-center gap-3">
                <span class="text-gray-600">Phương thức thanh toán:</span>
                <div class="flex gap-2">
                    <span class="px-2.5 py-1 bg-white/8 border border-white/10 rounded-lg text-xs font-semibold text-gray-300">Chuyển khoản</span>
                    <span class="px-2.5 py-1 bg-white/8 border border-white/10 rounded-lg text-xs font-semibold text-gray-300">COD</span>
                    <span class="px-2.5 py-1 bg-white/8 border border-white/10 rounded-lg text-xs font-semibold text-gray-300">Tiền mặt</span>
                </div>
            </div>
        </div>
    </div>
</footer>

{{-- ======================== FLOATING BUTTONS ======================== --}}
<div class="fixed bottom-6 right-5 flex flex-col gap-3 z-50">

    {{-- Zalo Button --}}
    <div class="tooltip-wrap">
        <span class="tooltip">Chat Zalo</span>
        <a href="https://zalo.me/0886160579" target="_blank" rel="noopener"
           class="w-14 h-14 rounded-2xl shadow-2xl flex items-center justify-center animate-pulse-ring-blue transition-all hover:scale-110 hover:-translate-y-0.5"
           style="background: linear-gradient(135deg, #0068ff, #0052cc);">
            <svg viewBox="0 0 48 48" class="w-8 h-8" fill="white" xmlns="http://www.w3.org/2000/svg">
                <path d="M24 4C12.95 4 4 12.95 4 24C4 35.05 12.95 44 24 44C35.05 44 44 35.05 44 24C44 12.95 35.05 4 24 4ZM35.2 32.1L33.6 31.3C33 31 32.4 31.1 31.9 31.5C31.2 32.1 30.4 32.5 29.5 32.7C27.5 33.1 25.3 32.5 23.6 31.2C21.3 29.4 20 26.6 20.1 23.7C20.1 20.1 22.3 16.9 25.5 15.6C28.9 14.2 32.9 15.3 35 18.1C36.9 20.6 37.1 24 35.7 26.7C35.3 27.5 35.3 28.5 35.7 29.3L36.5 30.7L35.2 32.1Z"/>
            </svg>
        </a>
    </div>

    {{-- Phone Button --}}
    <div class="tooltip-wrap">
        <span class="tooltip">Gọi ngay</span>
        <a href="tel:0886160579"
           class="w-14 h-14 rounded-2xl shadow-2xl flex items-center justify-center animate-pulse-ring transition-all hover:scale-110 hover:-translate-y-0.5"
           style="background: linear-gradient(135deg, #dc2626, #b91c1c);">
            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
            </svg>
        </a>
    </div>

    {{-- Scroll to Top --}}
    <button onclick="window.scrollTo({top:0,behavior:'smooth'})"
        class="w-10 h-10 bg-white border border-gray-200 text-gray-500 rounded-xl shadow-lg flex items-center justify-center hover:bg-brand-main hover:text-white hover:border-brand-main transition-all hover:scale-110"
        title="Lên đầu trang">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/></svg>
    </button>
</div>

<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    // Initialize AOS
    AOS.init({
        duration: 700,
        easing: 'ease-out-cubic',
        once: true,
        offset: 60,
    });
</script>

@stack('scripts')
</body>
</html>
