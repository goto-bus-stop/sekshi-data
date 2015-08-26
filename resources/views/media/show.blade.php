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

        <h2>Play History</h2>
        @include('history.list', ['entries' => $history])
    </div>
@endsection
