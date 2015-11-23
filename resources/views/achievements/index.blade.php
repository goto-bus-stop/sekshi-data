@extends('layouts.master')

@section('content')
    <ul class="AchievementShowcase">
        @foreach ($achievements as $achievement)
            <li class="AchievementThumb">
                <a href="{{ action('AchievementController@show', $achievement) }}">
                    <img class="AchievementThumb-image"
                         src="{{ $achievement->image }}"
                         alt="{{ $achievement->id }}"
                         title="{{ $achievement->description }}" />
                    <span class="AchievementThumb-time">
                        Unlocked: {{ $achievement->unlockCount }} times
                    </span>
                </a>
            </li>
        @endforeach
    </ul>
@endsection
