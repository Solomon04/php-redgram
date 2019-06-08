<?php

namespace App\Commands;

use App\Api\Redgram;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class InstagramAuthentication extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'auth:ig {--incorrect} {--empty}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Verify Instagram Authentication.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->option('empty')){
            $this->alert("You need to fill out your Instagram credentials!");
        }

        if($this->option('incorrect')){
            $this->alert("Incorrect username or password for Instagram!");
        }

        $username = $this->ask("What is your instagram username?");
        $password = $this->secret("What is your instagram password?");
        Redgram::setEnvironmentValue([
            'INSTAGRAM_USERNAME' => $username,
            'INSTAGRAM_PASSWORD' => $password
        ]);
        $this->warn("Your Instagram credentials have been saved.");
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
