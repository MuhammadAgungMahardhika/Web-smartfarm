function runDataTable(id) {
    let jquery_datatable = $(`${id}`).DataTable({
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
