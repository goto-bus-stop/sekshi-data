@extends('layouts.master')

@section('content')
    <div class="HistorySort">
        Sort by:
        <a href="{{ action('HistoryController@index') }}?sort=time"
           class="HistorySort-sort HistorySort-sort--time
                  {{ $sort === 'time' ? 'HistorySort-sort--active' : '' }}">
            <span class="HistorySort-icon Icon Icon--time"></span>
            Time
        </a>
        <a href="{{ action('HistoryController@index') }}?sort=woots"
           class="HistorySort-sort HistorySort-sort--woots
                  {{ $sort === 'woots' ? 'HistorySort-sort--active' : '' }}">
            <span class="HistorySort-icon Icon Icon--woot"></span>
            Woots
        </a>
        <a href="{{ action('HistoryController@index') }}?sort=grabs"
           class="HistorySort-sort HistorySort-sort--grabs
                  {{ $sort === 'grabs' ? 'HistorySort-sort--active' : '' }}">
            <span class="HistorySort-icon Icon Icon--grab"></span>
            Grabs
        </a>
        <a href="{{ action('HistoryController@index') }}?sort=mehs"
           class="HistorySort-sort HistorySort-sort--mehs
                  {{ $sort === 'mehs' ? 'HistorySort-sort--active' : '' }}">
            <span class="HistorySort-icon Icon Icon--meh"></span>
            Mehs
        </a>
    </div>

    @include('history.list', ['entries' => $entries])
@endsection
