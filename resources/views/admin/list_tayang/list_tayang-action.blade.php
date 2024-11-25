<div class="flex flex-row gap-1 float-right bg-white">
    {{-- SHOW --}}
    <a href="{{ url('berita/' . $data->slug) }}" target="_blank" id="infoDataButton" data-id="{{ $data->slug }}" class="infoDataButton btn_info tooltip" data-tip="Lihat"><i class="fas fa-eye"></i></a>
        
    {{-- EDIT --}}
    @if(auth()->user()->level == 'owner' || auth()->user()->id == $data->id_user)
    <a href="{{ url('admin/berita/' . $data->slug . '/edit') }}" id="editDataButton" data-id="{{ $data->slug }}" class="editDataButton btn_edit tooltip" data-tip="Edit"><i class="fas fa-pen-alt"></i></a>

    {{-- DELETE --}}
    <form action="{{ url('admin/berita/' . $data->slug ) }}" method="post">
        @method('delete')
        @csrf
        <button id="deleteButton" data-id="{{ $data->slug }}" class="deleteButton btn_delete tooltip" data-tip="Hapus"><i class="fas fa-trash-alt"></i></button>
    </form>
    @endif
</div>