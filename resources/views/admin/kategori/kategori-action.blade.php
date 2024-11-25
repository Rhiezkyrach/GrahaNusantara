<div class="flex flex-row gap-1 float-right bg-white">
    {{-- SHOW --}}
    <a href="{{ url('admin/kategori/' . $data->slug .'/show') }}" data-id="{{ $data->slug }}" class="infoDataButton btn_info tooltip" data-tip="Lihat"><i class="fas fa-eye"></i></a>
        
    {{-- EDIT --}}
    <a href="{{ url('admin/kategori/' . $data->slug . '/edit') }}" data-id="{{ $data->slug }}" class="editDataButton btn_edit tooltip" data-tip="Edit"><i class="fas fa-pen-alt"></i></a>

    {{-- DELETE --}}
    <form action="{{ url('admin/kategori/' . $data->slug ) }}" method="post">
        @method('delete')
        @csrf
        <button data-id="{{ $data->slug }}" class="deleteButton btn_delete tooltip" data-tip="Hapus"><i class="fas fa-trash-alt"></i></button>
    </form>
</div>