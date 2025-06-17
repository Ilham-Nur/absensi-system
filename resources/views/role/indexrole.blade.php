@extends('layout.app')

@section('title', 'Role')

@section('content')


    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahRoleModal" tabindex="-1" aria-labelledby="tambahRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tambahRoleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahRole">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaRole" class="form-label">Nama Role</label>
                            <input type="text" name="name" id="namaRole" class="form-control" required>
                            <span class="text-danger error-text name_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit-->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editRoleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditRole">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="id" id="editRoleId" hidden>
                        <div class="mb-3">
                            <label for="editNamaRole" class="form-label">Nama Role</label>
                            <input type="text" name="name" id="editNamaRole" class="form-control" required>
                            <span class="text-danger error-text name_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
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
                            <h2>Role</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
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
            <!-- ========== title-wrapper end ========== -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="mb-0">List Role</h6>
                            <button type="button" class="main-btn primary-btn btn-hover ms-auto"
                                style="width: 20px; height: 20px;" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#tambahRoleModal">
                                Tambah Role
                            </button>
                        </div>

                        <div class="table-wrapper table-responsive">
                            <table class="table" id="role-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <h6>No</h6>
                                        </th>
                                        <th>
                                            <h6>Name</h6>
                                        </th>
                                        <th>
                                            <h6>Action</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- DataTables akan mengisi sendiri -->
                                </tbody>
                            </table>

                            <!-- end table -->
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
        </div>
        <!-- end container -->
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            let table = $('#role-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('roles.list') }}",
                columns: [{
                        data: null,
                        name: 'index',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-secondary btn-edit-role" data-id="${data}" data-name="${row.name}">
                                    <span class="mdi mdi-square-edit-outline"></span>
                                </button>
                                <button class="btn btn-sm btn-danger btn-delete-role" data-id="${data}">
                                    <span class="mdi mdi-trash-can"></span>
                                </button>
                            </div>
                        `;
                        }
                    }
                ]
            });

            // Handle Tambah Role
            $('#formTambahRole').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = form.serialize();

                $.ajax({
                    url: "{{ route('roles.store') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                        $(form).find('button[type="submit"]').prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                $('#tambahRoleModal').modal('hide');
                                form[0].reset();
                                table.ajax.reload(null, false);
                            });
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON?.errors;
                        if (errors) {
                            $.each(errors, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            let msg = xhr.responseJSON?.message ||
                                'Terjadi kesalahan saat menyimpan role.';
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: msg
                            });
                        }
                    },
                    complete: function() {
                        $(form).find('button[type="submit"]').prop('disabled', false).html(
                            'Simpan');
                    }
                });
            });

            // Handle Edit Role
            $(document).on('click', '.btn-edit-role', function() {
                let roleId = $(this).data('id');
                let roleName = $(this).data('name');

                $('#editRoleId').val(roleId);
                $('#editNamaRole').val(roleName);
                $('#editRoleModal').modal('show');
            });

            $('#formEditRole').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let roleId = $('#editRoleId').val();
                let formData = form.serialize();

                $.ajax({
                    url: "/role/update/" + roleId,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                        $(form).find('button[type="submit"]').prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin"></i> Mengupdate...');
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                $('#editRoleModal').modal('hide');
                                table.ajax.reload(null, false);
                            });
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON?.errors;
                        if (errors) {
                            $.each(errors, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            let msg = xhr.responseJSON?.message ||
                                'Terjadi kesalahan saat mengupdate role.';
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: msg
                            });
                        }
                    },
                    complete: function() {
                        $(form).find('button[type="submit"]').prop('disabled', false).html(
                            'Update');
                    }
                });
            });

            // Handle Delete Role
            $(document).on('click', '.btn-delete-role', function() {
                let roleId = $(this).data('id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Role yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/role/delete/" + roleId,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: response.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        table.ajax.reload(null, false);
                                    });
                                }
                            },
                            error: function(xhr) {
                                let msg = xhr.responseJSON?.message ||
                                    'Terjadi kesalahan saat menghapus role.';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops!',
                                    text: msg
                                });
                            }
                        });
                    }
                });
            });

            // Reset form saat modal ditutup
            $('#tambahRoleModal').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $(this).find('span.error-text').text('');
            });

            $('#editRoleModal').on('hidden.bs.modal', function() {
                $(this).find('span.error-text').text('');
            });
        });
    </script>
@endsection
