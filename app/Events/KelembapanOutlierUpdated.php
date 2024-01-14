<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KelembapanOutlierUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $idKandang, $meanKelembapan, $stdDevKelembapan, $lowerKelembapan, $upperKelembapan, $kelembapanOutlier, $kelembapan;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($idKandang, $meanKelembapan, $stdDevKelembapan, $lowerKelembapan, $upperKelembapan, $kelembapanOutlier, $kelembapan)
    {
        $this->idKandang = $idKandang;
        $this->meanKelembapan = $meanKelembapan;
        $this->stdDevKelembapan = $stdDevKelembapan;
        $this->lowerKelembapan = $lowerKelembapan;
        $this->upperKelembapan = $upperKelembapan;
        $this->kelembapanOutlier = $kelembapanOutlier;
        $this->kelembapan = $kelembapan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('kelembapan-outlier');
    }
}
