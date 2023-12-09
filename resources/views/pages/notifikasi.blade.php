<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Notifikasi</h3>
                <p class="text-subtitle text-muted">Halaman Notifikasi</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Notifikasi</li>
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
                                        Kandang 1
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>

            <div class="card-body table-responsive bg-light p-4 rounded">
                {{-- <div class="text-start mb-4" id="addButton">

                </div> --}}
                <div id="tableData">

                </div>

            </div>
        </div>
    </section>
</x-app-layout>
<script>
    fetchKandang(<?= Auth::user()->id ?>)

    function fetchKandang(userId) {
        // check Role 
        let checkRole = <?= Auth::user()->id_role ?>;
        let optionButton = '';
        let url = ''
        if (checkRole == 2) {
            url = 'user'
        } else if (checkRole == 3) {
            url = 'peternak'
        }

        $.ajax({
            type: "GET",
            url: `/kandang/${url}/${userId}`,
            success: function(response) {
                let dataKandang = response.data
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
            url: `/notification/kandang/${kandangId}`,
            contentType: "application/json",
            async: false,
            success: function(response) {
                // asign value
                let itemData = response.data
                console.log(itemData)
                let data = ''

                // adding input harian data
                for (let i = 0; i < itemData.length; i++) {
                    let status = ''
                    if (itemData[i].status == 1) {
                        status =
                            ` <a title="tandain telah dibaca" class="btn btn-outline-primary btn-sm me-1" onclick="updateItem('${itemData[i].id}','${2}','${kandangId}')"><i class="fa fa-envelope"></i> </a>`
                    } else if (itemData[i].status == 2) {
                        status =
                            `<a title="tandain belum dibaca" class="btn btn-outline-primary btn-sm me-1" onclick="updateItem('${itemData[i].id}','${1}','${kandangId}')"><i class="fa fa-envelope-open"></i></a>`
                    }

                    data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${itemData[i].pesan}</td>
                    <td>${itemData[i].status == 1 ? "<i>belum dibaca</i>" : "<i>sudah dibaca</i>"}</td>
                    <td>${itemData[i].waktu}</td>
                    <td>
                       ${status}
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
                                                aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Pesan
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Status
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Waktu
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

    // API
    function updateItem(id, status, idKandang) {
        $.ajax({
            type: "PATCH",
            url: `/notification/${id}`,
            data: JSON.stringify({
                status: status
            }),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response)
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
                console.log("sini?")
                console.log(err.responseText)
            }
        })
    }
</script>
