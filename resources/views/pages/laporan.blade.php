<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Laporan</h3>
                <p class="text-subtitle text-muted">Halaman Laporan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                        <table class="table table-borderless text-start">
                            <thead>
                                <tr>
                                    <th>DateTime</th>
                                    <td>
                                        02-12-2023
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nama Kandang</th>
                                    <td>
                                        Kandang Ayam
                                    </td>
                                </tr>
                                <tr>
                                    <th>Alamat Kandang</th>
                                    <td>
                                        Jln Diponegoro No.4
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
            <div class="card-body table-responsive bg-light p-4 rounded">
                <table class="table dataTable no-footer " id="table1" aria-describedby="table1_info">
                    <thead>
                        <tr>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                aria-label="Name: activate to sort column ascending" style="width: 136.047px;">No</th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                aria-label="Name: activate to sort column ascending" style="width: 136.047px;">Datetime
                            </th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="table1" rowspan="1"
                                colspan="1" aria-label="Email: activate to sort column descending"
                                style="width: 604.641px;" aria-sort="ascending">Email</th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Nama
                                Kandang
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                aria-label="City: activate to sort column ascending" style="width: 239.078px;">Alamat
                                Kandang</th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">Suhu
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                Kelembapan
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">Amonia
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd">
                            <td class="">1</td>
                            <td class="sorting_1">blandit.enim.consequat@mollislectuspede.net</td>
                            <td>0800 1111</td>
                            <td>Lobbes</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
