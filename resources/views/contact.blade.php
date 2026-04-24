@extends('layouts.app')

@section('seo')
    <x-seo
        title="Liên hệ - Báo giá thiết bị đo lường"
        description="Liên hệ Viam Semicon để nhận báo giá thiết bị đo lường, robot vận chuyển, RF cable. Địa chỉ: 251 Đường Dục Tú, Đông Anh, Hà Nội. Hotline: 0886 160 579."
        :jsonld="\App\Helpers\SeoHelper::schema('localbusiness', [])"
    />
@endsection

@push('styles')
<style>
    /* ===== CONTACT PAGE STYLES ===== */

    /* Hero gradient */
    .contact-hero {
        background: linear-gradient(135deg, #0f2444 0%, #1a3a6e 40%, #1a56db 80%, #3b82f6 100%);
        position: relative;
        overflow: hidden;
    }
    .contact-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .contact-hero-blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        opacity: 0.15;
    }

    /* Form input focus */
    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.875rem;
        transition: all 0.2s;
        background: white;
        color: #1f2937;
        outline: none;
    }
    .form-input:focus {
        border-color: #1a56db;
        box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
    }
    .form-input.error { border-color: #dc2626; }
    .form-input::placeholder { color: #9ca3af; }

    /* Form label */
    .form-label {
        display: block;
        font-size: 0.8125rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 6px;
        letter-spacing: 0.01em;
    }

    /* Submit button */
    .submit-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 24px;
        background: linear-gradient(135deg, #1a56db, #3b82f6);
        color: white;
        font-weight: 800;
        border-radius: 14px;
        border: none;
        font-size: 0.9375rem;
        transition: all 0.3s;
        box-shadow: 0 4px 14px rgba(26,86,219,0.35);
        cursor: pointer;
        letter-spacing: 0.01em;
    }
    .submit-btn:hover {
        box-shadow: 0 8px 24px rgba(26,86,219,0.45);
        transform: translateY(-1px);
    }
    .submit-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    /* Contact info card */
    .contact-info-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    /* Contact item */
    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }
    .contact-item:last-child { border-bottom: none; }
    .contact-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Trust badges */
    .trust-stat-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 20px;
        text-align: center;
        transition: all 0.3s;
    }
    .trust-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(26,86,219,0.1);
        border-color: #bfdbfe;
    }

    /* Map container */
    .map-container {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    /* Wave divider */
    .wave-divider svg {
        display: block;
        margin-top: -1px;
    }
</style>
@endpush

@section('no-cta')@endsection

@section('content')

@php
    $breadcrumbs = [
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Liên hệ'],
    ];
@endphp

@include('partials.breadcrumbs')

{{-- ======================== HERO BANNER ======================== --}}
<section class="contact-hero py-16 sm:py-20">
    {{-- Decorative blobs --}}
    <div class="contact-hero-blob w-96 h-96 bg-blue-400 top-0 right-0"></div>
    <div class="contact-hero-blob w-64 h-64 bg-white bottom-0 left-10"></div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="text-center text-white max-w-2xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-xs font-semibold mb-5"
                 data-aos="fade-down">
                <svg class="w-3.5 h-3.5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                Phản hồi trong 1 giờ làm việc
            </div>
            <h1 class="text-3xl sm:text-5xl font-black mb-4 leading-tight" data-aos="fade-up">
                Liên hệ với chúng tôi
            </h1>
            <p class="text-blue-100 text-base sm:text-lg leading-relaxed" data-aos="fade-up" data-aos-delay="100">
                Đội ngũ chuyên gia Viam Semicon sẵn sàng tư vấn và báo giá nhanh nhất
                cho mọi nhu cầu về thiết bị điện tử, đo lường và bán dẫn.
            </p>

            {{-- Quick contact chips --}}
            <div class="flex flex-wrap items-center justify-center gap-3 mt-8" data-aos="fade-up" data-aos-delay="150">
                <a href="tel:0986020896" class="flex items-center gap-2 px-5 py-2.5 bg-brand-accent text-white font-bold rounded-full shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5 text-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                    0986 020 896
                </a>
                <a href="mailto:sale@viamsemicon.com" class="flex items-center gap-2 px-5 py-2.5 bg-white/15 backdrop-blur-sm text-white font-semibold rounded-full border border-white/30 hover:bg-white/25 transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    sale@viamsemicon.com
                </a>
                <a href="https://zalo.me/0986020896" target="_blank" rel="noopener"
                   class="flex items-center gap-2 px-5 py-2.5 text-white font-semibold rounded-full border border-white/30 hover:bg-white/25 transition-all text-sm"
                   style="background: rgba(0,104,255,0.3);">
                    Chat Zalo
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Wave divider --}}
<div class="wave-divider" style="margin-top: -2px; line-height: 0;">
    <svg viewBox="0 0 1440 48" preserveAspectRatio="none" style="width:100%;height:48px;" fill="#f8fafc" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,48 L1440,48 L1440,0 C1200,40 960,48 720,28 C480,8 240,0 0,20 L0,48 Z"/>
    </svg>
