<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SuhuOutlierUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $idKandang, $mean, $stdDev, $lowerLimit, $upperLimit, $suhuOutlier, $suhuWinsorzing;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($idKandang, $mean, $stdDev, $lowerLimit, $upperLimit, $suhuOutlier, $suhuWinsorzing)
    {
        $this->idKandang = $idKandang;
        $this->mean = $mean;
        $this->stdDev = $stdDev;
        $this->lowerLimit = $lowerLimit;
        $this->upperLimit = $upperLimit;
        $this->suhuOutlier = $suhuOutlier;
        $this->suhuWinsorzing = $suhuWinsorzing;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('suhu-outlier');
    }
}
