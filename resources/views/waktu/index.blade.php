@extends('layout.app')

@section('title', 'Waktu')

@section('content')

    <!-- Modal Tambah Waktu -->
    <div class="modal fade" id="modalTambahWaktu" tabindex="-1" aria-labelledby="modalTambahWaktuLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formTambahWaktu">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahWaktuLabel">Tambah Waktu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <!-- Select Status -->
                        <div class="mb-3">
                            <label for="status_id" class="form-label">Status</label>
                            <div class="input-group">
                                <select name="status_id" id="status_id" class="form-select">
                                    <option value="">-- Pilih Status --</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger error-text status_id_error"></span>
                        </div>

                        <!-- Start Time -->
                        <div class="mb-3">
                            <label for="starttime" class="form-label">Waktu Mulai</label>
                            <input type="time" name="starttime" id="starttime" class="form-control" required>
                            <span class="text-danger error-text starttime_error"></span>
                        </div>

                        <!-- End Time -->
                        <div class="mb-3">
                            <label for="endtime" class="form-label">Waktu Selesai</label>
                            <input type="time" name="endtime" id="endtime" class="form-control" required>
                            <span class="text-danger error-text endtime_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Waktu -->
    <div class="modal fade" id="modalEditWaktu" tabindex="-1" aria-labelledby="modalEditWaktuLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEditWaktu">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditWaktuLabel">Edit Waktu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editWaktuId">

                        <!-- Select Status -->
                        <div class="mb-3">
                            <label for="edit_status_id" class="form-label">Status</label>
                            <select name="status_id" id="edit_status_id" class="form-select">
                                <option value="">-- Pilih Status --</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text status_id_error"></span>
                        </div>

                        <!-- Start Time -->
                        <div class="mb-3">
                            <label for="edit_starttime" class="form-label">Waktu Mulai</label>
                            <input type="time" name="starttime" id="edit_starttime" class="form-control" required>
                            <span class="text-danger error-text starttime_error"></span>
                        </div>

                        <!-- End Time -->
                        <div class="mb-3">
                            <label for="edit_endtime" class="form-label">Waktu Selesai</label>
                            <input type="time" name="endtime" id="edit_endtime" class="form-control" required>
                            <span class="text-danger error-text endtime_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
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
                            <h2>Waktu</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Waktu</a>
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
                            <h6 class="mb-0">List Waktu</h6>
                            <button type="button" class="main-btn primary-btn btn-hover ms-auto" data-bs-toggle="modal"
                                data-bs-target="#modalTambahWaktu">
                                Tambah Waktu
                            </button>
                        </div>
                        <div class="table-wrapper table-responsive">
                            <table class="table" id="waktu-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <h6>No</h6>
                                        </th>
                                        <th>
                                            <h6>Status</h6>
                                        </th>
                                        <th>
                                            <h6>Start Time</h6>
                                        </th>
                                        <th>
                                            <h6>End Time</h6>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            let table = $('#waktu-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('waktu.list') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status.name', 
                        name: 'status.name',
                        defaultContent: '-'
                    },
                    {
                        data: 'starttime',
                        name: 'starttime'
                    },
                    {
                        data: 'endtime',
                        name: 'endtime'
                    },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `
                    <div class="btn-group">
                        <button class="btn btn-sm btn-secondary btn-edit-waktu" data-id="${data}">
                            <span class="mdi mdi-square-edit-outline"></span>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete-waktu" data-id="${data}">
                            <span class="mdi mdi-trash-can"></span>
                        </button>
                    </div>
                `;
                        }
                    }
                ]
            });


            // Tambah Waktu
            $('#formTambahWaktu').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = form.serialize();
                $.ajax({
                    url: "{{ route('waktu.store') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                        $(form).find('button[type="submit"]').prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data waktu berhasil ditambahkan.'
                            }).then(() => {
                                $('#modalTambahWaktu').modal('hide');
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
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: xhr.responseJSON?.message ||
                                    'Terjadi kesalahan saat menyimpan waktu.'
                            });
                        }
                    },
                    complete: function() {
                        $(form).find('button[type="submit"]').prop('disabled', false).html(
                            'Simpan');
                    }
                });
            });


            $(document).on('click', '.btn-edit-waktu', function() {
                let id = $(this).data('id');

                $.get(`/waktu/edit/${id}`, function(res) {
                    $('#editWaktuId').val(res.id);
                    $('#edit_status_id').val(res.status_id);
                    $('#edit_starttime').val(res.starttime);
                    $('#edit_endtime').val(res.endtime);
                    $('#modalEditWaktu').modal('show');
                });
            });

            // Edit Waktu   
            $('#formEditWaktu').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = form.serialize();
                let id = $('#editWaktuId').val();

                $.ajax({
                    url: "{{ url('waktu/update') }}/" + id,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function() {
                        form.find('span.error-text').text('');
                        form.find('button[type="submit"]').prop('disabled', true).html(
                            '<i class="fas fa-spinner fa-spin"></i> Memperbarui...');
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data waktu berhasil diperbarui.'
                            }).then(() => {
                                $('#modalEditWaktu').modal('hide');
                                form[0].reset();
                                table.ajax.reload(null, false);
                            });
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON?.errors;
                        if (errors) {
                            $.each(errors, function(prefix, val) {
                                form.find('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: xhr.responseJSON?.message ||
                                    'Terjadi kesalahan saat memperbarui waktu.'
                            });
                        }
                    },
                    complete: function() {
                        // Ini akan selalu dipanggil, baik success maupun error
                        form.find('button[type="submit"]').prop('disabled', false).html(
                            'Update');
                    }
                });
            });

            //Delete
            $(document).on('click', '.btn-delete-waktu', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus waktu ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/waktu/delete/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: 'Data waktu berhasil dihapus.'
                                    }).then(() => {
                                        table.ajax.reload(null, false);
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops!',
                                    text: xhr.responseJSON?.message ||
                                        'Terjadi kesalahan saat menghapus waktu.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
