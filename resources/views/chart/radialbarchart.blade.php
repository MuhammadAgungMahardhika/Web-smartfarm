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
    <div class="col-4">
        <div id="suhuChart">

        </div>
    </div>
    <div class="col-4">
        <div id="kelembapanChart">

        </div>
    </div>
    <div class="col-4">
        <div id="amoniaChart">

        </div>
    </div>
</div>


{{-- Script Kelembapan dan Suhu dan Amonia --}}
<script></script>
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
                                    return `${val}NH3`; // Display the value with 
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
                url: `/sensor-suhu-kelembapan-amoniak/kandang/${idKandang}`,
                success: function(response) {

                    if (response.data != null) {
                        console.log(response.data)
                        let suhuKelembapan = response.data.suhuKelembapan
                        if (suhuKelembapan != null) {
                            let suhuData = suhuKelembapan.suhu
                            let kelembapanData = suhuKelembapan.kelembapan

                            // masukan nilai suhu
                            if (suhuData != null) {
                                suhuChart.updateSeries([suhuData]);
                                $('#suhuData').html(suhuData)
                            } else {
                                suhuChart.updateSeries([0]);
                                $('#suhuData').html(0)
                            }

                            // masukan nilai kelembapan
                            if (kelembapanData != null) {
                                kelembapanChart.updateSeries([kelembapanData]);
                                $('#kelembapanData').html(kelembapanData)
                            } else {
                                kelembapanChart.updateSeries([0]);
                                $('#kelembapanData').html(0)
                            }

                        } else {
                            suhuChart.updateSeries([0]);
                            $('#suhuData').html(0)
                            kelembapanChart.updateSeries([0]);
                            $('#kelembapanData').html(0)
                        }

                        let amoniaDatas = response.data.amoniak
                        if (amoniaDatas != null) {
                            let amoniak = amoniaDatas.amoniak
                            // masukan nilai amonia
                            if (amoniaData != null) {
                                amoniaChart.updateSeries([amoniak])
                                $('#amoniaData').html(amoniak)
                            } else {
                                amoniaChart.updateSeries([0])
                                $('#amoniaData').html(0)
                            }
                        } else {
                            amoniaChart.updateSeries([0])
                            $('#amoniaData').html(0)
                        }

                    } else {
                        // jika semua data kosong

                        kelembapanChart.updateSeries([0]);
                        $('#kelembapanData').html(0)

                        suhuChart.updateSeries([0]);
                        $('#suhuData').html(0)

                        amoniaChart.updateSeries([0])
                        $('#amoniaData').html(0)
                    }
                },
                error: function(err) {
                    console.log(err.responseText)
                }
            })

        }

        // Update data every 1 seconds (1000 milliseconds)
        setInterval(updateData, 1000);


    })
</script>
