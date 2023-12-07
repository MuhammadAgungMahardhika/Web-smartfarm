<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Input Harian</h3>
                <p class="text-subtitle text-muted">Halaman Input Harian</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Input Harian</li>
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
        $('#addButton').html(
            ` <a title="tambah" class="btn btn-success btn-sm block" data-bs-toggle="modal" data-bs-target="#default" onclick="addModal('${id}')"><i class="fa fa-plus"></i> </a>`
        )
        showTableData(id)
    }

    function showTableData(kandangId) {
        let itemData = ''

        $.ajax({
            type: "GET",
            url: `/rekap-data/kandang/${kandangId}`,
            contentType: "application/json",
            async: false,
            success: function(response) {
                // asign value
                itemData = response.data
                let data = ''

                // adding input harian data
                for (let i = 0; i < itemData.length; i++) {
                    data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${itemData[i].hari}</td>
                    <td>${itemData[i].rata_rata_suhu}</td>
                    <td>${itemData[i].kelembapan}</td>
                    <td>${itemData[i].rata_rata_amoniak}</td>
                    <td>${itemData[i].pakan}</td>
                    <td>${itemData[i].minum}</td>
                    <td>${itemData[i].bobot}</td>
                    <td>${itemData[i].jumlah_kematian_harian}</td>
                    <td style="min-width: 180px">
                        <a title="mengubah" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#default" onclick="editModal('${itemData[i].id}')"><i class="fa fa-edit"></i> </a>
                        <a title="hapus" class="btn btn-outline-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#default" onclick="deleteModal('${itemData[i].id}')"><i class="fa fa-trash"></i></a>
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
                                                aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Hari
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Rata Rata Suhu
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Rata Rata Kelembapan
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="City: activate to sort column ascending" style="width: 239.078px;">Rata Rata Amonia
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
                                                Jumlah Kematian harian
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
            },
            error: function(err) {
                console.log(err.responseText)
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
        let item = getKandang(idKandang)
        let namaKandang = item.nama_kandang
        let populasiAwal = item.populasi_awal

        let today = new Date()
        let yyyy = today.getFullYear()
        let mm = today.getMonth() + 1
        let dd = today.getDate()
        if (dd < 10) dd = '0' + dd;
        if (mm < 10) mm = '0' + mm;
        let dateNow = yyyy + "-" + mm + "-" + dd

        $('#modalTitle').html("Menambahkan Input Harian")
        $('#modalBody').html(`
                <form class="form form-horizontal">
                        <div class="form-body">
                            <div class="row">
                                <input type="hidden" id="idKandang" value="${idKandang}" class="form-control">
                                <div class="col-md-4">
                                    <label for="namakandang">Nama Kandang</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" value="${namaKandang}" id="namakandang" class="form-control" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="populasiAwal">Populasi awal</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" value="${populasiAwal}" id="populasiAwal" class="form-control" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="hariKe">Hari ke-</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" value="${dateNow}" id="hariKe" class="form-control">
                                </div>
                              
                                <div class="col-md-4">
                                    <label for="rataRataSuhu">Rata Rata Suhu</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="rataRataSuhu" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="rataRataKelembapan">Rata Rata Kelembapan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="rataRataKelembapan" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="rataRataAmonia">Rata Rata Amonia</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="rataRataAmonia" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="pakan">Pakan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="pakan" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="minum">Minum</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="minum" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="bobot">Bobot</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="bobot" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="jumlahKematianHarian">Jumlah Kematian Hari Ini</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="jumlahKematianHarian" class="form-control">
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
        let item = getRekapData(id)
        let idKandang = item.id_kandang
        let namaKandang = getKandang(idKandang).nama_kandang
        let hari = item.hari
        let rataRataSuhu = item.rata_rata_suhu
        let rataRataKelembapan = item.kelembapan
        let rataRataAmoniak = item.rata_rata_amoniak
        let pakan = item.pakan
        let minum = item.minum
        let bobot = item.bobot
        let jumlahKematianHarian = item.jumlah_kematian_harian

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
                                    <label for="hariKe">Hari ke-</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" value="${hari}" id="hariKe" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="rataRataSuhu">Rata Rata Suhu</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" value="${rataRataSuhu}" id="rataRataSuhu" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="rataRataKelembapan">Rata Rata Kelembapan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" value="${rataRataKelembapan}" id="rataRataKelembapan" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="rataRataAmonia">Rata Rata Amonia</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" value="${rataRataAmoniak}" id="rataRataAmonia" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="pakan">Pakan</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" value="${pakan}" id="pakan" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="minum">Minum</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" value="${minum}" id="minum" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="bobot">Bobot</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" value="${bobot}" id="bobot" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="jumlahKematianHarian">Jumlah Kematian Hari Ini</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" value="${jumlahKematianHarian}" id="jumlahKematianHarian" class="form-control">
                                </div>

                            </div>
                        </div>
                    </form>
                `)
        $('#modalFooter').html(
            `<a class="btn btn-success btn-sm" onclick="update('${id}')">Ubah</a>`)

    }




    function deleteModal(id) {
        let item = getRekapData(id)
        let namaKandang = getKandang(item.id_kandang).nama_kandang
        let hari = item.hari
        let rataRataSuhu = item.rata_rata_suhu
        let rataRataKelembapan = item.kelembapan
        let rataRataAmoniak = item.rata_rata_amoniak
        let pakan = item.pakan
        let minum = item.minum
        let bobot = item.bobot
        let jumlahKematianHarian = item.jumlah_kematian_harian

        $('#modalTitle').html("Hapus Data Harian")
        $('#modalBody').html(`
                    <div>
                        <table class="table table-borderless">  
                            <tbody>
                                <tr>
                                    <th class="text-center" colspan="2">Data Harian</th>
                                </tr>
                                <tr>
                                    <td>Nama Kandang</td> <td>${namaKandang}</td>
                                </tr> 
                                <tr>
                                    <td>Hari ke</td> <td>${hari}</td>
                                </tr> 
                                <tr>
                                    <td>Rata rata suhu</td><td>${rataRataSuhu}</td>
                                </tr>
                                <tr>
                                    <td>Rata rata suhu</td><td>${rataRataKelembapan}</td>
                                </tr>  
                                <tr>
                                    <td>Rata rata amonia</td><td>${rataRataAmoniak}</td>
                                </tr> 
                                <tr>
                                    <td>Pakan</td><td>${pakan}</td>
                                </tr> 
                                <tr>
                                    <td>Minum</td><td>${minum}</td>
                                </tr> 
                                <tr>
                                    <td>Bobot</td><td>${bobot}</td>
                                </tr> 
                                <tr>
                                    <td>Jumlah kematian harian</td><td>${jumlahKematianHarian}</td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                    `)
        $('#modalFooter').html(
            `<a class="btn btn-danger btn-sm" onclick="deleteItem('${id}')">Hapus</a>`)
    }

    function reset() {
        $('#hariKe').val("")
        $('#jumlahAwalAyam').val("")
        $('#jumlahAyam').val("")
        $('#bobotAyam').val("")
        $('#pakan').val("")
        $('#minum').val("")
        $('#jumlahKematian').val("")
        $('#rataSuhu').val("")
        $('#rataKelembapan').val("")
        $('#rataAmoniak').val("")
    }



    function getRekapData(id) {
        let item
        $.ajax({
            type: "GET",
            url: `/rekap-data/${id}`,
            async: false,
            success: function(response) {
                item = response.data
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
        return item
    }

    function getKandang(id) {
        let item
        $.ajax({
            type: "GET",
            url: `/kandang/${id}`,
            async: false,
            success: function(response) {
                item = response.data
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
        return item
    }

    // -------------------------------API---------------------------------------------------------------------

    function save() {
        let idKandang = $('#idKandang').val()
        let hariKe = $('#hariKe').val()
        let rataRataSuhu = $('#rataRataSuhu').val()
        let rataRataKelembapan = $('#rataRataKelembapan').val()
        let rataRataAmonia = $('#rataRataAmonia').val()
        let pakan = $('#pakan').val()
        let minum = $('#minum').val()
        let bobot = $('#bobot').val()
        let jumlahKematianharian = $("#jumlahKematianHarian").val()

        // validasi
        if (hariKe <= 0) {
            return Swal.fire("SweetAlert2 is working!");
        }


        // asign value if validated
        let data = {
            id_kandang: idKandang,
            hari: hariKe,
            rata_rata_suhu: rataRataSuhu,
            kelembapan: rataRataKelembapan,
            rata_rata_amoniak: rataRataAmonia,
            pakan: pakan,
            minum: minum,
            bobot: bobot,
            jumlah_kematian_harian: jumlahKematianharian,
        }

        $.ajax({
            type: "POST",
            url: `/rekap-data`,
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify(data),
            success: function(response) {
                console.log(response)
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Berhasil menambahkan data",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    showTableData(response.kandang.id_kandang)
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
            url: `/rekap-data/${id}`,
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
                    showTableData(response.kandang.id_kandang)
                })
            },
            error: function(err) {
                console.log(err.responseText)
            }

        })
    }

    function update(id) {
        let idKandang = $('#idKandang').val()
        let hariKe = $('#hariKe').val()
        let rataRataSuhu = $('#rataRataSuhu').val()
        let rataRataKelembapan = $('#rataRataKelembapan').val()
        let rataRataAmonia = $('#rataRataAmonia').val()
        let pakan = $('#pakan').val()
        let minum = $('#minum').val()
        let bobot = $('#bobot').val()
        let jumlahKematianharian = $("#jumlahKematianHarian").val()

        // validasi
        // asign value if validated
        let data = {
            id_kandang: idKandang,
            hari: hariKe,
            rata_rata_suhu: rataRataSuhu,
            kelembapan: rataRataKelembapan,
            rata_rata_amoniak: rataRataAmonia,
            pakan: pakan,
            minum: minum,
            bobot: bobot,
            jumlah_kematian_harian: jumlahKematianharian,
        }


        $.ajax({
            type: "PUT",
            url: `/rekap-data/${id}`,
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
                    showTableData(idKandang)
                })

            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
    }
</script>
