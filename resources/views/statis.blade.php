@extends('layouts.main')

@section('main_section')

{{-- Statis --}}
<div class="flex flex-col w-full h-auto">
<div class="text-xxs dark:text-gray-200 font-semibold"><a href="/">Home</a> / </span class="text-red-600"> <a href="/statis/{{ $statis->slug }}">{{ $statis->judul }}</a></span></div>
<div class="text-2xl md:text-3xl dark:text-white font-bold mt-3 text-center leading-snug">{{ $statis->judul }}</div>
<div class="flex w-full my-2 h-0.5 bg-gray-200"></div>

<div class="mt-2 text-base dark:text-white leading-relaxed space-y-5">{!! $statis->isi !!}</div>

<div class="flex w-full my-5 h-0.5 bg-gray-200"></div>

</div>
{{-- /Statis --}}

@endsection