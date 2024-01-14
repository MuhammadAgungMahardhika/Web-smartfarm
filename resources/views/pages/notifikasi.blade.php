<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Notification</h3>
                <p class="text-subtitle text-muted">Notification page</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Notification</li>
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
                                    <th>Cage Name</th>
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
                                    <th>Cage Address</th>
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

                <div id="tableData">
                    <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                        <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Name: activate to sort column ascending" style="width: 136.047px;">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">
                                    Message
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">
                                    Status
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                    Datetime
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
                            @foreach ($data[0]['notification'] as $notification)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $notification->pesan }}</td>
                                    <td class="{{ $notification->status == 1 ? 'text-primary' : 'text-success' }}">
                                        <i>{{ $notification->status == 1 ? 'unread' : 'read' }}</i>
                                    </td>
                                    <td>{{ $notification->waktu }}</td>
                                    <td class="text-center">
                                        @if ($notification->status == 1)
                                            <a title="marking as read" class="btn btn-outline-primary btn-sm me-1"
                                                onclick="updateItem('{{ $notification->id }}','2','{{ $data[0]->id }}')">
                                                <i class="fa fa-envelope"></i>
                                            </a>
                                        @else
                                            <a title="marking as unread" class="btn btn-outline-primary btn-sm me-1"
                                                onclick="updateItem('{{ $notification->id }}','1','{{ $data[0]->id }}')">
                                                <i class="fa fa-envelope-open"></i>
                                            </a>
                                        @endif
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
            url: `/notification/kandang/${kandangId}`,
            contentType: "application/json",
            success: function(response) {

                let itemData = response.data
                let data = ''

                // adding input harian data
                for (let i = 0; i < itemData.length; i++) {
                    let {
                        id,
                        status,
                        pesan,
                        waktu
                    } = itemData[i]
                    let statusInfo = ""

                    if (status == 1) {
                        statusInfo =
                            ` <a title="Marking as read" class="btn btn-outline-primary btn-sm me-1" onclick="updateItem('${id}','${2}','${kandangId}')"><i class="fa fa-envelope"></i> </a>`
                    } else if (status == 2) {
                        statusInfo =
                            `<a title="Marking as unread" class="btn btn-outline-primary btn-sm me-1" onclick="updateItem('${id}','${1}','${kandangId}')"><i class="fa fa-envelope-open"></i></a>`
                    }

                    data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${pesan}</td>
                    <td class="${ status == 1? 'text-primary' : 'text-success'  }">${status == 1 ? "<i>unread</i>" : "<i>read</i>"}</td>
                    <td>${waktu}</td>
                    <td class="text-center">
                       ${statusInfo}
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
                                                aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Message
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Status
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Datetime
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
                [10, 25, 50, 75, 100, 200, -1],
                [10, 25, 50, 75, 100, 200, "All"],
            ],
            pageLength: 10,

        });
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
