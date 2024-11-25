<!-- Modal -->
<input type="checkbox" id="{{ $inputid }}" class="modal-toggle"/>
<label for="{{ $inputid }}" id="{{ $modalid }}" class="modal cursor-pointer">
  <label class="modal-box relative w-11/12 {{ $class }}">

    {{ $slot }}

  </label>
</label>