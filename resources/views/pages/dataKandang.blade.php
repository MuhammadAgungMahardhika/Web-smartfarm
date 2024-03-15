<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">Cage Data</h3>
                <p class="text-subtitle text-muted">Cage Data Page</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Cage Data</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    {{-- Nama dan Alamat Kandang --}}
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
                                <tr>
                                    <th>Export to</th>
                                    <td>
                                        <a class="btn btn-outline-danger btn-sm me-2 mb-2" onclick="exportToPDF()"><i
                                                class="fa fa-file-pdf-o"> </i> Pdf
                                        </a>
                                        <a class="btn btn-outline-success btn-sm me-2 mb-2" onclick="exportToExcel()"><i
                                                class="fa fa-file-excel-o"> </i> Excel
                                        </a>
                                        <a class="btn btn-outline-success btn-sm me-2 mb-2" onclick="exportToCsv()"><i
                                                class="fa fa-file-csv"> </i> Csv
                                        </a>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    {{-- Filter menu --}}
                    <div class="col-12 col-md-8 col-lg-8">
                        <div class="text-start p-2 shadow-sm border-circle" id="filterMenu">
                            <p>Filter Data {{ $data[0]->nama_kandang }}</p>
                            <div class="btn-group me-2 mb-2">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    id="dateDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" onclick="filterByDate('{{ $data[0]->id }}')">
                                    <i class="fa fa-calendar"></i> Filter By Date
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dateDropdown">
                                    <div class="row p-2">
                                        <div class="col-12 form-group">
                                            <input type="text" id="dateFilter" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-group me-2 mb-2">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    id="dayDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-calendar"></i> Filter By Day
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dayDropdown">
                                    <div class="row p-2">
                                        <div class="col-md-10 form-group">
                                            <input type="number" placeholder="Day" id="dayFilter" class="form-control">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <a class="btn btn-success btn-sm"
                                                onclick="filterByDay('{{ $data[0]->id }}')"><i
                                                    class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-group me-2 mb-2">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    id="classificationDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-calendar"></i> Filter By Classification
                                </button>
                                <div class="dropdown-menu" aria-labelledby="classificationDropdown"
                                    style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 40px);"
                                    data-popper-placement="bottom-start">
                                    <a class="dropdown-item"
                                        onclick="filterByClassification('{{ $data[0]->id }}','normal')">Normal</a>
                                    <a class="dropdown-item"
                                        onclick="filterByClassification('{{ $data[0]->id }}','abnormal')">Abnormal</a>
                                </div>
                            </div>
                            <button id="reloadButton" class="btn btn-outline-secondary btn-sm  me-2 mb-2"
                                onclick="showTableData('{{ $data[0]->id }}')">
                                <i class="fa fa-sync"></i>
                                Reload Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-4 rounded">
                {{-- table data --}}
                <div id="tableData">
                    <table class="table dataTable no-footer " id="table" aria-describedby="table1_info">
                        <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Name: activate to sort column ascending"
                                    style="width: 30px;">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Phone: activate to sort column ascending"
                                    style="width: 223.344px;">
                                    Date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Phone: activate to sort column ascending"
                                    style="width: 223.344px;">Day
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Phone: activate to sort column ascending"
                                    style="width: 223.344px;">Cage
                                    Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="City: activate to sort column ascending"
                                    style="width: 239.078px;">
                                    Cage Address
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 239.078px;">
                                    Cage
                                    Area (M<sup>2</sup>)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 239.078px;">
                                    Initial Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 239.078px;">
                                    Remaining Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 223.344px;">
                                    Feed (G)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 223.344px;">
                                    Watering (L)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 117.891px;">Classification
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($data[0]['data_kandangs'] as $dataKandang)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $dataKandang->date }}</td>
                                    <td>{{ $dataKandang->hari_ke }}</td>
                                    <td>{{ $data[0]->nama_kandang }}</td>
                                    <td>{{ $data[0]->alamat_kandang }}</td>
                                    <td>{{ $data[0]->luas_kandang }}</td>
                                    <td>{{ $data[0]->populasi_awal }}</td>
                                    <td>{{ $dataKandang->riwayat_populasi }}</td>
                                    <td>{{ $dataKandang->pakan }}</td>
                                    <td>{{ $dataKandang->minum }}</td>
                                    <td>{{ $dataKandang->classification }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>
{{-- Eksporter --}}
<script>
    function exportToPDF() {

        const element = document.getElementById("table");

        // Konfigurasi opsi
        const option = {
            margin: 1,
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            pagebreak: {
                mode: 'avoid-all'
            },
            jsPDF: {
                width: 2,
                unit: 'mm',
                format: 'a3',
                orientation: 'l',
            }

        };

        // Gunakan HTML2PDF untuk membuat dokumen PDF
        // New Promise-based usage:
        html2pdf().set(option).from(element).save();

    }

    function exportToExcel() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = mm + '/' + dd + '/' + yyyy;

        const table = document.getElementById("table");
        const ws = XLSX.utils.table_to_sheet(table);

        // Buat objek workbook dan tambahkan sheet
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

        // Simpan ke file Excel
        XLSX.writeFile(wb, `laporan-kandang-${today}.xlsx`);
    }

    function exportToCsv() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = mm + '/' + dd + '/' + yyyy;

        const table = document.getElementById("table");
        const ws = XLSX.utils.table_to_sheet(table);

        // Buat objek workbook dan tambahkan sheet
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

        // Simpan ke file Csv
        XLSX.writeFile(wb, `laporan-kandang-${today}.csv`);
    }
