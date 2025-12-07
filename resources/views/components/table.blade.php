@props([
    'striped' => false,
    'hover' => true,
    'responsive' => true,
    'headClass' => 'text-primary',
])

@php
    $classes = 'table';
    if ($striped) {
        $classes .= ' table-striped';
    }
    if ($hover) {
        $classes .= ' table-hover';
    }
@endphp

<div @if ($responsive) class="table-responsive" @endif>
    <table {{ $attributes->merge(['class' => $classes]) }}>
        @isset($head)
            <thead class="{{ $headClass }}">
                {{ $head }}
            </thead>
        @endisset

        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
