{{-- Style --}}
<style>
    #suhuChart {

        margin: auto auto;
    }

    #kelembapanChart {

        margin: auto auto;
    }

    #amoniaChart {
        margin: auto auto;
    }
</style>

{{-- Element --}}
<div class="row text-center" id="rowChart">
    <div class="col-12 col-md-4 col-lg-4">
        <div id="suhuChart">

        </div>
    </div>
    <div class="col-12 col-md-4 col-lg-4">
        <div id="kelembapanChart">

        </div>
    </div>
    <div class="col-12 col-md-4 col-lg-4">
        <div id="amoniaChart">

        </div>
    </div>
</div>

{{-- Script Kelembapan dan Suhu dan Amonia --}}
<script>
    checkChartType()

    function checkChartType() {
        let checkChart = localStorage.getItem("chart")
        if (checkChart === null) {
            setChartType("radial")
        }
        let selectChart = document.getElementById('selectChart')
        if (checkChart == "radial") {
            selectChart.innerHTML = `<option value="radial" selected>Radial</option>
                                    <option value="line">Line</option>`
        } else if (checkChart == "line") {
            selectChart.innerHTML = `<option value="radial">Radial</option>
                                    <option value="line" selected>Line</option>`
        }
    }

    function setChartType(type) {
        localStorage.setItem("chart", type)
        window.location.reload()
    }

    function setCardsStatusToOffline() {
        setGlobalStatus(2)
        setSuhuCardValue(0, 2)
        setKelembapanCardValue(0, 2)
        setAmoniaCardValue(0, 2)
    }

    function setGlobalStatus(status) {
        if (status == 1) {
            $('#status').html(`<span class="badge bg-success">Online</span>`)
        } else if (status == 2) {
            $('#status').html(`<span class="badge bg-secondary">Offline</span>`)
        }
    }

    function setSuhuCardValue(value, status) {
        $('#suhuData').html(value)
        if (status == 1) {
            $("#suhuStatus").html(`<span class="badge bg-danger">Invalid</span>`)
        } else if (status == 2) {
            $("#suhuStatus").html(`<span class="badge bg-secondary">Offline</span>`)
        } else if (status == 3) {
            $("#suhuStatus").html(`<span class="badge bg-success">Normal</span>`)

        } else if (status == 4) {
            $("#suhuStatus").html(`<span class="badge bg-warning">Transformed</span>`)
        }
    }

    function setKelembapanCardValue(value, status) {
        $('#kelembapanData').html(value)
        if (status == 1) {
            $("#kelembapanStatus").html(`<span class="badge bg-danger">Invalid</span>`)
        } else if (status == 2) {
            $("#kelembapanStatus").html(`<span class="badge bg-secondary">Offline</span>`)
        } else if (status == 3) {
            $("#kelembapanStatus").html(`<span class="badge bg-success">Normal</span>`)

        } else if (status == 4) {
            $("#kelembapanStatus").html(`<span class="badge bg-warning">Transformed</span>`)
        }
    }

    function setAmoniaCardValue(value, status) {
        $('#amoniaData').html(value);
        if (status == 1) {
            $("#amoniaStatus").html(`<span class="badge bg-danger">Invalid</span>`)
        } else if (status == 2) {
            $("#amoniaStatus").html(`<span class="badge bg-secondary">Offline</span>`)
        } else if (status == 3) {
            $("#amoniaStatus").html(`<span class="badge bg-success">Normal</span>`)

        } else if (status == 4) {
            $("#amoniaStatus").html(`<span class="badge bg-warning">Transformed</span>`)
        }
    }
    // check chart
    let checkChart = document.getElementById('selectChart').value
    console.log("chartnya = " + checkChart)
    if (checkChart == "radial") {
        // render chart radial chart
        console.log("radial chart")
        let suhuChart, kelembapanChart, amoniaChart
        document.addEventListener("DOMContentLoaded", () => {
            // suhu
            let optionSuhuChart = {
                colors: ['#75a3d9'],
                chart: {
                    type: 'radialBar'
                },
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: {
                                show: true,
                                // fontSize: '16px',
                                color: '#888',
                                // offsetY: '-10px',
                            },
                            value: {
                                fontSize: '24px',
                                color: '#75a3d9',
                                show: true,
                                formatter: function(val, opt) {
                                    if (opt.angle === -90) {
                                        return 'Start'; // Label for start value
                                    } else if (opt.angle === 90) {
                                        return 'End'; // Label for end value
                                    } else {
                                        return `${val} °C`; // Display temperature value with °C
                                    }
                                }
                            }
                        },
                        startAngle: -135,
                        endAngle: 135,
                        hollow: {
                            size: '60%',
                        },
                    }
                },
                series: [0],
                labels: ['Temperature']
            }
            suhuChart = new ApexCharts(document.querySelector("#suhuChart"), optionSuhuChart);

            suhuChart.render();
            // kelembapan
            let optionKelembapanChart = {
                colors: ['#d975b7'],
                chart: {
                    type: 'radialBar'
                },
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: {
                                show: true,
                                // fontSize: '16px',
                                color: '#888',
                                // offsetY: '-10px',
                            },
                            value: {
                                fontSize: '24px',
                                color: '#75a3d9',
                                show: true,
                                formatter: function(val, opt) {
                                    if (opt.angle === -90) {
                                        return '0'; // Label for start value
                                    } else if (opt.angle === 90) {
                                        return '100'; // Label for end value
                                    } else {
                                        return `${val} %Rh`; // Display humidity value with rh
                                    }
                                },
                            }
                        },
                        startAngle: -135,
                        endAngle: 135,
                        hollow: {
                            size: '60%',
                        },
                    }
                },
                series: [0],
                labels: ['Humidity']
            }

            kelembapanChart = new ApexCharts(document.querySelector("#kelembapanChart"), optionKelembapanChart);
            kelembapanChart.render();

            let optionsAmonia = {
                colors: ['#77d975'],
                chart: {
                    type: 'radialBar'
                },
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: {
                                show: true,
                                // fontSize: '16px',
                                color: '#888',
                                // offsetY: '-10px',
                            },
                            value: {
                                fontSize: '24px',
                                color: '#75a3d9',
                                show: true,
                                formatter: function(val, opt) {
                                    if (opt.angle === -90) {
                                        return '0'; // Label for start value
                                    } else if (opt.angle === 90) {
                                        return '100'; // Label for end value
                                    } else {
                                        return `${val} ppm`; // Display the amonia value with ppm
                                    }
                                },
                            }
                        },
                        startAngle: -135,
                        endAngle: 135,
                        hollow: {
                            size: '60%',
                        },
                    }
                },
                series: [0],
                labels: ['Amonia']
            }

            amoniaChart = new ApexCharts(document.querySelector("#amoniaChart"), optionsAmonia);
            amoniaChart.render();

            let pusher = new Pusher('4f34ab31e54a4ed8a72d', {
                cluster: 'ap1'
            });

            let channel = pusher.subscribe('sensor-data');
            channel.bind('pusher:subscription_succeeded', function() {

                channel.bind('App\\Events\\SensorDataUpdated', function(data) {
                    idKandang = data.idKandang;
                    let selectedKandang = $('#selectKandang').val()
                    if (idKandang == selectedKandang) {
                        let suhu = parseFloat(data.suhu).toFixed(3);
                        let suhuOutlier = data.suhuOutlier ? data.suhuOutlier : null
                        let kelembapan = parseFloat(data.kelembapan).toFixed(3);
                        let kelembapanOutlier = data.kelembapanOutlier ? data
                            .kelembapanOutlier : null
                        let amonia = parseFloat(data.amonia).toFixed(3);
                        let amoniaOutlier = data.amoniaOutlier ? data.amoniaOutlier : null

                        let dataOutlier = {
                            suhuOutlier: suhuOutlier,
                            kelembapanOutlier: kelembapanOutlier,
                            amoniaOutlier: amoniaOutlier,
                        }
                        updateData(suhu, kelembapan, amonia, dataOutlier)
                        resetOfflineTimeout()
                    }
                });
            });

            // Timer status 5 menit 5 detik
            let timeDuration = 305000;
            let timeOutId
            startOfflineTimeOut()

            function startOfflineTimeOut() {
                timeOutId = setTimeout(() => {
                    setCardsStatusToOffline()
                    updateData()
                }, timeDuration);
            }

            function resetOfflineTimeout() {

                clearTimeout(timeOutId)
                startOfflineTimeOut()
            }



        })

        // Function to update radial chart data in real-time
        function updateData(suhuData = null, kelembapanData = null, amoniaData = null, dataOutlier = null) {
            setGlobalStatus(1)
            if (suhuData != null || kelembapanData != null || amoniaData != null) {
                console.log("suhu =" + suhuData)
                console.log("kelembapan =" + kelembapanData)
                console.log("amonia =" + amoniaData)
                console.log("suhu outlier : " + dataOutlier.suhuOutlier)
                console.log("kelembapan outlier : " + dataOutlier.kelembapanOutlier)
                console.log("amonia outlier : " + dataOutlier.amoniaOutlier)

                if (suhuData != null && !isNaN(suhuData)) {
                    suhuChart.updateSeries([suhuData], true, {
                        duration: 200
                    });

                    // check jika data sebelumnya outlier ganti status
                    let suhuOutlier = dataOutlier.suhuOutlier
                    suhuOutlier != null ?
                        setSuhuCardValue(suhuData, 4) :
                        setSuhuCardValue(suhuData, 3)

                } else {
                    suhuChart.updateSeries([0], true, {
                        duration: 200
                    });
                    setSuhuCardValue(0, 1)
                }

                if (kelembapanData != null && !isNaN(kelembapanData)) {
                    kelembapanChart.updateSeries([kelembapanData], true, {
                        duration: 200
                    });

                    let kelembapanOutlier = dataOutlier.kelembapanOutlier
                    kelembapanOutlier != null ?
                        setKelembapanCardValue(kelembapanData, 4) :
                        setKelembapanCardValue(kelembapanData, 3)
                } else {
                    kelembapanChart.updateSeries([0], true, {
                        duration: 200
                    });
                    setKelembapanCardValue(0, 1)
                }

                if (amoniaData != null && !isNaN(amoniaData)) {
                    amoniaChart.updateSeries([amoniaData], true, {
                        duration: 200
                    });
                    let amoniaOutlier = dataOutlier.amoniaOutlier
                    amoniaOutlier != null ?
                        setAmoniaCardValue(amoniaData, 4) :
                        setAmoniaCardValue(amoniaData, 3)
                } else {
                    amoniaChart.updateSeries([0], true, {
                        duration: 200
                    });
                    setAmoniaCardValue(0, 1)
                }
            } else {
                // jika semua data kosong
                kelembapanChart.updateSeries([0], true, {
                    duration: 200
                });
                suhuChart.updateSeries([0], true, {
                    duration: 200
                });
                amoniaChart.updateSeries([0], true, {
                    duration: 200
                });
                setCardsStatusToOffline()
            }

        }
    } else if (checkChart == "line") {
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
                    }

                });
            });
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

            // update data 
            suhuOutlier != null ? setSuhuCardValue(lastSuhu, 4) : setSuhuCardValue(lastSuhu, 3)
            kelembapanOutlier != null ? setKelembapanCardValue(lastKelembapan, 4) : setKelembapanCardValue(
                lastKelembapan, 3)
            amoniaOutlier != null ? setAmoniaCardValue(lastAmonia, 4) : setAmoniaCardValue(
                lastAmonia, 3)

            // Update data pada grafik
            // lineChart.updateSeries([{
            //         name: 'Temperature',
            //         data: dataSuhu
            //     },
            //     {
            //         name: 'Humidity',
            //         data: dataKelembapan
            //     },
            //     {
            //         name: 'Amonia',
            //         data: dataAmonia
            //     }
            // ]);

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


    }
</script>
