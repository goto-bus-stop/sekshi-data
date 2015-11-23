<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sekshi Data</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/badges.css') }}">
</head>
<body>
    <nav class="Navigation">
        <ul class="NavList">
            <li class="NavItem NavItem--brand">
                SekshiBot Data
            </li>
            <li class="NavItem">
                <a href="{{ action('UserController@index') }}">Users</a>
            </li>
            <li class="NavItem">
                <a href="{{ action('HistoryController@index') }}">Play History</a>
            </li>
            <li class="NavItem">
                <a href="{{ action('HistoryController@mostPlayed') }}">Most Played Songs</a>
            </li>
            <li class="NavItem">
                <a href="{{ action('AchievementController@index') }}">Achievements</a>
            </li>
            <li class="NavItem">
                <a href="{{ action('MediaController@index') }}">Known Media</a>
            </li>
        </ul>
    </nav>
    @yield('content')
</body>
</html>
