<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Cage Visualization</h3>
                <p class="text-subtitle text-muted">Realtime Monitoring</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Cage Visualization</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="card border border-ligth">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="selectKandang">Choose Cage</label>
                                            <select class="form-select" id="selectKandang"
                                                onchange="setKandang(this.value)">

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div id="status">
                                            <span class="badge bg-secondary">Offline</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                {{-- <div class="row">
                                    <div class="col-12 col-md-4 col-lg-4">
                                        <div class="card  shadow-sm ">
                                            <div class="card-header text-center" style="background-color: #75a3d9">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 32 32">
                                                    <path fill="white"
                                                        d="M20 10h7v2h-7zm0 6h10v2H20zm0 6h7v2h-7zm-10-1.816V7H8v13.184a3 3 0 1 0 2 0z" />
                                                    <path fill="currentColor"
                                                        d="M30 4H12.974A4.983 4.983 0 0 0 4 7v11.11a7 7 0 1 0 10 0V7a5.002 5.002 0 0 0-.101-1H30ZM9 28a4.993 4.993 0 0 1-3.332-8.718L6 18.983V7a3 3 0 0 1 6 0v11.983l.332.299A4.993 4.993 0 0 1 9 28Z" />
                                                </svg>
                                                <span class="text-white" style="font-size: 20px">Temperature</span>
                                            </div>
                                            <div class="card-body ">
                                                <div class="row mt-4">
                                                    <div class="col text-center border-end border-secondary">
                                                        <strong class="h2" id="suhuData">0</strong>
                                                        <strong class="h5">&deg; C</strong>
                                                    </div>
                                                    <div class="col text-center" id="suhuStatus">
                                                        <span class="badge bg-secondary">Offline</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4">
                                        <div class="card shadow-sm">
                                            <div class="card-header text-center" style="background-color: #d975b7">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 32 32">
                                                    <path fill="white"
                                                        d="M23.476 13.993L16.847 3.437a1.04 1.04 0 0 0-1.694 0L8.494 14.044A9.986 9.986 0 0 0 7 19a9 9 0 0 0 18 0a10.063 10.063 0 0 0-1.524-5.007ZM16 26a7.009 7.009 0 0 1-7-7a7.978 7.978 0 0 1 1.218-3.943l.935-1.49l10.074 10.074A6.977 6.977 0 0 1 16 26.001Z" />
                                                </svg>
                                                <span class="text-white" style="font-size: 20px">Humidity</span>

                                            </div>
                                            <div class="card-body ">
                                                <div class="row mt-4">
                                                    <div class="col text-center border-end border-secondary">
                                                        <strong id="kelembapanData" class="h2">0</strong>
                                                        <strong class="h5">% Rh</strong>
                                                    </div>
                                                    <div class="col text-center" id="kelembapanStatus">
                                                        <span class="badge bg-secondary">Offline</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4">
                                        <div class="card shadow-sm">
                                            <div class="card-header text-center" style="background-color: #77d975">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 32 32">
                                                    <path fill="white"
                                                        d="M27.231 23.618L20 13.675V4h2V2H10v2h2v9.675l-7.231 9.943A4.018 4.018 0 0 0 8.019 30H23.98a4.018 4.018 0 0 0 3.25-6.382ZM14 14.325V4h4v10.325L20.673 18h-9.346ZM23.981 28H8.02a2.02 2.02 0 0 1-1.633-3.206L9.873 20h12.254l3.487 4.794A2.02 2.02 0 0 1 23.981 28Z" />
                                                </svg>
                                                <span class="text-white" style="font-size: 20px">Ammonia</span>
                                            </div>
                                            <div class="card-body ">
                                                <div class="row mt-4">
                                                    <div class="col text-center border-end border-secondary">
                                                        <strong id="amoniaData" class="h2">0</strong>
                                                        <strong class="h5"> ppm </strong>
                                                    </div>
                                                    <div class="col text-center" id="amoniaStatus">
                                                        <span class="badge bg-secondary">Offline</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col">
                                        <div class="card shadow-sm">
                                            <div class="card-body ">
                                                {{-- chart --}}
                                                <div class="row text-center" id="rowChart">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>
<script>
    checkKandang()

    function checkKandang() {
        let idKandang = localStorage.getItem("kandang")
        let selectKandang = document.getElementById('selectKandang')

        if (idKandang === null) {
            setKandang({{ $kandang[0]->id }})
            idKandang = {{ $kandang[0]->id }}
        }

        let kandang = {!! json_encode($kandang) !!}
        let option = ""
        kandang.forEach(item => {
            if (idKandang == item.id) {
                option += `<option value="${item.id}" selected>${item.nama_kandang}</option>`
            } else {
                option += `<option value="${item.id}">${item.nama_kandang}</option>`
            }

        });
        selectKandang.innerHTML = option
    }

    function setKandang(idKandang) {
        localStorage.setItem("kandang", idKandang)
        window.location.reload()
    }
</script>
<script>
    function setStatus(val) {
        if (val == 1) {
            $('#status').html(`<span class="badge bg-secondary">Offline</span>`)
        } else if (val == 2) {
            $('#status').html(`<span class="badge bg-success">Online</span>`)
        }
    }

    let lineChart;
    let dataSuhu = [];
    let dataKelembapan = [];
    let dataAmonia = [];

    document.addEventListener("DOMContentLoaded", function() {
        let options = {
            colors: ['#75a3d9', '#d975b7', '#77d975'],
            series: [{
                name: "Temperature",
                data: dataSuhu
            }, {
                name: "Humidity",
                data: dataKelembapan
            }, {
                name: "Amonia",
                data: dataAmonia
            }],
            chart: {
                height: 350,
                type: 'line',
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                        speed: 1000
                    }
                },
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight',

            },
            // title: {
            //     text: 'Real-time Data',
            //     align: 'left'
            // },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'],
                    opacity: 0.5
                },
            },

        };

        lineChart = new ApexCharts(document.querySelector("#rowChart"), options);
        lineChart.render();

        // Setiap 1 detik panggil fungsi updateData
        let pusher = new Pusher('4f34ab31e54a4ed8a72d', {
            cluster: 'ap1'
        });

        let channel = pusher.subscribe('sensor-data');
        channel.bind('pusher:subscription_succeeded', function() {
            // Setel callback untuk event SensorDataUpdated setelah berlangganan berhasil
            channel.bind('App\\Events\\SensorDataUpdated', function(data) {
                idKandang = data.idKandang;
                console.log(data)
                let selectedKandang = $('#selectKandang').val()
                if (idKandang == selectedKandang) {
                    let newDate = new Date().toLocaleString("en-US", {
                        timeZone: "Asia/Jakarta"
                    });
                    console.log(newDate)
                    dataSuhu.push({
                        x: newDate,
                        y: parseFloat(data.suhu).toFixed(3)
                    })
                    dataKelembapan.push({
                        x: newDate,
                        y: parseFloat(data.kelembapan).toFixed(3)
                    })
                    dataAmonia.push({
                        x: newDate,
                        y: parseFloat(data.amonia).toFixed(3)
                    })
                    let dataOutlier = {
                        suhuOutlier: data.suhuOutlier,
                        kelembapanOutlier: data.kelembapanOutlier,
                        amoniaOutlier: data.amoniaOutlier
                    }
                    updateLineData(dataOutlier)
                    resetOfflineTimeout()
                }

            });
        });
        // Timer status
        let timeDuration = 5000;
        let timeOutId
        startOfflineTimeOut()

        function startOfflineTimeOut() {
            timeOutId = setTimeout(() => {
                setStatus(1)

            }, timeDuration);
        }

        function resetOfflineTimeout() {
            clearTimeout(timeOutId)
            setStatus(2)
            startOfflineTimeOut()
        }
    });

    // Fungsi untuk mengupdate data grafik
    function updateLineData(dataOutlier) {
        let suhuOutlier = dataOutlier.suhuOutlier ? dataOutlier.suhuOutlier : null
        let kelembapanOutlier = dataOutlier.kelembapanOutlier ? dataOutlier.kelembapanOutlier : null
        let amoniaOutlier = dataOutlier.amoniaOutlier ? dataOutlier.amoniaOutlier : null

        // Generate data secara dinamis, gantilah dengan logika pengambilan data sesuai kebutuhan
        let idKandang = $('#selectKandang').val()
        // Batasi jumlah data yang ditampilkan menjadi 100 data terakhir
        const maxDataPoints = 10;

        if (dataSuhu.length > maxDataPoints) {
            dataSuhu.shift();
            dataKelembapan.shift();
            dataAmonia.shift();
        }

        let lastSuhuIndex = dataSuhu.length - 1
        let lastKelembapanIndex = dataKelembapan.length - 1
        let lastAmoniaIndex = dataAmonia.length - 1

        let lastSuhu = dataSuhu[lastSuhuIndex].y
        let lastKelembapan = dataKelembapan[lastKelembapanIndex].y
        let lastAmonia = dataAmonia[lastAmoniaIndex].y

        // Update data pada grafik
        lineChart.updateOptions({
            series: [{
                    name: 'Temperature',
                    data: dataSuhu
                },
                {
                    name: 'Humidity',
                    data: dataKelembapan
                },
                {
                    name: 'Amonia',
                    data: dataAmonia
                }
            ],
            xaxis: {
                type: 'datetime',
                labels: {
                    formatter: function(val) {
                        return new Date(val).toLocaleString("en-US", {
                            timeZone: "Asia/Jakarta"
                        });
                    },
                    style: {
                        fontSize: '10px'
                    }
                }
            }
        });
    }
</script>
