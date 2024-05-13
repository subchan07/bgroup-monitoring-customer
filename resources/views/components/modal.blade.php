@props(['title', 'idModal'])

<div class="modal fade" id="{{ $idModal }}" tabindex="-1" aria-labelledby="{{ $idModal }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $idModal }}Label">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
