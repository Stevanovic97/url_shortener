<?php

namespace App\Listeners;

use App\Events\UrlViewed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AllViewsInc
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UrlViewed $event
     * @return void
     */
    public function handle(UrlViewed $event)
    {
        dd($event);
    }
}
