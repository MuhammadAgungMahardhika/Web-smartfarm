<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">House List</h3>
                <p class="text-subtitle text-muted">house list page</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">House List</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="card-title text-center">House List</div>
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
                                    Start date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending">
                                    Harvest date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Harvest amount (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Weight amount (Kg)
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
                                            onclick="editModal('{{ $panen->id }}')"><i class="fa fa-edit"></i>
                                        </a>
                                        <a title="hapus" class="btn btn-outline-danger btn-sm me-1"
                                            data-bs-toggle="modal" data-bs-target="#default"
                                            onclick="deleteModal('{{ $panen->id }}')"><i class="fa fa-trash"></i></a>
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
                                    <i class="fa fa-calendar"></i> Filter Harvest By Date
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
                                    aria-label="Name: activate to sort column ascending">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending">
                                    Start date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending">
                                    Harvest date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Harvest amount (Head)
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
        $('#modalTitle').html("Filter Harvest By Date")
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
                return Swal.fire("Please fill the from date")
            }

            // check jika to date kosong
            if (!endDate) {
                return Swal.fire("Please fill the end date");
            }

            let data = {
                id_kandang: idKandang,
                from: startDate,
                to: endDate
            }
            $.ajax({
                type: "POST",
                url: `/panen/date`,
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(data),
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
                                    aria-label="Name: activate to sort column ascending">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending">
                                    Start date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending">
                                    Harvest date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Harvest amount (Head)
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

    // menambahkan data panen
    function addModal() {
        $.ajax({
            type: "GET",
            url: `/users/free/`,
            success: function(response) {
                console.log(response)
                let pemilik = response.data.pemilik
                let peternak = response.data.peternak


                // option pemilik
                let optionPemilik = ``
                if (pemilik.length > 0) {
                    pemilik.forEach(item => {

                        optionPemilik +=
                            `<option>Select Owner</option><option value="${item.id}">${item.name} (${item.email})</option>`
                    })
                }

                // option peternak 
                let optionPeternak = ``
                if (peternak.length > 0) {
                    peternak.forEach(item => {
                        optionPeternak +=
                            `<option>Select Farmer</option><option value="${item.id}">${item.name} (${item.email})</option>`
                    });
                }
                $('#modalTitle').html("Add New House")
                $('#modalBody').html(`
                <form class="form form-horizontal">
                        <div class="form-body"> 
                            <div class="row">
                            
                                <div class="col-md-4">
                                    <label for="namaKandang">House name</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="namaKandang" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="alamatKandang">House Address</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="alamatKandang" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="luasKandang">House Area (M2)</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="luasKandang" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="populasiAwal">Initial Population</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="populasiAwal" class="form-control">
                                </div>
                               
                                <div class="col-md-4">
                                    <label for="idPemilik">Owner</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <fieldset class="form-group">
                                            <select class="form-select" id="idPemilik">
                                              ${optionPemilik}
                                            </select>
                                        </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <label for="peternak">Farmer</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <fieldset class="form-group">
                                            <select class="form-select" id="idPeternak">
                                              ${optionPeternak}
                                            </select>
                                        </fieldset>
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

    // mengubah data panen
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

                $('#modalTitle').html("Edit Harvest Data")
                $('#modalBody').html(`
                <form class="form form-horizontal">
                        <div class="form-body">
                            <div class="row">
                                <input type="hidden" id="idKandang" value="${id_kandang}" class="form-control">
                                <div class="col-md-4">
                                    <label for="namaKandang">House name</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="namaKandang" value="${kandang.nama_kandang}" class="form-control" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggalMulai">Start date</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" id="tanggalMulai" value="${tanggal_mulai}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggalPanen">Harvest date</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" id="tanggalPanen" value="${tanggal_panen}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="jumlahPanen">Harvest amount (Head)</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="jumlahPanen" value="${jumlah_panen}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="bobotTotal">Weight amount(Kg)</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="bobotTotal" value="${bobot_total}" class="form-control">
                                </div>
                                
                            </div>
                        </div>
                    </form>
                `)
                $('#modalFooter').html(
                    `<a class="btn btn-success btn-sm" onclick="update('${id}')">Change</a>`)
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
    }

    // menghapus data panen
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

                $('#modalTitle').html("Delete Harvest Data")
                $('#modalBody').html(`
                    <div>
                        <table class="table table-borderless">  
                            <tbody>
                                <tr>
                                    <th class="text-center" colspan="2">Harvest Data</th>
                                </tr>
                                <tr>
                                    <td>House name</td> <td>${kandang.nama_kandang}</td>
                                </tr> 
                                <tr>
                                    <td>Start date</td> <td>${tanggal_mulai}</td>
                                </tr> 
                                <tr>
                                <td>Harvest date</td><td>${tanggal_panen}</td>
                                </tr>
                                <tr>
                                <td>Harvest amount (Head)</td>  <td>${jumlah_panen}</td>
                                </tr>  
                                <tr>
                                <td>Weight amount(Kg)</td>  <td>${bobot_total}</td>
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
        let luasKandang = $('#luasKandang').val()
        let populasiAwal = $('#populasiAwal').val()
        let idPemilik = $('#idPemilik').val()
        let idPeternak = $('#idPeternak').val()

        console.log(namaKandang.length)
        console.log(alamatKandang)
        console.log(luasKandang)
        console.log(populasiAwal)
        console.log(idPemilik)
        console.log(idPeternak)
        // validasi
        if (!namaKandang) {
            return Swal.fire("Please fill the house name")
        }
        if (!alamatKandang) {
            return Swal.fire("Please fill the house address")
        }
        if (!luasKandang) {
            return Swal.fire("Please fill the house area")
        }
        if (!populasiAwal) {
            return Swal.fire("Please fill the Initial population")
        }
        if (!idPemilik) {
            return Swal.fire("Owner required!")
        }
        if (!idPeternak) {
            return Swal.fire("Farmer required!")
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

        // $.ajax({
        //     type: "POST",
        //     url: `/panen`,
        //     contentType: "application/json",
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     data: JSON.stringify(data),
        //     success: function(response) {
        //         Swal.fire({
        //             position: "top-end",
        //             icon: "success",
        //             title: "Data added",
        //             showConfirmButton: false,
        //             timer: 1500
        //         }).then(() => {
        //             $('#default').modal('hide')
        //             showTableData(response.panen.id_kandang)
        //         })
        //     },
        //     error: function(err) {
        //         console.log(err.responseText)
        //     }

        // })

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
                    title: "Date deleted",
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
