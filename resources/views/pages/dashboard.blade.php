<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Dashboard</h3>
                <p class="text-subtitle text-muted">Realtime Monitoring</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
                                            <label class="input-group-text" for="selectKandang">Choose Cage</label>
                                            <select class="form-select" id="selectKandang"
                                                onchange="setKandang(this.value)">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div id="chartType">
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="selectChart">Chart
                                                    Type</label>
                                                <select class="form-select" id="selectChart"
                                                    onchange="setChartType(this.value)">
                                                </select>
                                            </div>
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
                                    <div class="col-12 col-md-4 col-lg-4">
                                        <div class="card  shadow-sm ">
                                            <div class="card-header text-center" style="background-color: #75a3d9">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 32 32">
                                                    <path fill="white"
                                                        d="M20 10h7v2h-7zm0 6h10v2H20zm0 6h7v2h-7zm-10-1.816V7H8v13.184a3 3 0 1 0 2 0z" />
                                                    <path fill="currentColor"
                                                        d="M30 4H12.974A4.983 4.983 0 0 0 4 7v11.11a7 7 0 1 0 10 0V7a5.002 5.002 0 0 0-.101-1H30ZM9 28a4.993 4.993 0 0 1-3.332-8.718L6 18.983V7a3 3 0 0 1 6 0v11.983l.332.299A4.993 4.993 0 0 1 9 28Z" />
                                                </svg>
                                                <span class="text-white" style="font-size: 20px">Temperature</span>
                                            </div>
                                            <div class="card-body ">
                                                <div class="row mt-4">
                                                    <div class="col text-center border-end border-secondary">
                                                        <strong class="h2" id="suhuData">0</strong>
                                                        <strong class="h5">&deg; C</strong>
                                                    </div>
                                                    <div class="col text-center" id="suhuStatus">
                                                        <span class="badge bg-secondary">Offline</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4">
                                        <div class="card shadow-sm">
                                            <div class="card-header text-center" style="background-color: #d975b7">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 32 32">
                                                    <path fill="white"
                                                        d="M23.476 13.993L16.847 3.437a1.04 1.04 0 0 0-1.694 0L8.494 14.044A9.986 9.986 0 0 0 7 19a9 9 0 0 0 18 0a10.063 10.063 0 0 0-1.524-5.007ZM16 26a7.009 7.009 0 0 1-7-7a7.978 7.978 0 0 1 1.218-3.943l.935-1.49l10.074 10.074A6.977 6.977 0 0 1 16 26.001Z" />
                                                </svg>
                                                <span class="text-white" style="font-size: 20px">Humidity</span>

                                            </div>
                                            <div class="card-body ">
                                                <div class="row mt-4">
                                                    <div class="col text-center border-end border-secondary">
                                                        <strong id="kelembapanData" class="h2">0</strong>
                                                        <strong class="h5">% Rh</strong>
                                                    </div>
                                                    <div class="col text-center" id="kelembapanStatus">
                                                        <span class="badge bg-secondary">Offline</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4">
                                        <div class="card shadow-sm">
                                            <div class="card-header text-center" style="background-color: #77d975">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 32 32">
                                                    <path fill="white"
                                                        d="M27.231 23.618L20 13.675V4h2V2H10v2h2v9.675l-7.231 9.943A4.018 4.018 0 0 0 8.019 30H23.98a4.018 4.018 0 0 0 3.25-6.382ZM14 14.325V4h4v10.325L20.673 18h-9.346ZM23.981 28H8.02a2.02 2.02 0 0 1-1.633-3.206L9.873 20h12.254l3.487 4.794A2.02 2.02 0 0 1 23.981 28Z" />
                                                </svg>
                                                <span class="text-white" style="font-size: 20px">Ammonia</span>
                                            </div>
                                            <div class="card-body ">
                                                <div class="row mt-4">
                                                    <div class="col text-center border-end border-secondary">
                                                        <strong id="amoniaData" class="h2">0</strong>
                                                        <strong class="h5"> ppm </strong>
                                                    </div>
                                                    <div class="col text-center" id="amoniaStatus">
                                                        <span class="badge bg-secondary">Offline</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="card shadow-sm">
                                            <div class="card-body ">
                                                {{-- chart --}}
                                                @include('chart.chart')
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
