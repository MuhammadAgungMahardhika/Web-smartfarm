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
                                    <th>Ekspor Laporan</th>
                                    <td>
                                        <a class="btn btn-outline-danger btn-sm me-2" onclick="exportToPDF()"><i
                                                class="fa fa-file-pdf-o"> </i> Pdf
                                        </a>
                                        <a class="btn btn-outline-success btn-sm" onclick="exportToExcel()"><i
                                                class="fa fa-file-excel-o"> </i> Excel
                                        </a>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>

            <div class="card-body table-responsive p-4 rounded">
                <div class="text-start mb-4" id="addButton">

                </div>
                <div id="tableData">
                    <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                        <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Name: activate to sort column ascending" style="width: 136.047px;">No
                                </th>

                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Nama
                                    Kandang
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending" style="width: 239.078px;">
                                    Alamat Kandang
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                    Suhu
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                    Kelembapan
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                    Amonia
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">
                                    Waktu
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($data[0]['sensors'] as $sensor)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data[0]->nama_kandang }}</td>
                                    <td>{{ $data[0]->alamat_kandang }}</td>
                                    <td>{{ $sensor->suhu }}</td>
                                    <td>{{ $sensor->kelembapan }}</td>
                                    <td>{{ $sensor->amonia }}</td>
                                    <td>{{ $sensor->datetime }}</td>
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
        XLSX.writeFile(wb, `data-suhu-kelembapan-amonia-kandang-${today}.xlsx`);
    }
</script>
<script>
    initDataTable('table')
    // setInterval(initKandang, 5000);

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
            url: `/sensors/kandang/${kandangId}`,
            success: function(response) {
                // asign value
                let sensors = response.data
                let data = ''
                // adding data kandang data
                for (let i = 0; i < sensors.length; i++) {
                    let {
                        datetime,
                        nama_kandang,
                        alamat_kandang,
                        suhu,
                        kelembapan,
                        amonia,
                    } = sensors[i]
                    console.log(sensors[i])

                    data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${nama_kandang}</td>
                    <td>${alamat_kandang}</td>
                    <td>${suhu}</td>
                    <td>${kelembapan}</td>
                    <td>${amonia}</td>
                    <td>${datetime}</td>
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
                                                Suhu
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Kelembapan
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Amonia
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Waktu
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
        jquery_datatable = $(`#${id}`).DataTable({
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
</script>
<script>
    let suhu, kelembapan, amonia

    var pusher = new Pusher('4f34ab31e54a4ed8a72d', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('sensor-data');
    channel.bind('pusher:subscription_succeeded', function() {
        // Setel callback untuk event SensorDataUpdated setelah berlangganan berhasil
        channel.bind('App\\Events\\SensorDataUpdated', function(data) {
            idKandang = data.idKandang
            suhu = parseInt(data.suhu)
            kelembapan = parseInt(data.kelembapan)
            amonia = parseInt(data.amonia)
            let selectedKandang = $("#selectKandang").val()
            if (idKandang == selectedKandang) {
                console.log(suhu)
            }
        });
    });
</script>
