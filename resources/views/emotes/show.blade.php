@extends('layouts.master')

@section('content')
    <table class="EmoteList">
        <thead>
            <tr>
                <th class="EmoteList-column">Emote</th>
                <th class="EmoteList-column">Image</th>
            </tr>
        </thead>
        <tbody>
            @each('emotes.emote', $emotes, 'emote')
        </tbody>
    </table>

    <script>
        // select full emote name on click
        document.querySelector('.emotes').addEventListener('click', function (e) {
            if (e.target.className === 'emote-name') {
                var range
                if (document.selection) {
                    range = document.body.createTextRange()
                    range.moveToElementText(e.target)
                    range.select()
                }
                else if (window.getSelection) {
                    range = document.createRange()
                    range.selectNodeContents(e.target)
                    window.getSelection().addRange(range)
                }
            }
        }, false)
    </script>
@endsection
