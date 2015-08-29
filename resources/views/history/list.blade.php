{!! $entries->render() !!}

<div class="history">
    <div class="media-list history-list">
        @each('history.entry', $entries, 'entry')
    </div>
</div>

{!! $entries->render() !!}
