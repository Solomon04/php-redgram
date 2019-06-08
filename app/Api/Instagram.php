<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 6/6/2019
 * Time: 12:50 PM
 */

namespace App\Api;

use Illuminate\Support\Facades\Artisan;
use InstagramAPI\Exception\IncorrectPasswordException;
use InstagramAPI\Instagram as IG;

class Instagram
{
    public $ig;

    public function __construct()
    {
        $this->ig = new IG();
        try{
            $this->ig->login(config('instagram.username'), config('instagram.password'));
        }catch (\Exception $exception){
            if($exception instanceof IncorrectPasswordException){
                Artisan::call('auth:ig --incorrect');
            }elseif ($exception instanceof \InvalidArgumentException){
                Artisan::call('auth:ig --empty');
            }
        }
    }
}