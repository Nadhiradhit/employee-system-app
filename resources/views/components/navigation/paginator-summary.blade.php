@props(['paginator'])

<div>
    <p class="text-sm text-base-content/70 leading-5">
        {!! __('Showing') !!}
        @if ($paginator->firstItem())
            <span class="font-medium text-base-content">{{ $paginator->firstItem() }}</span>
            {!! __('to') !!}
            <span class="font-medium text-base-content">{{ $paginator->lastItem() }}</span>
        @else
            {{ $paginator->count() }}
        @endif
        {!! __('of') !!}
        <span class="font-medium text-base-content">{{ $paginator->total() }}</span>
        {!! __('results') !!}
    </p>
</div>
