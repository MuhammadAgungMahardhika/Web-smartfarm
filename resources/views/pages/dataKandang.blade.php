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
        <div class="card ">
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
                                <tr>
                                    <th>Export to</th>
                                    <td>
                                        <a class="btn btn-outline-danger btn-sm me-2" onclick="exportToPDF()"><i
                                                class="fa fa-file-pdf-o"> </i> Pdf
                                        </a>
                                        <a class="btn btn-outline-success btn-sm me-2" onclick="exportToExcel()"><i
                                                class="fa fa-file-excel-o"> </i> Excel
                                        </a>
                                        <a class="btn btn-outline-success btn-sm" onclick="exportToCsv()"><i
                                                class="fa fa-file-csv"> </i> Csv
                                        </a>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-4 rounded">
                <div class="text-start mb-4" id="filterMenu">
                    <a href="" class="btn btn-success">Filter</a>
                </div>
                <div id="tableData">
                    <table class="table dataTable no-footer " id="table" aria-describedby="table1_info">
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
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Pen
                                    Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending" style="width: 239.078px;">
                                    Pen Address
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">Pen
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
                                    style="width: 223.344px;">
                                    Weight (Kg)
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
                                    <td>{{ $dataKandang->bobot }}</td>
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
                format: 'a4',
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
            url: `/data-kandang/kandang/${kandangId}`,
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
                        bobot,
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
                    <td>${bobot}</td>
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
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Pen
                                    Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending" style="width: 239.078px;">
                                    Pen Address
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">Pen
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
                                    style="width: 223.344px;">
                                    Weight (Kg)
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
