<x-app-layout>
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
        <div class="card border border-ligth">
            <div class="card-body">
                <div class="row">

                    {{-- Daftar menu untuk admin --}}
                    <?php if(Auth::user()->id_role == '1'): ?>
                    <div class="col-4">
                        <div class="card shadow-sm">
                            <a href="/userList">
                                <div class="card-body">
                                    <p>List Users</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                    {{-- Daftar menu untuk Pemilik --}}
                    <?php if (Auth::user()->id_role == '2'): ?>

                    <div class="col-4">
                        <div class="card shadow-sm">
                            <a href="/dashboard">
                                <div class="card-body">
                                    <p>Dashboard</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="card shadow-sm">
                            <a href="/dataKandang">
                                <div class="card-body">
                                    <p>Data Kandang</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="card shadow-sm">
                            <a href="/forecast">
                                <div class="card-body">
                                    <p>Forecast</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="card shadow-sm">
                            <a href="/klasifikasiMonitoring">
                                <div class="card-body">
                                    <p>Klasifikasi </p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="card shadow-sm">
                            <a href="/notifikasi">
                                <div class="card-body">
                                    <p>Notifikasi</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="card shadow-sm">
                            <a href="/hasilPanen">
                                <div class="card-body">
                                    <p>Hasil Panen</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <?php endif; ?>

                    {{-- Daftar menu untuk peternak --}}
                    <?php if(Auth::user()->id_role == '3'): ?>
                    <div class="col-4">
                        <div class="card shadow-sm">
                            <a href="/inputHarian">
                                <div class="card-body">
                                    <p>Input Harian</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card shadow-sm">
                            <a href="/notifikasi">
                                <div class="card-body">
                                    <p>Notifikasi</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>
</x-app-layout>
