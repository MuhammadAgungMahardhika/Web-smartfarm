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

    function fetchKandang(peternakId) {

        let dataKandang
        let optionButton = ""

        $.ajax({
            type: "GET",
            url: `/kandang/peternak/${peternakId}`,
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
        $.ajax({
            type: "GET",
            url: `/data-kandang/kandang/${kandangId}`,
            contentType: "application/json",
            async: false,
            success: function(response) {
                // asign value
                let itemData = response.data
                let data = ''

                // adding input harian data
                for (let i = 0; i < itemData.length; i++) {
                    data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${itemData[i].hari_ke}</td>
                    <td>${itemData[i].date}</td>
                    <td>${itemData[i].pakan}</td>
                    <td>${itemData[i].minum}</td>
                    <td>${itemData[i].bobot}</td>
                    <td>${itemData[i].total_kematian }</td>
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
                                                aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Tanggal
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
        let populasiSaatIni = item.populasi_saat_ini

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
                                    <i>Nama Kandang</i>
                                </div>
                                <div class="col-md-8 form-group">
                                    <i>${namaKandang}</i>
                                </div>
                                <div class="col-md-4">
                                    <i>Populasi awal</i>
                                </div>
                                <div class="col-md-8 form-group ">
                                    <i>${populasiAwal}</i>
                                </div>
                                <div class="col-md-4">
                                    <i>Populasi Saat ini</i>
                                </div>
                                <div class="col-md-8 form-group mb-4">
                                    <i>${populasiSaatIni}</i>
                                </div>
                                <div class="col-md-4">
                                    <label for="hariKe">Hari ke-</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" value="" id="hariKe" class="form-control" placeholder="" autofocus>
                                </div>
                                <div class="col-md-4">
                                    <label for="date">Tanggal</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" value="${dateNow}" id="date" class="form-control">
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
                                    <label for="klasifikasi">Klasifikasi</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <fieldset class="form-group">
                                        <select class="form-select" id="klasifikasi">
                                            <option value="normal">Normal</option>
                                            <option value="abnormal">Abnormal</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div>
                                    <div class="table-responsive bg-light border border-secondary p-2">
                                        <p class="text-center">Data Kematian  </p>
                                        <a title="tambahkan data kematian" class="btn btn-success btn-sm" onclick="addRowKematian()"><i class="fa fa-plus"></i></a>
                                        <table class="table table-borderless my-2">
                                            <tbody id="tableKematian">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>    
                            </div>
                        </div>
                    </form>
                `)

        $('#modalFooter').html(`
                <a class="btn btn-success btn-sm" onclick="save()">Laporkan</a>`)
    }

    function addRowKematian() {
        // set row id 
        let id = Math.floor(Math.random() * 1000000000);
        $('#tableKematian').append(`
        <tr id="${id}">
            <td>
                <div class="form-group">
                   <label for="jumlah">Jumlah</label>
                </div>
            </td> 
            <td>
                <div class="form-group">
                   <input type="number" name="jumlah_kematian" class="form-control" required>
                </div>
            </td> 
            <td>
                <div class="form-group">
                   <label for="jam">Jam</label>
                </div>
            </td>
            <td colspan="2"> 
                <div class="form-group">
                   <input type="time" name="jam" class="form-control" required step="1" >
                </div>    
            </td> 
            <td>
                <div class="form-group">
                    <a title="hapus data kematian ini" class="btn btn-outline-danger btn-sm" onclick="deleteRowKematian(${id})"><i class="fa fa-x"> </i></a>
                </div>
            </td>
        </tr>`)
    }

    function deleteRowKematian(id) {
        $(`#${id}`).remove()
    }

    function editModal(id) {
        let item = getDataKandang(id)
        let dataKematian = item.data_kematians
        let idKandang = item.id_kandang
        let namaKandang = getKandang(idKandang).nama_kandang
        let hariKe = item.hari_ke
        let date = item.date
        let pakan = item.pakan
        let minum = item.minum
        let bobot = item.bobot
        let riwayatPopulasi = parseInt(item.riwayat_populasi)
        let klasifikasi = item.classification

        let optionButton = klasifikasi == "normal" ?
            '<option selected value="normal">Normal</option><option value="abnormal">Abnormal</option>' :
            '<option value="normal">Normal</option> <option selected value="abnormal">Abnormal</option>'
        let rowKematian = ''
        if (dataKematian.length > 0) {
            for (let i = 0; i < dataKematian.length; i++) {
                let id = Math.floor(Math.random() * 1000000000);
                let jumlah = dataKematian[i].jumlah_kematian
                let jam = dataKematian[i].jam
                rowKematian +=
                    `<tr id="${id}">
                    <td>
                        <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        </div>
                    </td> 
                    <td>
                        <div class="form-group">
                        <input type="number" value="${jumlah}" name="jumlah_kematian" class="form-control" required>
                        </div>
                    </td> 
                    <td>
                        <div class="form-group">
                        <label for="jam">Jam</label>
                        </div>
                    </td>
                    <td colspan="2"> 
                        <div class="form-group">
                            <input type="time" value="${jam}" name="jam" class="form-control" required step="1" >
                        </div>      
                    </td> 
                    <td>
                        <div class="form-group">
                            <a title="hapus data kematian ini" class="btn btn-outline-danger btn-sm" onclick="deleteRowKematian(${id})"><i class="fa fa-x"> </i></a>
                        </div>
                    </td>
                </tr>`
            }
        }

        $('#modalTitle').html("Mengubah Input Harian")
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
                                    <input type="number" value="${hariKe}" id="hariKe" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="date">Tanggal</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" value="${date}" id="date" class="form-control">
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
                                    <label for="klasifikasi">Klasifikasi</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <fieldset class="form-group">
                                        <select class="form-select" id="klasifikasi">
                                           ${optionButton}
                                        </select>
                                    </fieldset>
                                </div>
                                <input type="hidden" value="${riwayatPopulasi}" id="riwayatPopulasi">
                                <div>
                                    <div class="table-responsive bg-light border border-secondary p-2">
                                        <p class="text-center">Data Kematian</p>
                                        <a title="tambahkan data kematian" class="btn btn-success btn-sm" onclick="addRowKematian()"><i class="fa fa-plus"></i></a>
                                        <table class="table table-borderless my-2">
                                            <tbody id="tableKematian">
                                                ${rowKematian}
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </form>
                `)
        $('#modalFooter').html(
            `<a class="btn btn-success btn-sm" onclick="update('${id}')">Ubah</a>`)

    }

    function deleteModal(id) {
        let item = getDataKandang(id)
        let kandang = getKandang(item.id_kandang)
        let namaKandang = kandang.nama_kandang
        let populasiSaatIni = kandang.populasi_saat_ini
        let hariKe = item.hari_ke
        let date = item.date
        let pakan = item.pakan
        let minum = item.minum
        let bobot = item.bobot
        let riwayatPopulasi = item.riwayat_populasi
        let klasifikasi = item.classification

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
                                    <td>Hari ke</td> <td>${hariKe}</td>
                                </tr> 
                                <tr>
                                    <td>Tanggal</td> <td>${date}</td>
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
                                    <td>Riwayat Populasi</td><td>${riwayatPopulasi}</td>
                                </tr> 
                                <tr>
                                    <td>Klasifikasi</td><td>${klasifikasi}</td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                    `)
        $('#modalFooter').html(
            `<a class="btn btn-danger btn-sm" onclick="deleteItem('${id}')">Hapus</a>`)
    }

    function getDataKandang(id) {
        let item
        $.ajax({
            type: "GET",
            url: `/data-kandang/${id}`,
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

    function getDataKematianByDataKandangId(id) {
        let item
        $.ajax({
            type: "GET",
            url: `/jumlah-kematian/data-kandang/${id}`,
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
        let date = $('#date').val()
        let pakan = $('#pakan').val()
        let minum = $('#minum').val()
        let bobot = $('#bobot').val()
        let populasiSaatIni = getKandang(idKandang).populasi_saat_ini
        let klasifikasi = $('#klasifikasi').val()


        let dataKematian = []
        let tableKematian = $('#tableKematian tr').each(function(tr) {
            let allValues = {}
            $(this).find('input').each(function(i) {
                const inputName = $(this).attr("name")
                allValues[inputName] = $(this).val()
            })
            dataKematian.push(allValues)
        })

        console.log(dataKematian)
        // validasi
        let totalKematian = 0
        for (i = 0; i < dataKematian.length; i++) {
            totalKematian += parseInt(dataKematian[i].jumlah_kematian)
        }



        let sisa_populasi = populasiSaatIni - totalKematian

        if (sisa_populasi < 0) {
            return Swal.fire("Kematian melebihi populasi saat ini!");
        }

        if (hariKe <= 0) {
            return Swal.fire("Hari tidak boleh kurang dari 1!");
        }


        // asign value if validated
        let data = {
            id_kandang: idKandang,
            hari_ke: hariKe,
            date: date,
            pakan: pakan,
            minum: minum,
            bobot: bobot,
            riwayat_populasi: sisa_populasi,
            classification: klasifikasi,
            data_kematian: dataKematian
        }

        $.ajax({
            type: "POST",
            url: `/data-kandang`,
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
            url: `/data-kandang/${id}`,
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
                    showTableData(response.dataKandang.id_kandang)
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
        let date = $('#date').val()
        let pakan = $('#pakan').val()
        let minum = $('#minum').val()
        let bobot = $('#bobot').val()
        let klasifikasi = $('#klasifikasi').val()

        let dataKematian = []
        let tableKematian = $('#tableKematian tr').each(function(tr) {
            let allValues = {}
            $(this).find('input').each(function(i) {
                const inputName = $(this).attr("name")
                allValues[inputName] = $(this).val()
            })
            dataKematian.push(allValues)
        })


        let totalKematian = 0
        for (i = 0; i < dataKematian.length; i++) {
            totalKematian += dataKematian[i].jumlah_kematian
        }

        let kembalikanNilaiPopulasi = parseInt(getDataKematianByDataKandangId(id).total_kematian)
        let populasiSaatIni = parseInt(getKandang(idKandang).populasi_saat_ini) + parseInt(kembalikanNilaiPopulasi)
        let sisa_populasi = populasiSaatIni - totalKematian


        // validasi
        if (sisa_populasi < 0) {
            return Swal.fire("Kematian melebihi populasi saat ini!");
        }
        // asign value if validated
        let data = {
            id_kandang: idKandang,
            hari_ke: hariKe,
            date: date,
            pakan: pakan,
            minum: minum,
            bobot: bobot,
            riwayat_populasi: sisa_populasi,
            classification: klasifikasi,
            data_kematian: dataKematian
        }

        $.ajax({
            type: "PUT",
            url: `/data-kandang/${id}`,
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
