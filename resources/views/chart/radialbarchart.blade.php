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
            series: [30],
            labels: ['Suhu']
        }

        let suhuChart = new ApexCharts(document.querySelector("#suhuChart"), optionSuhuChart);
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
            series: [30],
            labels: ['Kelembapan']
        }

        let kelembapanChart = new ApexCharts(document.querySelector("#kelembapanChart"), optionKelembapanChart);
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
            series: [30],
            labels: ['Amonia']
        }

        let amoniaChart = new ApexCharts(document.querySelector("#amoniaChart"), optionsAmonia);
        amoniaChart.render();

        // Function to update chart data in real-time
        function updateData() {
            let idKandang = $('#selectKandang').val()
            // get data from database suhu kelembapan amoniak
            $.ajax({
                type: "GET",
                // cache: false,
                url: `/sensor-suhu-kelembapan-amoniak/kandang/${idKandang}`,
                success: function(response) {
                    if (response.data.sensor != null) {
                        let sensor = response.data.sensor
                        // masukkan nilai suhu
                        console.log("suhu =" + sensor.suhu)
                        console.log("kelembapan =" + sensor.kelembapan)
                        console.log("amonia =" + sensor.amonia)

                        let suhuData = sensor.suhu;
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

                        // masukkan nilai kelembapan
                        let kelembapanData = sensor.kelembapan;
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

                        // masukkan nilai amonia
                        let amoniaData = sensor.amonia;
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
                        console.log("semua kosong")
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
                },
                error: function(err) {
                    console.log(err.responseText);
                }
            });

        }

        // Update data every 1 seconds (1000 milliseconds)
        setInterval(updateData, 1000);


    })
</script>
