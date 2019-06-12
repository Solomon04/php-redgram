<?php

namespace App\Commands;

use App\Api\Redgram;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use InstagramAPI\Exception\IncorrectPasswordException;
use InstagramAPI\Instagram;
use LaravelZero\Framework\Commands\Command;

class MainCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'main {--y}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Run the main function';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ig = new Instagram();
        try{
            $ig->login(config('instagram.username'), config('instagram.password'));
        }catch (\Exception $exception){
            if($exception instanceof IncorrectPasswordException){
                $this->call('auth:ig --incorrect');
            }elseif ($exception instanceof \InvalidArgumentException){
                $this->call('auth:ig --empty');
            }
        }
        $content = Redgram::getRedditPosts(config('reddit.username'), config('reddit.password'), config('reddit.subreddit'));
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

            if (Storage::disk('local')->exists($post->data->id . ".jpg")){
                continue;
            }

            $image = file_get_contents($post->data->url);
            if(!Storage::disk('local')->put($post->data->id . ".jpg", $image)){
                continue;
            }

            //TODO refactor for other operating systems than just Windows.
            if(PHP_OS == "WINNT"){
                $path = base_path(sprintf("storage\app\%s.jpg", $post->data->id));
                exec($path);
            }

            if(!$this->option('y')){
                if (!$this->confirm('Do you want to post this?')) {
                    continue;
                }
            }

            try {
                $photoFilename = storage_path('app/' . $post->data->id .".jpg");
                $captionText = $post->data->title;

                if(config('instagram.custom_caption')){
                    try{
                        $captionText = File::get('caption.txt');
                    }catch (\Exception $exception){
                        $error = "Error: " . $exception->getMessage()."\n";
                        $this->warn($error);
                    }
                }

                if(config('instagram.hashtags')){
                    try{
                        $hashtags = File::get('hashtags.txt');
                        $captionText = $captionText . "\n" . $hashtags;
                    }catch (\Exception $exception){
                        $error = "Error: " . $exception->getMessage()."\n";
                        $this->warn($error);
                    }

                }

                $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($photoFilename);
                $ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $captionText]);
            } catch (\Exception $e) {
                $error = 'Something went wrong: '.$e->getMessage()."\n";
                $this->warn($error);
            }
            if($this->option('y')){
                break;
            }
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
        $schedule->command(static::class . "--y")->dailyAt('9:00');
        $schedule->command(static::class . "--y")->dailyAt('12:00');
        $schedule->command(static::class . "--y")->dailyAt('15:00');
        $schedule->command(static::class . "--y")->dailyAt('18:00');
        $schedule->command(static::class . "--y")->dailyAt('21:00');
    }
}
