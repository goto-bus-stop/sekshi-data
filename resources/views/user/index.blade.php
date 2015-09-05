@extends('layouts.master')

@section('content')
    {!! $users->render() !!}

    <div class="UserList">
        @each('user.entry', $users, 'user')
    </div>

    {!! $users->render() !!}
@endsection
