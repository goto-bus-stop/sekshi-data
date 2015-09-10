<div class="MediaItem history-list-row" data-entry-id="{{ $entry->id }}">
    <img class="MediaItem-image" src="{{ $entry->mediaM->image }}" alt="Image">
    <div class="MediaItem-meta">
        @include('media.item_header', ['classes' => 'MediaItem-title', 'media' => $entry->mediaM])
        <span class="MediaItem-dj">
            @if (!is_null($entry->djM))
                <a href="{{ user_url($entry->djM) }}">{{ $entry->djM->username or '?' }}</a>
            @else
                {{ $entry->djM->username or '?' }}
            @endif
        </span>
        <time class="MediaItem-time" datetime="{{ $entry->time ? $entry->time->toW3CString() : '' }}">
            {{ $entry->time or '0000-00-00 00:00:00' }}
        </time>
    </div>
    <div class="MediaScoreGroup history-list-row-score">
        <div class="MediaScore MediaScore--woots">
            <i class="Icon Icon--woot MediaScore-icon"></i>
            <span class="MediaScore-value">{{ $entry->score->positive or '?' }}</span>
        </div>
        <div class="MediaScore MediaScore--grabs">
            <i class="Icon Icon--grab MediaScore-icon"></i>
            <span class="MediaScore-value">{{ $entry->score->grabs or '?' }}</span>
        </div>
        <div class="MediaScore MediaScore--mehs">
            <i class="Icon Icon--meh MediaScore-icon"></i>
            <span class="MediaScore-value">{{ $entry->score->negative or '?' }}</span>
        </div>
        <div class="MediaScore MediaScore--listeners">
            <i class="Icon Icon--listeners MediaScore-icon"></i>
            <span class="MediaScore-value">{{ $entry->score->listeners or '?' }}</span>
        </div>
    </div>
</div>
