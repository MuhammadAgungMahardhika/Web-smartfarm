<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Cage List</h3>
                <p class="text-subtitle text-muted">Chicken cage list page</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Cage List</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="card-title text-center">Cage List</div>
            </div>

            <div class="card-body table-responsive  p-4 rounded">
                {{-- add button --}}
                <div class="text-start mb-4" id="addButton">
                    <a title="tambah" class="btn btn-success btn-sm block" data-bs-toggle="modal"
                        data-bs-target="#default" onclick="addModal()">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
                {{-- table data --}}
                <div id="tableData">
                    <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                        <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Name: activate to sort column ascending">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending">
                                    Cage Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending">
                                    Cage Address
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending">
                                    Cage Area (M<sup>2</sup>)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Initial Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Remaining Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Amount of Death (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Owner
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Farmer
                                </th>

                                <th class="sorting text-center" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending">Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($data as $kandang)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $kandang->nama_kandang }}</td>
                                    <td>{{ $kandang->alamat_kandang }}</td>
                                    <td>{{ $kandang->luas_kandang }}</td>
                                    <td>{{ $kandang->populasi_awal }}</td>
                                    <td>{{ $kandang->populasi_saat_ini }}</td>
                                    <td>{{ $kandang->total_kematian }}</td>
                                    <td>{{ $kandang->nama_pemilik }}<br>{{ $kandang->email_pemilik != null ? '(' . $kandang->email_pemilik . ')' : '' }}
                                    </td>
                                    <td>{{ $kandang->nama_peternak }}<br>{{ $kandang->email_peternak != null ? '(' . $kandang->email_peternak . ')' : '' }}
                                    </td>
                                    <td style="min-width: 180px">
                                        <a title="mengubah" class="btn btn-outline-primary btn-sm me-1"
                                            data-bs-toggle="modal" data-bs-target="#default"
                                            onclick="editModal('{{ $kandang->id }}')"><i class="fa fa-edit"></i>
                                        </a>
                                        <a title="hapus" class="btn btn-outline-danger btn-sm me-1"
                                            data-bs-toggle="modal" data-bs-target="#default"
                                            onclick="deleteModal('{{ $kandang->id }}')"><i
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
        let idKandang = $("#selectKandang").val()
        $.ajax({
            type: "GET",
            url: `/kandang/${idKandang}`,
            success: function(response) {
                let kandang = response.data
                let namaKandang = kandang.nama_kandang
                let alamatKandang = kandang.alamat_kandang
                $('#alamatKandang').html(alamatKandang)
                $('#filterMenu').html(
                    `<p>Filter Data ${namaKandang}</p>
                     <div class="btn-group me-2 mb-2">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    id="dateDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" onclick="filterByDate('${idKandang}')">
                                    <i class="fa fa-calendar"></i> Filter House By Date
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dateDropdown">
                            <div class="row p-2">
                                <div class="col-12 form-group">
                                    <input type="text" id="dateFilter" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button id="reloadButton" class="btn btn-outline-secondary btn-sm  me-2 mb-2"
                    onclick="showTableData('${idKandang}')">
                    <i class="fa fa-sync"></i>
                    Reload Data
                    </button>
                    `
                )
                $('#addButton').html(
                    ` <a title="tambah" class="btn btn-success btn-sm block" data-bs-toggle="modal" data-bs-target="#default" onclick="addModal('${idKandang}')"><i class="fa fa-plus"></i> </a>`
                )
                showTableData(idKandang)
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
    }


    function showTableData() {
        $.ajax({
            type: "GET",
            url: `/kandang/`,
            success: function(response) {
                let kandangData = response.data
                let data = ''
                console.log(kandangData)
                // adding kandang data
                for (let i = 0; i < kandangData.length; i++) {
                    let {
                        id,
                        nama_kandang,
                        alamat_kandang,
                        luas_kandang,
                        populasi_awal,
                        populasi_saat_ini,
                        total_kematian,
                        id_pemilik,
                        nama_pemilik,
                        email_pemilik,
                        id_peternak,
                        nama_peternak,
                        email_peternak
                    } = response.data[i];
                    data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${nama_kandang}</td>
                    <td>${alamat_kandang}</td>
                    <td>${luas_kandang}</td>
                    <td>${populasi_awal}</td>
                    <td>${populasi_saat_ini}</td>
                    <td>${total_kematian}</td>
                    <td>${nama_pemilik}<br>${email_pemilik != null ? '('+email_pemilik+')' : '' }</td>
                    <td>${nama_peternak}<br>${email_peternak != null ? '('+email_peternak+')' : '' }</td>
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
                                    aria-label="Name: activate to sort column ascending">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending">
                                    Cage Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending">
                                    Cage Address
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending">
                                    Cage Area (M<sup>2</sup>)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Initial Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Remaining Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Amount of Death (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Owner
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Farmer
                                </th>

                                <th class="sorting text-center" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending">Action
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
        });
    }

    function filterByDate(idKandang) {
        $('#modalTitle').html("Filter House By Date")
        $('#modalBody').html(`
                <form class="form form-horizontal">
                        <div class="form-body"> 
                            <div class="row">
                                <input type="hidden" id="idKandang" value="${idKandang}" class="form-control">
                                <div class="col-md-3">
                                    <label for="from"><i class="fa fa-calendar"></i> Date range </label>
                                </div>
                                <div class="col-md-9 form-group">
                                    <input type="text" id="from" class="form-control">
                                </div>
                            </div>
                        </div>
                    </form>
            `)

        let dateNow = new Date();

        $('#dateFilter').daterangepicker({
            opens: 'left', // Tampilan kalender saat datepicker dibuka (left/right)
            autoUpdateInput: false, // Otomatis memperbarui input setelah memilih tanggal
            locale: {
                format: 'YYYY-MM-DD', // Format tanggal yang diinginkan
                separator: ' to ', // Pemisah untuk rentang tanggal
            }
        });

        // Menangani perubahan tanggal
        $('#dateFilter').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));

            // Tangkap tanggal awal dan akhir
            var startDate = picker.startDate.format('YYYY-MM-DD');
            var endDate = picker.endDate.format('YYYY-MM-DD');

            // Tampilkan pada console 
            new Date(startDate)
            new Date(endDate)

            // check jika from date kosong
            if (!startDate) {
                return Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Please fill the from date",
                    showConfirmButton: false,
                    timer: 1500
                })

            }

            // check jika to date kosong
            if (!endDate) {
                return Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Please fill the end date",
                    showConfirmButton: false,
                    timer: 1500
                })

            }

            let data = {
                id_kandang: idKandang,
                from: startDate,
                to: endDate
            }
            $.ajax({
                type: "POST",
                url: `/kandang/date`,
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(data),
                success: function(response) {

                    let kandangData = response.data

                    let data = ''
                    // adding kandang data
                    for (let i = 0; i < kandangData.length; i++) {
                        let {
                            id,
                            tanggal_mulai,
                            tanggal_kandang,
                            jumlah_kandang,
                            bobot_total
                        } = kandangData[i]
                        data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${tanggal_mulai}</td>
                    <td>${tanggal_kandang}</td>
                    <td>${jumlah_kandang}</td>
                    <td>${bobot_total}</td>
                    <td style="min-width: 180px">
                        <a title="edit" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#default" onclick="editModal('${id}')"><i class="fa fa-edit"></i> </a>
                        <a title="delete" class="btn btn-outline-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#default" onclick="deleteModal('${id}')"><i class="fa fa-trash"></i></a>
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
                                    aria-label="Name: activate to sort column ascending">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending">
                                    Start date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending">
                                    House date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    House amount (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Weight amount(Kg)
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending">Action
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
        });

        // Menangani reset tanggal
        $('#dateFilter').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    }

    // menambahkan data kandang
    function addModal() {
        $.ajax({
            type: "GET",
            url: `/users/free/`,
            success: function(response) {
                console.log(response)
                let pemilik = response.data.pemilik
                let peternak = response.data.peternak

                // option pemilik
                let optionPemilik = '<option value="null">Select Owner</option>'
                if (pemilik.length > 0) {

                    pemilik.forEach(item => {
                        optionPemilik +=
                            `<option value="${item.id}">${item.name} (${item.email})</option>`
                    })
                }

                // option peternak 
                let optionPeternak = '<option value="null">Select Farmer</option>'
                if (peternak.length > 0) {
                    peternak.forEach(item => {
                        optionPeternak +=
                            `<option value="${item.id}">${item.name} (${item.email})</option>`
                    });
                }
                $('#modalTitle').html("Add New House")
                $('#modalBody').html(`
                <form class="form form-horizontal">
                        <div class="form-body"> 
                            <div class="row">
                            
                                <div class="col-md-4">
                                    <label for="namaKandang">Cage name <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="namaKandang" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="alamatKandang">Cage Address <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="alamatKandang" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="luasKandang">Cage Area (M<sup>2</sup>) <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="luasKandang" class="form-control" >
                                </div>
                                <div class="col-md-4">
                                    <label for="idPemilik">Owner <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <fieldset class="form-group">
                                            <select class="form-select" id="idPemilik">
                                              ${optionPemilik}
                                            </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <label for="idPeternak">Farmer <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <fieldset class="form-group">
                                            <select class="form-select" id="idPeternak">
                                              ${optionPeternak}
                                            </select>
                                        </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <label for="populasiAwal">Initial Population <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="populasiAwal" class="form-control" >
                                </div>
                            </div>
                        </div>
                    </form>
                `)

                $('#modalFooter').html(`<a class="btn btn-success btn-sm" onclick="save()">Submit</a>`)
            },
            error: function(err) {
                console.log(err)
            }
        })


    }

    // mengubah data kandang
    function editModal(id) {
        $.ajax({
            type: "GET",
            url: `/kandang/${id}`,
            success: function(response) {
                let {
                    id,
                    nama_kandang,
                    alamat_kandang,
                    luas_kandang,
                    populasi_awal,
                    populasi_saat_ini,
                    total_kematian,
                    id_pemilik,
                    nama_pemilik,
                    email_pemilik,
                    id_peternak,
                    nama_peternak,
                    email_peternak
                } = response.data;
                let pemilikAndPeternak = getPemilikAndPeternak()
                let pemilik = pemilikAndPeternak.pemilik
                let peternak = pemilikAndPeternak.peternak
                console.log(pemilik)
                console.log(peternak)

                // option pemilik
                let optionPemilik = '<option value="null">Select Owner</option>'
                if (pemilik.length > 0) {
                    pemilik.forEach(item => {
                        if (id_pemilik == item.id) {
                            optionPemilik +=
                                `<option value="${id_pemilik}" selected>${nama_pemilik} (${email_pemilik})</option>`
                        } else {
                            optionPemilik +=
                                `<option value="${item.id}">${item.name} (${item.email})</option>`

                        }
                    })
                }

                // option peternak 
                let optionPeternak = '<option value="null">Select Farmer</option>'
                if (peternak.length > 0) {
                    peternak.forEach(item => {
                        if (id_peternak == item.id) {
                            optionPeternak +=
                                `<option value="${id_peternak}" selected>${nama_peternak} (${email_peternak})</option>`
                        } else {
                            optionPeternak +=
                                `<option value="${item.id}">${item.name} (${item.email})</option>`
                        }
                    });
                }
                $('#modalTitle').html("Edit Cage")
                $('#modalBody').html(`
                <form class="form form-horizontal">
                        <div class="form-body">
                            <div class="row">
                                <input type="hidden" id="idKandang" value="${id}" class="form-control">
                                <div class="col-md-4">
                                    <label for="namaKandang">Cage Name <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="namaKandang" value="${nama_kandang}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="alamatKandang">Cage Address <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="alamatKandang" value="${alamat_kandang}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="luasKandang">Cage Area (M<sup>2</sup>) <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="luasKandang" value="${luas_kandang}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="idPemilik">Owner <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <fieldset class="form-group">
                                            <select class="form-select" id="idPemilik">
                                              ${optionPemilik}
                                            </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <label for="idPeternak">Farmer <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <fieldset class="form-group">
                                            <select class="form-select" id="idPeternak">
                                              ${optionPeternak}
                                            </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <label for="populasiAwal">Initial Population (Head) <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="populasiAwal" value="${populasi_awal}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="populasiSaatIni">Remaining Population (Head)</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="populasiSaatIni" value="${populasi_saat_ini}" class="form-control" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="totalKematian">Amount of Death (Head)</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="totalKematian" value="${total_kematian}" class="form-control" readonly>
                                </div>
                               
                            </div>
                        </div>
                    </form>
                `)
                $('#modalFooter').html(
                    `<a class="btn btn-success btn-sm" onclick="update('${id}')">Edit</a>`)
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
    }

    function getPemilikAndPeternak() {
        let result
        $.ajax({
            type: "GET",
            url: `/users/free`,
            async: false,
            success: function(response) {
                result = response.data
            },
            error: function(err) {

            }
        })
        return result
    }

    // menghapus data kandang
    function deleteModal(id) {
        $.ajax({
            type: "GET",
            url: `/kandang/${id}`,
            success: function(response) {
                let {
                    id,
                    nama_kandang,
                    alamat_kandang,
                    luas_kandang,
                    populasi_awal,
                    populasi_saat_ini,
                    total_kematian,
                    id_pemilik,
                    nama_pemilik,
                    email_pemilik,
                    id_peternak,
                    nama_peternak,
                    email_peternak
                } = response.data;

                $('#modalTitle').html("Delete Cage")
                $('#modalBody').html(`
                    <div>
                        <table class="table table-borderless">  
                            <tbody>
                                <tr>
                                    <th class="text-center" colspan="2">Cage</th>
                                </tr>
                                <tr>
                                    <td>Cage name</td> <td>${nama_kandang}</td>
                                </tr> 
                                <tr>
                                    <td>Cage Address</td> <td>${alamat_kandang}</td>
                                </tr> 
                                <tr>
                                    <td>Cage Area (M<sup>2</sup>)</td><td>${luas_kandang}</td>
                                </tr>
                                <tr>
                                    <td>Initial Population (Head)</td><td>${populasi_awal}</td>
                                </tr>  
                                <tr>
                                    <td>Remaining Population (Head)</td>  <td>${populasi_saat_ini}</td>
                                </tr> 
                                <tr>
                                    <td>Amount of Death (Head)</td>  <td>${total_kematian}</td>
                                </tr> 
                                <tr>
                                    <td>Owner</td>  <td>${nama_pemilik} (${email_pemilik})</td>
                                </tr> 
                                <tr>
                                    <td>Farmer</td>  <td>${nama_peternak} (${email_peternak})</td>
                                </tr> 
                            </tbody>
                        </table>
                    </div>
                    `)
                $('#modalFooter').html(
                    `<a class="btn btn-danger btn-sm" onclick="deleteItem('${id}')">Delete</a>`)
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })

    }
    // -------------------------------API KE DATABASE---------------------------------------------------------------------

    function save() {
        let namaKandang = $('#namaKandang').val()
        let alamatKandang = $('#alamatKandang').val()
        let luasKandang = parseInt($('#luasKandang').val())
        let populasiAwal = parseInt($('#populasiAwal').val())
        let idPemilik = $('#idPemilik').val()
        let idPeternak = $('#idPeternak').val()

        console.log(typeof idPemilik)
        console.log(idPemilik)
        // validasi
        if (!namaKandang) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Please fill the Cage name",
                showConfirmButton: false,
                timer: 1500
            })

        }
        if (!alamatKandang) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Please fill the Cage address",
                showConfirmButton: false,
                timer: 1500
            })

        }
        if (!luasKandang) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Please fill the Cage area",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (luasKandang < 0) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "House Area cannot be less than 0",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (!populasiAwal) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Please fill the Initial population",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (populasiAwal < 0) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Initial Population cannot be less than 0",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (!idPemilik || idPemilik == "null") {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Owner required!",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (!idPeternak || idPeternak == "null") {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Farmer required!",
                showConfirmButton: false,
                timer: 1500
            })
        }
        // asign value if validated
        let data = {
            nama_kandang: namaKandang,
            alamat_kandang: alamatKandang,
            luas_kandang: luasKandang,
            populasi_awal: populasiAwal,
            id_user: idPemilik,
            id_peternak: idPeternak
        }

        $.ajax({
            type: "POST",
            url: `/kandang`,
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify(data),
            success: function(response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Data added",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    $('#default').modal('hide')
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
            url: `/kandang/${id}`,
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Date deleted",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    $('#default').modal('hide')
                    showTableData(response.kandang.id_kandang)
                })
            },
            error: function(err) {
                console.log(err.responseText)
            }

        })
    }

    function update(id) {
        let namaKandang = $('#namaKandang').val()
        let alamatKandang = $('#alamatKandang').val()
        let luasKandang = parseInt($('#luasKandang').val())
        let populasiAwal = parseInt($('#populasiAwal').val())
        let totalKematian = parseInt($('#totalKematian').val())
        let idPemilik = $('#idPemilik').val()
        let idPeternak = $('#idPeternak').val()

        let populasiSaatIni = populasiAwal - totalKematian

        // validasi
        if (!namaKandang) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Please fill the Cage name",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (!alamatKandang) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Please fill the Cage address",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (!luasKandang) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Please fill the Cage area",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (luasKandang < 0) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "House Area cannot be less than 0",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (!populasiAwal) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Please fill the Initial population",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (populasiAwal < 0) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Initial Population cannot be less than 0",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (populasiSaatIni < 0) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "The initial population must not be less than  amount of deaths.",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (!idPemilik || idPemilik == "null") {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Owner required!",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (!idPeternak || idPeternak == "null") {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Farmer required!",
                showConfirmButton: false,
                timer: 1500
            })
        }

        let data = {
            nama_kandang: namaKandang,
            alamat_kandang: alamatKandang,
            luas_kandang: luasKandang,
            populasi_awal: populasiAwal,
            populasi_saat_ini: populasiSaatIni,
            id_user: idPemilik,
            id_peternak: idPeternak,
        }
        console.log(data)


        $.ajax({
            type: "PUT",
            url: `/kandang/${id}`,
            data: JSON.stringify(data),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Data edited",
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
