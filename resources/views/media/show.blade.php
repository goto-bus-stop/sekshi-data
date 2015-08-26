@extends('layouts.master')

@section('content')
    <div class="media">
        <h1>{{ $media->full_title }}</h1>
        <p>
            This song was played {{ $history->total() }} times.
        </p>
        @if ($lover)
            <p>
                <a href="{{ user_url($lover) }}">{{ $lover->username }}</a>
                loves this song the most: they played it {{ $loverCount }} times.
            </p>
        @endif
        <div class="embed">
            @if ($media->format === 1)
                <iframe width="560"
                        height="315"
                        src="https://www.youtube-nocookie.com/embed/{{ $media->cid }}"
                        frameborder="0"
                        allowfullscreen>
                </iframe>
            @endif
        </div>

        <h2>Play History</h2>
        @include('history.list', ['entries' => $history])
    </div>
@endsection
