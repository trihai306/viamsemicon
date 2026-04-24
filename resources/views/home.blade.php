@extends('layouts.app')

@section('seo')
    @php
        $seoJsonld = \App\Helpers\SeoHelper::schema('organization', ['name' => 'Viam Semicon', 'url' => url('/')])
                   . \App\Helpers\SeoHelper::schema('website', []);
    @endphp
    <x-seo
        :title="config('site.seo.title')"
        :description="config('site.seo.description')"
        canonical="{{ url('/') }}"
        :jsonld="$seoJsonld"
    />
@endsection

@push('styles')
<style>
    /* Hero Swiper */
    .hero-swiper { width: 100%; }
    .hero-swiper .swiper-slide { position: relative; }

    /* Particle canvas */
    #hero-canvas {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        pointer-events: none;
    }

    /* Animated geometric shapes */
    .geo-shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        opacity: 0.15;
        animation: float-shape 10s ease-in-out infinite;
    }
    @keyframes float-shape {
        0%, 100% { transform: translateY(0px) scale(1); }
        50% { transform: translateY(-30px) scale(1.05); }
    }

    /* Stats bar */
    .stats-bar-gradient {
        background: linear-gradient(135deg, #0f2444 0%, #1a365d 50%, #0f2444 100%);
    }

    /* Promo banner */
    .promo-banner-bg {
        background: linear-gradient(135deg, #1a365d 0%, #1e40af 45%, #d97706 100%);
    }

    /* Deal tabs */
    .deal-tab {
        transition: all 0.25s ease;
        border: 2px solid transparent;
        cursor: pointer;
    }
    .deal-tab:hover {
        border-color: #fbbf24;
        color: #d97706;
    }
    .deal-tab.active {
        background: linear-gradient(135deg, #f59e0b, #d97706) !important;
        color: white !important;
        border-color: transparent !important;
        box-shadow: 0 4px 14px rgba(245,158,11,0.4) !important;
    }

    /* News card */
    .news-card {
        transition: all 0.3s ease;
        position: relative;
    }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.10);
    }
    .news-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #f59e0b, #d97706);
        transform: scaleX(0);
        transition: transform 0.3s ease;
        border-radius: 0 0 12px 12px;
    }
    .news-card:hover::after { transform: scaleX(1); }

    /* Section pattern */
    .section-pattern {
        background-image: radial-gradient(circle at 1px 1px, rgba(26,86,219,0.05) 1px, transparent 0);
        background-size: 32px 32px;
    }

    /* Partner logo */
    .partner-logo-item {
        transition: all 0.3s ease;
        filter: grayscale(80%);
        opacity: 0.65;
    }
    .partner-logo-item:hover {
        filter: grayscale(0%);
        opacity: 1;
        transform: scale(1.05);
    }

    /* Partner marquee */
    .partner-marquee-wrapper {
        mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
    }
    .partner-marquee-track {
        animation: marquee-scroll 30s linear infinite;
        width: max-content;
    }
    .partner-marquee-track:hover {
        animation-play-state: paused;
    }
    @keyframes marquee-scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
</style>
@endpush

@section('content')

{{-- ======================== HERO SLIDER ======================== --}}
@php $sliderCount = is_countable($sliders ?? null) ? count($sliders) : 0; @endphp

