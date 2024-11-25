<div class="flex flex-col justify-between w-full gap-2 mt-1 mb-2 md:flex-row md:items-center">
    <div class="flex flex-col md:flex-row gap-1.5">
        {{-- Buttons --}}
        <div class="flex flex-row gap-2">
            <button class="rounded-md px-2 py-0.5 text-sm bg-slate-600 text-white" id="printButton">PRINT</button>
            <button class="rounded-md px-2 py-0.5 text-sm bg-slate-600 text-white" id="excelButton">EXCEL</button>
            <button class="rounded-md px-2 py-0.5 text-sm bg-slate-600 text-white" id="pdfButton">PDF</button>
        </div>

        {{-- Per Page --}}
        <div class="w-full form-control md:w-36">
            <div class="flex flex-row">
                <select class="w-full py-1.5 rounded-l-lg placeholder:text-sm" id="rowsPerPage">
                    <option disabled>SHOW</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                    {{-- <option value="{{ $slot }}">ALL - {{ $slot }}</option> --}}
                </select>
                <button class="px-4 py-0.5 bg-slate-600 text-white rounded-r-lg"><i class="fa-duotone fa-eye"></i></button>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <div class="flex flex-row gap-2">
        <div class="w-full md:w-72">
            <div class="flex flex-row">
                <input type="text" id="searchData" name="searchData" placeholder="Search…" class="w-full py-1.5 rounded-l-lg" auto-complete="off"/>
                <button class="px-4 py-0.5 bg-slate-600 text-white rounded-r-lg"><i class="-ml-1 fa-duotone fa-magnifying-glass"></i></button>
            </div>
        </div>
        <a id="createDataButton" href="{{ $addurl }}"><div class="text-white text-sm font-semibold bg-lime-600 hover:bg-lime-700 px-4 py-2.5 rounded-lg whitespace-nowrap"><i class="fas fa-plus"></i> Tambah</div></a>
    </div> 
</div>