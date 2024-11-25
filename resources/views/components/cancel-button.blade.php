<div class="flex w-full h-auto items-start justify-start">
    <button id="cancelSubmit" type="submit" class="relative my-2 rounded-lg px-5 py-2.5 overflow-hidden group bg-rose-500 hover:bg-gradient-to-r hover:from-rose-500 hover:to-rose-500 text-white hover:ring-2 hover:ring-offset-2 hover:ring-rose-500 transition-all ease-out duration-300">
        <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
        <div class="relative uppercase text-sm font-semibold"><i class="fa-duotone fa-xmark"></i> {{ $slot }}</div>
    </button>
</div>