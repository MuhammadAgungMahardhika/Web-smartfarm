<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Amonia Outlier Detection</h3>
                <p class="text-subtitle text-muted">Realtime Monitoring</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Amonia Outlier Detection</li>
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
                                            <label class="input-group-text" for="selectKandang">Choose Kandang</label>
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
                                <div class="row">
                                    <div class="col">
                                        <div class="card shadow-sm">
                                            <div class="card-body ">
                                                <div class="row text-center">
                                                    <div class="col-12 col-md-6 col-lg-6" id="amoniaOutlier">

                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-6" id="amoniaWinsorzing">


                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 col-lg-6 p-4">
                                                        <table>
                                                            <thead>
                                                                <th>Info Outlier</th>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        Total revival
                                                                    </td>
                                                                    <td>
                                                                        : <span id="totalRevival">0</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Mean
                                                                    </td>
                                                                    <td>
                                                                        : <span id="mean"></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Standart deviation
                                                                    </td>
                                                                    <td>
                                                                        : <span id="standartDeviation">0</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Minimum
                                                                    </td>
                                                                    <td>
                                                                        : <span id="Minumum">0</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Maximum
                                                                    </td>
                                                                    <td>
                                                                        : <span id="maximum">0</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Lower limit
                                                                    </td>
                                                                    <td>
                                                                        : <span id="lowerLimit">0</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Upper limit
                                                                    </td>
                                                                    <td>
                                                                        : <span id="upperLimit">0</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Total outlier / today
                                                                    </td>
                                                                    <td>
                                                                        : <span id="totalOutlier">0</span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-6 p-4">
                                                        <table>
                                                            <thead>
                                                                <th>Info Winsorzing</th>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        Total revival
                                                                    </td>
                                                                    <td>
                                                                        : <span id="totalRevival">0</span>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                        Minimum
                                                                    </td>
                                                                    <td>
                                                                        : <span id="Minumum">0</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Maximum
                                                                    </td>
                                                                    <td>
                                                                        : <span id="maximum">0</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Lower limit
                                                                    </td>
                                                                    <td>
                                                                        : <span id="lowerLimit">0</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Upper limit
                                                                    </td>
                                                                    <td>
                                                                        : <span id="upperLimit">0</span>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
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
{{-- Script Amonia Sigma --}}
<script>
    let amoniaSigma;
    let dataAmoniaSigma = []


    document.addEventListener("DOMContentLoaded", function() {
        let options = {
            colors: ['#75a3d9'],
            series: [{
                name: "Amonia",
                data: dataAmoniaSigma
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
            title: {
                text: 'Outlier Detection With 3 Sigma',
                align: 'left'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'],
                    opacity: 0.5
                },
            },
            xaxis: {
                type: 'datetime',
                labels: {
                    format: 'yyyy/MM/dd HH:mm:ss'
                },
                tooltip: {
                    enabled: true,
                    formatter: function(val, opts) {
                        return opts.w.globals.labels[opts.dataPointIndex]
                    }
                }
            }
        };

        // amonia sigma
        amoniaSigma = new ApexCharts(document.querySelector("#amoniaOutlier"), options);
        amoniaSigma.render();

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
                    let newDate = new Date().getTime()
                    dataAmoniaSigma.push({
                        x: newDate,
                        y: parseFloat(data.amonia).toFixed(3)
                    })
                    updateAmoniaSigma()
                }

            });
        });
    });

    // Fungsi untuk mengupdate data grafik
    function updateAmoniaSigma() {
        // Generate data secara dinamis, gantilah dengan logika pengambilan data sesuai kebutuhan
        let idKandang = $('#selectKandang').val()
        // Batasi jumlah data yang ditampilkan menjadi 100 data terakhir
        const maxDataPoints = 10;

        if (dataAmoniaSigma.length > maxDataPoints) {
            dataAmoniaSigma.shift();
        }

        let lastAmoniaIndex = dataAmoniaSigma.length - 1
        let lastAmonia = dataAmoniaSigma[lastAmoniaIndex].y


        console.log("amonia = " + lastAmonia)

        $('#amoniaData').html(lastAmonia)

        // Update data pada grafik
        amoniaSigma.updateSeries([{
            name: 'Amonia',
            data: dataAmoniaSigma
        }]);
    }
</script>
{{-- Script Amonia Winsorzing --}}
<script>
    let amoniaWinsorzing;
    let dataAmoniaWinsorzing = []


    document.addEventListener("DOMContentLoaded", function() {
        let options = {
            colors: ['#75a3d9'],
            series: [{
                name: "Amonia",
                data: dataAmoniaWinsorzing
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
            title: {
                text: 'Outlier Handling With Winsorzing',
                align: 'left'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'],
                    opacity: 0.5
                },
            },
            xaxis: {
                type: 'datetime',
                labels: {
                    format: 'yyyy/MM/dd HH:mm:ss'
                },
                tooltip: {
                    enabled: true,
                    formatter: function(val, opts) {
                        return opts.w.globals.labels[opts.dataPointIndex]
                    }
                }
            }
        };

        // amonia sigma
        amoniaWinsorzing = new ApexCharts(document.querySelector("#amoniaWinsorzing"), options);
        amoniaWinsorzing.render();

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
                    let newDate = new Date().getTime()
                    dataAmoniaWinsorzing.push({
                        x: newDate,
                        y: parseFloat(data.amonia).toFixed(3)
                    })
                    updateAmoniaWinsorzing()
                }

            });
        });
    });

    // Fungsi untuk mengupdate data grafik
    function updateAmoniaWinsorzing() {
        // Generate data secara dinamis, gantilah dengan logika pengambilan data sesuai kebutuhan
        let idKandang = $('#selectKandang').val()
        // Batasi jumlah data yang ditampilkan menjadi 100 data terakhir
        const maxDataPoints = 10;

        if (dataAmoniaWinsorzing.length > maxDataPoints) {
            dataAmoniaWinsorzing.shift();
        }

        let lastAmoniaIndex = dataAmoniaWinsorzing.length - 1
        let lastAmonia = dataAmoniaWinsorzing[lastAmoniaIndex].y


        console.log("amonia = " + lastAmonia)

        $('#amoniaData').html(lastAmonia)

        // Update data pada grafik
        amoniaWinsorzing.updateSeries([{
            name: 'Amonia',
            data: dataAmoniaWinsorzing
        }]);
    }
</script>
