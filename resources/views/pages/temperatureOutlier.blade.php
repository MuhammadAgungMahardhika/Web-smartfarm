<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Temperature Outlier Detection</h3>
                <p class="text-subtitle text-muted">Realtime Monitoring</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Temperature Outlier Detection</li>
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
                                                    <div class="col-12 col-md-6 col-lg-6" id="suhuOutlier">

                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-6" id="suhuWinsorzing">


                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 col-lg-6 p-4">
                                                        <table>
                                                            <thead>
                                                                <th>Info </th>
                                                            </thead>
                                                            <tbody id="suhuOutlierTable">
                                                                <tr>
                                                                    <td>
                                                                        Total records
                                                                    </td>
                                                                    <td>
                                                                        : <span id="totalRecords"></span>
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
                                                                        : <span id="standartDeviation"></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Minimum
                                                                    </td>
                                                                    <td>
                                                                        : <span id="minimum"></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Maksimum
                                                                    </td>
                                                                    <td>
                                                                        : <span id="maksimum"></span>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                        Lower limit
                                                                    </td>
                                                                    <td>
                                                                        : <span id="lowerLimit"></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Upper limit
                                                                    </td>
                                                                    <td>
                                                                        : <span id="upperLimit"></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Total outlier
                                                                    </td>
                                                                    <td>
                                                                        : <span id="totalOutlier"></span>
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
                                                                        Total records
                                                                    </td>
                                                                    <td>
                                                                        : <span id="totalRecordsW"></span>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                        Minimum
                                                                    </td>
                                                                    <td>
                                                                        : <span id="minimumW"></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Maximum
                                                                    </td>
                                                                    <td>
                                                                        : <span id="maximumW"></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Lower limit
                                                                    </td>
                                                                    <td>
                                                                        : <span id="lowerLimitW"></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Upper limit
                                                                    </td>
                                                                    <td>
                                                                        : <span id="upperLimitW"></span>
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
{{-- Script Suhu Sigma --}}
<script>
    let suhuSigmaChart, suhuWinsorzingChart;
    let dataSuhuSigma = []
    let dataSuhuWinsorzing = []

    // variable suhu winsorzing
    let minimumW = 0
    let maksimumW = 0
    let totalRecordsW = 0
    // variable suhu outlier
    let minimum = 0
    let maksimum = 0
    let totalOutlier = 0
    let totalRecords = 0


    function setCardsStatusToOffline() {
        $('#status').html(`<span class="badge bg-secondary">Offline</span>`)
    }

    function setCardsStatusToOnline() {
        $('#status').html(`<span class="badge bg-success">Online</span>`)
    }

    function setSuhuWinsorzingTable(data) {
        totalRecordsW++
        let lowerLimit = data.lowerLimit
        let upperLimit = data.upperLimit
        let suhuWinsorzing = data.suhuWinsorzing
        let suhu = parseFloat(suhuWinsorzing)
        let tempMinim, tempMaksim
        // menentukan nilai minimum
        minimumW == 0 ? minimumW = suhu : '';
        tempMinim = minimumW;
        suhu < tempMinim ? minimumW = suhu : '';

        // menentukan nilai maksimum
        maksimumW == 0 ? maksimumW = suhu : '';
        tempMaksim = maksimumW;
        suhu > tempMaksim ? maksimumW = suhu : '';

        $('#totalRecordsW').html(totalRecordsW)
        $('#minimumW').html(minimumW)
        $('#maximumW').html(maksimumW)
        $('#lowerLimitW').html(lowerLimit)
        $('#upperLimitW').html(upperLimit)
    }

    function setSuhuOutlierTable(data) {

        totalRecords++
        let mean = data.mean
        let stdDev = data.stdDev
        let lowerLimit = data.lowerLimit
        let upperLimit = data.upperLimit
        let suhuOutlier = data.suhuOutlier
        let suhuWinsorzing = data.suhuWinsorzing
        let suhu = parseFloat(suhuWinsorzing)
        console.log(data)
        console.log(suhu)
        let tempMinim, tempMaksim

        // menentukan total outlier
        if (suhuOutlier != null) {
            suhu = parseFloat(suhuOutlier).toFixed(3)
            totalOutlier++
        }

        // menentukan nilai minimum
        minimum == 0 ? minimum = suhu : '';
        tempMinim = minimum;
        suhu < tempMinim ? minimum = suhu : '';

        // menentukan nilai maksimum
        maksimum == 0 ? maksimum = suhu : '';
        tempMaksim = maksimum;
        suhu > tempMaksim ? maksimum = suhu : '';


        $('#totalRecords').html(totalRecords)
        $('#mean').html(mean)
        $('#standartDeviation').html(stdDev)
        $('#minimum').html(minimum)
        $('#maksimum').html(maksimum)
        $('#lowerLimit').html(lowerLimit)
        $('#upperLimit').html(upperLimit)
        $('#totalOutlier').html(totalOutlier)
    }


    let options = {
        colors: ['#75a3d9'],
        series: [{
            name: "Temperature",
            data: dataSuhuSigma
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
                enabled: true,
                type: 'xy' // Tipe zoom, 'xy' untuk zoom in/out pada sumbu X dan Y
            },
            pan: {
                enabled: true,
                type: 'xy' // Tipe pan, 'xy' untuk pan pada sumbu X dan Y
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
        }
    };

    let optionWinsorzing = {
        colors: ['#75a3d9'],
        series: [{
            name: "Temperature",
            data: dataSuhuWinsorzing
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
                enabled: true,
                type: 'xy' // Tipe zoom, 'xy' untuk zoom in/out pada sumbu X dan Y
            },
            pan: {
                enabled: true,
                type: 'xy' // Tipe pan, 'xy' untuk pan pada sumbu X dan Y
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
        }

    };

    // suhu sigma
    suhuSigmaChart = new ApexCharts(document.querySelector("#suhuOutlier"), options);
    suhuSigmaChart.render();

    // suhu winsorzing
    suhuWinsorzingChart = new ApexCharts(document.querySelector("#suhuWinsorzing"), optionWinsorzing);
    suhuWinsorzingChart.render();

    // Timer status , 5 menit 5 detik
    let timeDuration = 305000;
    let timeOutId
    startOfflineTimeOut()

    // Setiap 1 detik panggil fungsi updateData
    let pusher = new Pusher('4f34ab31e54a4ed8a72d', {
        cluster: 'ap1'
    });

    let channel = pusher.subscribe('suhu-outlier');
    channel.bind('pusher:subscription_succeeded', function() {
        // Setel callback untuk event SensorDataUpdated setelah berlangganan berhasil
        channel.bind('App\\Events\\SuhuOutlierUpdated', function(data) {

            let idKandang = data.idKandang;
            let selectedKandang = $('#selectKandang').val()
            if (idKandang == selectedKandang) {

                updateDataAndChart(data)
                resetOfflineTimeout()
            }

        });
    });



    function startOfflineTimeOut() {
        timeOutId = setTimeout(() => {
            setCardsStatusToOffline()
        }, timeDuration);
    }

    function resetOfflineTimeout() {
        setCardsStatusToOnline()
        clearTimeout(timeOutId)
        startOfflineTimeOut()
    }
    // Fungsi untuk mengupdate data dan grafik
    function updateDataAndChart(data) {

        let newDate = new Date().toLocaleString("en-US", {
            timeZone: "Asia/Jakarta"
        });
        let upperLimit = data.upperLimit
        let lowerLimit = data.lowerLimit
        let suhuOutlier = data.suhuOutlier
        let suhuWinsorzing = data.suhuWinsorzing
        let suhu = suhuOutlier != null ? parseFloat(suhuOutlier) : parseFloat(suhuWinsorzing)

        // simpan nilai sebelum dan yang baru pada suhu outlier
        dataSuhuSigma.push({
            x: newDate,
            y: parseFloat(suhu).toFixed(3)
        })

        // Update suhu outlier 
        setSuhuOutlierTable(data)
        // Batasi jumlah data suhu outlier yang ditampilkan menjadi 10 data terakhir
        const maxDataPoints = 10;
        if (dataSuhuSigma.length > maxDataPoints) {
            dataSuhuSigma.shift();
        }

        // Update grafik suhu outlier, batas atas dan batas bawah
        let maxDataValue = Math.max(...dataSuhuSigma.map(entry => entry.y));

        suhuSigmaChart.updateOptions({
            series: [{
                data: dataSuhuSigma
            }],
            yaxis: {
                max: maxDataValue + 20,
                min: -(maxDataValue + 20),
            },
            annotations: {
                yaxis: [{
                    y: parseFloat(upperLimit),
                    borderColor: '#FF0000',
                    label: {
                        style: {
                            color: '#FF0000',
                            fontSize: '7px'
                        },
                        text: 'Upper Limit',
                        offsetY: 0,
                        offsetX: 0,

                    }
                }, {
                    y: parseFloat(lowerLimit),
                    borderColor: '#FF0000',
                    label: {
                        style: {
                            color: '#FF0000',
                            fontSize: '7px'
                        },
                        text: 'Lower Limit',
                        offsetY: 0,
                        offsetX: 0,

                    }
                }]
            },
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

        // Update suhu winsorzing 
        if (suhuWinsorzing != suhu) {
            console.log("suhu transformed")
            console.log("suhu : " + suhu + typeof suhu)
            dataSuhuWinsorzing.push({
                x: newDate,
                y: parseFloat(suhuWinsorzing).toFixed(3)
            })
            setSuhuWinsorzingTable(data)
            // Batasi jumlah data suhu winsorzing yang ditampilkan menjadi 10 data terakhir
            if (dataSuhuWinsorzing.length > maxDataPoints) {
                dataSuhuWinsorzing.shift();
            }
            // Update grafik suhu winsorzing
            suhuWinsorzingChart.updateOptions({
                series: [{
                    data: dataSuhuWinsorzing
                }],
                yaxis: {
                    max: maxDataValue + 20,
                    min: -(maxDataValue + 20),
                },
                annotations: {
                    yaxis: [{
                        y: parseFloat(upperLimit),
                        borderColor: '#FF0000',
                        label: {
                            style: {
                                color: '#FF0000',
                                fontSize: '7px'
                            },
                            text: 'Upper Limit',
                            offsetY: 0,
                            offsetX: 0,

                        }
                    }, {
                        y: parseFloat(lowerLimit),
                        borderColor: '#FF0000',
                        label: {
                            style: {
                                color: '#FF0000',
                                fontSize: '7px'
                            },
                            text: 'Lower Limit',
                            offsetY: 0,
                            offsetX: 0,

                        }
                    }]
                },
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
    }
    // history
    function getDateToday() {
        return new Date().toISOString().split('T')[0];
    }
    setInitialValue(getDateToday())


    function setInitialValue(date) {

        let idKandang = localStorage.getItem("kandang")
        $.ajax({
            url: `/sensors/suhu/${idKandang}/${date}`,
            method: 'GET',
            dataType: 'json',

            success: function(response) {
                let datas = response.data
                let mean = response.mean
                let stdDev = response.stddev
                let lowerLimit = response.lower_limit
                let upperLimit = response.upper_limit

                datas.forEach((d, index) => {
                    setTimeout(() => {
                        let suhuOutlier = d.suhu_outlier;
                        let suhuWinsorzing = d.suhu;

                        let data = {
                            mean: mean,
                            stdDev: stdDev,
                            lowerLimit: lowerLimit,
                            upperLimit: upperLimit,
                            suhuOutlier: suhuOutlier,
                            suhuWinsorzing: suhuWinsorzing
                        };
                        updateDataAndChart(data);

                    }, index * 1000);
                    resetOfflineTimeout()
                });

            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);

            }
        });
    }
</script>
