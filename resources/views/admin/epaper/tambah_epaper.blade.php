<form id="forms" method="post" action="/admin/epaper" enctype="multipart/form-data">
    @csrf

    <div class="w-full h-auto px-2 py-2 border border-green-500 rounded-md itemrow bg-green-100/25">
      <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-green-500 text-white">TAMBAH E-PAPER</span></div>

      <div class="grid grid-cols-1 gap-2">

        {{-- EDISI --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputedisi"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">EDISI</span></label>
            <input type="date" id="inputedisi" name="edisi" class="main_input_md"
                value="{{ old('edisi', Carbon\Carbon::now()->translatedFormat('Y-m-d')) }}" auto-complete="off" required>
        </div>

        {{-- COVER --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputcover"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">COVER</span></label>
            <div class="flex w-full h-60 mb-0.5 p-2 overflow-hidden rounded-md">
                <img class="object-cover w-full h-full cover-preview rounded" src="{{ asset('images/img-default.png') }}" alt="">
            </div>
            <input name="cover" id="inputcover" type="file" class="w-full file-input file-input-bordered" accept="image/*" required>
            @error('cover') <div class="text-xs text-red-600">{{ $message }}</div>@enderror
        </div>

        {{-- PDF --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputpdf"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">PDF</span></label>
            <input name="pdf" id="inputpdf" type="file" class="w-full main_file_input_md" accept="application/pdf" required>
        </div>

      </div>

    </div>

    <x-close-modal-button>
        <x-slot:submit></x-slot:submit>
    </x-close-modal-button>
</form>
