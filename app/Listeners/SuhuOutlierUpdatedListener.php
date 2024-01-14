<?php

namespace App\Listeners;

use App\Events\SuhuOutlierUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SuhuOutlierUpdatedListener
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
     * @param  \App\Events\SuhuOutlierUpdated  $event
     * @return void
     */
    public function handle(SuhuOutlierUpdated $event)
    {
        //
    }
}