<section class="relative">
    @if($sliderCount > 0)
    <div class="hero-swiper swiper" id="heroSwiper">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
            <div class="swiper-slide">
                <div class="relative" style="height: clamp(400px, 55vw, 660px);">
                    <img src="{{ Storage::url($slider->image) }}"
                         alt="{{ $slider->title ?? 'Viam Semicon' }}"
                         class="w-full h-full object-cover"
                         loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                    <div class="absolute inset-0" style="background: linear-gradient(110deg, rgba(10,22,40,0.88) 0%, rgba(15,36,68,0.6) 40%, rgba(26,86,219,0.15) 70%, transparent 100%);"></div>

                    @if($slider->title || $slider->subtitle)
                    <div class="absolute inset-0 flex items-center">
                        <div class="max-w-7xl mx-auto px-4 md:px-8 w-full">
                            <div class="max-w-2xl">
                                @if($slider->title)
                                <div class="inline-flex items-center gap-2 px-3 py-1.5 mb-4 rounded-full text-xs font-semibold uppercase tracking-widest"
                                     style="background: rgba(245,158,11,0.25); border: 1px solid rgba(245,158,11,0.4); color: #fcd34d;">
                                    <span class="w-1.5 h-1.5 bg-amber-300 rounded-full"></span>
                                    Viam Semicon
                                </div>
                                <h2 class="text-white text-3xl md:text-5xl lg:text-6xl font-black mb-4 leading-tight" style="text-shadow: 0 2px 20px rgba(0,0,0,0.4);">
                                    {{ $slider->title }}
                                </h2>
                                @endif
                                @if($slider->subtitle)
                                <p class="text-blue-100 text-base md:text-xl mb-8 leading-relaxed opacity-90">{{ $slider->subtitle }}</p>
                                @endif
                                <div class="flex flex-wrap gap-3">
                                    @if($slider->link)
                                    <a href="{{ $slider->link }}"
                                       class="inline-flex items-center gap-2.5 px-7 py-3.5 font-bold rounded-xl text-white text-sm md:text-base transition-all hover:opacity-90 shadow-xl"
                                       style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                        Xem ngay
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                    @else
                                    <a href="{{ route('products.index') }}"
                                       class="inline-flex items-center gap-2.5 px-7 py-3.5 font-bold rounded-xl text-white text-sm md:text-base transition-all hover:opacity-90 shadow-xl"
                                       style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                        Xem sản phẩm
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                    @endif
                                    <a href="{{ route('contact') }}"
                                       class="inline-flex items-center gap-2.5 px-7 py-3.5 font-semibold rounded-xl text-white text-sm md:text-base transition-all"
                                       style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.3); backdrop-filter: blur(8px);">
                                        Liên hệ báo giá
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @if($sliderCount > 1)
        <div class="swiper-pagination" style="bottom: 24px;"></div>
        <div class="swiper-button-prev" style="left: 24px;"></div>
        <div class="swiper-button-next" style="right: 24px;"></div>
        @endif
    </div>

    @else
    {{-- Fallback hero --}}
    <div class="relative overflow-hidden" style="height: clamp(460px, 56vw, 660px); background: linear-gradient(135deg, #060d1a 0%, #0f2444 30%, #1a3a6e 60%, #0a1628 100%);">
        <div class="geo-shape w-96 h-96 bg-blue-500" style="top: -10%; left: -5%;"></div>
        <div class="geo-shape w-80 h-80 bg-amber-500" style="bottom: -15%; right: -5%; animation-delay: 3s;"></div>
        <div class="geo-shape w-64 h-64 bg-blue-300" style="top: 30%; right: 20%; animation-delay: 6s;"></div>
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 60px 60px;"></div>
        <canvas id="hero-canvas"></canvas>
        <div class="relative z-10 h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 md:px-8 w-full">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-4 py-2 mb-6 rounded-full text-xs font-bold uppercase tracking-widest"
                         style="background: rgba(245,158,11,0.2); border: 1px solid rgba(245,158,11,0.4); color: #fcd34d;">
                        <span class="w-2 h-2 bg-amber-300 rounded-full animate-pulse"></span>
                        Nhà phân phối chính hãng tại Việt Nam
                    </div>
                    <h1 class="text-white text-4xl md:text-6xl lg:text-7xl font-black mb-5 leading-none">
                        <span class="block">VIAM</span>
                        <span class="block" style="background: linear-gradient(135deg, #fbbf24, #f59e0b, #fde68a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">SEMICON</span>
                    </h1>
                    <p class="text-blue-200 text-lg md:text-2xl mb-4 font-light leading-relaxed">
                        Thiết bị đo lường &bull; Robot vận chuyển &bull; RF Cable & Adapters
                    </p>
                    <p class="text-blue-300/70 text-base mb-10 max-w-xl">Cung cấp giải pháp công nghệ tiên tiến cho ngành sản xuất và điện tử tại Việt Nam.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('products.index') }}"
                           class="inline-flex items-center gap-2.5 px-8 py-4 font-bold rounded-xl text-white text-base transition-all hover:opacity-90 shadow-xl"
                           style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            Xem sản phẩm
                        </a>
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center gap-2.5 px-8 py-4 font-bold rounded-xl text-white text-base transition-all animate-pulse-ring"
                           style="background: linear-gradient(135deg, #dc2626, #b91c1c);">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                            Liên hệ báo giá
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>

