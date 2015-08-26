<div class="history-list-row" data-entry-id="{{ $entry->id }}">
    <img src="{{ $entry->mediaM->image }}" alt="Image">
    <div class="meta">
        <a class="media" href="{{ url('media', $entry->mediaM->cid) }}">
            {{ $entry->mediaM->full_title }}
        </a>
        <span class="dj">
            @if (!is_null($entry->djM))
                @if (!empty($entry->djM->slug))
                    <a href="{{ url('user', $entry->djM->slug) }}">{{ $entry->djM->username or '?' }}</a>
                @else
                    <a href="{{ url('user', $entry->djM->id) }}">{{ $entry->djM->username or '?' }}</a>
                @endif
            @else
                {{ $entry->djM->username or '?' }}
            @endif
        </span>
        <time class="time" datetime="{{ $entry->time->toW3CString() }}">
            {{ $entry->time or '0000-00-00 00:00:00' }}
        </time>
    </div>
    <div class="score">
        <div class="woots">
            <i class="icon-woot"></i><span>{{ $entry->score->positive or '?' }}</span>
        </div>
        <div class="grabs">
            <i class="icon-grab"></i><span>{{ $entry->score->grabs or '?' }}</span>
        </div>
        <div class="mehs">
            <i class="icon-meh"></i><span>{{ $entry->score->negative or '?' }}</span>
        </div>
        <div class="listeners">
            <i class="icon-listeners"></i><span>{{ $entry->score->listeners or '?' }}</span>
        </div>
    </div>
</div>
