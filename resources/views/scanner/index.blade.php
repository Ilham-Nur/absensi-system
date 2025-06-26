<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Scanner - Gatra Perdana Trustrue</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- QR Code Scanner -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <style>
        body,
        html {
            height: 100%;
        }

        .scanner-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .scanner-container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .illustration-container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-right: 40px;
            width: auto;

        }

        .illustration-container img {
            max-height: 500px;
            width: 100%;

            max-width: 100%;

            height: auto;

            border-radius: 12px;
            object-fit: contain;

        }

        .scanner-content {
            flex: 1;
            padding-left: 40px;
            border-left: 1px solid #eee;
        }

        .scanner-header h3 {
            font-weight: 600;
        }

        #reader {
            border-radius: 12px;
            overflow: hidden;
            margin-top: 20px;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
        }

        @media (max-width: 992px) {
            .scanner-container {
                flex-direction: column;
            }

            .illustration-container {
                padding-right: 0;
                padding-bottom: 30px;
            }

            .scanner-content {
                padding-left: 0;
                border-left: none;
                border-top: 1px solid #eee;
                padding-top: 30px;
            }
        }
    </style>
</head>

<body>
    <div class="scanner-wrapper">
        <div class="scanner-container">
            <!-- Bagian ilustrasi di sebelah kiri -->
            <div class="illustration-container">
                <img src="{{ asset('images/ilustrasi_scaner.jpg') }}" alt="Scanner Illustration" class="img-fluid">
            </div>

            <!-- Bagian konten scanner di sebelah kanan -->
            <div class="scanner-content text-center">
                <!-- Judul -->
                <div class="scanner-header mb-4">
                    <h3><i class="bi bi-qr-code-scan"></i> QR / Barcode Scanner</h3>
                    <p class="text-muted small">Klik tombol di bawah untuk mulai memindai kode.</p>
                </div>

                <!-- Hasil scan -->
                <div class="mb-3 text-start">
                    <label for="scan_result" class="form-label">Hasil Scan</label>
                    <input type="text" class="form-control" id="scan_result" placeholder="Menunggu hasil scan...">
                </div>

                <!-- Tombol kontrol -->
                <div class="btn-group mb-3 w-100">
                    <button id="startScanBtn" class="btn btn-success w-50 me-2">
                        <i class="bi bi-camera-video"></i> Mulai Scan
                    </button>
                    <button id="stopScanBtn" class="btn btn-danger w-50" disabled>
                        <i class="bi bi-x-circle"></i> Tutup Kamera
                    </button>
                </div>

                <!-- Kamera -->
                <div id="reader" style="width: 100%; height: auto; display: none;"></div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const startScanBtn = document.getElementById('startScanBtn');
        const stopScanBtn = document.getElementById('stopScanBtn');
        const readerDiv = document.getElementById('reader');
        const resultInput = document.getElementById('scan_result');

        let html5QrCode;
        let scannerStarted = false;

        startScanBtn.addEventListener('click', function() {
            if (scannerStarted) {
                Swal.fire({
                    icon: 'info',
                    title: 'Kamera sudah aktif',
                    text: 'Scanner sedang berjalan.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            html5QrCode = new Html5Qrcode("reader");
            readerDiv.style.display = 'block';

            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                (decodedText, decodedResult) => {
                    resultInput.value = decodedText;

                    // Kirim ke backend via AJAX
                    fetch("{{ route('scanner.scan') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                result: decodedText
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.fire({
                                icon: data.status === 'success' ? 'success' : 'error',
                                title: data.message,
                                timer: 3000,
                                showConfirmButton: false
                            });

                            if (data.status === 'success') {
                                resultInput.value = ''; // Kosongkan input hanya jika sukses
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan',
                                text: 'Gagal mengirim data.',
                            });
                        });

                    // Matikan kamera
                    html5QrCode.stop().then(() => {
                        scannerStarted = false;
                        readerDiv.style.display = 'none';
                        stopScanBtn.disabled = true;
                    });
                },
                (errorMessage) => {
                    // error saat scan (tidak ditampilkan)
                }
            ).then(() => {
                scannerStarted = true;
                stopScanBtn.disabled = false;
            }).catch((err) => {
                readerDiv.style.display = 'none';
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal membuka kamera',
                    text: err
                });
            });
        });

        stopScanBtn.addEventListener('click', function() {
            if (scannerStarted && html5QrCode) {
                html5QrCode.stop().then(() => {
                    scannerStarted = false;
                    readerDiv.style.display = 'none';
                    stopScanBtn.disabled = true;

                    Swal.fire({
                        icon: 'info',
                        title: 'Kamera dimatikan',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }).catch((err) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal menutup kamera',
                        text: err
                    });
                });
            }
        });
    </script>

</body>

</html>
