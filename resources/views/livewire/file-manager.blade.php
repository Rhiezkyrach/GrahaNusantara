<div>

    @if(!Request::is(['admin/media', 'admin/media/*']))
        <label class="w-full btn bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl text-white" for="inputgambar_detail"><i class="fa-duotone fa-upload"></i> UPLOAD GAMBAR</label>
    @endif
                  
    <div class="mt-4 w-full h-auto px-2 py-2 border border-slate-500 rounded-md itemrow bg-slate-50">
      <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-slate-500 text-white">FILE MANAGER</span></div>

        {{-- LIST FOTO --}}
        {{-- SEARCH --}}
        <div class="mb-2 px-2">   
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" id="default-search" wire:model.live="search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-400 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari Foto..." autofocus>
            </div>
        </div>
        {{-- END:SEARCH --}}

        <div class="w-full p-2 rounded">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5">
                @forelse($items as $d)
                    <div wire:key="item-{{ $d->id_berita }}" class="relative bg-base-200 border border-gray-300 rounded-lg hover:scale-105 duration-200 shadow overflow-hidden">
                        {{-- <div class="absolute top-0 left-0 bg-rose-500 text-white text-xxs px-2 py-1 rounded-br-md">{{ $d->FinishGood->FinishGoodProductGroup ? $d->FinishGood->FinishGoodProductGroup->description : ''}}</div> --}}
                        {{-- <div class="absolute top-0 left-0 bg-rose-500 text-white text-xxs px-2 py-1 rounded-br-md">{{ $d->finish_good}}</div> --}}
                        
                        {{-- <div class="z-50 absolute px-2 py-1 top-0 right-0 dropdown dropdown-bottom dropdown-end">
                            <div tabindex="0" role="button" class="btn btn-xs btn-warning m-1 rounded-sm"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-1 shadow bg-base-200 rounded-md w-32 mr-2">
                                <li data-id="{{ $d->finish_good}}" id="viewFinishgood" class="viewFinishgood text-xs hover:bg-slate-300 cursor-pointer"><span class="whitespace-nowrap"><i class="fa-duotone fa-eye"></i> VIEW</span></li>
                                <li data-id="{{ $d->finish_good}}" id="editFinishgood" class="editFinishgood text-xs hover:bg-slate-300 cursor-pointer"><span class="whitespace-nowrap"><i class="fa-duotone fa-pen-to-square"></i> EDIT</span></li>
                            </ul>
                        </div> --}}
                        
                        <a href="{{ asset('storage/' . $d->gambar_detail) }}" target="_balnk" class="productImage">
                            <img class="w-full h-20 lg:h-32 object-cover rounded-t-lg shadow-sm" src="{{ $d->gambar_detail && Storage::exists($d->gambar_detail) ? asset('storage/' . $d->gambar_detail) : asset('images/img-default.png') }}" alt="{{ $d->judul }}" title="{{ $d->judul }}"/>
                        </a>
                        <div class="p-3 flex flex-col justify-between">
                            <p class="mb-2 text-xxs text-gray-700">{{ Str::words($d->judul, 8) }}</p>

                            @if(!Request::is(['admin/media', 'admin/media/*']))
                            <div data-id="{{ $d->id_berita }}" data-gambar="{{ $d->gambar_detail }}" data-judul="{{ $d->judul  }}"
                                class="selectimage group w-full px-2 py-1 text-sm font-medium text-center text-white whitespace-nowrap cursor-pointer bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-md">
                                Pilih <i class="fa-duotone fa-arrow-right group-hover:ml-2 duration-200"></i>
                            </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="mt-2 text-center col-span-3 md:col-span-4 italic text-red-600">Foto Tidak Ditemukan</div>
                @endforelse
            </div>
        </div>

        <div class="mt-4 mb-2">
            {{ $items->onEachSide(1)->links() }}
        </div>
        {{-- END: LIST FOTO --}}
    </div>

    @if(Request::is(['admin/berita', 'admin/berita/*' , 'admin/galeri', 'admin/galeri/*']))
        <x-close-modal-button/>
    @elseif(Request::is(['admin/media', 'admin/media/*']))
        <x-back-button url="{{ url('/admin/dashboard') }}">Kembali</x-back-button>
    @endif

</div>
