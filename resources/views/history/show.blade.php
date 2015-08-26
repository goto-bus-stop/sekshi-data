@extends('layouts.master')

@section('content')
    @include('history.list', ['entries' => $entries])
@endsection
