@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<x-main-container title="File manager" url="{{ $setting && $setting->Network ? $setting->Network->url : url('/') }}">

  <div class="mt-5 w-full">
    @livewire('file-manager')
  </div>

</x-main-container>
<!-- /Main Container -->

<!-- Modal -->
<x-modals class="max-w-2xl">
    <x-slot:inputid>modal-container</x-slot:inputid>
    <x-slot:modalid>modal-content</x-slot:modalid>
    <div id="modal-ajax">
        {{-- Ajax --}}
    </div>
</x-modals>

@push('js')
<script>
//Ajax CSRF
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
});

$(document).ready(function () {
    // 
});
</script>
@endpush

@endsection