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


{{-- Script Kelembapan dan Suhu --}}
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

        var suhuChart = new ApexCharts(document.querySelector("#suhuChart"), optionSuhuChart);
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

        var kelembapanChart = new ApexCharts(document.querySelector("#kelembapanChart"), optionKelembapanChart);
        kelembapanChart.render();

        // Function to update chart data in real-time
        function updateData() {
            // Simulate new temperature data (replace with your actual data)
            let kelembapanData = Math.floor(Math.random() * 100);
            let suhuData = Math.floor(Math.random() * 100);
            let data = {
                id_kandang: 1,
                suhu: suhuData,
                kelembapan: kelembapanData
            }

            $.ajax({
                type: "POST",
                url: `/sensor-suhu`,
                data: JSON.stringify(data),
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response)

                    kelembapanChart.updateSeries([kelembapanData]);
                    $('#kelembapanData').html(kelembapanData)

                    suhuChart.updateSeries([suhuData]);
                    $('#suhuData').html(suhuData)
                },
                error: function(err) {
                    console.log(err.responseText)
                }
            })

        }

        // Update data every 3 seconds (3000 milliseconds)
        setInterval(updateData, 1000);


    })
</script>

{{-- Script Amonia --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        let options = {
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

        var chart = new ApexCharts(document.querySelector("#amoniaChart"), options);
        chart.render();

        // Function to update chart data in real-time
        function updateData() {
            // Simulate new temperature data (replace with your actual data)
            amoniaData = Math.floor(Math.random() * 100);
            // Update the chart series with the new data
            chart.updateSeries([amoniaData]);
            $('#amoniaData').html(amoniaData)
            let data = {
                id_kandang: 1,
                amoniak: amoniaData
            }
            updateSensorData(data)
        }

        // Update data every 3 seconds (3000 milliseconds)
        setInterval(updateData, 1000);

        // update sensor data
        function updateSensorData(data) {
            $.ajax({
                type: "POST",
                url: `/sensor-amoniak`,
                data: JSON.stringify(data),
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response)
                },
                error: function(err) {
                    console.log(err.responseText)
                }
            })
        }
    })
</script>
