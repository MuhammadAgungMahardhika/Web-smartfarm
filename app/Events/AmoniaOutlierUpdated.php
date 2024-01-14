<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AmoniaOutlierUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $idKandang, $meanAmonia, $stdDevAmonia, $lowerAmonia, $upperAmonia, $amoniaOutlier, $amonia;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($idKandang, $meanAmonia, $stdDevAmonia, $lowerAmonia, $upperAmonia, $amoniaOutlier, $amonia)
    {
        $this->idKandang = $idKandang;
        $this->meanAmonia = $meanAmonia;
        $this->stdDevAmonia = $stdDevAmonia;
        $this->lowerAmonia = $lowerAmonia;
        $this->upperAmonia = $upperAmonia;
        $this->amoniaOutlier = $amoniaOutlier;
        $this->amonia = $amonia;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('amonia-outlier');
    }
}
