<div class="media-item" data-cid="{{ $media->cid }}">
    <img class="media-item-image" src="{{ $media->image }}" alt="Image">
    <div class="media-item-meta">
        <a class="media" href="{{ url('media', $media->cid) }}">
            {{ $media->full_title }}
        </a>
        @if (isset($plays))
            <span class="playcount">
                {{ $plays }} plays
            </span>
        @endif
        @if (isset($firstPlayed))
            <time class="time"
                  datetime="{{ $firstPlayed ? $firstPlayed->toW3CString() : '' }}">
                since {{ $firstPlayed or '0000-00-00 00:00:00' }}
            </time>
        @endif
    </div>
</div>
