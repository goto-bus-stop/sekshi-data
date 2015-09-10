<div class="MediaItemHeader {{ $classes or '' }}">
    @if (isset($media->blacklisted))
        <span class="MediaItemHeader-blacklisted">
            @if (!empty($media->blacklisted->reason))
                {{ trans('reasons.' . $media->blacklisted->reason) }}
            @else
                Blacklisted
            @endif
        </span>
    @endif
    <a class="MediaItemHeader-title" href="{{ action('MediaController@show', $media->cid) }}">
        {{ $media->full_title }}
    </a>
</div>
