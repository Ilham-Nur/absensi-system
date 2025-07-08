@extends('layout.app')
@section('title', 'User')

@section('content')
    <div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="modalLabel">User</h5>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formUser">
                        @csrf
                        <input type="hidden" id="userId">
                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" placeholder="Masukan Nama" name="name"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Masukan Email" name="email"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Masukan Password"
                                name="password" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                placeholder="Konfirmasi Password" name="password_confirmation" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role_id" required>
                                <option value="" disabled selected>Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="modalEditLabel">Edit User</h5>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditUser">
                        @csrf
                        <input type="hidden" id="editUserId" name="id"> {{-- Add name attribute for form submission --}}
                        <div class="form-group mb-3">
                            <label for="editNama">Nama</label>
                            <input type="text" class="form-control" id="editNama" placeholder="Masukan Nama" name="name"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" placeholder="Masukan Email" name="email"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editRole">Role</label>
                            <select class="form-control" id="editRole" name="role_id" required>
                                <option value="" disabled selected>Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>User</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">User Management</a> {{-- Changed to be more descriptive --}}
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">User</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    </div>
                </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">List User</h6>
                            <button id="btnUser" type="button" class="main-btn primary-btn btn-hover ms-auto"
                                data-bs-toggle="modal" data-bs-target="#modalUser">
                                Tambah User
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="userTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            let table = $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user.list') }}",
                columns: [
                    {
                        data: null,
                        name: 'No',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role.name', // Assuming 'role' is a relationship in your User model
                        name: 'role.name',
                        orderable: false, // Role name might not be directly sortable on the database side
                        searchable: false // If you want to search by role name, you might need custom server-side logic
                    },
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-sm btn-primary btnEditUser" data-id="${row.id}">Edit</button>
                                <button class="btn btn-sm btn-danger btnDeleteUser" data-id="${row.id}">Delete</button>
                                <button class="btn btn-sm btn-secondary btnResetPassword" data-id="${row.id}">Reset Password</button>
                            `;
                        }
                    }
                ]
            });

            $("#btnUser").on("click", function () {
                $("#modalLabel").text("Tambah User");
                $("#formUser")[0].reset();
                $("#userId").val('');
                $('#password').prop('required', true);
                $('#password_confirmation').prop('required', true);
                $("#modalUser").modal("show");
            });

            $("#formUser").on("submit", function (e) {
                e.preventDefault();
                let form = $(this);
                let formData = form.serialize();

                $.ajax({
                    url: "{{ route('user.store') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {

                        form.find('.invalid-feedback').remove();
                        form.find('.form-control').removeClass('is-invalid');

                        form.find('button[type="submit"]').prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin"></i> Saving...');
                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                $('#modalUser').modal('hide');
                                form[0].reset();
                                table.ajax.reload(null, false); 
                            });
                        }
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON?.errors;
                        if (errors) {
                            $.each(errors, function (field, messages) {
                                let input = form.find(`[name="${field}"]`);
                                input.addClass('is-invalid');
                                input.after(`<div class="invalid-feedback">${messages.join(', ')}</div>`);
                            });
                        } else {
                            let msg = xhr.responseJSON?.message || 'An error occurred while saving the user.';
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: msg
                            });
                        }
                    },
                    complete: function () {
                        form.find('button[type="submit"]').prop('disabled', false).html(
                            'Save');
                    }
                });
            });

          
            $(document).on('click', '.btnEditUser', function () {
                let userId = $(this).data('id');
                $("#modalEditLabel").text("Edit User");

                $('#formEditUser').find('.invalid-feedback').remove();
                $('#formEditUser').find('.form-control').removeClass('is-invalid');


                $.ajax({
                    url: `/user/${userId}/edit`, 
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            $('#editUserId').val(response.data.id);
                            $('#editNama').val(response.data.name);
                            $('#editEmail').val(response.data.email);
                            $('#editRole').val(response.data.role_id);

                            $('#modalEditUser').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to fetch user data for editing.'
                            });
                        }
                    },
                    error: function (xhr) {
                        let msg = xhr.responseJSON?.message || 'An error occurred while fetching user data.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: msg
                        });
                    }
                });
            });

            $("#formEditUser").on("submit", function (e) {
                e.preventDefault();
                let form = $(this);
                let userId = $("#editUserId").val();
                let formData = form.serialize();

                $.ajax({
                    url: `/user/update/${userId}`,
                    type: "POST",
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        // Clear previous error messages
                        form.find('.invalid-feedback').remove();
                        form.find('.form-control').removeClass('is-invalid');

                        form.find('button[type="submit"]').prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin"></i> Updating...');
                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                $('#modalEditUser').modal('hide');
                                table.ajax.reload(null, false); // Reload DataTables
                            });
                        }
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON?.errors;
                        if (errors) {
                            $.each(errors, function (field, messages) {
                                let input = form.find(`[name="${field}"]`);
                                input.addClass('is-invalid');
                                input.after(`<div class="invalid-feedback">${messages.join(', ')}</div>`);
                            });
                        } else {
                            let msg = xhr.responseJSON?.message || "An error occurred while updating the user.";
                            Swal.fire({
                                icon: "error",
                                title: "Oops!",
                                text: msg
                            });
                        }
                    },
                    complete: function () {
                        form.find('button[type="submit"]').prop('disabled', false).html(
                            'Save');
                    }
                });
            });

            // Handle delete button click (using event delegation)
            $(document).on('click', '.btnDeleteUser', function () {
                let id = $(this).data("id");

                Swal.fire({
                    title: "Are you sure you want to delete?",
                    text: "Data will be permanently deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, Delete!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/user/delete/${id}`,
                            type: "DELETE", // Use DELETE method for RESTful APIs
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Deleted!",
                                    text: response.message || "User has been deleted successfully.",
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    table.ajax.reload(null, false); // Reload DataTables
                                });
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Failed!",
                                    text: xhr.responseJSON?.message || "An error occurred during deletion."
                                });
                            }
                        });
                    }
                });
            });


            $(document).on('click', '.btnResetPassword', function () {
                let id = $(this).data("id");

                Swal.fire({
                    title: "Are you sure you want to reset the password?",
                    text: "The password will be reset to default!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, Reset!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/user/reset-password/${id}`,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Password Reset!",
                                    text: response.message || "Password has been reset to default.",
                                    showConfirmButton: true,
                                    confirmButtonText: "OK"
                                });
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Failed!",
                                    text: xhr.responseJSON?.message || "An error occurred while resetting the password."
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection