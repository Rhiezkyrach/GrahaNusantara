<div class="flex flex-row gap-1 float-right bg-white">
    {{-- SHOW --}}
    {{-- <a href="{{ url('berita/' . $data->slug) }}" target="_blank" id="infoDataButton" data-id="{{ $data->slug }}" class="infoDataButton btn_info tooltip" data-tip="Lihat"><i class="fas fa-eye"></i></a> --}}
    <a href="{{ $data->Network ? $data->Network->url . '/berita/' . $data->slug : '' }}" target="_blank" id="infoDataButton" data-id="{{ $data->slug }}" class="infoDataButton btn_info tooltip" data-tip="Lihat"><i class="fas fa-eye"></i></a>
        
    {{-- OWNER & ADMIN BISA MODIFY SEMUA BERITA --}}
    @if(auth()->user()->level == 'owner' || auth()->user()->level == 'admin')
        {{-- EDIT --}}
        <a href="{{ url('admin/berita/' . $data->slug . '/edit') }}" id="editDataButton" data-id="{{ $data->slug }}" class="editDataButton btn_edit tooltip" data-tip="Edit"><i class="fas fa-pen-alt"></i></a>
    
        {{-- DELETE --}}
        <form action="{{ url('admin/berita/' . $data->slug ) }}" method="post">
            @method('delete')
            @csrf
            <button id="deleteButton" data-id="{{ $data->slug }}" class="deleteButton btn_delete tooltip" data-tip="Hapus"><i class="fas fa-trash-alt"></i></button>
        </form>
    
    {{-- REDAKTUR BISA MODIFY BERITA YG DIBUAT OLEHNYA & DAN WARTAWAN --}}
    @elseif(auth()->user()->id == $data->id_user && auth()->user()->level == 'redaktur')
        {{-- EDIT --}}
        <a href="{{ url('admin/berita/' . $data->slug . '/edit') }}" id="editDataButton" data-id="{{ $data->slug }}" class="editDataButton btn_edit tooltip" data-tip="Edit"><i class="fas fa-pen-alt"></i></a>
    
        {{-- DELETE --}}
        <form action="{{ url('admin/berita/' . $data->slug ) }}" method="post">
            @method('delete')
            @csrf
            <button id="deleteButton" data-id="{{ $data->slug }}" class="deleteButton btn_delete tooltip" data-tip="Hapus"><i class="fas fa-trash-alt"></i></button>
        </form>
    
    {{-- WARTAWAN HANYA BISA MODIFY BERITA YG DIBUAT OLEHNYA --}}
    @elseif(auth()->user()->level == 'wartawan' && auth()->user()->Reporter->id_wartawan ==  $data->id_wartawan)
        {{-- EDIT --}}
        <a href="{{ url('admin/berita/' . $data->slug . '/edit') }}" id="editDataButton" data-id="{{ $data->slug }}" class="editDataButton btn_edit tooltip" data-tip="Edit"><i class="fas fa-pen-alt"></i></a>
    @endif
</div>