@extends('layouts.app')

@section('seo')
    <x-seo
        title="Giới thiệu về Viam Semicon"
        description="Công ty TNHH VIAM GLOBAL - Chuyên cung cấp thiết bị đo lường, robot vận chuyển, RF cable & adapters chính hãng. Địa chỉ: 251 Đường Dục Tú, Đông Anh, Hà Nội."
        canonical="{{ route('about') }}"
        :jsonld="\App\Helpers\SeoHelper::schema('organization', ['name' => 'Viam Semicon', 'url' => url('/')])"
    />
@endsection

@section('content')

@php
    $breadcrumbs = [
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Giới thiệu'],
    ];
@endphp

@include('partials.breadcrumbs')

{{-- Hero --}}
<div class="relative bg-gradient-to-r from-brand-dark via-brand-main to-blue-500 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    <div class="relative max-w-7xl mx-auto px-4 py-16 lg:py-20">
        <div class="max-w-3xl">
            <p class="text-blue-300 text-sm font-semibold uppercase tracking-widest mb-3">Về chúng tôi</p>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight mb-5">
                Công ty TNHH<br><span class="text-blue-200">VIAM GLOBAL</span>
            </h1>
            <p class="text-blue-100 text-lg leading-relaxed mb-6">
                Nhà phân phối linh kiện điện tử, bán dẫn và thiết bị đo lường hàng đầu Việt Nam. Chúng tôi cam kết cung cấp sản phẩm chính hãng, chất lượng cao với dịch vụ chuyên nghiệp nhất.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-accent text-white font-bold rounded-xl hover:bg-red-700 transition-colors shadow-lg">
                    Xem sản phẩm
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 border-2 border-white text-white font-bold rounded-xl hover:bg-white hover:text-brand-dark transition-colors">
                    Liên hệ ngay
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Stats --}}
<section class="bg-white py-10 border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach([
                ['number' => '10+', 'label' => 'Năm kinh nghiệm', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['number' => '1000+', 'label' => 'Mã sản phẩm', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                ['number' => '300+', 'label' => 'Khách hàng tin dùng', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['number' => '50+', 'label' => 'Thương hiệu đối tác', 'icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9'],
            ] as $stat)
            <div class="text-center p-4">
                <div class="w-12 h-12 bg-brand-main bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-brand-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                </div>
                <p class="text-3xl sm:text-4xl font-black text-brand-dark mb-1">{{ $stat['number'] }}</p>
                <p class="text-sm text-gray-500 font-medium">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- About Content --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <p class="text-brand-main font-semibold text-sm uppercase tracking-widest mb-2">Câu chuyện của chúng tôi</p>
                <h2 class="text-2xl sm:text-3xl font-black text-brand-dark mb-5">Viam Semicon — Đối tác tin cậy trong lĩnh vực linh kiện điện tử</h2>
                <div class="space-y-4 text-gray-600 text-sm leading-relaxed">
                    <p>Được thành lập với mục tiêu trở thành nhà phân phối linh kiện điện tử và bán dẫn hàng đầu Việt Nam, <strong class="text-brand-dark">Viam Semicon</strong> đã không ngừng phát triển và mở rộng danh mục sản phẩm để đáp ứng nhu cầu ngày càng cao của thị trường.</p>
                    <p>Với hơn 10 năm kinh nghiệm trong ngành, chúng tôi cung cấp hơn 1000 mã sản phẩm đa dạng từ các thương hiệu nổi tiếng thế giới như Texas Instruments, STMicroelectronics, Infineon, Renesas, Murata và nhiều hãng khác.</p>
                    <p>Đội ngũ kỹ thuật viên giàu kinh nghiệm của chúng tôi sẵn sàng hỗ trợ khách hàng trong việc lựa chọn sản phẩm phù hợp và tư vấn giải pháp kỹ thuật tối ưu.</p>
                </div>

                @if(isset($page) && $page && $page->content)
                <div class="mt-6 prose-article">
                    {!! $page->content !!}
                </div>
                @endif
            </div>

            <div class="space-y-5">
                @foreach([
                    ['title' => 'Sản phẩm đa dạng', 'desc' => 'Hơn 1000 mã sản phẩm IC, Transistor, Tụ điện, Điện trở, Mosfet từ các thương hiệu hàng đầu thế giới.', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                    ['title' => 'Chất lượng đảm bảo', 'desc' => 'Toàn bộ sản phẩm đều có nguồn gốc xuất xứ rõ ràng, chứng chỉ chất lượng đầy đủ, hoàn toàn chính hãng 100%.', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['title' => 'Giao hàng toàn quốc', 'desc' => 'Hệ thống logistics chuyên nghiệp, giao hàng nhanh chóng đến tất cả 63 tỉnh thành trên toàn quốc trong 24-48 giờ.', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                    ['title' => 'Hỗ trợ kỹ thuật', 'desc' => 'Đội ngũ kỹ sư điện tử giàu kinh nghiệm sẵn sàng hỗ trợ tư vấn kỹ thuật, chọn linh kiện thay thế tương đương.', 'icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z'],
                ] as $item)
                <div class="flex gap-4 bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-brand-main bg-opacity-10 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-brand-main" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-brand-dark mb-1">{{ $item['title'] }}</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $item['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Mission / Vision / Values --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <p class="text-brand-main font-semibold text-sm uppercase tracking-widest mb-2">Định hướng phát triển</p>
            <h2 class="text-2xl sm:text-3xl font-black text-brand-dark">Tầm nhìn, Sứ mệnh & Giá trị</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                [
                    'title' => 'Tầm nhìn',
                    'desc' => 'Trở thành nhà phân phối linh kiện điện tử, bán dẫn hàng đầu Việt Nam và mở rộng sang thị trường Đông Nam Á. Xây dựng hệ sinh thái cung ứng linh kiện điện tử hiện đại, tin cậy.',
                    'color' => 'from-blue-500 to-brand-dark',
                    'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
                ],
                [
                    'title' => 'Sứ mệnh',
                    'desc' => 'Cung cấp linh kiện điện tử chính hãng, chất lượng cao với giá cạnh tranh nhất. Hỗ trợ khách hàng tối ưu hóa chi phí sản xuất và nâng cao chất lượng sản phẩm.',
                    'color' => 'from-brand-accent to-red-700',
                    'icon' => 'M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9',
                ],
                [
                    'title' => 'Giá trị cốt lõi',
                    'desc' => 'Chất lượng — Uy tín — Chuyên nghiệp — Tận tâm. Mọi hoạt động của chúng tôi đều hướng đến sự hài lòng tối đa của khách hàng.',
                    'color' => 'from-green-500 to-teal-600',
                    'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
                ],
            ] as $item)
            <div class="rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-shadow">
                <div class="bg-gradient-to-br {{ $item['color'] }} p-6 text-white">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                    </div>
                    <h3 class="text-xl font-black">{{ $item['title'] }}</h3>
                </div>
                <div class="bg-white p-6">
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $item['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Contact CTA --}}
<section class="py-14 bg-gray-50 border-t border-gray-200">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-2xl font-black text-brand-dark mb-3">Hợp tác cùng Viam Semicon</h2>
        <p class="text-gray-500 text-base mb-8">Liên hệ với chúng tôi để nhận báo giá tốt nhất và tư vấn sản phẩm phù hợp cho doanh nghiệp của bạn.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-brand-main text-white font-bold rounded-xl hover:bg-brand-dark transition-colors shadow-md">
                Liên hệ ngay
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            <a href="tel:0986020896" class="inline-flex items-center gap-2 px-8 py-3.5 bg-brand-accent text-white font-bold rounded-xl hover:bg-red-700 transition-colors shadow-md">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                0986 020 896
            </a>
        </div>
    </div>
</section>

@push('styles')
<style>
    .prose-article h2 { color: #1a365d; font-size: 1.25rem; font-weight: 700; margin-top: 1.5em; margin-bottom: 0.5em; }
    .prose-article p { color: #374151; line-height: 1.8; margin-bottom: 1em; font-size: 0.9rem; }
    .prose-article ul { list-style-type: disc; padding-left: 1.5em; margin-bottom: 1em; }
    .prose-article li { color: #374151; margin-bottom: 0.4em; font-size: 0.9rem; }
</style>
@endpush

@endsection
