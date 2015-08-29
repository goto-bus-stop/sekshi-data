<div class="media-item history-list-row" data-entry-id="{{ $entry->id }}">
    <img class="media-item-image" src="{{ $entry->mediaM->image }}" alt="Image">
    <div class="media-item-meta">
        <a class="media" href="{{ url('media', $entry->mediaM->cid) }}">
            {{ $entry->mediaM->full_title }}
        </a>
        <span class="dj">
            @if (!is_null($entry->djM))
                <a href="{{ user_url($entry->djM) }}">{{ $entry->djM->username or '?' }}</a>
            @else
                {{ $entry->djM->username or '?' }}
            @endif
        </span>
        <time class="time" datetime="{{ $entry->time ? $entry->time->toW3CString() : '' }}">
            {{ $entry->time or '0000-00-00 00:00:00' }}
        </time>
    </div>
    <div class="media-score history-list-row-score">
        <div class="media-score-type media-score-woots">
            <i class="icon-woot"></i><span>{{ $entry->score->positive or '?' }}</span>
        </div>
        <div class="media-score-type media-score-grabs">
            <i class="icon-grab"></i><span>{{ $entry->score->grabs or '?' }}</span>
        </div>
        <div class="media-score-type media-score-mehs">
            <i class="icon-meh"></i><span>{{ $entry->score->negative or '?' }}</span>
        </div>
        <div class="media-score-type media-score-listeners">
            <i class="icon-listeners"></i><span>{{ $entry->score->listeners or '?' }}</span>
        </div>
    </div>
</div>
