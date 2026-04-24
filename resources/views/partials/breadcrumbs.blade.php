@php
    $crumbs = $items ?? $breadcrumbs ?? [];
@endphp

@if(count($crumbs) > 0)
<nav class="bg-gray-100 border-b border-gray-200" aria-label="Breadcrumb">
    <div class="max-w-7xl mx-auto px-4 py-2.5">
        <ol class="flex flex-wrap items-center gap-1.5 text-sm text-gray-500">
            @foreach($crumbs as $crumb)
                @php
                    $label = $crumb['label'] ?? $crumb['name'] ?? '';
                    $url = $crumb['url'] ?? null;
                @endphp
                @if($loop->last)
                    <li class="flex items-center gap-1.5" aria-current="page">
                        @if(!$loop->first)
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        @endif
                        <span class="text-brand-dark font-medium truncate max-w-xs">{{ $label }}</span>
                    </li>
                @else
                    <li class="flex items-center gap-1.5">
                        @if(!$loop->first)
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        @endif
                        @if($url)
                            <a href="{{ $url }}" class="hover:text-brand-main transition-colors flex items-center gap-1">
                                @if($loop->first)
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                                @endif
                                {{ $label }}
                            </a>
                        @else
                            <span>{{ $label }}</span>
                        @endif
                    </li>
                @endif
            @endforeach
        </ol>
    </div>
</nav>
@endif
