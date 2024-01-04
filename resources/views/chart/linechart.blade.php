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
    let suhuChart, kelembapanChart, amoniaChart;
    document.addEventListener("DOMContentLoaded", () => {
        const timeDuration = 5000;
        let timeOutId;

        function startOfflineTimeOut() {
            timeOutId = setTimeout(() => {
                setStatus(false);
                updateData();
            }, timeDuration);
        }

        function resetOfflineTimeout() {
            clearTimeout(timeOutId);
            setStatus(true);
            startOfflineTimeOut();
        }

        function setStatus(status) {
            if (status == false) {
                $("#status").html(`<span class="badge bg-secondary">Offline</span>`);
            } else if (status == true) {
                $('#status').html(`<span class="badge bg-success">Online</span>`);
            }
        }

        // suhu
        let optionSuhuChart = {
            chart: {
                type: 'line', // Change chart type to 'line'
                height: 350,
            },
            xaxis: {
                type: 'datetime', // Assuming you want time-based x-axis
            },
            yaxis: {
                title: {
                    text: 'Temperature (°C)',
                },
            },
            series: [{
                name: 'Temperature',
                data: [],
            }],
        };

        suhuChart = new ApexCharts(document.querySelector("#suhuChart"), optionSuhuChart);
        suhuChart.render();

        // kelembapan
        let optionKelembapanChart = {
            chart: {
                type: 'line', // Change chart type to 'line'
                height: 350,
            },
            xaxis: {
                type: 'datetime', // Assuming you want time-based x-axis
            },
            yaxis: {
                title: {
                    text: 'Humidity (%RH)',
                },
            },
            series: [{
                name: 'Humidity',
                data: [],
            }],
        };

        kelembapanChart = new ApexCharts(document.querySelector("#kelembapanChart"), optionKelembapanChart);
        kelembapanChart.render();

        // amonia
        let optionsAmonia = {
            chart: {
                type: 'line', // Change chart type to 'line'
                height: 350,
            },
            xaxis: {
                type: 'datetime', // Assuming you want time-based x-axis
            },
            yaxis: {
                title: {
                    text: 'Amonia (PPM)',
                },
            },
            series: [{
                name: 'Amonia',
                data: [],
            }],
        };

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
                suhu = parseFloat(data.suhu).toFixed(3);
                kelembapan = parseFloat(data.kelembapan).toFixed(3);
                amonia = parseFloat(data.amonia).toFixed(3);
                console.log(data);
                let selectedKandang = $('#selectKandang').val();

                if (idKandang == selectedKandang) {
                    updateData(suhu, kelembapan, amonia, data.timestamp);
                }
                resetOfflineTimeout();
            });
        });
        startOfflineTimeOut();
    });

    // Function to update chart data in real-time
    function updateData(suhuData = null, kelembapanData = null, amoniaData = null, timestamp = null) {
        if (suhuData != null || kelembapanData != null || amoniaData != null) {
            const updatedTimestamp = timestamp ? new Date(timestamp) : new Date();

            if (suhuData != null && !isNaN(suhuData)) {
                suhuChart.updateSeries([{
                    data: [{
                        x: updatedTimestamp,
                        y: suhuData
                    }]
                }], true);
                $('#suhuData').html(suhuData);
            } else {
                suhuChart.updateSeries([{
                    data: []
                }], true);
                $('#suhuData').html(0);
            }

            if (kelembapanData != null && !isNaN(kelembapanData)) {
                kelembapanChart.updateSeries([{
                    data: [{
                        x: updatedTimestamp,
                        y: kelembapanData
                    }]
                }], true);
                $('#kelembapanData').html(kelembapanData);
            } else {
                kelembapanChart.updateSeries([{
                    data: []
                }], true);
                $('#kelembapanData').html(0);
            }

            if (amoniaData != null && !isNaN(amoniaData)) {
                amoniaChart.updateSeries([{
                    data: [{
                        x: updatedTimestamp,
                        y: amoniaData
                    }]
                }], true);
                $('#amoniaData').html(amoniaData);
            } else {
                amoniaChart.updateSeries([{
                    data: []
                }], true);
                $('#amoniaData').html(0);
            }
        } else {
            $("#status").html(`<span class="badge bg-secondary">Offline</span>`);
            // jika semua data kosong
            kelembapanChart.updateSeries([{
                data: []
            }], true);
            $('#kelembapanData').html(0);

            suhuChart.updateSeries([{
                data: []
            }], true);
            $('#suhuData').html(0);

            amoniaChart.updateSeries([{
                data: []
            }], true);
            $('#amoniaData').html(0);
        }
    }
</script>
