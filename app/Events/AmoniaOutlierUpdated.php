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
    public $idKandang, $mean, $stdDev, $lowerLimit, $upperLimit, $amoniaOutlier, $amoniaWinsorzing;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($idKandang, $meanAmonia, $stdDevAmonia, $lowerAmonia, $upperAmonia, $amoniaOutlier, $amoniaWinsorzing)
    {
        $this->idKandang = $idKandang;
        $this->mean = $meanAmonia;
        $this->stdDev = $stdDevAmonia;
        $this->lowerLimit = $lowerAmonia;
        $this->upperLimit = $upperAmonia;
        $this->amoniaOutlier = $amoniaOutlier;
        $this->amoniaWinsorzing = $amoniaWinsorzing;
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