</div>

{{-- ======================== STATS BAR ======================== --}}
<section class="py-8" style="background: #f8fafc;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4" data-aos="fade-up">
            @foreach([
                ['number' => '500+', 'label' => 'Sản phẩm', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'color' => '#1a56db'],
                ['number' => '200+', 'label' => 'Khách hàng', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'color' => '#10b981'],
                ['number' => '10+', 'label' => 'Năm kinh nghiệm', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => '#f59e0b'],
                ['number' => '1h', 'label' => 'Phản hồi tư vấn', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => '#dc2626'],
            ] as $stat)
            <div class="trust-stat-card">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3"
                     style="background: {{ $stat['color'] }}15;">
                    <svg class="w-6 h-6" style="color: {{ $stat['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $stat['icon'] }}"/>
                    </svg>
                </div>
                <div class="text-2xl font-black" style="color: {{ $stat['color'] }}">{{ $stat['number'] }}</div>
                <div class="text-xs text-gray-500 font-medium mt-1">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ======================== MAIN CONTENT ======================== --}}
<section class="py-12 lg:py-16" style="background: #f8fafc;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            {{-- ===== CONTACT FORM (3 cols) ===== --}}
            <div class="lg:col-span-3" data-aos="fade-right">
                <div class="contact-info-card"
                    x-data="{
                        form: {
                            name: '{{ request('name', '') }}',
                            email: '{{ request('email', '') }}',
                            phone: '{{ request('phone', '') }}',
                            subject: '{{ request('product', '') ? 'Báo giá: ' . request('product', '') : '' }}',
                            message: '{{ request('product', '') ? 'Tôi muốn nhận báo giá cho sản phẩm: ' . request('product', '') : '' }}'
                        },
                        errors: {},
                        submitting: false,
                        success: {{ session('success') ? 'true' : 'false' }},
                        validate() {
                            this.errors = {};
                            if (!this.form.name.trim()) this.errors.name = 'Vui lòng nhập họ tên';
                            if (!this.form.phone.trim()) this.errors.phone = 'Vui lòng nhập số điện thoại';
                            if (this.form.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email)) this.errors.email = 'Email không hợp lệ';
                            if (!this.form.message.trim()) this.errors.message = 'Vui lòng nhập nội dung';
                            return Object.keys(this.errors).length === 0;
                        }
                    }">

                    {{-- Form Header --}}
                    <div class="px-6 pt-6 pb-5 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                             style="background: linear-gradient(135deg, #1a56db, #3b82f6);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-black text-brand-dark">Gửi yêu cầu tư vấn / báo giá</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Điền thông tin bên dưới — chúng tôi sẽ liên hệ trong 1 giờ</p>
                        </div>
                    </div>

                    <div class="p-6">
                        {{-- Success message --}}
                        <div x-show="success" x-cloak
                             class="mb-6 flex items-start gap-3 px-4 py-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <div>
                                <p class="font-bold">Gửi thành công!</p>
                                <p class="text-sm mt-0.5">{{ session('success', 'Chúng tôi đã nhận được yêu cầu và sẽ liên hệ sớm nhất.') }}</p>
                            </div>
                        </div>

                        {{-- Server-side errors --}}
                        @if($errors->any())
                        <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST"
                              @submit.prevent="if(validate()) { submitting = true; $el.submit(); }">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                {{-- Name --}}
                                <div>
                                    <label class="form-label">
                                        Họ và tên <span class="text-brand-accent">*</span>
                                    </label>
                                    <input type="text" name="name" x-model="form.name"
                                           placeholder="VD: Nguyễn Văn A"
                                           value="{{ old('name') }}"
                                           :class="errors.name ? 'error' : ''"
                                           class="form-input">
                                    <p x-show="errors.name" x-text="errors.name"
                                       class="text-red-500 text-xs mt-1.5 flex items-center gap-1" x-cloak>
                                    </p>
                                </div>

                                {{-- Phone --}}
                                <div>
                                    <label class="form-label">
                                        Số điện thoại <span class="text-brand-accent">*</span>
                                    </label>
                                    <input type="tel" name="phone" x-model="form.phone"
                                           placeholder="VD: 0986 020 896"
                                           value="{{ old('phone') }}"
                                           :class="errors.phone ? 'error' : ''"
                                           class="form-input">
                                    <p x-show="errors.phone" x-text="errors.phone"
                                       class="text-red-500 text-xs mt-1.5" x-cloak></p>
                                </div>

                                {{-- Email --}}
                                <div class="sm:col-span-2">
                                    <label class="form-label">
                                        Email
                                        <span class="text-gray-400 font-normal text-xs ml-1">(không bắt buộc)</span>
                                    </label>
                                    <input type="email" name="email" x-model="form.email"
                                           placeholder="email@congty.com"
                                           value="{{ old('email') }}"
                                           :class="errors.email ? 'error' : ''"
                                           class="form-input">
                                    <p x-show="errors.email" x-text="errors.email"
                                       class="text-red-500 text-xs mt-1.5" x-cloak></p>
                                </div>

                                {{-- Subject --}}
                                <div class="sm:col-span-2">
                                    <label class="form-label">Tiêu đề / Sản phẩm cần báo giá</label>
                                    <input type="text" name="subject" x-model="form.subject"
                                           placeholder="VD: Báo giá Robot AGV, IC Bán dẫn, Cáp RF..."
                                           value="{{ old('subject', request('product') ? 'Báo giá: ' . request('product') : '') }}"
                                           class="form-input">
                                </div>

                                {{-- Message --}}
                                <div class="sm:col-span-2">
                                    <label class="form-label">
                                        Nội dung chi tiết <span class="text-brand-accent">*</span>
                                    </label>
                                    <textarea name="message" x-model="form.message" rows="5"
                                              placeholder="Mô tả chi tiết yêu cầu: tên sản phẩm, số lượng, thông số kỹ thuật, thời gian cần hàng..."
                                              :class="errors.message ? 'error' : ''"
                                              class="form-input resize-none">{{ old('message', request('product') ? 'Tôi muốn nhận báo giá cho sản phẩm: ' . request('product') : '') }}</textarea>
                                    <p x-show="errors.message" x-text="errors.message"
                                       class="text-red-500 text-xs mt-1.5" x-cloak></p>
                                </div>
                            </div>

                            <div class="mt-5">
                                <button type="submit" :disabled="submitting" class="submit-btn">
                                    <span x-show="!submitting" class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                        Gửi yêu cầu ngay
                                    </span>
                                    <span x-show="submitting" x-cloak class="flex items-center gap-2">
                                        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        Đang gửi...
                                    </span>
                                </button>
                                <p class="text-xs text-gray-400 text-center mt-3">
                                    <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    Thông tin của bạn được bảo mật tuyệt đối. Phản hồi trong vòng 1 giờ làm việc.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ===== CONTACT INFO (2 cols) ===== --}}
            <div class="lg:col-span-2 space-y-5" data-aos="fade-left" data-aos-delay="100">

                {{-- Company Info Card --}}
                <div class="contact-info-card">
                    <div class="px-6 pt-5 pb-4 border-b border-gray-50">
                        <h2 class="text-lg font-black text-brand-dark">Thông tin liên hệ</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Nhiều kênh liên hệ — phản hồi cực nhanh</p>
                    </div>
                    <div class="px-6 py-2">

                        {{-- Address --}}
                        <div class="contact-item">
                            <div class="contact-icon-wrap" style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-sm">Địa chỉ</p>
                                <p class="text-gray-600 text-sm mt-0.5 leading-relaxed">
                                    Số 251 Đường Dục Tú, Xã Dục Tú,<br>
                                    Huyện Đông Anh, Thành phố Hà Nội
                                </p>
                                <a href="https://maps.google.com/?q=251+Duong+Duc+Tu+Dong+Anh+Ha+Noi"
                                   target="_blank" rel="noopener"
                                   class="text-xs text-brand-main font-semibold mt-1.5 inline-flex items-center gap-1 hover:underline">
                                    Xem bản đồ
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="contact-item">
                            <div class="contact-icon-wrap" style="background: linear-gradient(135deg, #fff1f2, #fce7f3);">
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-sm mb-1">Hotline</p>
                                <a href="tel:0986020896" class="font-black text-brand-accent text-xl leading-none hover:underline block">0986 020 896</a>
                                <a href="tel:0528152831" class="font-semibold text-brand-main text-sm mt-1 inline-block hover:underline">0528.152.831</a>
                                <p class="text-xs text-gray-400 mt-1">Alex Nguyen • Thứ 2 - Thứ 7, 8:00 - 18:00</p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="contact-item">
                            <div class="contact-icon-wrap" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7);">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-sm">Email</p>
                                <a href="mailto:sale@viamsemicon.com"
                                   class="text-brand-main font-semibold text-sm mt-0.5 inline-block hover:underline">
                                    sale@viamsemicon.com
                                </a>
                                <p class="text-xs text-gray-400 mt-0.5">Phản hồi email trong 2 giờ</p>
                            </div>
                        </div>

                        {{-- Working hours --}}
                        <div class="contact-item">
                            <div class="contact-icon-wrap" style="background: linear-gradient(135deg, #fefce8, #fef3c7);">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-sm">Giờ làm việc</p>
                                <p class="text-gray-600 text-sm mt-0.5">Thứ 2 - Thứ 7: <span class="font-semibold">8:00 - 18:00</span></p>
                                <p class="text-gray-400 text-xs">Chủ nhật: Nghỉ</p>
                            </div>
                        </div>
                    </div>

                    {{-- Quick action buttons --}}
                    <div class="px-6 pb-6">
                        <div class="grid grid-cols-2 gap-3">
                            <a href="tel:0986020896"
                               class="flex items-center justify-center gap-2 py-3 text-white rounded-xl font-bold text-sm transition-all hover:shadow-lg hover:-translate-y-0.5"
                               style="background: linear-gradient(135deg, #dc2626, #ef4444);">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                                Gọi ngay
                            </a>
                            <a href="https://zalo.me/0986020896" target="_blank" rel="noopener"
                               class="flex items-center justify-center gap-2 py-3 text-white rounded-xl font-bold text-sm transition-all hover:shadow-lg hover:-translate-y-0.5"
                               style="background: #0068ff;">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12c0 5.52 4.48 10 10 10 5.52 0 10-4.48 10-10C22 6.48 17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm1-13h-2v6h2zm0 8h-2v2h2z"/></svg>
                                Chat Zalo
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Map --}}
                <div class="map-container" data-aos="fade-up" data-aos-delay="200">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.485264!2d105.869!3d21.123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDA3JzIyLjgiTiAxMDXCsDUyJzA4LjQiRQ!5e0!3m2!1svi!2svn!4v1234567890"
                        width="100%" height="260" style="border:0; display:block;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Vị trí Viam Semicon — 251 Đường Dục Tú, Đông Anh, Hà Nội">
                    </iframe>
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-100">
                        <span class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-brand-main flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                            251 Đường Dục Tú, Đông Anh, HN
                        </span>
                        <a href="https://maps.google.com/?q=251+Duong+Duc+Tu+Dong+Anh+Ha+Noi"
                           target="_blank" rel="noopener"
                           class="text-xs text-brand-main font-semibold hover:underline flex items-center gap-1 flex-shrink-0 ml-2">
                            Chỉ đường
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Social / Quick links --}}
                <div class="contact-info-card p-5" data-aos="fade-up" data-aos-delay="250">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Kết nối với chúng tôi</p>
                    <div class="space-y-3">
                        <a href="https://www.facebook.com/viamsemicon" target="_blank" rel="noopener"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-50 hover:bg-blue-100 transition-colors group">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center text-white flex-shrink-0" style="background: #1877f2;">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 text-sm group-hover:text-blue-700 transition-colors">Facebook</div>
                                <div class="text-xs text-gray-500">@viamsemicon</div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="https://zalo.me/0986020896" target="_blank" rel="noopener"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-50 hover:bg-blue-100 transition-colors group">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center text-white flex-shrink-0" style="background: #0068ff;">
                                <span class="font-black text-xs">Zalo</span>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 text-sm group-hover:text-blue-700 transition-colors">Zalo OA</div>
                                <div class="text-xs text-gray-500">Chat trực tiếp</div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ======================== TRUST SECTION ======================== --}}
