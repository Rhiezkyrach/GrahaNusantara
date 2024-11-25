<div class="flex flex-row gap-1 float-right bg-white">
    {{-- SHOW --}}
    <a href="{{ url('admin/struktur/' . $data->id .'/show') }}" data-id="{{ $data->id }}" class="infoDataButton btn_info tooltip" data-tip="Lihat"><i class="fas fa-eye"></i></a>
        
    {{-- EDIT --}}
    <a href="{{ url('admin/struktur/' . $data->id . '/edit') }}" data-id="{{ $data->id }}" class="editDataButton btn_edit tooltip" data-tip="Edit"><i class="fas fa-pen-alt"></i></a>

    {{-- DELETE --}}
    <form action="{{ url('admin/struktur/' . $data->id ) }}" method="post">
        @method('delete')
        @csrf
        <button data-id="{{ $data->id }}" class="deleteButton btn_delete tooltip" data-tip="Hapus"><i class="fas fa-trash-alt"></i></button>
    </form>
</div>