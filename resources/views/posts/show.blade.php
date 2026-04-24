@extends('layouts.app')

@section('seo')
    @php
        $seoTitle = $post->seo_title ?: $post->title;
        $seoDesc = $post->seo_description ?: strip_tags(Str::limit($post->excerpt ?: $post->content, 160));
        $ogImg = $post->image ? Storage::url($post->image) : null;
        $isRecruit = ($post->category_type ?? '') === 'tuyen-dung';

        $seoJsonld = \App\Helpers\SeoHelper::schema('article', [
                'title' => $seoTitle,
                'description' => $seoDesc,
                'image' => $ogImg ?? '',
                'published_at' => $post->published_at?->toIso8601String(),
                'updated_at' => $post->updated_at?->toIso8601String(),
            ])
            . \App\Helpers\SeoHelper::schema('breadcrumb', ['items' => [
                ['name' => 'Trang chủ', 'url' => url('/')],
                ['name' => $isRecruit ? 'Tuyển dụng' : 'Tin tức', 'url' => route($isRecruit ? 'recruitment' : 'posts.index')],
                ['name' => $post->title, 'url' => url()->current()],
            ]]);
    @endphp
    <x-seo
        :title="$seoTitle"
        :description="$seoDesc"
        og-type="article"
        :og-image="$ogImg"
        :jsonld="$seoJsonld"
    />
    <meta property="article:published_time" content="{{ $post->published_at?->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ $post->updated_at?->toIso8601String() }}">
@endsection

