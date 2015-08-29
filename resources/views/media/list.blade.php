{!! $media->render() !!}

<div class="media-list">
    @foreach ($list as $m)
        @include('media.entry', ['media' => $m->media, 'firstPlayed' => $m->first_played, 'plays' => $m->plays])
    @endforeach
</div>

{!! $media->render() !!}
