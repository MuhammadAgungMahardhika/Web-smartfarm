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
                                        return `${val}°C`; // Display temperature value with °C
                                    }
                                }
                            }
                        },
                        startAngle: -135, // Adjust the start angle
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
                                        return `${val}%RH`; // Display temperature value with °C
                                    }
                                },
                            }
                        },
                        startAngle: -135, // Adjust the start angle
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
                                        return `${val}PPM`; // Display the value with 
                                    }
                                },
                            }
                        },
                        startAngle: -135, // Adjust the start angle
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
                // Setel callback untuk event SensorDataUpdated setelah berlangganan berhasil
                channel.bind('App\\Events\\SensorDataUpdated', function(data) {
                    idKandang = data.idKandang;
                    let selectedKandang = $('#selectKandang').val()
                    if (idKandang == selectedKandang) {
                        suhu = parseFloat(data.suhu).toFixed(3);
                        kelembapan = parseFloat(data.kelembapan).toFixed(3);
                        amonia = parseFloat(data.amonia).toFixed(3);
                        console.log(data)
                        updateData(suhu, kelembapan, amonia)
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
                    setStatus(false)
                    updateData()
                }, timeDuration);
            }

            function resetOfflineTimeout() {
                clearTimeout(timeOutId)
                setStatus(true)
                startOfflineTimeOut()
            }

            function setStatus(status) {
                if (status == false) {
                    $("#status").html(`<span class="badge bg-secondary">Offline</span>`)
                } else if (status == true) {
                    $('#status').html(`<span class="badge bg-success">Online</span>`)
                }
            }

        })

        // Function to update radial chart data in real-time
        function updateData(suhuData = null, kelembapanData = null, amoniaData = null) {
            if (suhuData != null || kelembapanData != null || amoniaData != null) {

                console.log("suhu =" + suhuData)
                console.log("kelembapan =" + kelembapanData)
                console.log("amonia =" + amoniaData)

                if (suhuData != null && !isNaN(suhuData)) {
                    suhuChart.updateSeries([suhuData], true, {
                        duration: 200
                    });
                    $('#suhuData').html(suhuData);
                } else {
                    suhuChart.updateSeries([0], true, {
                        duration: 200
                    });
                    $('#suhuData').html(0);
                }

                if (kelembapanData != null && !isNaN(kelembapanData)) {
                    kelembapanChart.updateSeries([kelembapanData], true, {
                        duration: 200
                    });
                    $('#kelembapanData').html(kelembapanData);
                } else {
                    kelembapanChart.updateSeries([0], true, {
                        duration: 200
                    });
                    $('#kelembapanData').html(0);
                }

                if (amoniaData != null && !isNaN(amoniaData)) {
                    amoniaChart.updateSeries([amoniaData], true, {
                        duration: 200
                    });
                    $('#amoniaData').html(amoniaData);
                } else {
                    amoniaChart.updateSeries([0], true, {
                        duration: 200
                    });
                    $('#amoniaData').html(0);
                }
            } else {
                $("#status").html(`<span class="badge bg-secondary">Offline</span>`)
                // jika semua data kosong
                kelembapanChart.updateSeries([0], true, {
                    duration: 200
                });
                $('#kelembapanData').html(0);

                suhuChart.updateSeries([0], true, {
                    duration: 200
                });
                $('#suhuData').html(0);

                amoniaChart.updateSeries([0], true, {
                    duration: 200
                });
                $('#amoniaData').html(0);
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
                    text: 'Real-time Data',
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
                    let newDate = new Date().getTime()
                    dataSuhu.push({
                        x: newDate,
                        y: parseFloat(data.suhu).toFixed(3)
                    })
                    dataKelembapan.push({
                        x: newDate,
                        y: parseFloat(data.amonia).toFixed(3)
                    })
                    dataAmonia.push({
                        x: newDate,
                        y: parseFloat(data.kelembapan).toFixed(3)
                    })
                    let selectedKandang = $('#selectKandang').val()
                    if (idKandang == selectedKandang) {
                        updateData()
                    }

                });
            });
        });

        // Fungsi untuk mengupdate data grafik
        function updateData() {
            // Generate data secara dinamis, gantilah dengan logika pengambilan data sesuai kebutuhan
            let idKandang = $('#selectKandang').val()
            // Batasi jumlah data yang ditampilkan menjadi 100 data terakhir
            const maxDataPoints = 10;

            if (dataSuhu.length > maxDataPoints) {
                dataSuhu.shift();
                dataKelembapan.shift();
                dataAmonia.shift();
            }

            // Update data pada grafik
            lineChart.updateSeries([{
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
            ]);
        }


    }
</script>