{{-- ======================== STATS BAR ======================== --}}
<div class="stats-bar-gradient text-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-white/10">
            @foreach([
                ['num' => '500+',  'label' => 'Sản phẩm',        'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                ['num' => '200+',  'label' => 'Khách hàng',       'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['num' => '10+',   'label' => 'Năm kinh nghiệm',  'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
                ['num' => '100%',  'label' => 'Hàng chính hãng',  'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            ] as $stat)
            <div class="flex items-center gap-3 px-5 py-4">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background: rgba(245,158,11,0.2);">
                    <svg class="w-4.5 h-4.5 text-amber-400" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                </div>
                <div>
                    <div class="text-xl font-black leading-none text-white">{{ $stat['num'] }}</div>
                    <div class="text-xs text-blue-200 font-medium mt-0.5">{{ $stat['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ======================== FEATURES SECTION (WHITE BG) ======================== --}}
@php $featuresList = collect($features ?? []); @endphp
@if($featuresList->count() > 0)
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 mb-3 rounded-full text-xs font-semibold uppercase tracking-widest"
                 style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); color: #d97706;">
                Cam kết chất lượng
            </div>
            <h2 class="text-2xl md:text-3xl font-black" style="color: #1a365d;">
                Tại sao chọn <span style="color: #f59e0b;">Viam Semicon?</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featuresList as $i => $feature)
            <div class="feature-card-white" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-4 shadow-sm"
                     style="background: linear-gradient(135deg, #1a365d, #2563eb);">
                    @if($feature->icon === 'shield-check')
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    @elseif($feature->icon === 'users')
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    @elseif($feature->icon === 'truck')
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                    @else
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    @endif
                </div>
                <h3 class="font-bold text-base mb-2" style="color: #1a365d;">{{ $feature->title }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $feature->description }}</p>
                <div class="mt-4 pt-4" style="border-top: 1px solid #e0e7ff;">
                    <a href="{{ route('about') }}" class="text-xs font-semibold flex items-center gap-1.5 transition-colors hover:gap-2.5" style="color: #f59e0b;">
                        Tìm hiểu thêm
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
{{-- Default features if DB is empty --}}
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10" data-aos="fade-up">
            <h2 class="text-2xl md:text-3xl font-black" style="color: #1a365d;">
                Tại sao chọn <span style="color: #f59e0b;">Viam Semicon?</span>
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['icon' => 'shield-check', 'title' => 'Kiểm tra chất lượng', 'desc' => 'Tất cả sản phẩm được kiểm tra nghiêm ngặt trước khi giao đến khách hàng. Cam kết hàng chính hãng 100%.'],
                ['icon' => 'users', 'title' => 'Đội ngũ chuyên gia', 'desc' => 'Hơn 10 năm kinh nghiệm trong lĩnh vực thiết bị điện tử và đo lường công nghiệp.'],
                ['icon' => 'settings', 'title' => 'Công cụ hỗ trợ kỹ thuật', 'desc' => 'Hỗ trợ tư vấn kỹ thuật và lắp đặt tận nơi cho khách hàng trên toàn quốc.'],
            ] as $i => $feat)
            <div class="feature-card-white" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-4 shadow-sm" style="background: linear-gradient(135deg, #1a365d, #2563eb);">
                    @if($feat['icon'] === 'shield-check')
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    @elseif($feat['icon'] === 'users')
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    @else
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    @endif
                </div>
                <h3 class="font-bold text-base mb-2" style="color: #1a365d;">{{ $feat['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $feat['desc'] }}</p>
                <div class="mt-4 pt-4" style="border-top: 1px solid #e0e7ff;">
                    <a href="{{ route('about') }}" class="text-xs font-semibold flex items-center gap-1.5 transition-all hover:gap-2.5" style="color: #f59e0b;">
                        Tìm hiểu thêm
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ======================== DEAL NỔI BẬT (TABS) ======================== --}}
@php $cats = collect($categories ?? [])->filter(function($c) { return is_countable($c->products) && count($c->products) > 0; })->values(); @endphp
@if($cats->count() > 0)
<section class="py-12 bg-slate-50 section-pattern" x-data="{ activeTab: 0 }">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8" data-aos="fade-up">
            <div>
                <div class="inline-flex items-center gap-1.5 mb-2 text-xs font-semibold uppercase tracking-widest"
                     style="color: #f59e0b;">
                    <span class="w-4 h-0.5 bg-amber-400 rounded-full inline-block"></span>
                    Sản phẩm nổi bật
                </div>
                <h2 class="text-2xl md:text-3xl font-black" style="color: #1a365d;">
                    Deal <span style="color: #f59e0b;">Nổi Bật</span>
                </h2>
            </div>
            {{-- Tab pills --}}
            <div class="flex flex-wrap gap-2">
                @foreach($cats as $i => $category)
                <button @click="activeTab = {{ $i }}"
                    :class="activeTab === {{ $i }} ? 'active' : ''"
                    class="deal-tab px-4 py-2 rounded-full font-semibold text-sm bg-white text-gray-600 shadow-sm">
                    {{ $category->name }}
                </button>
                @endforeach
            </div>
        </div>

        @foreach($cats as $i => $category)
        <div x-show="activeTab === {{ $i }}"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0">
            @if($category->products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($category->products->take(5) as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
            <div class="text-center mt-6">
                <a href="{{ url('/danh-muc-san-pham/' . $category->slug) }}"
                   class="inline-flex items-center gap-2 px-7 py-3 font-bold text-sm rounded-xl text-white transition-all hover:opacity-90 shadow-lg"
                   style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    Xem tất cả {{ $category->name }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
            @else
            <div class="text-center py-10 text-gray-400 text-sm">Chưa có sản phẩm trong danh mục này.</div>
            @endif
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ======================== PROMOTIONAL BANNER ======================== --}}
<section class="promo-banner-bg relative overflow-hidden py-12">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-16 -left-16 w-80 h-80 bg-white opacity-5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-16 -right-16 w-80 h-80 bg-amber-300 opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 48px 48px;"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="text-white text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 mb-4 rounded-full text-xs font-bold uppercase tracking-widest"
                 style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.25);">
                <span class="w-1.5 h-1.5 bg-amber-300 rounded-full animate-pulse"></span>
                Nhà phân phối chính hãng
            </div>
            <h2 class="text-2xl md:text-4xl font-black mb-3 uppercase tracking-wide leading-tight">
                Phân phối thiết bị<br class="hidden md:block"> đo lường
            </h2>
            <p class="text-blue-100 text-sm md:text-base max-w-xl leading-relaxed">
                Cung cấp đầy đủ các loại thiết bị đo lường, kiểm tra chất lượng, robot vận chuyển và RF Cable &amp; Adapters từ các thương hiệu uy tín hàng đầu thế giới.
            </p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl font-bold text-sm transition-all hover:opacity-90 shadow-xl"
               style="background: #f59e0b; color: #1a365d;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Xem sản phẩm
            </a>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl font-bold text-sm text-white transition-all hover:bg-white/20"
               style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.3);">
                Liên hệ báo giá
            </a>
        </div>
    </div>
</section>

{{-- ======================== PRODUCTS BY CATEGORY ======================== --}}
@foreach(collect($categoriesWithProducts ?? []) as $cat)
<section class="py-12 {{ $loop->even ? 'bg-slate-50 section-pattern' : 'bg-white' }}">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-6" data-aos="fade-up">
            <div>
                <h2 class="section-header">{{ $cat->name }}</h2>
                @if($cat->description)
                <p class="text-sm text-gray-500 mt-1 max-w-md line-clamp-1 pl-5">{{ strip_tags($cat->description) }}</p>
                @endif
            </div>
            <a href="{{ url('/danh-muc-san-pham/' . $cat->slug) }}"
               class="flex items-center gap-1.5 font-semibold text-sm transition-all hover:gap-2.5 flex-shrink-0 px-4 py-2 rounded-lg"
               style="color: #f59e0b; background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.2);">
                Xem tất cả
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($cat->products->take(5) as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endforeach

{{-- ======================== PARTNERS SECTION ======================== --}}
@php $partnersList = collect($partners ?? []); @endphp
@if($partnersList->count() > 0)
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 mb-3 rounded-full text-xs font-semibold uppercase tracking-widest"
                 style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); color: #d97706;">
                Đối tác của chúng tôi
            </div>
            <h2 class="text-2xl md:text-3xl font-black" style="color: #1a365d;">
                Thương hiệu <span style="color: #f59e0b;">uy tín</span> toàn cầu
            </h2>
            <p class="text-gray-500 text-sm mt-2">Chúng tôi là đại lý phân phối chính thức của các thương hiệu hàng đầu thế giới</p>
        </div>

        <div class="partner-marquee-wrapper overflow-hidden relative" data-aos="fade-up" data-aos-delay="100">
            <div class="partner-marquee-track flex items-center gap-8">
                @foreach($partnersList as $partner)
                <a href="{{ $partner->link ?? '#' }}"
                   target="{{ $partner->link ? '_blank' : '_self' }}"
                   rel="noopener"
                   class="partner-logo-item flex-shrink-0 flex items-center justify-center bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:border-amber-200"
                   style="min-height: 100px; min-width: 180px;">
                    <img src="{{ Storage::url($partner->logo) }}"
                         alt="{{ $partner->name }}"
                         class="max-h-14 max-w-full object-contain"
                         loading="lazy">
                </a>
                @endforeach
                @foreach($partnersList as $partner)
                <a href="{{ $partner->link ?? '#' }}"
                   target="{{ $partner->link ? '_blank' : '_self' }}"
                   rel="noopener"
                   aria-hidden="true"
                   class="partner-logo-item flex-shrink-0 flex items-center justify-center bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:border-amber-200"
                   style="min-height: 100px; min-width: 180px;">
                    <img src="{{ Storage::url($partner->logo) }}"
                         alt="{{ $partner->name }}"
                         class="max-h-14 max-w-full object-contain"
                         loading="lazy">
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- ======================== LATEST NEWS ======================== --}}
@php $homePosts = collect($latestPosts ?? []); @endphp
@if($homePosts->count() > 0)
<section class="py-12 bg-slate-50 section-pattern">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8" data-aos="fade-up">
            <div>
                <div class="inline-flex items-center gap-1.5 mb-2 text-xs font-semibold uppercase tracking-widest" style="color: #f59e0b;">
                    <span class="w-4 h-0.5 bg-amber-400 rounded-full inline-block"></span>
                    Cập nhật mới nhất
                </div>
                <h2 class="text-2xl md:text-3xl font-black" style="color: #1a365d;">
                    Tin <span style="color: #f59e0b;">Tức</span> &amp; Sự Kiện
                </h2>
            </div>
            <a href="{{ route('posts.index') }}"
               class="hidden md:flex items-center gap-1.5 font-semibold text-sm transition-all hover:gap-2.5 px-4 py-2 rounded-lg"
               style="color: #f59e0b; background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.2);">
                Xem tất cả
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($homePosts as $i => $post)
            <article class="news-card bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 flex flex-col"
                     data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                <a href="{{ url('/tin-tuc/' . $post->slug) }}" class="block relative overflow-hidden" style="height: 195px;">
                    @if($post->image)
                    <img src="{{ Storage::url($post->image) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                         loading="{{ $i < 2 ? 'eager' : 'lazy' }}">
                    @else
                    <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, #1a365d, #2563eb);">
                        <svg class="w-14 h-14 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    @endif
                    {{-- Date badge --}}
                    <div class="absolute top-3 left-3 text-white text-xs font-bold px-2.5 py-1.5 rounded-lg shadow"
                         style="background: rgba(245,158,11,0.9); backdrop-filter: blur(4px);">
                        {{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}
                    </div>
                    <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.35) 0%, transparent 60%);"></div>
                </a>
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-bold text-gray-800 text-sm leading-snug mb-2 line-clamp-2 hover:text-blue-700 transition-colors">
                        <a href="{{ url('/tin-tuc/' . $post->slug) }}">{{ $post->title }}</a>
                    </h3>
                    @if($post->excerpt)
                    <p class="text-gray-400 text-xs line-clamp-2 leading-relaxed mb-3 flex-1">{{ strip_tags($post->excerpt) }}</p>
                    @else
                    <div class="flex-1"></div>
                    @endif
                    <a href="{{ url('/tin-tuc/' . $post->slug) }}"
                       class="inline-flex items-center gap-1.5 text-xs font-bold transition-all hover:gap-2.5 mt-2"
                       style="color: #f59e0b;">
                        Đọc tiếp
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <div class="text-center mt-6 md:hidden">
            <a href="{{ route('posts.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-sm text-white"
               style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                Xem tất cả tin tức
            </a>
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
    // Init Hero Swiper
    @if($sliderCount > 0)
    const heroSwiper = new Swiper('#heroSwiper', {
        loop: {{ $sliderCount > 1 ? 'true' : 'false' }},
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        effect: 'fade',
        fadeEffect: { crossFade: true },
        speed: 800,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
    @endif

    // Animated particles for hero fallback
    const canvas = document.getElementById('hero-canvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        let particles = [];
        function resizeCanvas() {
            canvas.width = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);
        for (let i = 0; i < 50; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                r: Math.random() * 2 + 0.5,
                dx: (Math.random() - 0.5) * 0.4,
                dy: (Math.random() - 0.5) * 0.4,
                opacity: Math.random() * 0.4 + 0.1,
            });
        }
        function drawParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.x += p.dx;
                p.y += p.dy;
                if (p.x < 0 || p.x > canvas.width) p.dx *= -1;
                if (p.y < 0 || p.y > canvas.height) p.dy *= -1;
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(251, 191, 36, ${p.opacity})`;
                ctx.fill();
            });
            particles.forEach((p1, i) => {
                particles.slice(i + 1).forEach(p2 => {
                    const dist = Math.hypot(p1.x - p2.x, p1.y - p2.y);
                    if (dist < 100) {
                        ctx.beginPath();
                        ctx.moveTo(p1.x, p1.y);
                        ctx.lineTo(p2.x, p2.y);
                        ctx.strokeStyle = `rgba(251, 191, 36, ${0.08 * (1 - dist / 100)})`;
                        ctx.lineWidth = 0.5;
                        ctx.stroke();
                    }
                });
            });
            requestAnimationFrame(drawParticles);
        }
        drawParticles();
    }
</script>
@endpush