<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl font-black text-brand-dark">Cam kết của Viam Semicon</h2>
            <p class="text-gray-500 mt-2 text-sm">Chúng tôi luôn đặt sự hài lòng của khách hàng lên hàng đầu</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach([
                [
                    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                    'color' => '#1a56db',
                    'bg' => '#eff6ff',
                    'title' => 'Hàng chính hãng 100%',
                    'desc' => 'Sản phẩm nhập khẩu chính thức từ nhà sản xuất uy tín, có đầy đủ chứng chỉ và CO/CQ',
                ],
                [
                    'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                    'color' => '#f59e0b',
                    'bg' => '#fffbeb',
                    'title' => 'Giao hàng toàn quốc',
                    'desc' => 'Đóng gói cẩn thận, giao hàng nhanh 24-48h cho hàng sẵn kho, hỗ trợ đơn hàng khẩn cấp',
                ],
                [
                    'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                    'color' => '#10b981',
                    'bg' => '#f0fdf4',
                    'title' => 'Xuất hóa đơn VAT',
                    'desc' => 'Hỗ trợ xuất hóa đơn VAT đầy đủ cho doanh nghiệp, tổ chức và cơ quan nhà nước',
                ],
                [
                    'icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z',
                    'color' => '#8b5cf6',
                    'bg' => '#f5f3ff',
                    'title' => 'Hỗ trợ kỹ thuật',
                    'desc' => 'Đội ngũ kỹ sư giàu kinh nghiệm hỗ trợ tư vấn lựa chọn, lắp đặt và vận hành thiết bị',
                ],
            ] as $i => $item)
            <div class="trust-stat-card text-left" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4"
                     style="background: {{ $item['bg'] }};">
                    <svg class="w-6 h-6" style="color: {{ $item['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">{{ $item['title'] }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
