<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Hasil Panen</h3>
                <p class="text-subtitle text-muted">Halaman Hasil Panen</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Hasil Panen</li>
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

            <div class="card-body table-responsive  p-4 rounded">
                <div class="text-start mb-4" id="addButton">
                    <a title="tambah" class="btn btn-success btn-sm block" data-bs-toggle="modal"
                        data-bs-target="#default" onclick="addModal('{{ $data[0]->id }}')">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
                <div id="tableData">
                    <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                        <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Name: activate to sort column ascending" style="width: 136.047px;">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">
                                    Tanggal mulai
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending" style="width: 239.078px;">
                                    Tanggal panen
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                    Jumlah panen
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                    Bobot total
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 117.891px;">Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($data[0]['panens'] as $panen)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $panen->tanggal_mulai }}</td>
                                    <td>{{ $panen->tanggal_panen }}</td>
                                    <td>{{ $panen->jumlah_panen }}</td>
                                    <td>{{ $panen->bobot_total }}</td>
                                    <td style="min-width: 180px">
                                        <a title="mengubah" class="btn btn-outline-primary btn-sm me-1"
                                            data-bs-toggle="modal" data-bs-target="#default"
                                            onclick="editModal('{{ $panen->id }}}')"><i class="fa fa-edit"></i> </a>
                                        <a title="hapus" class="btn btn-outline-danger btn-sm me-1"
                                            data-bs-toggle="modal" data-bs-target="#default"
                                            onclick="deleteModal('{{ $panen->id }}')"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
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
        $.ajax({
            type: "GET",
            url: `/kandang/${id}`,
            success: function(response) {
                let kandang = response.data
                $('#alamatKandang').html(kandang.alamat_kandang)
                $('#addButton').html(
                    ` <a title="tambah" class="btn btn-success btn-sm block" data-bs-toggle="modal" data-bs-target="#default" onclick="addModal('${id}')"><i class="fa fa-plus"></i> </a>`
                )
                showTableData(id)
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
    }

    function showTableData(kandangId) {
        $.ajax({
            type: "GET",
            url: `/panen/kandang/${kandangId}`,
            success: function(response) {
                let panenData = response.data
                let data = ''
                // adding panen data
                for (let i = 0; i < panenData.length; i++) {
                    let {
                        id,
                        tanggal_mulai,
                        tanggal_panen,
                        jumlah_panen,
                        bobot_total
                    } = panenData[i]
                    data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${tanggal_mulai}</td>
                    <td>${tanggal_panen}</td>
                    <td>${jumlah_panen}</td>
                    <td>${bobot_total}</td>
                    <td style="min-width: 180px">
                        <a title="mengubah" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#default" onclick="editModal('${id}')"><i class="fa fa-edit"></i> </a>
                        <a title="hapus" class="btn btn-outline-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#default" onclick="deleteModal('${id}')"><i class="fa fa-trash"></i></a>
                    </td>
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
                                                aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Tanggal mulai
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="City: activate to sort column ascending" style="width: 239.078px;">Tanggal panen
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Jumlah panen
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Bobot total
                            </th>
                            <th class="sorting text-center" tabindex="0" aria-controls="table1" rowspan="1"
                                                colspan="1" aria-label="Status: activate to sort column ascending"
                                                style="width: 117.891px;">Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
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



    function addModal(idKandang) {
        $.ajax({
            type: "GET",
            url: `/kandang/${idKandang}`,
            success: function(response) {
                let kandang = response.data
                $('#modalTitle').html("Menambahkan Hasil Panen")
                $('#modalBody').html(`
                <form class="form form-horizontal">
                        <div class="form-body"> 
                            <div class="row">
                                <input type="hidden" id="idKandang" value="${kandang.id}" class="form-control">
                                <div class="col-md-4">
                                    <label for="namaKandang">Nama kandang</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="namaKandang" value="${kandang.nama_kandang}" class="form-control" readonly>
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
                                    <label for="bobotAyam">Bobot Total</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="bobotAyam" class="form-control">
                                </div>
                                
                            </div>
                        </div>
                    </form>
                `)

                $('#modalFooter').html(`<a class="btn btn-success btn-sm" onclick="save()">Laporkan</a>`)
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
    }

    function editModal(id) {
        $.ajax({
            type: "GET",
            url: `/panen/${id}`,
            success: function(response) {
                let {
                    id_kandang,
                    kandang,
                    tanggal_mulai,
                    tanggal_panen,
                    jumlah_panen,
                    bobot_total
                } = response.data;
                $('#modalTitle').html("Mengubah Hasil Panen")
                $('#modalBody').html(`
                <form class="form form-horizontal">
                        <div class="form-body">
                            <div class="row">
                                <input type="hidden" id="idKandang" value="${id_kandang}" class="form-control">
                                <div class="col-md-4">
                                    <label for="namaKandang">Nama kandang</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="namaKandang" value="${kandang.nama_kandang}" class="form-control" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggalMulai">Tanggal mulai</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" id="tanggalMulai" value="${tanggal_mulai}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggalPanen">Tanggal panen</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" id="tanggalPanen" value="${tanggal_panen}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="jumlahPanen">Jumlah panen</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="jumlahPanen" value="${jumlah_panen}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="bobotTotal">Bobot Total</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="bobotTotal" value="${bobot_total}" class="form-control">
                                </div>
                                
                            </div>
                        </div>
                    </form>
                `)
                $('#modalFooter').html(
                    `<a class="btn btn-success btn-sm" onclick="update('${id}')">Ubah</a>`)
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
    }

    function deleteModal(id) {
        $.ajax({
            type: "GET",
            url: `/panen/${id}`,
            success: function(response) {
                let {
                    kandang,
                    tanggal_mulai,
                    tanggal_panen,
                    bobot_total,
                    jumlah_panen
                } = response.data

                $('#modalTitle').html("Hapus Hasil Panen")
                $('#modalBody').html(`
                    <div>
                        <table class="table table-borderless">  
                            <tbody>
                                <tr>
                                    <th class="text-center" colspan="2">Data panen</th>
                                </tr>
                                <tr>
                                    <td>Nama Kandang</td> <td>${kandang.nama_kandang}</td>
                                </tr> 
                                <tr>
                                    <td>Tanggal Mulai</td> <td>${tanggal_mulai}</td>
                                </tr> 
                                <tr>
                                <td>Tanggal Panen</td><td>${tanggal_panen}</td>
                                </tr>
                                <tr>
                                <td>Jumlah Panen</td>  <td>${jumlah_panen}</td>
                                </tr>  
                                <tr>
                                <td>Bobot Total</td>  <td>${bobot_total}</td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                    `)
                $('#modalFooter').html(
                    `<a class="btn btn-danger btn-sm" onclick="deleteItem('${id}')">Hapus</a>`)
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })

    }
    // -------------------------------API---------------------------------------------------------------------

    function save() {
        let idKandang = $('#idKandang').val()
        let tanggalMulai = $('#tanggalMulai').val()
        let tanggalPanen = $('#tanggalPanen').val()
        let jumlahPanen = $('#jumlahPanen').val()
        let bobotAyam = $('#bobotAyam').val()

        // validasi

        // asign value if validated
        let data = {
            id_kandang: idKandang,
            tanggal_mulai: tanggalMulai,
            tanggal_panen: tanggalPanen,
            jumlah_panen: jumlahPanen,
            bobot_total: bobotAyam
        }

        $.ajax({
            type: "POST",
            url: `/panen`,
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify(data),
            success: function(response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Berhasil menambahkan data",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    $('#default').modal('hide')
                    showTableData(response.panen.id_kandang)
                })
            },
            error: function(err) {
                console.log(err.responseText)
            }

        })

    }

    function deleteItem(id) {
        $.ajax({
            type: "DELETE",
            url: `/panen/${id}`,
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Berhasil menghapus data",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    $('#default').modal('hide')
                    showTableData(response.panen.id_kandang)
                })
            },
            error: function(err) {
                console.log(err.responseText)
            }

        })
    }

    function update(id) {
        let idKandang = $('#idKandang').val()
        let tanggalMulai = $('#tanggalMulai').val()
        let tanggalPanen = $('#tanggalPanen').val()
        let jumlahPanen = $('#jumlahPanen').val()
        let bobotTotal = $('#bobotTotal').val()

        let data = {
            id_kandang: idKandang,
            tanggal_mulai: tanggalMulai,
            tanggal_panen: tanggalPanen,
            jumlah_panen: jumlahPanen,
            bobot_total: bobotTotal
        }
        $.ajax({
            type: "PUT",
            url: `/panen/${id}`,
            data: JSON.stringify(data),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Berhasil mengubah data",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    $('#default').modal('hide')
                    showTableData(idKandang)
                })

            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
    }
</script>
