<x-app-layout>
    <style>
        .daftarMenu {
            transition: transform 0.3s ease;
        }

        .daftarMenu:hover {
            transform: scale(1.1);
            opacity: 0.9;
        }
    </style>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Daftar Menu</h3>
                <p class="text-subtitle text-muted">Halaman menu </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Daftar Menu</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center text-center">
                    {{-- Daftar menu untuk admin --}}
                    @if (Auth::user()->id_role == '1')
                        <div class="col-12 col-md-3 col-lg-4">
                            <div class="card shadow-sm daftarMenu">
                                <a href="/userList">
                                    <div class="card-body">
                                        <img src="/images/menu/users.jpg" class="card-img-top img-fluid"
                                            alt="singleminded">
                                        <h5 class="card-title mt-4">List Users</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Daftar menu untuk Pemilik --}}
                    @if (Auth::user()->id_role == '2')
                        <div class="col-12 col-md-3 col-lg-4">
                            <div class="card shadow-sm daftarMenu">
                                <a href="/dashboard">
                                    <div class="card-body">
                                        <img src="/images/menu/dashboard.jpg" class="card-img-top img-fluid"
                                            alt="singleminded">
                                        <h5 class="card-title mt-4">Dashboard</h5>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 col-lg-4">
                            <div class="card shadow-sm daftarMenu">
                                <a href="/dataKandang">
                                    <div class="card-body">
                                        <img src="/images/menu/monitoringKandang2.jpg" class="card-img-top img-fluid"
                                            alt="singleminded">
                                        <h5 class="card-title mt-4">Data Kandang</h5>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 col-lg-4">
                            <div class="card shadow-sm daftarMenu">
                                <a href="/forecast">
                                    <div class="card-body">
                                        <img src="/images/menu/forecast.jpg" class="card-img-top img-fluid"
                                            alt="singleminded">
                                        <h5 class="card-title mt-4">Forecast</h5>
                                    </div>
                                </a>
                            </div>
                        </div>



                        <div class="col-12 col-md-3 col-lg-4">
                            <div class="card shadow-sm daftarMenu">
                                <a href="/hasilPanen">
                                    <div class="card-body">
                                        <img src="/images/menu/hasilPanen.jpg" class="card-img-top img-fluid"
                                            alt="singleminded">
                                        <h5 class="card-title mt-4">Hasil Panen</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Daftar menu untuk peternak --}}
                    @if (Auth::user()->id_role == '3')
                        <div class="col-12 col-md-3 col-lg-4">
                            <div class="card shadow-sm daftarMenu">
                                <a href="/inputHarian">
                                    <div class="card-body">
                                        <img src="/images/menu/inputHarian.jpg" class="card-img-top img-fluid"
                                            alt="singleminded">
                                        <h5 class="card-title mt-4">Input Harian</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Daftar menu pemilik dan peternak --}}
                    @if (Auth::user()->id_role == '2' || Auth::user()->id_role == '3')
                        <div class="col-12 col-md-3 col-lg-4">
                            <div class="card shadow-sm daftarMenu">
                                <a href="/klasifikasiMonitoring">
                                    <div class="card-body">
                                        <img src="/images/menu/klasifikasi.jpg" class="card-img-top img-fluid"
                                            alt="singleminded">
                                        <h5 class="card-title mt-4">Klasifikasi</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-4">
                            <div class="card shadow-sm daftarMenu">
                                <a href="/notifikasi">
                                    <div class="card-body">
                                        <img src="/images/menu/notification.jpg" class="card-img-top img-fluid"
                                            alt="singleminded">
                                        <h5 class="card-title mt-4">Notifikasi</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
