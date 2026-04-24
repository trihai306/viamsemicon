@extends('layouts.app')

@section('seo')
    @php
        $seoTitle = $pageTitle ?? 'Tin tức';
        $seoDesc = 'Tin tức, kiến thức và cập nhật mới nhất từ Viam Semicon về linh kiện điện tử, bán dẫn và công nghệ đo lường.';
        $seoJsonld = \App\Helpers\SeoHelper::schema('breadcrumb', ['items' => [
            ['name' => 'Trang chủ', 'url' => url('/')],
            ['name' => $seoTitle, 'url' => url()->current()],
        ]]);
    @endphp
    <x-seo
        :title="$seoTitle"
        :description="$seoDesc"
        :jsonld="$seoJsonld"
    />
@endsection

@push('styles')
<style>
    /* ===== POSTS INDEX PAGE STYLES ===== */

    /* Hero */
    .posts-hero {
        background: linear-gradient(135deg, #0f2444 0%, #1a3a6e 45%, #1a56db 85%, #3b82f6 100%);
        position: relative;
        overflow: hidden;
    }
    .posts-hero-pattern {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,0.05) 1px, transparent 1px);
        background-size: 30px 30px;
    }

    /* Post card */
    .post-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s cubic-bezier(0.25,0.46,0.45,0.94), box-shadow 0.3s, border-color 0.3s;
    }
    .post-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.10);
        border-color: #bfdbfe;
    }

    /* Image area */
    .post-card-image {
        position: relative;
        height: 220px;
        overflow: hidden;
        flex-shrink: 0;
        background: #f8fafc;
    }
    .post-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.25,0.46,0.45,0.94);
    }
    .post-card:hover .post-card-image img {
        transform: scale(1.08);
    }

    /* Date overlay badge */
    .post-date-badge {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: rgba(15, 36, 68, 0.85);
        backdrop-filter: blur(8px);
        border-radius: 10px;
        padding: 5px 10px;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.7rem;
        color: rgba(255,255,255,0.9);
        font-weight: 600;
    }

    /* Category badge on image */
    .post-cat-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        backdrop-filter: blur(8px);
    }

    /* Reading time badge */
    .post-readtime-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(8px);
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 0.7rem;
        font-weight: 700;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Hover overlay */
    .post-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15,36,68,0.7) 0%, transparent 60%);
        opacity: 0;
        transition: opacity 0.35s;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding-bottom: 20px;
    }
    .post-card:hover .post-card-overlay {
        opacity: 1;
    }
    .post-card-overlay span {
        background: white;
        color: #0f2444;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 6px 16px;
        border-radius: 20px;
        transform: translateY(8px);
        transition: transform 0.3s;
    }
    .post-card:hover .post-card-overlay span {
        transform: translateY(0);
    }

    /* Featured first post */
    .post-card-featured {
        grid-column: 1 / -1;
    }
    @media (min-width: 1024px) {
        .post-card-featured .post-card-image {
            height: 360px;
        }
        .post-card-featured {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        .post-card-featured .post-card-image {
            height: 100%;
            min-height: 320px;
        }
    }

    /* Pagination */
    .pagination-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border-radius: 10px;
        border: 1.5px solid #e5e7eb;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        transition: all 0.2s;
        gap: 4px;
    }
    .pagination-btn:hover {
        border-color: #1a56db;
        color: #1a56db;
        background: #eff6ff;
    }
    .pagination-btn.active {
        background: linear-gradient(135deg, #1a56db, #3b82f6);
        border-color: transparent;
        color: white;
        box-shadow: 0 4px 12px rgba(26,86,219,0.3);
    }
    .pagination-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }
</style>
@endpush

@section('content')

@php
    $pageTitle = $pageTitle ?? 'Tin tức';
    $isRecruitment = request()->routeIs('recruitment*');

    $breadcrumbs = [
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => $pageTitle],
    ];
@endphp

@include('partials.breadcrumbs')

