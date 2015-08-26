<div class="history-entry">
    <img src="{{ $entry->mediaM->image }}" alt="Image">
    <div class="meta">
        <span class="media">{{ $entry->mediaM->full_title }}</span>
        <span class="dj">{{ $entry->djM->username or '' }}</span>
        <span class="time">{{ $entry->time }}</span>
    </div>
    <div class="score">
        <div class="woots">
            <i class="icon-woot"></i><span>{{ $entry->score->positive }}</span>
        </div>
        <div class="grabs">
            <i class="icon-grab"></i><span>{{ $entry->score->grabs }}</span>
        </div>
        <div class="mehs">
            <i class="icon-meh"></i><span>{{ $entry->score->negative }}</span>
        </div>
        <div class="listeners">
            <i class="icon-listeners"></i><span>{{ $entry->score->listeners }}</span>
        </div>
    </div>
</div>
