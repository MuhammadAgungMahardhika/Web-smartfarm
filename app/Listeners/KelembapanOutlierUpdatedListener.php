<?php

namespace App\Listeners;

use App\Events\KelembapanOutlierUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class KelembapanOutlierUpdatedListener
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
     * @param  \App\Events\KelembapanOutlierUpdated  $event
     * @return void
     */
    public function handle(KelembapanOutlierUpdated $event)
    {
        //
    }
}
