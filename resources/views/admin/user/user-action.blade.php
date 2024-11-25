<div class="flex flex-row gap-1 float-right bg-white">
    {{-- ID CARD --}}
    <a href="{{ url('admin/id-card/' . $data->id)}}" data-id="{{ $data->id }}" target="_blank" class="idCardButton btn_primary tooltip" data-tip="ID Card"><i class="fa-regular fa-id-card"></i> ID</a>
    
    {{-- SHOW --}}
    <a href="{{ url('admin/user/' . $data->id) }}" data-id="{{ $data->id }}" class="infoDataButton btn_info tooltip" data-tip="Lihat"><i class="fas fa-eye"></i></a>
        
    {{-- EDIT --}}
    <a href="{{ url('admin/user/' . $data->id . '/edit') }}" data-id="{{ $data->id }}" class="editDataButton btn_edit tooltip" data-tip="Edit"><i class="fas fa-pen-alt"></i></a>

    {{-- DELETE --}}
    <form action="{{ url('admin/user/' . $data->id ) }}" method="post">
        @method('delete')
        @csrf
        <button data-id="{{ $data->id }}" class="deleteButton btn_delete tooltip" data-tip="Hapus"><i class="fas fa-trash-alt"></i></button>
    </form>
</div>