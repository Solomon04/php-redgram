<?php

namespace App\Commands;

use App\Api\Reddit;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class VerifyRedditCredentials extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'verify:reddit';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Verify User Reddit Credentials';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $content = Reddit::getContents(config('reddit.username'), config('reddit.password'), config('reddit.subreddit'));
        $posts = $content->data->children;
        foreach ($posts as $post){
            if($post->data->is_video){
                continue;
            }

            if($post->data->score < 25){
                continue;
            }

            if (!strpos($post->data->url, 'jpg')) {
                continue;
            }

            print $post->data->id;
            print "\n";
            print $post->data->score;
            print "\n";
            print $post->data->url;
            print "\n";
            print $post->data->title;
            print "\n";
            print "--------------------";
            print "\n";
        }
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
