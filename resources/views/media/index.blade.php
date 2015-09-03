@extends('layouts.master')

@section('content')
    <form class="search-media" method="get">
        <input type="hidden" name="since" value="{{ old('since') }}">
        <input class="search-media-query" type="text" name="q">
        <button class="search-media-button" type="submit">Search</button>
    </form>

    @if ($list->count() > 0)
        {!! $list->render() !!}

        <div class="MediaList">
            @foreach ($list as $m)
                @include('media.entry', ['media' => $m, 'plays' => $m->playcount, 'showDuration' => true])
            @endforeach
        </div>

        {!! $list->render() !!}

    @else
        <p class="no-results">No results.</p>
    @endif
@endsection
