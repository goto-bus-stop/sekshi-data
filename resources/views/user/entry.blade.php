<div class="UserRow">
    <div class="UserRow-badge Badge Badge--{{ $user->badge ?: 'none' }}"></div>
    <div class="UserRow-info">
        <a class="UserRow-username" href="{{ user_url($user) }}">{{ $user->username }}</a>
        <span class="UserRow-playcount">{{ $user->playcount }} plays</span>
        <span class="UserRow-karma">{{ $user->totalKarma }} karma</span>
    </div>
</div>
