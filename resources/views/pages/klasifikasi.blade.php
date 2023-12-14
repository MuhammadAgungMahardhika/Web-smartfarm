<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Klasifikasi Monitoring</h3>
                <p class="text-subtitle text-muted">Halaman Klasifikasi Monitoring</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Klasifikasi Monitoring</li>
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
                                    <th>Nama Kandang</th>
                                    <td id="namaKandang">
                                        <fieldset class="form-group">
                                            <select class="form-select" id="selectKandang" onchange="initKandang()">
                                                @foreach ($data as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->nama_kandang }}
                                                    </option>
                                                @endforeach; ?>
                                            </select>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Alamat Kandang</th>
                                    <td id="alamatKandang">
                                        {{ $data[0]->alamat_kandang }}
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>

            <div class="card-body table-responsive bg-light p-4 rounded">
                <div id="tableData">
                    <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                        <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Name: activate to sort column ascending" style="width: 136.047px;">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Nama
                                    Kandang
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending" style="width: 239.078px;">
                                    Alamat
                                    Kandang
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                    Tanggal
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                    Hari-ke
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                    Pakan
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                    Minum
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                    Bobot
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                    Klasifikasi
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($data[0]['data_kandangs'] as $dataKandang)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data[0]->nama_kandang }}</td>
                                    <td>{{ $data[0]->alamat_kandang }}</td>
                                    <td>{{ $dataKandang->date }}</td>
                                    <td>{{ $dataKandang->hari_ke }}</td>
                                    <td>{{ $dataKandang->pakan }}</td>
                                    <td>{{ $dataKandang->minum }}</td>
                                    <td>{{ $dataKandang->bobot }}</td>
                                    <td
                                        class="{{ $dataKandang->classification == 'normal' ? 'text-success' : 'text-danger' }}">
                                        {{ $dataKandang->classification }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>
<script>
    initDataTable('table')

    function initKandang() {
        let id = $("#selectKandang").val()
        let kandang = getKandang(id)
        $('#alamatKandang').html(kandang.alamat_kandang)
        showTableData(id)
    }

    function addModal(idKandang) {
        $('#modalTitle').html("Menambahkan Hasil Panen")
        $('#modalBody').html(`
        <form class="form form-horizontal">
                <div class="form-body"> 
                    <div class="row">
                        <input type="hidden" id="idKandang" value="${idKandang}" class="form-control">
                        <div class="col-md-4">
                            <label for="namaKandang">Nama kandang</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="namaKandang" value="namaKandangTes" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="tanggalMulai">Tanggal mulai</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="date" id="tanggalMulai" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="tanggalPanen">Tanggal panen</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="date" id="tanggalPanen" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="jumlahPanen">Jumlah panen</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="jumlahPanen" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="bobotAyam">Bobot Ayam</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="bobotAyam" class="form-control">
                        </div>
                        
                    </div>
                </div>
            </form>
        `)
        $('#modalFooter').html(`<a class="btn btn-success btn-sm" onclick="save()">Laporkan</a>`)
    }

    function editModal(id) {
        $('#modalTitle').html("Mengubah Hasil Panen")
        $('#modalBody').html(`
        <form class="form form-horizontal">
                <div class="form-body">
                    <div class="row">
                        <input type="hidden" id="idKandang" value="${id}" class="form-control">
                        <div class="col-md-4">
                            <label for="namaKandang">Nama kandang</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="namaKandang" value="Kandang 1" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="tanggalMulai">Tanggal mulai</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="date" id="tanggalMulai" value="2023-12-11" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="tanggaPanen">Tanggal panen</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="date" id="tanggaPanen" value="2023-12-11" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="jumlahPanen">Jumlah panen</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="jumlahPanen" value="20" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="bobotAyam">Bobot Ayam</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="bobotAyam" value="20" class="form-control">
                        </div>
                        
                    </div>
                </div>
            </form>
        `)
        $('#modalFooter').html(`<a class="btn btn-success btn-sm" onclick="update('${id}')">Laporkan</a>`)
    }

    function deleteModal(id) {
        $('#modalTitle').html("Hapus Hasil Panen")
        $('#modalBody').html(`Apakah anda yakin ingin menghapus hasil panen ini?`)
        $('#modalFooter').html(`<a class="btn btn-danger btn-sm" onclick="delete('${id}'')">Hapus</a>`)
    }

    function showTableData(kandangId) {
        $.ajax({
            type: "GET",
            url: `/data-kandang/detail/kandang/${kandangId}`,
            async: false,
            success: function(response) {
                // asign value
                let kandangs = response.data
                console.log(kandangs)
                let data = ''
                let iDataKandang = ''
                let iDataPopulations = ''

                // adding data kandang data
                for (let i = 0; i < kandangs.length; i++) {
                    let date = kandangs[i].date
                    let hari = kandangs[i].hari_ke
                    let namaKandang = kandangs[i].nama_kandang
                    let alamatKandang = kandangs[i].alamat_kandang
                    let pakan = kandangs[i].pakan
                    let minum = kandangs[i].minum
                    let bobot = kandangs[i].bobot
                    let populasiAwal = kandangs[i].populasi_awal
                    let riwayatPopulasi = kandangs[i].riwayat_populasi
                    let luasKandang = kandangs[i].luas_kandang
                    let klasifikasi = kandangs[i].classification

                    data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${date}</td>
                    <td>${namaKandang}</td>             
                    <td>${alamatKandang}</td>             
                    <td>${hari}</td>             
                    <td>${pakan}</td>
                    <td>${minum}</td>
                    <td>${bobot}</td>
                    <td>${klasifikasi}</td>
                    </tr>
                    `
                }

                // construct table
                let table = `
                <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                    <thead>
                        <tr>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Name: activate to sort column ascending" style="width: 136.047px;">No
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Date
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="City: activate to sort column ascending" style="width: 239.078px;">Nama Kandang
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Alamat Kandang
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Hari-ke
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                            Pakan
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                            Minum
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                            Bobot
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                            Klasifikasi
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        ${data}
                    </tbody>
                </table>
                `
                $('#tableData').html(table)
                initDataTable('table')
            }
        })
    }

    function initDataTable(id) {
        let jquery_datatable = $(`#${id}`).DataTable({
            responsive: true,
            aLengthMenu: [
                [25, 50, 75, 100, 200, -1],
                [25, 50, 75, 100, 200, "All"],
            ],
            pageLength: 10,
            language: {
                lengthMenu: "Dapatkan _MENU_ data",
                search: "Cari:",
                emptyTable: "Tidak ada data ditemukan",
                zeroRecords: "Tidak ada data yang dicari",
                infoFiltered: "(Di filter dari _MAX_ total data)",
                infoEmpty: "Menunjukan 0 sampai 0 dari 0 data",
                info: "Menunjukan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya",
                },
            },
        });

        const setTableColor = () => {
            document
                .querySelectorAll(".dataTables_paginate .pagination")
                .forEach((dt) => {
                    dt.classList.add("pagination-primary");
                });
        };
        setTableColor();
        jquery_datatable.on("draw", setTableColor);
    }

    function getKandang(id) {
        let data
        $.ajax({
            type: "GET",
            url: `/kandang/${id}`,
            async: false,
            success: function(response) {
                data = response.data
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
        return data
    }
</script>
