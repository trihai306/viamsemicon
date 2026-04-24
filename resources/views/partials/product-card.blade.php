{{--
    Premium Product Card Component
    Variables:
    - $product: App\Models\Product instance
    - $size (optional): 'sm' | 'md' (default: 'md')
--}}
@php $size = $size ?? 'md'; @endphp

<article class="product-card group relative bg-white rounded-xl overflow-hidden flex flex-col"
    style="transition: all 0.3s ease; border: 1px solid #f1f5f9; box-shadow: 0 1px 4px rgba(0,0,0,0.06);"
    onmouseenter="this.style.transform='translateY(-4px)';this.style.boxShadow='0 20px 40px rgba(0,0,0,0.08)';this.style.borderColor='#fbbf24'"
    onmouseleave="this.style.transform='';this.style.boxShadow='0 1px 4px rgba(0,0,0,0.06)';this.style.borderColor='#f1f5f9'">

    {{-- Product Image Area --}}
    <a href="{{ url('/san-pham/' . $product->slug) }}"
       class="block relative bg-white flex-shrink-0"
       style="aspect-ratio: 1/1; overflow: hidden;">

        {{-- White bg image wrapper --}}
        <div class="w-full h-full flex items-center justify-center p-3">
            @if($product->image)
                <img
                    src="{{ Storage::url($product->image) }}"
                    alt="{{ $product->name }}"
                    loading="lazy"
                    class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105"
                    style="max-height: 180px;"
                >
            @else
                {{-- Placeholder --}}
                <div class="w-full h-full flex flex-col items-center justify-center"
                     style="background: linear-gradient(135deg, #fffbeb, #fef3c7); min-height: 120px;">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-2"
                         style="background: linear-gradient(135deg, rgba(245,158,11,0.2), rgba(217,119,6,0.15));">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-amber-400/70">Viam Semicon</span>
                </div>
            @endif
        </div>

        {{-- Hover overlay with CTA --}}
        <div class="absolute inset-0 flex items-end justify-center pb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
             style="background: linear-gradient(to top, rgba(26,54,93,0.7) 0%, transparent 60%);">
            <span class="px-4 py-1.5 bg-amber-400 text-white text-xs font-bold rounded-full shadow-md flex items-center gap-1.5 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Xem chi tiết
            </span>
        </div>

        {{-- Featured badge (top-left, red) --}}
        @if($product->is_featured)
        <div class="absolute top-2 left-2 z-10">
            <span class="inline-flex items-center gap-0.5 px-2 py-0.5 text-xs font-bold text-white rounded-md shadow"
                  style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Nổi bật
            </span>
        </div>
        @endif

        {{-- Category badge (top-right, amber) --}}
        @if($product->category && $size !== 'sm')
        <div class="absolute top-2 right-2 z-10">
            <span class="px-2 py-0.5 text-xs font-semibold rounded-md truncate max-w-[80px] block"
                  style="background: rgba(245,158,11,0.15); color: #b45309; border: 1px solid rgba(245,158,11,0.3);">
                {{ Str::limit($product->category->name, 10) }}
            </span>
        </div>
        @endif
    </a>

    {{-- Product Info --}}
    <div class="p-3 flex flex-col flex-1">
        {{-- Category label for sm size --}}
        @if($product->category && $size === 'sm')
        <span class="text-xs font-semibold mb-1 truncate" style="color: #d97706;">{{ $product->category->name }}</span>
        @endif

        {{-- Product Name --}}
        <a href="{{ url('/san-pham/' . $product->slug) }}"
           class="font-bold text-gray-800 line-clamp-2 leading-snug text-sm mb-1 group-hover:text-blue-700 transition-colors"
           style="min-height: 2.4rem;">
            {{ $product->name }}
        </a>

        {{-- Short description --}}
        @if($product->short_description && $size !== 'sm')
        <p class="text-xs text-gray-400 mt-1 line-clamp-2 leading-relaxed flex-1">{{ Str::limit(strip_tags($product->short_description), 80) }}</p>
        @else
        <div class="flex-1"></div>
        @endif

        {{-- Price & CTA --}}
        <div class="flex items-center justify-between mt-2.5 pt-2.5 gap-2" style="border-top: 1px solid #f1f5f9;">
            <div class="min-w-0">
                @if($product->price)
                    <span class="font-black text-base leading-none" style="color: #f59e0b;">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                @elseif($product->price_text)
                    <span class="font-bold text-sm" style="color: #f59e0b;">{{ $product->price_text }}</span>
                @else
                    <div>
                        <span class="font-bold text-xs block leading-none" style="color: #f59e0b;">Liên hệ</span>
                        <span class="text-xs text-gray-400">báo giá</span>
                    </div>
                @endif
            </div>
            <a href="{{ url('/san-pham/' . $product->slug) }}"
               class="flex-shrink-0 px-3 py-1.5 text-white text-xs font-bold rounded-lg transition-all hover:opacity-90"
               style="background: linear-gradient(135deg, #1a365d, #2563eb);">
                Chi tiết →
            </a>
        </div>
    </div>
</article>
