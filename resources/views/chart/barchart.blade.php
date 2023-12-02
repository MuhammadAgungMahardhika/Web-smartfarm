{{-- Style --}}
<style>
    #chart {
        max-width: 650px;
        margin: 35px auto;
    }
</style>

{{-- element --}}

<div id="chart">
</div>


{{-- Script --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {

        // Set bar chart
        let options = {
            colors: ['#75a3d9', '#d975b7', '#77d975'],
            chart: {
                type: 'bar'
            },
            stroke: {
                show: true,
                curve: 'smooth',
                lineCap: 'butt',
                colors: ['#75a3d9', '#d975b7', '#77d975'],
                width: 3,
                dashArray: 0,
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 2500
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    colors: ['white', 'white', 'white']
                }
            },
            plotOptions: {
                bar: {
                    distributed: true,
                }
            },
            series: [{
                name: ["Percentage"],
                data: [{
                    x: 'Suhu',
                    y: 99
                }, {
                    x: 'Kelembapan',
                    y: 18
                }, {
                    x: 'Amonia',
                    y: 13
                }]
            }],
            yaxis: {
                title: {
                    text: "Percentage",
                    rotate: 0,
                    offsetX: 20,
                    offsetY: -180,
                    style: {
                        color: "black",
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 600,
                        cssClass: 'apexcharts-yaxis-title',
                    },
                },
                min: 1,
                max: 100,
                floating: false,
                tooltip: {
                    enabled: true,
                    offsetX: 0,
                },
            },
            xaxis: {
                categories: ['suhu', 'kelembapan', 'amonia']
            }
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        // #1 Update the value of each chart
        setInterval(() => {
            let suhuData = Math.floor(Math.random() * 100)
            let kelembapanData = Math.floor(Math.random() * 100)
            let amoniaData = Math.floor(Math.random() * 10)
            updateCardData(suhuData, kelembapanData, amoniaData)
            chart.updateOptions({
                series: [{
                    name: ["Percentage"],
                    data: [{
                        x: 'Suhu',
                        y: suhuData
                    }, {
                        x: 'Kelembapan',
                        y: kelembapanData
                    }, {
                        x: 'Amonia',
                        y: amoniaData
                    }]
                }],
            });
        }, 1000);
        // #2 update the value in card 
        function updateCardData(a, b, c) {
            let suhuData = document.getElementById('suhuData')
            suhuData.textContent = a
            let kelembapanData = document.getElementById('kelembapanData')
            kelembapanData.textContent = b
            let amoniaData = document.getElementById('amoniaData')
            amoniaData.textContent = c
        }

    })
</script>
