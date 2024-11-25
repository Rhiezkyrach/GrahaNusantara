<div class="mt-3 pb-2 flex flex-row gap-2.5 float-right">

    <button onclick="event.preventDefault(); $('#modal-container, #modal-container2, #modal-container-allocate, #createNew, #infoData, #editData, #createQUO').prop('checked',false);" 
            class="closeForm relative rounded-lg px-5 py-2.5 overflow-hidden group bg-stone-700 hover:bg-gradient-to-r hover:from-stone-700 hover:to-stone-600 text-white hover:ring-2 hover:ring-offset-2 hover:ring-stone-600 transition-all ease-out duration-300">
        <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
        <span class="relative uppercase text-sm font-semibold whitespace-nowrap"><i class="fa-duotone fa-xmark"></i> Tutup</span>
    </button>

    @isset($submit)
    <button id="formSubmit" type="submit" class="relative rounded-lg px-5 py-2.5 overflow-hidden group bg-green-600 hover:bg-gradient-to-r hover:from-green-600 hover:to-green-500 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-500 transition-all ease-out duration-300">
        <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
        <div id="process" class="process relative uppercase text-sm font-semibold whitespace-nowrap"><i class="fa-duotone fa-floppy-disk"></i> Simpan</div>
        <div id="processing" class="processing hidden relative font-semibold text-sm uppercase"><i class="fa-regular fa-circle-notch animate-spin"></i> MEMPROSES</div>
    </button>
    @endisset
</div>
