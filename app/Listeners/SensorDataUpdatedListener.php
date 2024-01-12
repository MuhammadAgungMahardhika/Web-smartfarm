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
        if ($suhu != null || $kelembapan != null || $amonia  != null) {
            // Dapatkan nilai rata-rata 
            $meanSuhu = $this->sensorRepository->getMean('suhu');
            $meanKelembapan = $this->sensorRepository->getMean('kelembapan');
            $meanAmonia = $this->sensorRepository->getMean('amonia');

            // dapatkan nilai standar deviasi 
            $stdDevSuhu = $this->sensorRepository->getStdDev('suhu');
            $stdDevKelembapan = $this->sensorRepository->getStdDev('kelembapan');
            $stdDevAmonia = $this->sensorRepository->getStdDev('amonia');

            // dump([$meanSuhu, $meanKelembapan, $meanAmonia]);
            // Deteksi outlier dan terapkan winsorizing
            $suhuWinsorizing = $this->detectAndWinsorize($suhu, $meanSuhu, $stdDevSuhu);
            $kelembapanWinsorizing = $this->detectAndWinsorize($kelembapan, $meanKelembapan, $stdDevKelembapan);
            $amoniaWinsorizing = $this->detectAndWinsorize($amonia, $meanAmonia, $stdDevAmonia);
            // dump([$suhu, $kelembapan, $amonia, $suhuWinsorizing, $kelembapanWinsorizing, $amoniaWinsorizing]);
            $isOutlier = false;
            // check apakah ada transformasi nilai, jika ada berarti ada berarti outlier
            if ($suhu != $suhuWinsorizing || $kelembapan != $kelembapanWinsorizing || $amonia != $amoniaWinsorizing) {
                $isOutlier = true;
                $suhu  = $suhuWinsorizing;
                $kelembapan = $kelembapanWinsorizing;
                $amonia = $amoniaWinsorizing;
            }

            $this->sensorRepository->createSensor((object)[
                "id_kandang" =>  $idKandang,
                "datetime" => Carbon::now()->timezone('Asia/Jakarta'),
                "suhu" => $suhu,
                "kelembapan" => $kelembapan,
                "is_outlier" => $isOutlier,
                "amonia" => $amonia,
            ]);
        }
    }

    protected function detectAndWinsorize($value, $mean, $stdDev)
    {
        // Menentukan batas bawah dan batas atas ( 3 sigma)
        $lowerLimit = $mean - 3 * $stdDev;
        $upperLimit = $mean + 3 * $stdDev;

        // Deteksi outlier dan terapkan winsorizing
        if ($value < $lowerLimit) {
            return $lowerLimit;
        } elseif ($value > $upperLimit) {
            return $upperLimit;
        }

        return $value;
    }
}
