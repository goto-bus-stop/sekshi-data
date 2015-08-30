@extends('layouts.master')

@section('content')
    <div class="user">
        <h1>{{ $user->username }}</h1>
        @if ($user->level >= 5 && !empty($user->slug))
            <p>
                <a target="_blank" href="https://plug.dj/@/{{ $user->slug }}">
                    https://plug.dj/@/{{ $user->slug }}
                </a>
            </p>
        @endif
        <p>
            {{ $user->username }} has {{ $karma }} karma.
        </p>
        <p>
            {{ $user->username }} played {{ $history->total() }} times.
        </p>
        @if ($favorite)
            <p>
                {{ $user->username }}'s favorite song is
                <a href="{{ url('media', $favorite->cid) }}">{{ $favorite->full_title }}</a>:
                they played it {{ $favoriteCount }} times.</p>
        @endif

        <h2 id="history">Play History</h2>
        @include('history.list', ['entries' => $history])
    </div>
@endsection
