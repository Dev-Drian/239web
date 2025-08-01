@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 border-b-2 border-blue-500 text-sm font-medium leading-5 text-blue-600 focus:outline-none focus:border-blue-700 transition duration-150 ease-in-out bg-blue-50/10 rounded-t-lg'
            : 'inline-flex items-center px-3 py-2 border-b-2 border-transparent text-sm font-medium leading-5 text-slate-400 hover:text-slate-200 hover:border-slate-300 focus:outline-none focus:text-slate-200 focus:border-slate-300 transition duration-150 ease-in-out hover:bg-white/5 rounded-t-lg';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>