@props(['title', 'active' => false])

@php
    $isActive = false;
    // Logic cek active state support wildcard (*)
    $patterns = explode('|', $active);
    foreach ($patterns as $pattern) {
        if (request()->is($pattern)) {
            $isActive = true;
            break;
        }
    }
@endphp

<div x-data="{ open: false }" class="relative group h-full flex items-center" @mouseleave="open = false">
    <button @mouseover="open = true"
        class="px-4 py-2 rounded-full hover:bg-white/10 transition duration-300 flex items-center gap-1 outline-none {{ $isActive ? 'text-unmaris-yellow bg-white/10 font-bold' : 'text-white hover:text-unmaris-yellow' }}">
        {{ $title }}
        <svg class="h-3 w-3 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="absolute left-1/2 transform -translate-x-1/2 top-full pt-2 z-50">

        <div class="bg-white rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 overflow-hidden text-left">
            {{ $content }}
        </div>
    </div>
</div>
