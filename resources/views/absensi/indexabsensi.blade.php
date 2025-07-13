@extends('layout.app')

@section('title', 'Absensi')

@section('content')

    {{-- Modal Tambah Absensi (ID saya sesuaikan agar lebih jelas) --}}
    <div class="modal fade" id="modalTambahAbsensi" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Tambah Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahAbsensi">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Hadir">Hadir</option>
                                <option value="Tidak Hadir">Tidak Hadir</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin</option>
                            </select>
                            <div class="invalid-feedback"></div>
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

    {{-- Modal Edit Absensi --}}
    <div class="modal fade" id="modalEditAbsensi" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditAbsensi">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                             <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                             <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Hadir">Hadir</option>
                                <option value="Tidak Hadir">Tidak Hadir</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin</option>
                            </select>
                             <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Absensi</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Absensi</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-0">Daftar Absensi</h6>
                        {{-- Pastikan data-bs-target sesuai dengan ID modal tambah --}}
                        <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalTambahAbsensi">
                            Tambah Absensi
                        </button>
                    </div>
                    <div class="table-wrapper table-responsive">
                        <table id="absensiTable" class="table responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // Inisialisasi DataTable
        let table = $('#absensiTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('absensi.list') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nama', name: 'nama' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // ===================================================================
        // RESPONSIVE FIX: Paksa tabel untuk menggambar ulang saat layout berubah
        // ===================================================================
        // Ganti '.sidebar-toggle' dengan ID atau CLASS dari tombol sidebar Anda
        // Anda bisa menemukannya dengan klik kanan -> Inspect pada tombol menu/sidebar
        $(document).on('click', '.sidebar-toggle, .menu-toggle', function() {
            // Beri jeda sedikit (misal 300ms) agar animasi sidebar selesai
            setTimeout(function() {
                // Perintah ini akan menyesuaikan ulang lebar kolom dan responsivitas tabel
                table.columns.adjust().responsive.recalc();
            }, 300);
        });


        // ===================================================================
        // TAMBAH: Logika untuk Simpan Data Baru (Ditingkatkan)
        // ===================================================================
        $('#formTambahAbsensi').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();

            $.ajax({
                url: '{{ route('absensi.store') }}',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    form.find('.invalid-feedback').text('');
                    form.find('.form-control, .form-select').removeClass('is-invalid');
                    form.find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
                },
                success: function (response) {
                    $('#modalTambahAbsensi').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Sukses!', response.message || 'Data berhasil disimpan.', 'success');
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function (key, value) {
                            $(`#${key}`).addClass('is-invalid').next('.invalid-feedback').text(value[0]);
                        });
                    } else {
                        Swal.fire('Error!', xhr.responseJSON.message || 'Terjadi kesalahan.', 'error');
                    }
                },
                complete: function() {
                    form.find('button[type="submit"]').prop('disabled', false).html('Simpan');
                }
            });
        });

        // ===================================================================
        // EDIT: Logika untuk Mengambil Data (Ditingkatkan)
        // ===================================================================
        $(document).on('click', '.edit-absensi', function () {
            let id = $(this).data('id');
            $.get("{{ url('absensi') }}/" + id + "/edit", function (response) {
                $('#edit_id').val(response.id);
                $('#edit_nama').val(response.nama);
                $('#edit_tanggal').val(response.tanggal);
                $('#edit_status').val(response.status);
                $('#modalEditAbsensi').modal('show');
            }).fail(function(xhr) {
                Swal.fire('Error!', xhr.responseJSON.message || 'Gagal mengambil data.', 'error');
            });
        });

        // ===================================================================
        // UPDATE: Logika untuk Kirim Perubahan (KODE BARU)
        // ===================================================================
        $('#formEditAbsensi').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let id = $('#edit_id').val();

            $.ajax({
                url: "{{ url('absensi') }}/" + id,
                type: 'POST', // Tetap POST, tapi kita selipkan _method
                data: formData + "&_method=PUT", // Method Spoofing
                beforeSend: function() {
                    form.find('.invalid-feedback').text('');
                    form.find('.form-control, .form-select').removeClass('is-invalid');
                    form.find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
                },
                success: function (response) {
                    $('#modalEditAbsensi').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Sukses!', response.message || 'Data berhasil diperbarui.', 'success');
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function (key, value) {
                            $(`#edit_${key}`).addClass('is-invalid').next('.invalid-feedback').text(value[0]);
                        });
                    } else {
                        Swal.fire('Error!', xhr.responseJSON.message || 'Terjadi kesalahan.', 'error');
                    }
                },
                complete: function() {
                    form.find('button[type="submit"]').prop('disabled', false).html('Update');
                }
            });
        });

        // ===================================================================
        // DELETE: Logika untuk Hapus Data (KODE BARU)
        // ===================================================================
        $(document).on('click', '.delete-absensi', function () {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('absensi') }}/" + id,
                        type: 'POST',
                        data: {
                            _method: 'DELETE'
                        },
                        success: function (response) {
                            table.ajax.reload();
                            Swal.fire('Dihapus!', response.message || 'Data telah dihapus.', 'success');
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', xhr.responseJSON.message || 'Gagal menghapus data.', 'error');
                        }
                    });
                }
            });
        });

    });
</script>
@endsection
