<x-app-layout>
    <style>
        /* Hide spinner arrows */
        input[type="tel"]::-webkit-outer-spin-button,
        input[type="tel"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="tel"] {
            /* Ensure the input is wide enough to fit phone numbers without clipping */
            width: auto;
            -moz-appearance: textfield;
            /* Firefox */
        }
    </style>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="color: #cb8e8e">User List</h3>
                <p class="text-subtitle text-muted">User list page</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">User List</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="card">
            <div class="card-header text-center">
                <div class="card-title">User List</div>

            </div>

            <div class="card-body table-responsive  p-4 rounded">
                <div class="text-start mb-4" id="addButton">
                    <a title="tambah" class="btn btn-success btn-sm block" data-bs-toggle="modal"
                        data-bs-target="#default" onclick="addModal()"><i class="fa fa-plus"></i> </a>
                </div>
                <div id="tableData">
                    <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                        <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Name: activate to sort column ascending" style="width: 136.047px;">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Role
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending" style="width: 239.078px;">
                                    Username
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                    Email
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                    Action
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($data as $user)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $user->roles->nama_role }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td style="min-width: 180px">
                                        <a title="mengubah" class="btn btn-outline-primary btn-sm me-1"
                                            data-bs-toggle="modal" data-bs-target="#default"
                                            onclick="editModal('{{ $user->id }}')"><i class="fa fa-edit"></i> </a>
                                        <a title="hapus" class="btn btn-outline-danger btn-sm me-1"
                                            data-bs-toggle="modal" data-bs-target="#default"
                                            onclick="deleteModal('{{ $user->id }}')"><i class="fa fa-trash"></i></a>
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
    function showTable() {
        $.ajax({
            type: "GET",
            url: `/users`,
            async: false,
            success: function(response) {
                let userData = response.data

                let data = ''
                for (let i = 0; i < userData.length; i++) {
                    let {
                        id,
                        roles,
                        name,
                        email
                    } = userData[i]

                    data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${roles.nama_role}</td>
                    <td>${name}</td>
                    <td>${email}</td>
                    <td style="min-width: 180px">
                        <a title="mengubah" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#default" onclick="editModal('${id}')"><i class="fa fa-edit"></i> </a>
                        <a title="hapus" class="btn btn-outline-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#default" onclick="deleteModal('${id}')"><i class="fa fa-trash"></i></a>
                    </td>
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
                                                aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Role
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="City: activate to sort column ascending" style="width: 239.078px;">Username 
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Email
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                aria-label="Status: activate to sort column ascending" style="width: 117.891px;">
                                                Action
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

    function reset() {

    }

    function addModal() {
        $.ajax({
            type: "GET",
            url: `/roles`,
            success: function(response) {
                let roles = response.data
                let roleData = ''

                roles.forEach(role => {
                    roleData +=
                        `<option value="${role.id_role}">${role.nama_role}</option>`
                });

                $('#modalTitle').html("Add User ")
                $('#modalBody').html(`
        <form class="form form-horizontal">
                <div class="form-body"> 
                    <div class="row">
                        <div class="col-md-4">
                            <label for="role">Role</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <select class="form-select" id="role">
                            ${roleData}
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="name">Username <span class="text-danger"> *</span></label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="name" class="form-control" placeholder="username" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="email">Email<span class="text-danger"> *</span></label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="email" class="form-control" placeholder="email">
                        </div>
                        <div class="col-md-4">
                            <label for="phoneNumber">Phone Number<span class="text-danger"> *</span></label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text"  id="phoneNumber" class="form-control" placeholder="Phone number">
                        </div>
                        <div class="col-md-4">
                            <label for="idTelegram">Telegram ID <br><span class="text-primary text-sm">(Optional)</span></label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="idTelegram" class="form-control" placeholder="Telegram ID">
                        </div>
                       
                        <div class="col-md-4">
                            <label for="password">Password<span class="text-danger"> *</span></label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="password" id="password" class="form-control" placeholder="password" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="konfirmasiPassword">Confirmation Password<span class="text-danger"> *</span></label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="password" id="konfirmasiPassword" class="form-control" placeholder="Confirmation password" autocomplete="off">
                        </div>
                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-jet-label for="terms">
                                <div class="flex items-center">
                                    <x-jet-checkbox name="terms" id="terms" />

                                    <div class="ml-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' =>
                                                '<a target="_blank" href="' .
                                                route('terms.show') .
                                                '" class="underline text-sm text-gray-600 hover:text-gray-900">' .
                                                __('Terms of Service') .
                                                '</a>',
                                            'privacy_policy' =>
                                                '<a target="_blank" href="' .
                                                route('policy.show') .
                                                '" class="underline text-sm text-gray-600 hover:text-gray-900">' .
                                                __('Privacy Policy') .
                                                '</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-jet-label>
                        </div>
                    @endif
                    </div>
                </div>
            </form>
        `)

                document.getElementById('phoneNumber').addEventListener('input', function(event) {
                    // Remove any non-numeric characters
                    this.value = this.value.replace(/[^0-9]/g, '');
                });

                $('#modalFooter').html(`<a class="btn btn-success btn-sm" onclick="save()">Submit</a>`)
            },
            error: function(err) {
                console.log(err.responseText)
            }
        })

    }



    function editModal(id) {
        $.ajax({
            type: "GET",
            url: `/user/${id}`,
            success: function(response) {

                let {
                    id_role,
                    roles,
                    name,
                    email,
                    id_telegram,
                    phone_number
                } = response.data


                let allRole = getRoles()

                let roleData = ""
                // Roles data
                allRole.forEach(r => {

                    roleData +=
                        `<option ${id_role == r.id_role ? 'selected' : ''} value="${r.id_role }">${r.nama_role}</option>`
                });

                $('#modalTitle').html("Edit User")
                $('#modalBody').html(`
        <form class="form form-horizontal">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="role">Role</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <select class="form-select" id="role">
                            ${roleData}
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="name">Username<span class="text-danger"> *</span></label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="name" value="${name}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="email">Email<span class="text-danger"> *</span></label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="email" value="${email}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="phoneNumber">Phone Number<span class="text-danger"> *</span></label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="phoneNumber" value="${phone_number != null ? phone_number : ''}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="idTelegram">Telegram ID <sup class="text-primary">(Optional)</sup></label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="idTelegram" value="${id_telegram == null? '' : id_telegram}" class="form-control">
                        </div>
                      
                    </div>
                </div>
            </form>
        `)

                // Prevent text di input phone number
                document.getElementById('phoneNumber').addEventListener('input', function(event) {
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
        $('#modalTitle').html("Delete User")
        $('#modalBody').html(`Are you sure to delete this user`)
        $('#modalFooter').html(`<a class="btn btn-danger btn-sm" onclick="deleteItem('${id}')">Delete</a>`)
    }

    function getRoles() {
        let item
        $.ajax({
            type: "GET",
            url: `/roles`,
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
    function save() {
        let idRole = $('#role').val()
        let name = $('#name').val()
        let email = $('#email').val()
        let idTelegram = $('#idTelegram').val()
        let phoneNumber = $('#phoneNumber').val()
        let password = $('#password').val()
        let konfirmasiPassword = $('#konfirmasiPassword').val()

        // validasi nama
        if (!name) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Username cannot be empty",
                showConfirmButton: false,
                timer: 1500
            })
        }
        // validasi email
        if (!email.match(
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            )) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Email is not valid",
                showConfirmButton: false,
                timer: 1500
            })
        }

        // validasi nomor telfon
        if (!phoneNumber) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Phone number cannot be empty",
                showConfirmButton: false,
                timer: 1500
            })
        }
        // validasi nomor telfon kurang dari 10 digit
        if (phoneNumber.length < 11) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Phone number cannot less than 10 digits",
                showConfirmButton: false,
                timer: 1500
            })
        }

        // validasi password tidak boleh kosong
        if (!password || !konfirmasiPassword) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Password or password confirmation cannot be empty",
                showConfirmButton: false,
                timer: 1500
            })
        }
        // validasi
        if (konfirmasiPassword != password) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "You password confirmation is not same as your password",
                showConfirmButton: false,
                timer: 1500
            })
        }

        let data = {
            id_role: idRole,
            name: name,
            email: email,
            id_telegram: idTelegram,
            phone_number: phoneNumber,
            password: password,
        }

        $.ajax({
            type: "POST",
            url: `/user`,
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify(data),
            success: function(response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "User added",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    $('#default').modal('hide')
                    showTable()
                })
            },
            error: function(err) {
                console.log(err.responseText)
            }

        })

    }

    function update(id) {
        let idRole = $('#role').val()
        let name = $('#name').val()
        let email = $('#email').val()
        let idTelegram = $('#idTelegram').val()
        let phoneNumber = $('#phoneNumber').val()
        // validasi nama
        if (!name) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Name cannot be empty",
                showConfirmButton: false,
                timer: 1500
            })
        }
        // validasi email
        if (!email.match(
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            )) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Your email is not valid",
                showConfirmButton: false,
                timer: 1500
            })
        }

        // validasi nomor telfon
        if (!phoneNumber) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Phone number cannot be empty",
                showConfirmButton: false,
                timer: 1500
            })
        }
        // validasi nomor telfon kurang dari 10 digit
        if (phoneNumber.length < 11) {
            return Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Your phone number is less than 10 digits",
                showConfirmButton: false,
                timer: 1500
            })
        }

        let data = {
            id_role: idRole,
            name: name,
            email: email,
            id_telegram: idTelegram,
            phone_number: phoneNumber
        }

        $.ajax({
            type: "PUT",
            url: `/user/${id}`,
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
                    showTable()
                })

            },
            error: function(err) {
                console.log(err.responseText)
            }
        })
    }

    function deleteItem(id) {
        $.ajax({
            type: "DELETE",
            url: `/user/${id}`,
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
                    showTable()
                })
            },
            error: function(err) {
                console.log(err.responseText)
            }

        })
    }
</script>
