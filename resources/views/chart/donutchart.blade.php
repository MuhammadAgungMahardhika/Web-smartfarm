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


{{-- Script  Suhu --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        let options = {
            colors: ['#75a3d9'],
            chart: {
                type: 'donut'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '80%'
                    },
                    size: 100
                }
            },
            series: [30],
            labels: ['Suhu']
        }

        var chart = new ApexCharts(document.querySelector("#suhuChart"), options);
        chart.render();
    })
</script>

{{-- Script Kelembapan --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        let options = {
            colors: ['#d975b7'],
            chart: {
                type: 'donut'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '80%'
                    },
                    size: 100
                }
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
            series: [30],
            labels: ['Kelembapan']
        }

        var chart = new ApexCharts(document.querySelector("#kelembapanChart"), options);
        chart.render();
    })
</script>

{{-- Script Amonia --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        let options = {
            colors: ['#77d975'],
            chart: {
                type: 'donut'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '80%'
                    },
                    size: 100
                }
            },
            series: [30],
            labels: ['Amonia']
        }

        var chart = new ApexCharts(document.querySelector("#amoniaChart"), options);
        chart.render();
    })
</script>
