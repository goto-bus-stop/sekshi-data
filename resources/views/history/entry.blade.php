<div class="history-entry">
    <img src="{{ $entry->mediaM->image }}" alt="Image">
    <div class="meta">
        <a class="media" href="{{ url('media', $entry->mediaM->cid) }}">
            {{ $entry->mediaM->full_title }}
        </a>
        <span class="dj">{{ $entry->djM->username or '?' }}</span>
        <span class="time">{{ $entry->time or '0000-00-00 00:00:00' }}</span>
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