{{-- ======================== HERO BANNER ======================== --}}
<section class="posts-hero py-14 sm:py-20">
    <div class="posts-hero-pattern"></div>
    <div class="max-w-7xl mx-auto px-4 relative z-10 text-center text-white">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-xs font-semibold mb-5"
             data-aos="fade-down">
            @if($isRecruitment)
            <svg class="w-3.5 h-3.5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
            Cơ hội nghề nghiệp
            @else
            <svg class="w-3.5 h-3.5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/><path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"/></svg>
            Kiến thức & Công nghệ
            @endif
        </div>

        <h1 class="text-3xl sm:text-5xl font-black mb-4 leading-tight" data-aos="fade-up">
            {{ $pageTitle }}
        </h1>
        <p class="text-blue-100 text-sm sm:text-lg max-w-xl mx-auto" data-aos="fade-up" data-aos-delay="80">
            @if($isRecruitment)
                Cơ hội nghề nghiệp tại Viam Semicon — Cùng chúng tôi phát triển và đổi mới
            @else
                Cập nhật tin tức, kiến thức chuyên sâu về linh kiện điện tử, bán dẫn và công nghệ đo lường
            @endif
        </p>

        @if($posts->total() > 0)
        <div class="mt-5 text-blue-300 text-sm" data-aos="fade-up" data-aos-delay="120">
            {{ $posts->total() }} bài viết
        </div>
        @endif
    </div>
</section>

{{-- Wave --}}
<div style="margin-top: -2px; line-height: 0; background: #0f2444;">
    <svg viewBox="0 0 1440 48" preserveAspectRatio="none" style="width:100%;height:48px;display:block;" fill="white" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,0 L1440,0 L1440,48 C1200,8 960,0 720,20 C480,40 240,48 0,28 L0,0 Z"/>
    </svg>
</div>