</script>
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
                showTableData(idKandang)
                $('#alamatKandang').html(kandang.alamat_kandang)
                $('#filterMenu').html(`
                <p>Filter Data ${namaKandang}</p>
                <div class="btn-group me-2 mb-2">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    id="dateDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" onclick="filterByDate('${idKandang}')">
                                    <i class="fa fa-calendar"></i> Filter By Date
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dateDropdown">
                                    <div class="row p-2">
                                        <div class="col-12 form-group">
                                            <input type="text" id="dateFilter" class="form-control">
                                        </div>
                                    </div>
                                </div>
                </div>
                <div class="btn-group me-2 mb-2">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    id="dayDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-calendar"></i> Filter By Day
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dayDropdown">
                                    <div class="row p-2">
                                        <div class="col-md-10 form-group">
                                            <input type="number" placeholder="Day" id="dayFilter" class="form-control">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <a class="btn btn-success btn-sm"
                                                onclick="filterByDay('${idKandang}')"><i
                                                    class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                </div>
                <div class="btn-group me-2 mb-2">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    id="classificationDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-calendar"></i> Filter By Classification
                                </button>
                                <div class="dropdown-menu" aria-labelledby="classificationDropdown"
                                    style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 40px);"
                                    data-popper-placement="bottom-start">
                                    <a class="dropdown-item"
                                        onclick="filterByClassification('${idKandang}','normal')">Normal</a>
                                    <a class="dropdown-item"
                                        onclick="filterByClassification('${idKandang}','abnormal')">Abnormal</a>
                                </div>
                </div>
                <button id="reloadButton" class="btn btn-outline-secondary btn-sm  me-2 mb-2"
                                onclick="showTableData('${idKandang}')">
                                <i class="fa fa-sync"></i>
                                Reload Data
                </button>
                `)
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
    }

    function showTableData(idKandang) {
        $.ajax({
            type: "GET",
            url: `/data-kandang/kandang/${idKandang}`,
            success: function(response) {
                // asign value
                let kandangs = response.data
                let data = ''
                // adding data kandang data
                for (let i = 0; i < kandangs.length; i++) {
                    let {
                        date,
                        hari_ke,
                        nama_kandang,
                        alamat_kandang,
                        pakan,
                        minum,
                        populasi_awal,
                        riwayat_populasi,
                        luas_kandang,
                        classification
                    } = kandangs[i]

                    data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${date}</td>
                    <td>${hari_ke}</td>
                    <td>${nama_kandang}</td>
                    <td>${alamat_kandang}</td>
                    <td>${luas_kandang}</td>
                    <td>${populasi_awal}</td>
                    <td>${riwayat_populasi}</td>
                    <td>${pakan}</td>
                    <td>${minum}</td>
                    <td>${classification}</td>
                    </tr>
                    `
                }

                // construct table
                let table = `
                <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                    <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Name: activate to sort column ascending" style="width: 30px;">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Day
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">House
                                    Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending" style="width: 239.078px;">
                                    House Address
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">House
                                    Area (M<sup>2</sup>)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">
                                    Initial Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">
                                    Remaining Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 223.344px;">
                                    Feed (G)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 223.344px;">
                                    Watering (L)
                                </th>
                    
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 117.891px;">Classification
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

    // Filter data by Day
    function filterByDay(idKandang) {
        let day = $('#dayFilter').val()
        let data = {
            id_kandang: idKandang,
            day: day
        }

        $.ajax({
            type: "POST",
            url: `/data-kandang/day`,
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify(data),
            success: function(response) {
                // asign value
                let kandangs = response.data
                let data = ''
                // adding data kandang data
                for (let i = 0; i < kandangs.length; i++) {
                    let {
                        date,
                        hari_ke,
                        nama_kandang,
                        alamat_kandang,
                        pakan,
                        minum,
                        populasi_awal,
                        riwayat_populasi,
                        luas_kandang,
                        classification
                    } = kandangs[i]

                    data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${date}</td>
                    <td>${hari_ke}</td>
                    <td>${nama_kandang}</td>
                    <td>${alamat_kandang}</td>
                    <td>${luas_kandang}</td>
                    <td>${populasi_awal}</td>
                    <td>${riwayat_populasi}</td>
                    <td>${pakan}</td>
                    <td>${minum}</td>
                    <td>${classification}</td>
                    </tr>
                    `
                }

                // construct table
                let table = `
                <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                    <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Name: activate to sort column ascending" style="width: 30px;">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Day
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">House
                                    Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending" style="width: 239.078px;">
                                    House Address
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">House
                                    Area (M<sup>2</sup>)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">
                                    Initial Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">
                                    Remaining Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 223.344px;">
                                    Feed (G)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 223.344px;">
                                    Watering (L)
                                </th>
                        
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 117.891px;">Classification
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
    // Filter data by classification
    function filterByClassification(idKandang, classification) {
        let data = {
            id_kandang: idKandang,
            classification: classification
        }
        $.ajax({
            type: "POST",
            url: `/data-kandang/classification`,
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify(data),
            success: function(response) {
                // asign value
                let kandangs = response.data
                let data = ''
                // adding data kandang data
                for (let i = 0; i < kandangs.length; i++) {
                    let {
                        date,
                        hari_ke,
                        nama_kandang,
                        alamat_kandang,
                        pakan,
                        minum,
                        populasi_awal,
                        riwayat_populasi,
                        luas_kandang,
                        classification
                    } = kandangs[i]

                    data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${date}</td>
                    <td>${hari_ke}</td>
                    <td>${nama_kandang}</td>
                    <td>${alamat_kandang}</td>
                    <td>${luas_kandang}</td>
                    <td>${populasi_awal}</td>
                    <td>${riwayat_populasi}</td>
                    <td>${pakan}</td>
                    <td>${minum}</td>
                    <td>${classification}</td>
                    </tr>
                    `
                }

                // construct table
                let table = `
                <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                    <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Name: activate to sort column ascending" style="width: 30px;">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Day
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">House
                                    Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending" style="width: 239.078px;">
                                    House Address
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">House
                                    Area (M<sup>2</sup>)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">
                                    Initial Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">
                                    Remaining Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 223.344px;">
                                    Feed (G)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 223.344px;">
                                    Watering (L)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 117.891px;">Classification
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
    // Filter data by tanggal
    function filterByDate(idKandang) {
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
            // Tampilkan data 
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
                url: `/data-kandang/date`,
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(data),
                success: function(response) {

                    // asign value
                    let kandangs = response.data
                    let data = ''
                    // adding data kandang data
                    for (let i = 0; i < kandangs.length; i++) {
                        let {
                            date,
                            hari_ke,
                            nama_kandang,
                            alamat_kandang,
                            pakan,
                            minum,
                            populasi_awal,
                            riwayat_populasi,
                            luas_kandang,
                            classification
                        } = kandangs[i]

                        data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${date}</td>
                    <td>${hari_ke}</td>
                    <td>${nama_kandang}</td>
                    <td>${alamat_kandang}</td>
                    <td>${luas_kandang}</td>
                    <td>${populasi_awal}</td>
                    <td>${riwayat_populasi}</td>
                    <td>${pakan}</td>
                    <td>${minum}</td>
                    <td>${classification}</td>
                    </tr>
                    `
                    }

                    // construct table
                    let table = `
                <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                    <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Name: activate to sort column ascending" style="width: 30px;">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Day
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">House
                                    Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending" style="width: 239.078px;">
                                    House Address
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">House
                                    Area (M<sup>2</sup>)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">
                                    Initial Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">
                                    Remaining Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 223.344px;">
                                    Feed (G)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 223.344px;">
                                    Watering (L)
                                </th>
                        
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 117.891px;">Classification
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

    function initDataTable(id) {
        let jquery_datatable = $(`#${id}`).DataTable({
            responsive: true,
            aLengthMenu: [
                [10, 25, 50, 75, 100, 200, -1],
                [10, 25, 50, 75, 100, 200, "All"],
            ]
        });
    }
</script>
