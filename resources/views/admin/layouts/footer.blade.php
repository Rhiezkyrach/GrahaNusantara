<div class="fixed z-50 w-full md:w-10/12 bottom-0 shadow-md bg-gradient-to-r from-stone-600 to-slate-600 py-2 px-6 ">

    <div class="flex flex-col items-center justify-between mx-auto xl:px-0 md:flex-row gap-2">
        <p class="text-xxs text-white text-center md:text-xs md:text-left">{!! $setting->copyright !!}<p>

        <div class="flex flex-row items-center gap-2">
            <span class="relative flex-col items-center hidden w-3 h-3 gap-2 md:flex">
                <span class="absolute inline-flex w-full h-full rounded-full opacity-75 animate-ping bg-sky-400"></span>
                <span class="relative inline-flex w-3 h-3 rounded-full bg-sky-500"></span>
            </span>
            <div class="flex flex-col md:flex-row items-center gap-2">
                <p class="-mt-3 text-xxs text-white md:mt-0 md:text-xs">Masuk Sebagai <span class="font-bold uppercase text-amber-400"><a href="{{ url('profile/' . Auth()->user()->id ) }}">{{ Auth()->user()->name }}</a></span></p>

                <form action="{{ url('/logout') }}" method="post">
                    @csrf
                    <button type="submit" class="hidden md:flex text-xs py-0.5 px-2 border border-white text-white hover:bg-red-600 hover:border-red-700 rounded">Log Out</button>
                </form>
            </div>
        </div>
    </div>

    <div type="hidden" class="bg-red-200 text-red-800"></div>
    <div type="hidden" class="bg-rose-200 text-rose-800"></div>
    <div type="hidden" class="bg-amber-200 text-amber-800"></div>
    <div type="hidden" class="bg-green-200 text-green-800"></div>
    <div type="hidden" class="bg-sky-200 text-sky-800"></div>

</div>