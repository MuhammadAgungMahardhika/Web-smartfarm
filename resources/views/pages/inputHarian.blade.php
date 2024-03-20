<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Daily Input </h3>
                <p class="text-subtitle text-muted">Daily input page</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Daily Input</li>
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
                                                @foreach ($kandang as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->nama_kandang }}
                                                    </option>
                                                @endforeach;
                                            </select>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Cage Address</th>
                                    <td id="alamatKandang">
                                        {{ $kandang[0]->alamat_kandang }}
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 p-2">
                        <div id="resetDaily">
                            <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#default"
                                onclick="addModalResetDaily('{{ $kandang[0]->id }}')"><i class="fa fa-refresh"></i>
                                Reset
                                Daily Input</a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card-body table-responsive  p-4 rounded">
                {{-- add button --}}
                <div class="text-start mb-4" id="addButton">
                    <a title="tambah" class="btn btn-success btn-sm block" data-bs-toggle="modal"
                        data-bs-target="#default" onclick="addModal('{{ $kandang[0]->id }}')">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
                {{-- Table data --}}
                <div id="tableData">
                    <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                        <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Name: activate to sort column ascending">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending">
                                    Date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending">Day
                                </th>

                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Feed (G)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Watering (L)
                                </th>

                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Daily mortality (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Time of mortality (Hour)
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
                            @foreach ($data as $dataKandang)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $dataKandang->date }}</td>
                                    <td>{{ $dataKandang->hari_ke }}</td>
                                    <td>{{ $dataKandang->pakan }}</td>
                                    <td>{{ $dataKandang->minum }}</td>
                                    <td>{{ $dataKandang->total_kematian }} </td>
                                    <td>{!! $dataKandang->jam_kematian != null
                                        ? str_replace(',', '<br>', $dataKandang->jam_kematian)
                                        : $dataKandang->jam_kematian !!}
                                    </td>
                                    <td>
                                        <a title="mengubah" class="btn btn-outline-primary btn-sm me-1"
                                            data-bs-toggle="modal" data-bs-target="#default"
                                            onclick="editModal('{{ $dataKandang->id }}')"><i class="fa fa-edit"></i>
                                        </a>
                                        <a title="hapus" class="btn btn-outline-danger btn-sm me-1"
                                            data-bs-toggle="modal" data-bs-target="#default"
                                            onclick="deleteModal('{{ $dataKandang->id }}')"><i
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
    const baseUrl = "{{ url('') }}"
    initDataTable('table')

    function initKandang() {
        let id = $("#selectKandang").val()
        $.ajax({
            type: "GET",
            url: baseUrl + `/kandang/${id}`,
            success: function(response) {
                let kandang = response.data
                $('#alamatKandang').html(kandang.alamat_kandang)
                $('#addButton').html(
                    ` <a title="tambah" class="btn btn-success btn-sm block" data-bs-toggle="modal" data-bs-target="#default" onclick="addModal('${id}')"><i class="fa fa-plus"></i> </a>`
                )
                $('#resetDaily').html(`
                     <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#default"
                                onclick="addModalResetDaily('${id}')"><i class="fa fa-refresh"></i>Reset Daily Input</a>
                `)
                showTableData(id)
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })


    }

    function addModalResetDaily(idKandang) {
        $('#modalTitle').html("Reset Daily Input Day")
        $('#modalBody').html("Warning! Are you sure to reset the day ? it will start from 1 again")
        $('#modalFooter').html(
            `<a class="btn btn-danger btn-sm" onclick="resetDailyInput('${idKandang}')">Reset now!</a>`)

    }

    function resetDailyInput(idKandang) {
        $.ajax({
            type: "GET",
            url: baseUrl + `/kandang/reset/${idKandang}`,
            contentType: "application/json",
            success: function(response) {
                // asign value
                let itemData = response.data
                if (itemData) {
                    $('#default').modal('hide')
                    return Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Daily Input Has been reset",
                        showConfirmButton: false,
                        timer: 1500
                    })

                }
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
    }

    function showTableData(kandangId) {
        $.ajax({
            type: "GET",
            url: baseUrl + `/data-kandang/kandang/${kandangId}`,
            contentType: "application/json",
            success: function(response) {
                // asign value
                let itemData = response.data
                let data = ''

                // adding input harian data
                for (let i = 0; i < itemData.length; i++) {
                    let {
                        id,
                        hari_ke,
                        date,
                        pakan,
                        minum,
                        total_kematian,
                        jam_kematian,
                    } = itemData[i]


                    data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${date}</td>
                    <td>${hari_ke}</td>
                    <td>${pakan}</td>
                    <td>${minum}</td>
                    <td>${total_kematian }</td>
                    <td>${jam_kematian != null? jam_kematian.replace(/,/g, '<br>') : ''}</td>
                    <td>
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
                                    aria-label="Name: activate to sort column ascending" >No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" >
                                    Date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" >Day
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Feed (G)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" >
                                    Watering (L)
                                </th>
                               
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Daily mortality (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending">
                                    Time of mortality (Hour)
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                   >Action
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
            "rowCallback": function(row, data, index) {
                // Mengatur vertical-align: top pada setiap sel dalam baris
                $('td', row).css('vertical-align', 'top');
            }
        });
    }

    function addModal(idKandang) {
        $.ajax({
            type: "GET",
            url: baseUrl + `/kandang/${idKandang}`,
            success: function(response) {

                let {
                    nama_kandang,
                    populasi_awal,
                    populasi_saat_ini
                } = response.data

                let today = new Date()
                let yyyy = today.getFullYear()
                let mm = today.getMonth() + 1
                let dd = today.getDate()
                if (dd < 10) dd = '0' + dd;
                if (mm < 10) mm = '0' + mm;
                let dateNow = yyyy + "-" + mm + "-" + dd
                let dateKe = dateNow

                let currentDataKandang = getCurrentDataKandang(idKandang)
                console.log(currentDataKandang);

                let hariKe = 1
                if (currentDataKandang) {
                    const kandangStatus = currentDataKandang.status

                    console.log(kandangStatus)
                    hariKe = currentDataKandang.hari_ke + 1
                    dateKe = currentDataKandang.date

                    // Mengonversi string menjadi objek Date
                    let tanggalObjek = new Date(dateKe);

                    // Menambahkan 1 hari
                    tanggalObjek.setDate(tanggalObjek.getDate() + 1);

                    // Mendapatkan tanggal, bulan, dan tahun yang diperlukan
                    let tahun = tanggalObjek.getFullYear();
                    let bulan = ('0' + (tanggalObjek.getMonth() + 1)).slice(-2);
                    let tanggal = ('0' + tanggalObjek.getDate()).slice(-2);

                    // Mengonversi kembali ke format string "YYYY-MM-DD"
                    dateKe = tahun + "-" + bulan + "-" + tanggal;

                    if (kandangStatus == "nonaktif") {
                        hariKe = 1
                        dateKe = dateNow
                    }
                }

                let isReadOnly = hariKe != 1 ? "readonly" : ""


                $('#modalTitle').html("Add Daily Data")
                $('#modalBody').html(`
                <form class="form form-horizontal">
                        <div class="form-body">
                            <div class="row">
                                <input type="hidden" id="idKandang" value="${idKandang}" class="form-control">
                                <div class="col-md-4">
                                    <i>Cage Name </i>
                                </div>
                                <div class="col-md-8 form-group">
                                    <i>${nama_kandang}</i>
                                </div>
                                <div class="col-md-4">
                                    <i>Initial Population</i>
                                </div>
                                <div class="col-md-8 form-group ">
                                    <i>${populasi_awal}</i>
                                </div>
                                <div class="col-md-4">
                                    <i>Remain Population</i>
                                </div>
                                <div class="col-md-8 form-group mb-4">
                                    <i>${populasi_saat_ini}</i>
                                </div>
                                <div class="col-md-4">
                                    <label for="hariKe">Day- <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" value="${hariKe}" id="hariKe" class="form-control" placeholder="" autofocus readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="date">Date <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" value="${dateKe}" id="date" class="form-control" ${isReadOnly}>
                                </div>
                                <div class="col-md-4">
                                    <label for="pakan">Feed (G) <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="pakan" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="minum">Watering (L) <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" id="minum" class="form-control">
                                </div>
                               
                                <div>
                                    <div class="table-responsive bg-light border border-secondary p-2">
                                        <p class="text-center">Daily Mortalities</p>
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

                // Prevent text di input day
                document.getElementById('hariKe').addEventListener('input', function(event) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
                $('#modalFooter').html(`<a class="btn btn-success btn-sm" onclick="save()">Submit</a>`)
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })

    }

    // mendapatkan hari selanjutnya 
    function getCurrentDataKandang(idKandang) {
        let result
        $.ajax({
            type: "GET",
            async: false,
            url: baseUrl + `/data-kandang/current/kandang/${idKandang}`,
            success: function(response) {
                result = response.data.data
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
        return result
    }

    function addRowKematian() {
        // set row id 
        let id = Math.floor(Math.random() * 1000000000);
        $('#tableKematian').append(`
        <tr id="${id}">
            <td>
                <div class="form-group">
                   <label for="jumlah">Amount (Head)</label>
                </div>
            </td> 
            <td>
                <div class="form-group">
                   <input type="number" name="jumlah_kematian" class="form-control" required>
                </div>
            </td> 
            <td>
                <div class="form-group">
                   <label for="jam">Time </label>
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
        $.ajax({
            type: "GET",
            url: baseUrl + `/data-kandang/${id}`,
            success: function(response) {
                let {
                    data_kematians,
                    id_kandang,
                    kandang,
                    hari_ke,
                    date,
                    pakan,
                    minum,
                    riwayat_populasi,
                    classification
                } = response.data

                riwayat_populasi = parseInt(riwayat_populasi)

                let rowKematian = ''
                if (data_kematians.length > 0) {
                    for (let i = 0; i < data_kematians.length; i++) {
                        let id = Math.floor(Math.random() * 1000000000);
                        let {
                            jumlah_kematian,
                            jam
                        } = data_kematians[i]

                        rowKematian +=
                            `<tr id="${id}">
                    <td>
                        <div class="form-group">
                        <label for="jumlah">Amount (Head) </label>
                        </div>
                    </td> 
                    <td>
                        <div class="form-group">
                        <input type="number" value="${jumlah_kematian}" name="jumlah_kematian" class="form-control" required>
                        </div>
                    </td> 
                    <td>
                        <div class="form-group">
                        <label for="jam">Time</label>
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
                $('#modalTitle').html("Edit Daily Data")
                $('#modalBody').html(`
                <form class="form form-horizontal">
                        <div class="form-body">
                            <div class="row">
                                <input type="hidden" id="idKandang" value="${id_kandang}" class="form-control">
                                <div class="col-md-4">
                                    <i>Cage Name</i>
                                </div>
                                <div class="col-md-8 form-group">
                                    <i>${kandang.nama_kandang}</i>
                                </div>
                                <div class="col-md-4">
                                    <i>Remain Population</i>
                                </div>
                                <div class="col-md-8 form-group mb-4">
                                    <i>${kandang.populasi_saat_ini}</i>
                                </div>
                                <div class="col-md-4">
                                    <label for="hariKe">Day- <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" value="${hari_ke}" id="hariKe" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="date">Date <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" value="${date}" id="date" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="pakan">Feed (G) <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" value="${pakan}" id="pakan" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="minum">Watering (L) <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" value="${minum}" id="minum" class="form-control">
                                </div>
                               
                                <input type="hidden" value="${riwayat_populasi}" id="riwayatPopulasi">
                                <div>
                                    <div class="table-responsive bg-light border border-secondary p-2">
                                        <p class="text-center">Daily Mortalities</p>
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
                // Prevent text di input day
                document.getElementById('hariKe').addEventListener('input', function(event) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
                $('#modalFooter').html(
                    `<a class="btn btn-success btn-sm" onclick="update('${id}')">Edit</a>`)
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })


    }

    function deleteModal(id) {
        $.ajax({
            type: "GET",
            url: baseUrl + `/data-kandang/${id}`,
            success: function(response) {
                let {
                    kandang,
                    nama_kandang,
                    populasi_saat_ini,
                    hari_ke,
                    date,
                    pakan,
                    minum,
                    riwayat_populasi,
                    classification
                } = response.data


                $('#modalTitle').html("Delete Daily Data")
                $('#modalBody').html(`
                    <div>
                        <table class="table table-borderless">  
                            <tbody>
                                <tr>
                                    <th class="text-center" colspan="2">Daily Input</th>
                                </tr>
                                <tr>
                                    <td>Cage Name</td> <td>${kandang.nama_kandang}</td>
                                </tr> 
                                <tr>
                                    <td>Day-</td> <td>${hari_ke}</td>
                                </tr> 
                                <tr>
                                    <td>Date</td> <td>${date}</td>
                                </tr> 
                                <tr>
                                    <td>Feed (G)</td><td>${pakan}</td>
                                </tr> 
                                <tr>
                                    <td>Watering (L)</td><td>${minum}</td>
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



    function getKandang(id) {
        let item
        $.ajax({
            type: "GET",
            url: baseUrl + `/kandang/${id}`,
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
            url: baseUrl + `/jumlah-kematian/data-kandang/${id}`,
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

        // validasi
        let totalKematian = 0
        for (i = 0; i < dataKematian.length; i++) {
            if (dataKematian[i].jumlah_kematian > 0 && dataKematian[i].jam.length > 0) {
                totalKematian += parseInt(dataKematian[i].jumlah_kematian)

            } else {
                return Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Please check your daily mortality data!",
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }

        let sisa_populasi = populasiSaatIni - totalKematian

        if (sisa_populasi < 0) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Deaths exceed the current population!",
                showConfirmButton: false,
                timer: 1500
            })
        }

        if (!hariKe) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Day required!",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (hariKe <= 0) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Day must not be less than 1!",
                showConfirmButton: false,
                timer: 1500
            })
        }

        if (!pakan) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Feed required!",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (pakan <= 0) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Feed must not be less than 1!",
                showConfirmButton: false,
                timer: 1500
            })
        }

        if (!minum) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Drink required!",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (minum <= 0) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Watering must not be less than 1!",
                showConfirmButton: false,
                timer: 1500
            })
        }


        // asign value if validated
        let data = {
            id_kandang: idKandang,
            hari_ke: hariKe,
            date: date,
            pakan: pakan,
            minum: minum,
            riwayat_populasi: sisa_populasi,
            classification: klasifikasi,
            data_kematian: dataKematian
        }

        $.ajax({
            type: "POST",
            url: baseUrl + `/data-kandang`,
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify(data),
            success: function(response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Data Added",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    $('#default').modal('hide')
                    showTableData(idKandang)
                })
            },
            error: function(err) {
                console.log(err)
                return Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Please select another date, already choosen",
                    showConfirmButton: false,
                    timer: 1500
                })

            }

        })
    }


    function deleteItem(id) {
        $.ajax({
            type: "DELETE",
            url: baseUrl + `/data-kandang/${id}`,
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Data deleted",
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
            if (dataKematian[i].jumlah_kematian > 0 && dataKematian[i].jam.length > 0) {
                totalKematian += parseInt(dataKematian[i].jumlah_kematian)
            } else {
                return Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Please check your daily mortality data!",
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }

        let kembalikanNilaiPopulasi = parseInt(getDataKematianByDataKandangId(id).total_kematian)
        let populasiSaatIni = parseInt(getKandang(idKandang).populasi_saat_ini) + parseInt(kembalikanNilaiPopulasi)
        let sisa_populasi = populasiSaatIni - totalKematian


        // validasi
        if (sisa_populasi < 0) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Deaths exceed the current population!",
                showConfirmButton: false,
                timer: 1500
            })
        }

        if (hariKe <= 0) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Day must not be less than 1!",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (pakan <= 0) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Feed must not be less than 1!",
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (minum <= 0) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Watering must not be less than 1!",
                showConfirmButton: false,
                timer: 1500
            })
        }

        // asign value if validated
        let data = {
            id_kandang: idKandang,
            hari_ke: hariKe,
            date: date,
            pakan: pakan,
            minum: minum,
            riwayat_populasi: sisa_populasi,
            classification: klasifikasi,
            data_kematian: dataKematian
        }
        $.ajax({
            type: "PUT",
            url: baseUrl + `/data-kandang/${id}`,
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
