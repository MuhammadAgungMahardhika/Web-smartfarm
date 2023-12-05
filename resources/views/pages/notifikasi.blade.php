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
        // $('#addButton').html(
        //     ` <a title="tambah" class="btn btn-success btn-sm block" data-bs-toggle="modal" data-bs-target="#default" onclick="addModal('${kandang.id_kandang}')"><i class="fa fa-plus"></i> </a>`
        // )
        showTableData(kandang.id_kandang)
    }

    function reset() {

    }

    function addModal(idKandang) {
        $('#modalTitle').html("Menambahkan Hasil Panen")

        $('#modalBody').html(`
        <form class="form form-horizontal">
                <div class="form-body"> 
                    <div class="row">
                        <input type="hidden" id="idKandang" value="${idKandang}" class="form-control">
                        <div class="col-md-4">
                            <label for="namaKandang">Nama kandang</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="namaKandang" value="namaKandangTes" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="tanggalMulai">Tanggal mulai</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="date" id="tanggalMulai" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="tanggalPanen">Tanggal panen</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="date" id="tanggalPanen" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="jumlahPanen">Jumlah panen</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="jumlahPanen" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="bobotAyam">Bobot Ayam</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="bobotAyam" class="form-control">
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
        $('#modalTitle').html("Mengubah Hasil Panen")
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
                            <label for="tanggalMulai">Tanggal mulai</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="date" id="tanggalMulai" value="2023-12-11" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="tanggaPanen">Tanggal panen</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="date" id="tanggaPanen" value="2023-12-11" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="jumlahPanen">Jumlah panen</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="jumlahPanen" value="20" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="bobotAyam">Bobot Ayam</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="number" id="bobotAyam" value="20" class="form-control">
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

    function showTableData(kandangId) {
        let notifikasiData = ''
        if (kandangId == '1') {
            notifikasiData = [{
                id_kandang: 1,
                date_time: "2023-12-11",
                nama_kandang: "Kandang 1",
                suhu: 20,
                kelembapan: 20,
                amonia: 90,
                rekomendasi_tindakan: "tambah suhu"
            }, {
                id_kandang: 1,
                date_time: "2023-12-11",
                nama_kandang: "Kandang 1",
                suhu: 20,
                kelembapan: 20,
                amonia: 90,
                rekomendasi_tindakan: "tambah suhu"
            }]
        } else if (kandangId == '2') {
            notifikasiData = [{
                id_kandang: 2,
                date_time: "2023-12-11",
                nama_kandang: "Kandang 2",
                suhu: 20,
                kelembapan: 20,
                amonia: 90,
                rekomendasi_tindakan: "tambah suhu"
            }, {
                id_kandang: 2,
                date_time: "2023-12-11",
                nama_kandang: "Kandang 2",
                suhu: 20,
                kelembapan: 20,
                amonia: 90,
                rekomendasi_tindakan: "tambah suhu"
            }]
        }

        let data = ''

        for (let i = 0; i < notifikasiData.length; i++) {
            data += `
            <tr>
            <td>${i+1}</td>
            <td>${notifikasiData[i].date_time}</td>
            <td>${notifikasiData[i].nama_kandang}</td>
            <td>${notifikasiData[i].suhu}</td>
            <td>${notifikasiData[i].kelembapan}</td>
            <td>${notifikasiData[i].amonia}</td>
            <td>${notifikasiData[i].rekomendasi_tindakan}</td>
           
            </tr>
            `
        }

        let table = `
        <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
            <thead>
                <tr>
                    <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                        aria-label="Name: activate to sort column ascending" style="width: 136.047px;">No
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                        aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">DateTime
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                        aria-label="City: activate to sort column ascending" style="width: 239.078px;">Nama Kandang
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                        aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                        Suhu
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                        aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                        Kelembapan
                    </th>
                    <th class="sorting text-center" tabindex="0" aria-controls="table1" rowspan="1"
                                        colspan="1" aria-label="Status: activate to sort column ascending"
                                        style="width: 117.891px;">Amonia
                    </th>
                    <th class="sorting text-center" tabindex="0" aria-controls="table1" rowspan="1"
                                        colspan="1" aria-label="Status: activate to sort column ascending"
                                        style="width: 117.891px;">Rekomendasi tindakan
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
</script>
