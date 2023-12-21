<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SensorDataUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $idKandang, $suhu, $kelembapan, $amonia;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($idKandang, $suhu, $kelembapan, $amonia)
    {
        $this->idKandang = $idKandang;
        $this->suhu = $suhu;
        $this->kelembapan = $kelembapan;
        $this->amonia = $amonia;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('sensor-data');
    }
}
