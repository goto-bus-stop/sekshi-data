{!! $entries->render() !!}

<div class="history">
    <div class="MediaList history-list">
        @each('history.entry', $entries, 'entry')
    </div>
</div>

{!! $entries->render() !!}