{{-- ======================== POSTS GRID ======================== --}}
<div class="max-w-7xl mx-auto px-4 py-12 lg:py-16">

    @forelse($posts as $post)
        @php
            $wordCount = str_word_count(strip_tags($post->content ?? ''));
            $readTime = max(1, round($wordCount / 200));
            $postDate = $post->published_at ?? $post->created_at;
        @endphp

        @if($loop->first)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @endif

        {{-- First post gets featured layout --}}
        @if($loop->first && $posts->currentPage() === 1)
        <div class="post-card-featured sm:col-span-2 lg:col-span-3" data-aos="fade-up">
            <div class="post-card" style="display: grid; grid-template-columns: 1fr 1fr;">
                {{-- Image --}}
                <div class="post-card-image" style="height: auto; min-height: 280px;">
                    @if($post->image)
                        <a href="{{ route('posts.show', $post->slug) }}">
                            <img src="{{ Storage::url($post->image) }}"
                                 alt="{{ $post->title }}"
                                 loading="eager">
                        </a>
                    @else
                        <a href="{{ route('posts.show', $post->slug) }}"
                           class="w-full h-full flex items-center justify-center"
                           style="background: linear-gradient(135deg, #0f2444, #1a56db);">
                            <svg class="w-20 h-20 text-white opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Badges --}}
                    <div class="post-cat-badge {{ $isRecruitment ? 'bg-green-500/80 text-white' : 'bg-blue-600/80 text-white' }}">
                        {{ $isRecruitment ? 'Tuyển dụng' : 'Nổi bật' }}
                    </div>
                    <div class="post-readtime-badge">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $readTime }} phút đọc
                    </div>
                    <div class="post-date-badge">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                        {{ $postDate->format('d/m/Y') }}
                    </div>
                    <div class="post-card-overlay"><span>Đọc ngay →</span></div>
                </div>

                {{-- Content --}}
                <div class="p-6 lg:p-8 flex flex-col justify-center">
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full mb-4 {{ $isRecruitment ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-brand-main' }}">
                        {{ $isRecruitment ? 'Tuyển dụng' : 'Tin tức nổi bật' }}
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-gray-900 leading-tight mb-4 group-hover:text-brand-main line-clamp-3">
                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-brand-main transition-colors">
                            {{ $post->title }}
                        </a>
                    </h2>
                    @if($post->excerpt)
                    <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-4">{{ strip_tags($post->excerpt) }}</p>
                    @endif
                    <a href="{{ route('posts.show', $post->slug) }}"
                       class="inline-flex items-center gap-2 px-6 py-3 text-white font-bold rounded-xl text-sm self-start transition-all hover:shadow-lg hover:-translate-y-0.5"
                       style="background: linear-gradient(135deg, #1a56db, #3b82f6);">
                        {{ $isRecruitment ? 'Xem chi tiết' : 'Đọc bài viết' }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>

        @else
        {{-- Regular post card --}}
        <div data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 80 }}">
            <div class="post-card h-full">
                {{-- Image --}}
                <div class="post-card-image">
                    @if($post->image)
                        <a href="{{ route('posts.show', $post->slug) }}">
                            <img src="{{ Storage::url($post->image) }}"
                                 alt="{{ $post->title }}"
                                 loading="lazy">
                        </a>
                    @else
                        <a href="{{ route('posts.show', $post->slug) }}"
                           class="w-full h-full flex items-center justify-center"
                           style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                            @if($isRecruitment)
                            <svg class="w-12 h-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            @else
                            <svg class="w-12 h-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            @endif
                        </a>
                    @endif

                    {{-- Date overlay --}}
                    <div class="post-date-badge">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                        {{ $postDate->format('d/m/Y') }}
                    </div>

                    {{-- Category badge --}}
                    <div class="post-cat-badge {{ $isRecruitment ? 'bg-green-500/80 text-white' : 'bg-blue-600/80 text-white' }}">
                        {{ $isRecruitment ? 'Tuyển dụng' : 'Tin tức' }}
                    </div>

                    {{-- Reading time --}}
                    <div class="post-readtime-badge">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $readTime }} phút
                    </div>

                    {{-- Hover overlay --}}
                    <a href="{{ route('posts.show', $post->slug) }}" class="post-card-overlay">
                        <span>Đọc ngay →</span>
                    </a>
                </div>

                {{-- Card body --}}
                <div class="p-5 flex flex-col flex-1">
                    <h2 class="font-bold text-gray-800 text-sm leading-snug mb-3 line-clamp-2 flex-1">
                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-brand-main transition-colors">
                            {{ $post->title }}
                        </a>
                    </h2>

                    @if($post->excerpt)
                    <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-4">{{ strip_tags($post->excerpt) }}</p>
                    @endif

                    <div class="mt-auto pt-3 border-t border-gray-50 flex items-center justify-between">
                        <a href="{{ route('posts.show', $post->slug) }}"
                           class="inline-flex items-center gap-1.5 text-brand-main text-xs font-bold hover:gap-3 transition-all">
                            {{ $isRecruitment ? 'Xem chi tiết' : 'Đọc tiếp' }}
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <span class="text-xs text-gray-400">{{ $postDate->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($loop->last)
        </div>
        @endif

    @empty
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <div class="w-24 h-24 rounded-full flex items-center justify-center mb-6"
                 style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                <svg class="w-12 h-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <p class="text-gray-600 font-bold text-xl mb-2">Chưa có bài viết nào</p>
            <p class="text-gray-400 text-sm mb-6">Vui lòng quay lại sau để xem nội dung mới nhất.</p>
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 px-6 py-3 text-white font-bold rounded-xl text-sm"
               style="background: linear-gradient(135deg, #1a56db, #3b82f6);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Về trang chủ
            </a>
        </div>
    @endforelse

    {{-- ======================== PAGINATION ======================== --}}
    @if($posts->hasPages())
    <div class="mt-14 flex justify-center">
        <nav class="flex items-center gap-2" aria-label="Phân trang">
            {{-- Prev --}}
            @if($posts->onFirstPage())
                <span class="pagination-btn disabled">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </span>
            @else
                <a href="{{ $posts->previousPageUrl() }}" class="pagination-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach($posts->getUrlRange(max(1, $posts->currentPage() - 2), min($posts->lastPage(), $posts->currentPage() + 2)) as $page => $url)
                @if($page === $posts->currentPage())
                    <span class="pagination-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($posts->hasMorePages())
                <a href="{{ $posts->nextPageUrl() }}" class="pagination-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span class="pagination-btn disabled">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif
        </nav>
    </div>
    @endif

</div>

@endsection
