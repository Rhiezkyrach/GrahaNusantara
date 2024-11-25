<div class="flex w-full h-auto items-end justify-end">
    <button id="formSubmit" type="submit" class="relative my-2 rounded-lg px-5 py-2.5 overflow-hidden group bg-green-600 hover:bg-gradient-to-r hover:from-green-600 hover:to-green-500 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-500 transition-all ease-out duration-300">
        <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
        <div id="process" class="relative uppercase text-sm font-semibold"><i class="fa-duotone fa-floppy-disk"></i> {{ $slot }}</div>
        <div id="processing" class="hidden relative font-semibold text-sm uppercase"><i class="fa-regular fa-circle-notch animate-spin"></i> MEMPROSES</div>
    </button>
</div>