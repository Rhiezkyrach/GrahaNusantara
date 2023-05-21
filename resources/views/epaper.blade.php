@extends('layouts.main_large')

@section('main_section')

{{-- ePaper --}}
<div class="flex flex-col w-full h-auto">
    <div class="text-xxs font-semibold"><a href="/">Home</a> / </span class="text-red-600"> <a href="/epaper/{{ $epaper->id }}/{{ $epaper->edisi }}">ePaper</a></span></div>
    <div class="text-2xl lg:text-4xl font-bold my-3 leading-snug">ePaper TangselPos</div>
    <div class="text-sm md:text-lg font-bold -mt-1 mb-3 leading-snug text-gray-700">Edisi {{ Carbon\Carbon::parse($epaper->edisi)->translatedFormat('l, d F Y') }}</div>

    <div class="bg-gray-200 w-full">
        <div class="epaper h-[560px] 2xl:h-[640px]"></div>
    </div>
</div>
{{-- /ePaper --}}

{{-- Edisi Sebelumnya --}}
@if($prevEpaper->count())
<div class="mt-7 w-full h-auto">
    <div class="text-2xl 2xl:text-3xl font-semibold mb-2">Edisi Sebelumnya</div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4">
        @foreach($prevEpaper as $pE)
        <div class="w-full flex flex-col border border-gray-300 rounded-md">
            <div class="w-full h-auto p-3 rounded-md overflow-hidden">
                <a href="/epaper/{{ $pE->slug }}">
                    <img class="w-full object-cover" src="{{ asset('thumbnail/' . $pE->cover) }}" alt="ePaper {{ $setting->judul_situs }}">
                </a>
                <div class="mt-4 text-xxs lg:text-xs font-semibold text-center">Edisi {{ Carbon\Carbon::parse($pE->edisi)->translatedFormat('l, d F Y') }}</div>
                <a href="/epaper/{{ $pE->slug }}">
                    <div class="mt-2 w-full md:w-auto text-white font-semibold text-center bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-md">Baca</div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
{{-- /Edisi Sebelumnya --}}

<script src="{{ asset('plugin/flippdf/3d-flip-book/js/libs/html2canvas.min.js') }}"></script>
<script src="{{ asset('plugin/flippdf/3d-flip-book/js/libs/three.min.js') }}"></script>
<script src="{{ asset('plugin/flippdf/3d-flip-book/js/libs/pdf.min.js') }}"></script>

<script type="text/javascript">
    window.PDFJS_LOCALE = {
    pdfJsWorker: '{{ asset('plugin/flippdf/3d-flip-book/js/pdf.worker.js') }}',
    pdfJsCMapUrl: 'cmaps'
    };
</script>

<script src="{{ asset('plugin/flippdf/3d-flip-book/js/dist/3dflipbook.min.js') }}"></script>

<script>
    var options = {
        pdf: '{{ asset('storage/' . $epaper->pdf) }}',

        propertiesCallback: function(props) {
            props.sheet.widthTexels = 7*210;
            props.sheet.heightTexels = 7*297;
            return props;
        },
    
        template: { // by means this property you can choose appropriate skin
            html: "{{ asset('plugin/flippdf/3d-flip-book/templates/default-book-view.html') }}",
            styles: [
                "{{ asset('plugin/flippdf/3d-flip-book/css/black-book-view.css') }}"// or one of white-book-view.css, short-white-book-view.css, shart-black-book-view.css
            ],
            links: [{
                rel: 'stylesheet',
                href: "{{ asset('plugin/flippdf/3d-flip-book/css/font-awesome.min.css')}}"
            }],
            script: "{{ asset('plugin/flippdf/3d-flip-book/js/default-book-view.js') }}",
            printStyle: undefined, // or you can set your stylesheet for printing ('print-style.css')
            sounds: {
                startFlip: "{{ asset('plugin/flippdf/3d-flip-book/sounds/start-flip.mp3') }}",
                endFlip: "{{ asset('plugin/flippdf/3d-flip-book/sounds/end-flip.mp3') }}"
            }
        },

        controlsProps: {
            downloadURL: '{{ asset('storage/' . $epaper->pdf) }}',
            scale: {
                max: 5,
                levels: 10
            }
        }

    };

    var book = $('.epaper').FlipBook(options);
</script>

@endsection