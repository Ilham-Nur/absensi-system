@extends('layout.app')
@section('title', 'User')

@section('content')
    <!-- Modal -->
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

    <section class="login-section pt-50 pb-50">
        <div class="container">
            <div class="page-title">
                <h3>User</h3>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <button id="btnUser" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalUser">Tambah User</button>
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
                                                    <button class="btn btn-sm btn-primary">Edit</button>
                                                    <button class="btn btn-sm btn-danger">Delete</button>
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

        // Simpan Data (Tambah/Edit)
        $("#formUser").submit(function (e) {
            e.preventDefault();

            let id = $("#userId").val();
            let name = $("#nama").val(); // Ambil value dari input nama
            let email = $("#email").val();
            let role = $("#role").val(); // Ambil value dari dropdown
            let password = $("#password").val(); // Ambil value dari input password
            let password_confirmation = $("#password_confirmation").val(); // Ambil value dari input konfirmasi password

            let url = id ? `/user/update/${id}` : "/user/store";
            let type = id ? "PUT" : "POST";

            $.ajax({
                url: url,
                type: type,
                data: {
                    id: id,
                    name: name, // Kirim sebagai "name"
                    email: email,
                    role_id: role, // Kirim role sebagai ID
                    password: password, // Kirim password
                    password_confirmation: password_confirmation, // Kirim konfirmasi password
                    _token: "{{ csrf_token() }}"
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
                        // Ambil pesan error dari response
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
                        url: `/user/destroy/${id}`,
                        type: "DELETE",
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
    </script>
@endsection