<?php

namespace App\Listeners;

use App\Events\SensorDataUpdated;
use App\Repositories\SensorRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SensorDataUpdatedListener
{
    protected $sensorRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SensorRepository $sensorRepository)
    {
        $this->sensorRepository = $sensorRepository;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SensorDataUpdated  $event
     * @return void
     */
    public function handle(SensorDataUpdated $event)
    {
        // Simpan nilai sensor Suhu Kelembapan dan amonia ke kandang
        $idKandang = $event->idKandang;
        $suhu = $event->suhu;
        $kelembapan = $event->kelembapan;
        $amonia = $event->amonia;
        if ($suhu != null || $kelembapan != null || $amonia  != null) {
            $this->sensorRepository->createSensor((object)[
                "id_kandang" =>  $idKandang,
                "datetime" => Carbon::now()->timezone('Asia/Jakarta'),
                "suhu" => $suhu,
                "kelembapan" => $kelembapan,
                "amonia" => $amonia,
            ]);
        }
        // broadcast(new SensorDataUpdated($event->suhu, $event->kelembapan, $event->amonia));
    }
}
