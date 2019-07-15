<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Overtrue\EasySms\EasySms;

class EasySmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EasySms::class, function ($app){
            return new EasySms(config('easysms'));
        });

        $this->app->alias(EasySms::class, 'easysms');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

//try {
//    $sms->send(18516243167, [
//        'content'  => '【高正义test】您的验证码是1234。如非本人操作，请忽略本短信',
//    ]);
//} catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
//    $message = $exception->getException('yunpian')->getMessage();
//    dd($message);
//}
