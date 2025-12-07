@props(['title'])

<div class="row">
    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">{{ $title }}</h3>

        <div class="page-header-actions">
            {{ $slot }}
        </div>
    </div>
</div>
