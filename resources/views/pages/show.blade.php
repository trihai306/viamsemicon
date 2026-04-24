@extends('layouts.app')

@section('seo')
    @php
        $seoTitle = $page->seo_title ?: $page->title;
        $seoDesc = $page->seo_description ?: strip_tags(Str::limit($page->content, 160));
        $seoJsonld = \App\Helpers\SeoHelper::schema('webpage', [
            'title' => $seoTitle,
            'description' => $seoDesc,
            'url' => url()->current(),
        ]);
    @endphp
    <x-seo
        :title="$seoTitle"
        :description="$seoDesc"
        :jsonld="$seoJsonld"
    />
@endsection

@section('content')

@php
    $breadcrumbs = [
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => $page->title],
    ];
@endphp

@include('partials.breadcrumbs')

{{-- Page Header --}}
<div class="bg-gradient-to-r from-brand-dark to-brand-main text-white py-10">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-2xl sm:text-3xl font-black">{{ $page->title }}</h1>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-12">
    <article class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-10">
        <div class="prose-article">
            {!! $page->content !!}
        </div>
    </article>

    {{-- CTA Strip --}}
    <div class="mt-10 bg-blue-50 rounded-2xl p-6 border border-blue-100 flex flex-col sm:flex-row items-center gap-4 justify-between">
        <div>
            <p class="font-bold text-brand-dark">Cần hỗ trợ thêm?</p>
            <p class="text-sm text-gray-500 mt-0.5">Liên hệ với chúng tôi để được tư vấn chi tiết.</p>
        </div>
        <div class="flex gap-3 flex-shrink-0">
            <a href="{{ route('contact') }}" class="px-5 py-2.5 bg-brand-main text-white rounded-xl font-semibold text-sm hover:bg-brand-dark transition-colors">Liên hệ</a>
            <a href="tel:0986020896" class="px-5 py-2.5 bg-brand-accent text-white rounded-xl font-semibold text-sm hover:bg-red-700 transition-colors">0986 020 896</a>
        </div>
    </div>
</div>

@push('styles')
<style>
    .prose-article h1, .prose-article h2, .prose-article h3, .prose-article h4 { color: #1a365d; font-weight: 700; margin-top: 1.75em; margin-bottom: 0.75em; }
    .prose-article h2 { font-size: 1.35rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.4em; }
    .prose-article h3 { font-size: 1.1rem; }
    .prose-article p { margin-bottom: 1.2em; line-height: 1.8; color: #374151; }
    .prose-article ul, .prose-article ol { padding-left: 1.75em; margin-bottom: 1.2em; }
    .prose-article ul { list-style-type: disc; }
    .prose-article ol { list-style-type: decimal; }
    .prose-article li { margin-bottom: 0.5em; line-height: 1.7; color: #374151; }
    .prose-article a { color: #2b6cb0; text-decoration: underline; }
    .prose-article img { max-width: 100%; border-radius: 0.75rem; margin: 1.5em 0; }
    .prose-article table { width: 100%; border-collapse: collapse; margin: 1.5em 0; font-size: 0.9rem; }
    .prose-article th { background: #1a365d; color: white; padding: 0.6em 1em; text-align: left; }
    .prose-article td { padding: 0.55em 1em; border: 1px solid #e2e8f0; }
    .prose-article tr:nth-child(even) td { background: #f7fafc; }
    .prose-article blockquote { border-left: 4px solid #2b6cb0; padding: 0.75em 1.25em; background: #eff6ff; margin: 1.5em 0; border-radius: 0 0.5rem 0.5rem 0; }
    .prose-article blockquote p { color: #1a365d; font-style: italic; margin: 0; }
    .prose-article strong { color: #1a202c; }
</style>
@endpush

@endsection
