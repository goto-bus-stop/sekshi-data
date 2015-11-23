@extends('layouts.master')

@section('content')
    <h1>Achievement</h1>

    <img src="{{ $achievement->image }}"
         alt="{{ $achievement->id }}"
         title="{{ $achievement->description }}" />

    <h2>Unlocked by {{ $unlocks->total() }} users</h2>

    {!! $unlocks->render() !!}

    <div class="UserList">
        <div class="UserList-header UserRow">
            <div class="UserRow-info">
                <div class="UserRow-username">Username</div>
                <div class="UserRow-unlockTime">Unlocked on</div>
            </div>
        </div>
        @foreach ($unlocks as $unlock)
            <div class="UserRow">
                <div class="UserRow-badge Badge Badge--{{ $unlock->userM->badge or 'none' }}"></div>
                <div class="UserRow-info">
                    @if (!empty($unlock->userM))
                        <a class="UserRow-username" href="{{ user_url($unlock->userM) }}">{{ $unlock->userM->username }}</a>
                    @else
                        <span class="UserRow-username">?</span>
                    @endif
                    <span class="UserRow-unlockTime">{{ $unlock->time->format('Y-m-d \a\t H:i:s') }}</span>
                </div>
            </div>
        @endforeach
    </div>

    {!! $unlocks->render() !!}
@endsection
