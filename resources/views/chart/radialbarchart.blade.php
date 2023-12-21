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
<div class="row text-center">
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
    let suhuChart, kelembapanChart, amoniaChart
    document.addEventListener("DOMContentLoaded", () => {
        const timeDuration = 5000;
        let timeOutId

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
            labels: ['Suhu']
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
                                    return '0°C'; // Label for start value
                                } else if (opt.angle === 90) {
                                    return '100°C'; // Label for end value
                                } else {
                                    return `${val}%rh`; // Display temperature value with °C
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
            labels: ['Kelembapan']
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
                                    return '0°C'; // Label for start value
                                } else if (opt.angle === 90) {
                                    return '100°C'; // Label for end value
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

        var pusher = new Pusher('4f34ab31e54a4ed8a72d', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('sensor-data');
        channel.bind('pusher:subscription_succeeded', function() {
            // Setel callback untuk event SensorDataUpdated setelah berlangganan berhasil
            channel.bind('App\\Events\\SensorDataUpdated', function(data) {
                idKandang = data.idKandang;
                suhu = parseInt(data.suhu);
                kelembapan = parseInt(data.kelembapan);
                amonia = parseInt(data.amonia);
                let selectedKandang = $('#selectKandang').val()

                if (idKandang == selectedKandang) {
                    updateData(suhu, kelembapan, amonia)
                }
                resetOfflineTimeout()
            });
        });
        startOfflineTimeOut()
    })

    // Function to update chart data in real-time
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
</script>
