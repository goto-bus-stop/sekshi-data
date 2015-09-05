@extends('layouts.master')

@section('content')
    {!! $users->render() !!}

    <div class="UserList">
        @each('user.entry', $users, 'user')
    </div>
{{--
    <table class="users">
        <thead>
            <tr>
                <th>Username</th>
                <th>Plays</th>
                <th>Karma</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    @if ($user)
                        <td><a href="{{ user_url($user) }}">{{ $user->username }}</a></td>
                        <td>{{ $user->history()->count() }}</td>
                        <td>{{ $user->karma()->sum('amount') }}</td>
                    @else
                        <td colspan="3">Deleted user</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
--}}

    {!! $users->render() !!}
@endsection
