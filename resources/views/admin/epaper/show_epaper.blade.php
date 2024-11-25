<div class="w-full h-auto px-2 py-2 border border-blue-500 rounded-md itemrow bg-blue-100/25">
    <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-blue-500 text-white">DETAIL E-PAPER</span></div>

    <div class="grid grid-cols-1 gap-2">

    {{-- EDISI --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputedisi"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">EDISI</span></label>
        <input type="date" id="inputedisi" name="edisi" class="main_input_md"
            value="{{ old('edisi', Carbon\Carbon::parse($epaper->edisi)->translatedFormat('Y-m-d')) }}" auto-complete="off" required>
    </div>

    {{-- COVER --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputcover"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">COVER</span></label>
        <div class="flex w-full h-60 mb-2 p-2 overflow-hidden rounded-md">
                @if($epaper->cover)
                <input name="coverLama" type="file" class="hidden" value="{{ $epaper->cover }}">
                <img src="{{ asset('storage/'. $epaper->cover) }}" class="cover-preview w-full h-full my-auto object-cover overflow-hidden rounded">
            @else
                <img class="object-cover w-full h-full cover-preview rounded" src="{{ asset('images/img-default.png') }}" alt="">
            @endif
        </div>
        <input name="cover" id="inputcover" type="file" class="w-full file-input file-input-bordered" accept="image/*">
    </div>

    {{-- PDF --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputpdf"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">PDF</span></label>
        <input name="pdf" id="inputpdf" type="file" class="w-full main_file_input_md" accept="application/pdf" required>
    </div>

    </div>

</div>

<x-close-modal-button/>
