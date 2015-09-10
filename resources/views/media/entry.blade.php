<div class="MediaItem" data-cid="{{ $media->cid }}">
    <img class="MediaItem-image" src="{{ $media->image }}" alt="Image">
    <div class="MediaItem-meta">
        @include('media.item_header', ['classes' => 'MediaItem-title', 'media' => $media])
        @if (isset($plays))
            <span class="MediaItem-playcount">
                {{ $plays }} plays
            </span>
        @endif
        @if (isset($firstPlayed))
            <time class="MediaItem-time"
                  datetime="{{ $firstPlayed ? $firstPlayed->toW3CString() : '' }}">
                since {{ $firstPlayed or '0000-00-00 00:00:00' }}
            </time>
        @endif
        @if (isset($showDuration) && $showDuration)
            <span class="MediaItem-duration">{{ duration($media->duration) }}</span>
        @endif
    </div>
</div>
