<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pagination Defaults
    |--------------------------------------------------------------------------
    |
    | These values control the default pagination counts used throughout
    | the application. Centralizing these values makes them easier to
    | maintain and adjust based on performance requirements.
    |
    */

    'defaults' => [
        'general' => 20,
        'admin' => 20,
        'forum_threads' => 20,
        'forum_posts' => 15,
        'tournaments' => 12,
        'participants' => 50,
        'media_gallery' => 20,
        'deals' => 24,
        'news' => 12,
        'search_results' => 15,
        'leaderboard' => 50,
        'predictions' => 12,
        'streamer_bans' => 30,
        'game_library' => 24,
    ],

];
