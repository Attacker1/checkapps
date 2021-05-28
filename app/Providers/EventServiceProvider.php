<?php

namespace App\Providers;

use App\Events\CheckVerified;
use App\Listeners\ChangeUserBalance;
use App\Listeners\IncreareCheckVerifyQuantity;
use App\Listeners\ResetCheckUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CheckVerified::class => [
            ChangeUserBalance::class,
            ResetCheckUser::class,
            IncreareCheckVerifyQuantity::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
