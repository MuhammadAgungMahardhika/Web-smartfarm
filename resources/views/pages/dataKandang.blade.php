<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Data Kandang</h3>
                <p class="text-subtitle text-muted">Halaman Data Kandang</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Data Kandang</li>
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

                                    </td>
                                </tr>
                                <tr>
                                    <th>Alamat Kandang</th>
                                    <td id="alamatKandang">

                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>

            <div class="card-body table-responsive bg-light p-4 rounded">
                <div class="text-start mb-4" id="addButton">

                </div>
                <div id="tableData">

                </div>

            </div>
        </div>
    </section>
</x-app-layout>
<script>
    fetchKandang(<?= auth()->user()->id ?>)

    function fetchKandang(userId) {

        let dataKandang
        let optionButton = ""

        $.ajax({
            type: "GET",
            url: `/kandang/user/${userId}`,
            success: function(response) {
                dataKandang = response.data

                // looping all kandang option
                for (let i = 0; i < dataKandang.length; i++) {
                    optionButton +=
                        `<option ${i == 0 ? 'selected': ''} value="${dataKandang[i].id}">${dataKandang[i].nama_kandang}</option>`
                }

                $('#namaKandang').html(`
                <fieldset class="form-group">
                    <select class="form-select" id="selectKandang" onchange="initKandang()">
                        ${optionButton}
                    </select>
                </fieldset>
                `)

                // init kandang data
                initKandang()
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
    }

    function initKandang() {
        let id = $("#selectKandang").val()
        let kandang = getKandang(id)

        $('#alamatKandang').html(kandang.alamat_kandang)
        showTableData(id)
    }

    function showTableData(kandangId) {
        $.ajax({
            type: "GET",
            url: `/detailKandang/${kandangId}`,
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
                    let namaKandang = kandangs[i].nama_kandang
                    let alamatKandang = kandangs[i].alamat_kandang
                    let totalPakan = kandangs[i].total_pakan
                    let totalMinum = kandangs[i].total_minum
                    let totalBobot = kandangs[i].total_bobot
                    let populasiSaatIni = kandangs[i].populasi_saat_ini

                    data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${namaKandang}</td>
                    <td>${alamatKandang}</td>
                    <td>${totalPakan}</td>
                    <td>${totalMinum}</td>
                    <td>${totalBobot}</td>
                    <td>${populasiSaatIni}</td>
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
                                                aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Nama Kandang
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="City: activate to sort column ascending" style="width: 239.078px;">Alamat Kandang
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Total Pakan
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Total Minum
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Total Bobot
                            </th>
                            <th class="sorting text-center" tabindex="0" aria-controls="table1" rowspan="1"
                                                colspan="1" aria-label="Status: activate to sort column ascending"
                                                style="width: 117.891px;">Populasi Saat Ini
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


    function reset() {

    }

    function addModal(idKandang) {
        let kandang = getKandang(idKandang)
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

        $('#modalFooter').html(`
         <a class="btn btn-secondary btn-sm" onclick="reset()">Reset</a>
         <a class="btn btn-success btn-sm" onclick="save()">Laporkan</a>`)

    }

    function editModal(id) {
        let item = getPanen(id)
        let idKandang = item.id_kandang
        let namaKandang = getKandang(idKandang).nama_kandang
        let tanggalMulai = item.tanggal_mulai
        let tanggalPanen = item.tanggal_panen
        let jumlahPanen = item.jumlah_panen
        let bobotTotal = item.bobot_total
        $('#modalTitle').html("Mengubah Hasil Panen")
        $('#modalBody').html(`
                <form class="form form-horizontal">
                        <div class="form-body">
                            <div class="row">
                                <input type="hidden" id="idKandang" value="${idKandang}" class="form-control">
                                <div class="col-md-4">
                                    <label for="namaKandang">Nama kandang</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="namaKandang" value="${namaKandang}" class="form-control" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggalMulai">Tanggal mulai</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" id="tanggalMulai" value="${tanggalMulai}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggalPanen">Tanggal panen</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" id="tanggalPanen" value="${tanggalPanen}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="jumlahPanen">Jumlah panen</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="jumlahPanen" value="${jumlahPanen}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="bobotTotal">Bobot Total</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="bobotTotal" value="${bobotTotal}" class="form-control">
                                </div>
                                
                            </div>
                        </div>
                    </form>
                `)
        $('#modalFooter').html(
            `<a class="btn btn-success btn-sm" onclick="update('${id}')">Ubah</a>`)

    }

    function deleteModal(id) {
        let item = getPanen(id)
        let namaKandang = getKandang(item.id_kandang).nama_kandang
        let tanggalMulai = item.tanggal_mulai
        let tanggalPanen = item.tanggal_panen
        let bobotTotal = item.bobot_total
        let jumlahPanen = item.jumlah_panen

        $('#modalTitle').html("Hapus Hasil Panen")
        $('#modalBody').html(`
                    <div>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th class="text-center" colspan="2">Data panen</th>
                                </tr>
                                <tr>
                                    <td>Nama Kandang</td> <td>${namaKandang}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Mulai</td> <td>${tanggalMulai}</td>
                                </tr>
                                <tr>
                                <td>Tanggal Panen</td><td>${tanggalPanen}</td>
                                </tr>
                                <tr>
                                <td>Jumlah Panen</td>  <td>${jumlahPanen}</td>
                                </tr>
                                <tr>
                                <td>Bobot Total</td>  <td>${bobotTotal}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    `)
        $('#modalFooter').html(
            `<a class="btn btn-danger btn-sm" onclick="deleteItem('${id}')">Hapus</a>`)
    }

    function getPanen(id) {
        let data
        $.ajax({
            type: "GET",
            url: `/panen/${id}`,
            async: false,
            success: function(response) {
                data = response.data
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
        return data;
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
</script>