@push('styles')
<style>
    /* ===== POST SHOW STYLES ===== */

    /* Article prose */
    .prose-article {
        color: #374151;
        line-height: 1.85;
        font-size: 1rem;
    }
    .prose-article h1, .prose-article h2, .prose-article h3, .prose-article h4 {
        color: #0f2444;
        font-weight: 800;
        margin-top: 2.25em;
        margin-bottom: 0.875em;
        line-height: 1.3;
    }
    .prose-article h2 {
        font-size: 1.5rem;
        border-bottom: 2px solid #bfdbfe;
        padding-bottom: 0.5em;
    }
    .prose-article h3 { font-size: 1.2rem; }
    .prose-article h4 { font-size: 1.05rem; color: #1e40af; }
    .prose-article p { margin-bottom: 1.35em; }
    .prose-article ul, .prose-article ol { padding-left: 2em; margin-bottom: 1.35em; }
    .prose-article ul { list-style-type: disc; }
    .prose-article ol { list-style-type: decimal; }
    .prose-article li { margin-bottom: 0.5em; line-height: 1.75; }
    .prose-article a { color: #1a56db; text-decoration: underline; text-underline-offset: 2px; }
    .prose-article a:hover { color: #0f2444; }
    .prose-article img {
        max-width: 100%;
        border-radius: 12px;
        margin: 2em 0;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    .prose-article blockquote {
        border-left: 5px solid #1a56db;
        padding: 1em 1.5em;
        background: linear-gradient(to right, #eff6ff, #f0f9ff);
        margin: 2em 0;
        border-radius: 0 12px 12px 0;
    }
    .prose-article blockquote p {
        color: #1e40af;
        font-style: italic;
        margin: 0;
        font-weight: 600;
    }
    .prose-article table { width: 100%; border-collapse: collapse; margin: 2em 0; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
    .prose-article th {
        background: linear-gradient(135deg, #0f2444, #1a56db);
        color: white;
        padding: 12px 16px;
        text-align: left;
        font-weight: 700;
        font-size: 0.875rem;
    }
    .prose-article td { padding: 10px 16px; border-bottom: 1px solid #f1f5f9; font-size: 0.875rem; }
    .prose-article tr:nth-child(even) td { background: #f8fafc; }
    .prose-article tr:hover td { background: #eff6ff; }
    .prose-article strong { color: #0f2444; font-weight: 700; }
    .prose-article code {
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.875em;
        color: #dc2626;
        font-family: 'Fira Code', 'Courier New', monospace;
    }
    .prose-article pre {
        background: #0f2444;
        color: #e2e8f0;
        padding: 20px 24px;
        border-radius: 12px;
        overflow-x: auto;
        margin: 2em 0;
        font-size: 0.875rem;
    }
    .prose-article pre code { background: none; color: inherit; padding: 0; }

    /* Article meta bar */
    .article-meta-bar {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        font-size: 0.8125rem;
        color: #6b7280;
    }
    .article-meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Share buttons */
    .share-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 700;
        transition: all 0.2s;
    }
    .share-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }

    /* Sidebar */
    .sidebar-sticky {
        position: sticky;
        top: 90px;
    }

    /* Recent post item */
    .recent-post-item {
        display: flex;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
        border-radius: 8px;
        padding: 8px 10px;
        margin: 0 -10px;
    }
    .recent-post-item:last-child { border-bottom: none; }
    .recent-post-item:hover { background: #f8fafc; }
    .recent-post-img {
        width: 64px;
        height: 56px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
        background: #f1f5f9;
    }
    .recent-post-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    .recent-post-item:hover .recent-post-img img { transform: scale(1.08); }

    /* Table of contents */
    .toc-list {
        list-style: none;
        padding: 0;
        margin: 0;
        space-y: 2px;
    }
    .toc-list li a {
        display: block;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.8125rem;
        color: #374151;
        transition: all 0.15s;
        border-left: 3px solid transparent;
    }
    .toc-list li a:hover {
        background: #eff6ff;
        color: #1a56db;
        border-left-color: #1a56db;
    }

    /* Progress reading bar */
    #reading-progress {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(to right, #1a56db, #3b82f6, #dc2626);
        z-index: 9999;
        transition: width 0.1s;
        border-radius: 0 2px 2px 0;
    }
</style>
@endpush

@section('content')

@php
    $isRecruitment = isset($post->category_type) && $post->category_type === 'tuyen-dung';
    $breadcrumbs = [
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => $isRecruitment ? 'Tuyển dụng' : 'Tin tức', 'url' => route($isRecruitment ? 'recruitment' : 'posts.index')],
        ['label' => Str::limit($post->title, 50)],
    ];
    $postDate = $post->published_at ?? $post->created_at;
    $wordCount = str_word_count(strip_tags($post->content ?? ''));
    $readTime = max(1, round($wordCount / 200));
@endphp

{{-- Reading progress bar --}}
<div id="reading-progress" style="width: 0%;"></div>

@include('partials.breadcrumbs')

<div class="max-w-7xl mx-auto px-4 py-10 lg:py-14">
    <div class="flex flex-col lg:flex-row gap-10">

        {{-- ======================== MAIN ARTICLE ======================== --}}
        <article class="flex-1 min-w-0" id="article-content">

            {{-- Featured Image --}}
            @if($post->image)
            <div class="rounded-2xl overflow-hidden mb-8 shadow-lg" data-aos="fade-up">
                <img src="{{ Storage::url($post->image) }}"
                     alt="{{ $post->title }}"
                     class="w-full max-h-[500px] object-cover"
                     loading="eager">
            </div>
            @endif

            {{-- Article Header --}}
            <header class="mb-8" data-aos="fade-up" data-aos-delay="{{ $post->image ? '0' : '0' }}">
                {{-- Category + meta tags --}}
                <div class="article-meta-bar mb-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-full
                        {{ $isRecruitment ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-brand-main' }}">
                        @if($isRecruitment)
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
                            Tuyển dụng
                        @else
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/><path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"/></svg>
                            Tin tức
                        @endif
                    </span>

                    <span class="article-meta-item">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                        {{ $postDate->format('d/m/Y') }}
                    </span>

                    <span class="article-meta-item">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $readTime }} phút đọc
                    </span>

                    <span class="article-meta-item">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        {{ number_format($wordCount) }} từ
                    </span>
                </div>

                {{-- Title --}}
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 leading-tight mb-5">
                    {{ $post->title }}
                </h1>

                {{-- Excerpt / Lead --}}
                @if($post->excerpt)
                <div class="border-l-4 border-brand-main pl-5 py-1 bg-blue-50/60 rounded-r-xl mb-5">
                    <p class="text-gray-600 text-base sm:text-lg leading-relaxed italic">
                        {{ strip_tags($post->excerpt) }}
                    </p>
                </div>
                @endif

                {{-- Share Bar --}}
                <div class="flex items-center gap-3 flex-wrap pt-5 border-t border-gray-100">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Chia sẻ:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       target="_blank" rel="noopener"
                       class="share-btn text-white" style="background: #1877f2;">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        Facebook
                    </a>
                    <a href="https://zalo.me/0986020896"
                       target="_blank" rel="noopener"
                       class="share-btn text-white" style="background: #0068ff;">
                        Zalo
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}"
                       target="_blank" rel="noopener"
                       class="share-btn text-white" style="background: #000000;">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        X/Twitter
                    </a>
                    <button onclick="navigator.clipboard.writeText(window.location.href).then(() => { this.textContent = 'Đã sao chép!'; setTimeout(() => { this.innerHTML = '<svg class=\"w-3.5 h-3.5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z\"/></svg> Sao chép link'; }, 2000); })"
                       class="share-btn bg-gray-100 text-gray-600 hover:bg-gray-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Sao chép link
                    </button>
                </div>
            </header>

            {{-- Article Content --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 lg:p-10 prose-article mb-8"
                 data-aos="fade-up" data-aos-delay="50">
                {!! $post->content !!}
            </div>

            {{-- Tags / Bottom Share --}}
            <div class="bg-gray-50 rounded-2xl p-5 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Chia sẻ bài viết:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       target="_blank" rel="noopener"
                       class="share-btn text-white" style="background: #1877f2;">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        Facebook
                    </a>
                </div>
                <a href="{{ route($isRecruitment ? 'recruitment' : 'posts.index') }}"
                   class="inline-flex items-center gap-1.5 text-brand-main text-sm font-semibold hover:underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Quay lại danh sách bài viết
                </a>
            </div>

            {{-- Author Card --}}
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-5 sm:p-6 border border-blue-100 flex items-start gap-5 mb-8" data-aos="fade-up">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 text-white font-black text-xl"
                     style="background: linear-gradient(135deg, #0f2444, #1a56db);">
                    V
                </div>
                <div>
                    <p class="font-black text-brand-dark text-base">Viam Semicon</p>
                    <p class="text-sm text-gray-500 mt-1 leading-relaxed">Nhà phân phối chuyên nghiệp các thiết bị đo lường, robot vận chuyển, linh kiện điện tử và bán dẫn hàng đầu Việt Nam. Cam kết hàng chính hãng, giá tốt nhất.</p>
                    <div class="flex items-center gap-3 mt-3">
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center gap-1.5 text-brand-main text-xs font-bold hover:underline">
                            Liên hệ chúng tôi
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('products.index') }}"
                           class="inline-flex items-center gap-1.5 text-gray-500 text-xs font-semibold hover:text-brand-main transition-colors hover:underline">
                            Xem sản phẩm
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Related Posts --}}
            @if(isset($relatedPosts) && $relatedPosts->count() > 0)
            <section data-aos="fade-up">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-1.5 h-7 rounded-full" style="background: linear-gradient(to bottom, #1a56db, #3b82f6);"></div>
                    <h2 class="text-lg font-black text-brand-dark">Bài viết liên quan</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @foreach($relatedPosts as $related)
                    @php
                        $relatedDate = $related->published_at ?? $related->created_at;
                    @endphp
                    <a href="{{ route('posts.show', $related->slug) }}"
                       class="flex gap-4 bg-white border border-gray-100 rounded-xl p-4 hover:border-blue-200 hover:shadow-md transition-all group">
                        <div class="w-20 h-18 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100" style="min-height: 72px;">
                            @if($related->image)
                                <img src="{{ Storage::url($related->image) }}" alt="{{ $related->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy"
                                     style="min-height: 72px;">
                            @else
                                <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, #eff6ff, #dbeafe); min-height: 72px;">
                                    <svg class="w-7 h-7 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-gray-800 line-clamp-2 leading-snug group-hover:text-brand-main transition-colors">
                                {{ $related->title }}
                            </h3>
                            <p class="text-xs text-gray-400 mt-2">{{ $relatedDate->format('d/m/Y') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif
        </article>

        {{-- ======================== SIDEBAR ======================== --}}
        <aside class="lg:w-72 xl:w-80 flex-shrink-0">
            <div class="sidebar-sticky space-y-6">

                {{-- Recent Posts --}}
                @if(isset($recentPosts) && $recentPosts->count())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-left">
                    <div class="px-4 py-3.5 border-b border-gray-100 flex items-center gap-2">
                        <div class="w-1 h-5 rounded-full bg-brand-main"></div>
                        <h3 class="font-black text-brand-dark text-sm uppercase tracking-wide">Bài viết mới nhất</h3>
                    </div>
                    <div class="p-4 space-y-1">
                        @foreach($recentPosts as $recent)
                        @php $recentDate = $recent->published_at ?? $recent->created_at; @endphp
                        <a href="{{ route('posts.show', $recent->slug) }}" class="recent-post-item">
                            <div class="recent-post-img">
                                @if($recent->image)
                                    <img src="{{ Storage::url($recent->image) }}" alt="{{ $recent->title }}" loading="lazy">
                                @else
                                    <div class="w-full h-full" style="background: linear-gradient(135deg, #1a56db, #0f2444);"></div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-xs font-semibold text-gray-800 line-clamp-2 leading-snug group-hover:text-brand-main transition-colors">{{ $recent->title }}</h4>
                                <p class="text-xs text-gray-400 mt-1">{{ $recentDate->format('d/m/Y') }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Categories --}}
                @if(isset($postCategories) && is_countable($postCategories) && count($postCategories) > 0)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-left" data-aos-delay="80">
                    <div class="px-4 py-3.5 border-b border-gray-100 flex items-center gap-2">
                        <div class="w-1 h-5 rounded-full bg-brand-main"></div>
                        <h3 class="font-black text-brand-dark text-sm uppercase tracking-wide">Danh mục</h3>
                    </div>
                    <nav class="p-3 space-y-0.5">
                        @foreach($postCategories as $cat)
                        <a href="{{ route('posts.index') }}"
                           class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm transition-colors {{ request('type') === ($cat['slug'] ?? '') ? 'bg-brand-main text-white font-bold' : 'text-gray-700 hover:bg-gray-50 hover:text-brand-main' }}">
                            <span class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-current opacity-60"></span>
                                {{ $cat['name'] ?? '' }}
                            </span>
                            @if(isset($cat['count']))
                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ request('type') === ($cat['slug'] ?? '') ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500' }}">
                                {{ $cat['count'] }}
                            </span>
                            @endif
                        </a>
                        @endforeach
                    </nav>
                </div>
                @endif

                {{-- Contact CTA Card --}}
                <div class="rounded-2xl overflow-hidden shadow-md" data-aos="fade-left" data-aos-delay="120"
                     style="background: linear-gradient(135deg, #0f2444 0%, #1a3a6e 50%, #1a56db 100%);">
                    <div class="p-5 relative">
                        <div class="absolute top-0 right-0 w-24 h-24 rounded-full opacity-10"
                             style="background: white; transform: translate(40%, -40%);"></div>
                        <svg class="w-10 h-10 text-blue-300 mb-3 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <h3 class="font-black text-white text-base mb-2 relative z-10">Cần tư vấn?</h3>
                        <p class="text-blue-200 text-xs mb-4 leading-relaxed relative z-10">
                            Đội ngũ kỹ sư Viam Semicon sẵn sàng hỗ trợ bạn 24/7 về thiết bị và linh kiện.
                        </p>
                        <div class="space-y-2 relative z-10">
                            <a href="tel:0986020896"
                               class="flex items-center justify-center gap-2 py-2.5 text-white font-bold rounded-xl text-sm transition-all hover:shadow-lg"
                               style="background: linear-gradient(135deg, #dc2626, #ef4444);">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                                Gọi 0986 020 896
                            </a>
                            <a href="{{ route('contact') }}"
                               class="flex items-center justify-center gap-2 py-2.5 font-semibold rounded-xl text-sm transition-all hover:bg-white/25"
                               style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.25); color: white;">
                                Gửi tin nhắn
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Quick product link --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5" data-aos="fade-left" data-aos-delay="160">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Khám phá sản phẩm</p>
                    <a href="{{ route('products.index') }}"
                       class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white flex-shrink-0"
                             style="background: linear-gradient(135deg, #1a56db, #3b82f6);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <div>
                            <div class="font-bold text-gray-800 text-sm group-hover:text-brand-main transition-colors">Xem tất cả sản phẩm</div>
                            <div class="text-xs text-gray-500">500+ sản phẩm chính hãng</div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 ml-auto group-hover:text-brand-main group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

            </div>
        </aside>
    </div>
</div>

@push('scripts')
<script>
// Reading progress bar
(function() {
    var bar = document.getElementById('reading-progress');
    if (!bar) return;
    window.addEventListener('scroll', function() {
        var article = document.getElementById('article-content');
        if (!article) return;
        var scrollTop = window.scrollY;
        var articleTop = article.offsetTop;
        var articleHeight = article.offsetHeight;
        var windowHeight = window.innerHeight;
        var progress = Math.min(100, Math.max(0,
            ((scrollTop - articleTop + windowHeight * 0.3) / (articleHeight - windowHeight * 0.7)) * 100
        ));
        bar.style.width = progress + '%';
    }, { passive: true });
})();
</script>
@endpush

@endsection
