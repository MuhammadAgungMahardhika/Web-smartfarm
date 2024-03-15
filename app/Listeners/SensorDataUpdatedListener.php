<?php

namespace App\Listeners;

use App\Events\SensorDataUpdated;
use App\Repositories\SensorRepository;
use Carbon\Carbon;

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
        $suhuOutlier  = $event->suhuOutlier;
        $kelembapanOutlier = $event->kelembapanOutlier;
        $amoniaOutlier = $event->amoniaOutlier;
    }
}
