@extends('layouts.master')

@section('content')
    @include('media.list', ['list' => $media])
@endsection
