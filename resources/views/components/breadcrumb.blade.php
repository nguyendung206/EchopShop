<div class="breakcrumb-1 my-4">
    <div class="breakcrumb-wrap container">
        @foreach ($items as $index => $item)
        <div class="breakcrumb-item {{ $loop->last ? 'breakcrumb-last-item' : '' }}">
            @if (isset($item['href']))
            <a style="color: rgba(177, 0, 0, 1);" href="{{ $item['href'] }}">
                @endif
                {{ $item['label'] }}
                @if (isset($item['href']))
            </a>
            @endif
            @if (!$loop->last)
                <div class="arrow"></div>
            @else
                <div class="arrow last-arrow"></div>
            @endif
        </div>
        @endforeach
    </div>
</div>
