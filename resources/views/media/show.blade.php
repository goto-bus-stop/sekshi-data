@extends('layouts.master')

@section('content')
    <div class="media">
        <h1>{{ $media->full_title }}</h1>

        <div class="embed">
            @if ($media->embeddable)
                <iframe width="800"
                        height="450"
                        src="{{ $media->embed_url }}"
                        scrolling="no"
                        frameborder="0"
                        allowfullscreen></iframe>
            @endif
        </div>

        <p>
            This song was played {{ $history->total() }} times.
        </p>
        @if ($lover)
            <p>
                <a href="{{ user_url($lover) }}">{{ $lover->username }}</a>
                loves this song the most: they played it {{ $loverCount }} times.
            </p>
        @endif

        @if (count($similar) > 0)
            <h2 id="similar">Other Videos by {{ $media->author }}</h2>
            <div class="MediaThumbs">
                @foreach ($similar as $m)
                    <a class="MediaThumb" href="{{ url('media', $m->cid) }}" title="{{ $m->full_title }}">
                        <img class="MediaThumb-image" src="{{ $m->image }}" alt="">
                        <span class="MediaThumb-title">{{ $m->title }}</span>
                    </a>
                @endforeach
            </div>
        @endif

        <h2 id="history">Play History</h2>
        @include('history.list', ['entries' => $history])
    </div>
@endsection
