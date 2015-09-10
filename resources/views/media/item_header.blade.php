<div class="MediaItemHeader {{ $classes or '' }}">
    <a class="MediaItemHeader-title" href="{{ action('MediaController@show', $media->cid) }}">
        {{ $media->full_title }}
    </a>
</div>
