<div class="UserRow">
    <div class="UserRow-badge Badge Badge--{{ $user->badge ?: 'none' }}"></div>
    <div class="UserRow-info">
        <a class="UserRow-username" href="{{ user_url($user) }}">{{ $user->username }}</a>
        <span class="UserRow-playcount">{{ $user->history()->count() }} plays</span>
        <span class="UserRow-karma">{{ $user->karma()->sum('amount') }} karma</span>
    </div>
</div>
