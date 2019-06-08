<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
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
    protected $signature = 'main';

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
        try {
            $photoFilename = storage_path('app/tram8dgkqi231.jpg');
            $captionText = "Follow @icodestuff.io for more content like this";
            $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($photoFilename);
            $ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $captionText]);
        } catch (\Exception $e) {
            echo 'Something went wrong: '.$e->getMessage()."\n";
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
