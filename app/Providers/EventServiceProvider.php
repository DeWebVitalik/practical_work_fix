<?php

namespace App\Providers;

use App\Link;
use App\File;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('linkViewed', function (Link $link) {
            $link->increment('views');
        });

        Event::listen('deleteFile', function (File $file) {
            $file->delete = File::DELETED;
            $file->links()->delete();
            $file->save();
        });
    }
}
