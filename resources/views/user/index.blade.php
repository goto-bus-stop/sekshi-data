@extends('layouts.master')

@section('content')
    {!! $users->render() !!}

    <div class="UserList">
        <div class="UserList-header UserRow">
            <div class="UserRow-info">
                <a href="{{ sort_url('user', 'asc') }}" class="UserRow-username">Username</a>
                <a href="{{ sort_url('plays', 'desc') }}" class="UserRow-playcount">Plays</a>
                <a href="{{ sort_url('karma', 'desc') }}" class="UserRow-karma">Karma</a>
            </div>
        </div>
        @each('user.entry', $users, 'user')
    </div>

    {!! $users->render() !!}
@endsection
