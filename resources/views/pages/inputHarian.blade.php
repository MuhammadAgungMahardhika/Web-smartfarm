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
                                {{-- <tr>
                                    <th>DateTime</th>
                                    <td id="dateTime">

                                    </td>
                                </tr> --}}
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
    // new DateAndTime();
    // setInterval("DateAndTime()", 1000);

    fetchKandang(userId = 1)

    function fetchKandang(userId) {
        let dataKandang = [{
                id_kandang: 1,
                nama_kandang: "Kandang 1",
                populasi_awal: 14,
                alamat_kandang: "Jln.Kandang 1"

            },
            {
                id_kandang: 2,
                nama_kandang: "Kandang 2",
                populasi_awal: 12,
                alamat_kandang: "Jln.Kandang 2"

            }
        ]
        let optionButton = ""

        for (let i = 0; i < dataKandang.length; i++) {
            optionButton +=
                `<option ${i == 0 ? 'selected': ''} value="${dataKandang[i].id_kandang}">${dataKandang[i].nama_kandang}</option>`
        }

        $('#namaKandang').html(`
        <fieldset class="form-group">
            <select class="form-select" id="selectKandang" onchange="changeKandang()">
                ${optionButton}
            </select>
         </fieldset>
        `)
        changeKandang()
    }

    function changeKandang() {
        let optionValue = $("#selectKandang").val()
        let kandang = ''
        if (optionValue == 1) {
            kandang = {
                id_kandang: 1,
                nama_kandang: "Kandang 1",
                populasi_awal: 12,
                alamat_kandang: "Jln.Kandang 1"
            }
        } else if (optionValue == 2) {
            kandang = {
                id_kandang: 2,
                nama_kandang: "Kandang 2",
                populasi_awal: 14,
                alamat_kandang: "Jln.Kandang 2"
            }
        }

        $('#alamatKandang').html(kandang.alamat_kandang)
        $('#addButton').html(
            ` <a title="tambah" class="btn btn-success btn-sm block" data-bs-toggle="modal" data-bs-target="#default" onclick="addModal('${kandang.id_kandang}','${kandang.nama_kandang}')"><i class="fa fa-plus"></i> </a>`
        )
        showTableData(kandang.id_kandang)
    }

    function showTableData(kandangId) {
        let data = `
        <tr>
          <td class="">1</td>
          <td class="sorting_1">2022-11-12</td>
          <td>1</td>
          <td>Cacing</td>
          <td>Sudah</td>
          <td>2 kg</td>
          <td>0</td>
          <td style="min-width: 180px">
            <a class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#default" onclick="editModal('${1}')"><i class="fa fa-edit"> </i> </a>
            <a class="btn btn-outline-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#default" onclick="deleteModal('${1}')"><i class="fa fa-trash"> </i></a>
          </td>
        </tr>
        `
        let table = `
        <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
            <thead>
                <tr>
                    <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                        aria-label="Name: activate to sort column ascending" style="width: 136.047px;">No
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                        aria-label="Name: activate to sort column ascending" style="width: 136.047px;">
                                        Datetime
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                        aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Hari
                                        ke-
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                        aria-label="City: activate to sort column ascending" style="width: 239.078px;">Pakan
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
                                        Kematian
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
                            <input type="text" value="namaKandangTes " id="namakandang" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="hariKe">Hari ke-</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="hariKe" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="jumlahAwalAyam">Jumlah Awal Ayam</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="jumlahAwalAyam" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="jumlahAyam">Jumlah Ayam</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="jumlahAyam" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="bobotAyam">Bobot Ayam</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="bobotAyam" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="pakan">Pakan</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="pakan" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="minum">Minum</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="minum" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="jumlahKematian">Jumlah Kematian</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="jumlahKematian" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="rataSuhu">Rata Rata Suhu</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="rataSuhu" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="rataKelembapan">Rata Rata Kelembapan</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="rataKelembapan" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="rataAmoniak">Rata Rata Amoniak</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="rataAmoniak" class="form-control">
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
        $('#modalTitle').html("Mengubah Input Harian")
        $('#modalBody').html(`
        <form class="form form-horizontal">
            <div class="form-body">
                    <div class="row">
                        <input type="hidden" id="idKandang" value="${id}" class="form-control">
                        <div class="col-md-4">
                            <label for="namaKandang">Nama kandang</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="namaKandang" value="Kandang 1" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="hariKe">Hari ke-</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" value="${id}" id="hariKe" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="jumlahAwalAyam">Jumlah Awal Ayam</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="jumlahAwalAyam" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="jumlahAyam">Jumlah Ayam</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="jumlahAyam" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="bobotAyam">Bobot Ayam</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="bobotAyam" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="pakan">Pakan</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="pakan" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="minum">Minum</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="minum" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="jumlahKematian">Jumlah Kematian</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="jumlahKematian" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="rataSuhu">Rata Rata Suhu</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="rataSuhu" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="rataKelembapan">Rata Rata Kelembapan</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="rataKelembapan" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="rataAmoniak">Rata Rata Amoniak</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="rataAmoniak" class="form-control">
                        </div>
                    </div>
                </div>
            </form>
        `)
        $('#modalFooter').html(
            `<a class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#default" onclick="editModal('${id}')">Reset</a>
        <a class="btn btn-success btn-sm" onclick="update('${id}')">Laporkan</a>`)
    }

    function deleteModal(id) {
        $('#modalTitle').html("Hapus Hasil Panen")
        $('#modalBody').html(`Apakah anda yakin ingin menghapus hasil panen ini?`)
        $('#modalFooter').html(`<a class="btn btn-danger btn-sm" onclick="delete('${id}'')">Hapus</a>`)
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

    function save() {
        let hariKe = $('#hariKe').val()
        let jumlahAwalAyam = $('#jumlahAwalAyam').val()
        let jumlahAyam = $('#jumlahAyam').val()
        let bobotAyam = $('#bobotAyam').val()
        let pakan = $('#pakan').val()
        let minum = $('#minum').val()
        let jumlahKematian = $('#jumlahKematian').val()
        let rataSuhu = $('#rataSuhu').val()
        let rataKelembapan = $('#rataKelembapan').val()
        let rataAmoniak = $('#rataAmoniak').val()

        if (hariKe <= 0) {
            return Swal.fire("SweetAlert2 is working!");
        }
        console.log(hariKe)
        console.log(jumlahAwalAyam)
        console.log(jumlahAyam)
        console.log(bobotAyam)
        console.log(pakan)
        console.log(minum)
        console.log(jumlahKematian)
        console.log(rataSuhu)
        console.log(rataKelembapan)
        console.log(rataAmoniak)

    }


    function DateAndTime() {
        var dt = new Date();

        var Hours = dt.getHours();
        var Min = dt.getMinutes();
        var Sec = dt.getSeconds();
        // var MilliSec = dt.getMilliseconds();  + MilliSec + "MilliSec " (for milliseconds).

        //strings
        var days = [
            "Minggu",
            "Senin",
            "Selasa",
            "Rabu",
            "Kamis",
            "Jumat",
            "Sabtu"
        ];

        //strings
        var months = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];

        // var localTime = dt.getLocaleTimeString();
        // var localDate = dt.getLocaleDateString();

        if (Min < 10) {
            Min === "0" + Min;
        } //displays two digits even Min less than 10

        if (Sec < 10) {
            Sec === "0" + Sec;
        } //displays two digits even Sec less than 10

        var suffix = " AM"; //cunverting 24Hours to 12Hours with AM & PM suffix
        if (Hours >= 12) {
            suffix = " PM";
            Hours = Hours - 12;
        }
        if (Hours === 0) {
            Hours = 12;
        }

        // document.getElementById("time").innerHTML = localTime;

        document.getElementById("dateTime").innerHTML =
            days[dt.getDay()] +
            ", " +
            dt.getDate() +
            " " +
            months[dt.getMonth()] +
            " " +
            dt.getFullYear() + "," + Hours + ":" + Min + ":" + Sec + ":" + suffix;

    }
</script>
