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

        <h2 id="achievements">Achievements</h2>
        @if (count($achievements) > 0)
            <ul class="AchievementShowcase">
                @foreach ($achievements as $achievement)
                    <li class="AchievementThumb">
                        <img class="AchievementThumb-image"
                             src="{{ $achievement->achievementM->image }}"
                             alt="{{ $achievement->achievementM->description }}"
                             title="{{ str_finish($achievement->achievementM->description, '.') }}
    Unlocked: {{ $achievement->time }}">
                        <time class="AchievementThumb-time"
                              datetime="{{ $achievement->time->toW3CString() }}">
                            Unlocked: {{ $achievement->time }}
                        </time>
                    </li>
                @endforeach
            </ul>
        @else
            <p>This user has not yet unlocked any achievements.</p>
        @endif

        <h2 id="history">Play History</h2>
        @if (count($history) > 0)
            @include('history.list', ['entries' => $history])
        @else
            <p>This user has not played any songs.</p>
        @endif
    </div>
@endsection
