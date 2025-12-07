@props([
    'type' => 'info', // success, danger, warning, info
    'title' => null,
    'message' => null,
])

@if ($message)
    <div {{ $attributes->merge(['class' => "alert alert-{$type} alert-dismissible fade show"]) }} role="alert">
        @if ($title)
            <strong>{{ $title }}</strong>
        @endif

        {{ $message }}

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
