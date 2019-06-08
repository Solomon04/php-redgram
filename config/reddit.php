<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Username
    |--------------------------------------------------------------------------
    |
    | This value is your Reddit username. Change the value by changing your
    | .env file.
    */
    'username' => env('REDDIT_USERNAME', ''),

    /*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    |
    | This value is your Reddit password. Change the value by changing your
    | .env file.
    */
    'password' => env('REDDIT_PASSWORD', ''),


    /*
    |--------------------------------------------------------------------------
    | Subreddit
    |--------------------------------------------------------------------------
    |
    | This value is your subreddit. Change the value by changing your
    | .env file. Note, this needs to be the name of the subreddit, not the
    | full URL.
    | Good Example: ProgrammerHumor
    | Bad Examples: r/ProgrammerHumor or https://www.reddit.com/r/ProgrammerHumor
    */

    'subreddit' => env('REDDIT_SUBREDDIT', 'askreddit')
];