@extends('layout.app')
@section('title', 'User')

@section('content')
    <!-- Modal Tambah -->
    <div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="modalLabel">User</h5>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formUser">
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
                            <select class="form-control" id="role" name="role" required>
                                <option value="" disabled selected>Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="modalEditLabel">Edit User</h5>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditUser">
                        <input type="hidden" id="editUserId">
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
                            <select class="form-control" id="editRole" name="role" required>
                                <option value="" disabled selected>Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="editPassword">Password (Opsional)</label>
                            <input type="password" class="form-control" id="editPassword" placeholder="Masukan Password"
                                name="password">
                        </div>

                        <div class="form-group mb-3">
                            <label for="editPasswordConfirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="editPasswordConfirmation"
                                placeholder="Konfirmasi Password" name="password_confirmation">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>User</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">php
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Role</a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">List User</h6>
                            <button type="button" class="main-btn primary-btn btn-hover ms-auto"
                                style="width: 20px; height: 20px;" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalUser">
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
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->role->name }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary btnEditUser"
                                                        data-id="{{ $user->id }}">Edit</button>
                                                    <button class="btn btn-sm btn-danger btnDeleteUser"
                                                        data-id="{{ $user->id }}">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
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
        // Konfigurasi DataTable
        $(document).ready(function () {
            $('#userTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

        // Tampilkan Modal Tambah
        $("#btnUser").click(function () {
            $("#modalLabel").text("Tambah User");
            $("#formUser")[0].reset();
            $("#userId").val("");
            $("#modalUser").modal("show");
        });

        // Simpan Data (Tambah)
        $("#formUser").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();

            $.ajax({
                url: "{{ route('user.store') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                beforeSend: function () {
                    $(form).find('span.error-text').text('');
                    $(form).find('button[type="submit"]').prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin"></i> Mengupdate...');
                },

                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: id ? "Berhasil Diperbarui!" : "Berhasil Ditambahkan!",
                        text: "Data user berhasil disimpan.",
                        showConfirmButton: true,
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    let errorMessage = "Terjadi kesalahan.";
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors)
                            .map((error) => error.join(", "))
                            .join("\n");
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Gagal!",
                        text: errorMessage,
                        showConfirmButton: true,
                        confirmButtonText: "OK"
                    });
                },
                complete: function () {
                    $submitBtn.prop("disabled", false);
                }
            });
        });

        // Hapus Data dengan SweetAlert2
        $(".btnDeleteUser").click(function () {
            let id = $(this).data("id");

            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/user/delete/`,
                        type: "GET",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil Dihapus!",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                text: xhr.responseJSON?.message || "Terjadi kesalahan."
                            });
                        }
                    });
                }
            });
        });
        
        // Tampilkan Modal Edit
        $(".btnEditUser").click(function () {
            let id = $(this).data("id");

            $.ajax({
                url: `/user/edit/${id}`,
                type: "GET",
                success: function (response) {
                    $("#editUserId").val(response.id);
                    $("#editNama").val(response.name);
                    $("#editEmail").val(response.email);
                    $("#editRole").val(response.role_id);
                    $("#editPassword").val("");
                    $("#editPasswordConfirmation").val("");

                    $("#modalEditUser").modal("show");
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal!",
                        text: xhr.responseJSON?.message || "Terjadi kesalahan."
                    });
                }
            });
        });

        // Simpan Perubahan
        $("#formEditUser").submit(function (e) {
            e.preventDefault();

            let id = $("#editUserId").val();
            let name = $("#editNama").val();
            let email = $("#editEmail").val();
            let role = $("#editRole").val();
            let password = $("#editPassword").val();
            let password_confirmation = $("#editPasswordConfirmation").val();

            $.ajax({
                url: `/user/update/${id}`,
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    role_id: role,
                    password: password,
                    password_confirmation: password_confirmation,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil Diperbarui!",
                        text: "Data user berhasil diperbarui.",
                        showConfirmButton: true,
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    let errorMessage = "Terjadi kesalahan.";
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors)
                            .map((error) => error.join(", "))
                            .join("\n");
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Gagal!",
                        text: errorMessage,
                        showConfirmButton: true,
                        confirmButtonText: "OK"
                    });
                }
            });
        });


        // Tampilkan Modal Delete
        $(".btnDeleteUser").click(function () {
            let id = $(this).data("id");
            $("#deleteUserId").val(id);
            $("#modalDeleteUser").modal("show");
        });

        // Konfirmasi Hapus
        $("#confirmDeleteUser").click(function () {
            let id = $("#deleteUserId").val();

            $.ajax({
                url: `/user/delete/${id}`,
                type: "GET",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil Dihapus!",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal!",
                        text: xhr.responseJSON?.message || "Terjadi kesalahan."
                    });
                }
            });
        });

    </script>
@endsection