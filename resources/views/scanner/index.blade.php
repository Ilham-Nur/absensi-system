<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Scan QR Code</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- HTML5 QR Code (untuk baca QR Code) -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
</head>

<style>
    /* Scale Video jadi kotak 1:1 */
    #reader video {
        object-fit: cover !important;
        width: 100% !important;
        height: 100% !important;
        aspect-ratio: 1 / 1 !important;
    }
</style>


<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-3xl bg-white shadow-xl rounded-xl p-6 sm:p-8 space-y-6">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800">🔍 QR / Barcode Scanner</h1>
            <p class="text-gray-500 text-sm mt-1">Arahkan kamera ke kode untuk mulai memindai.</p>
        </div>

        <!-- Placeholder untk Scanner (Kamera) -->
        <div class="relative w-full max-w-xs mx-auto aspect-square bg-black rounded-lg overflow-hidden">
            <!-- Reader (kamera) -->
            <div id="reader" class="absolute inset-0 z-0"></div>

            <!-- Scanner Frame (sudut-sudut) -->
            <div class="absolute inset-0 pointer-events-none z-10">
                <!-- Top Left -->
                <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-indigo-500 rounded-tl-lg"></div>
                <!-- Top Right -->
                <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-indigo-500 rounded-tr-lg"></div>
                <!-- Bottom Left -->
                <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-indigo-500 rounded-bl-lg">
                </div>
                <!-- Bottom Right -->
                <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-indigo-500 rounded-br-lg">
                </div>
            </div>

            <!-- Arahan -->
            <div class="absolute bottom-3 w-full text-center text-white text-sm font-medium pointer-events-none z-10">
                Arahkan kamera ke QR / Barcode
            </div>
        </div>

        <!-- Hasil -->
        <div>
            <label for="scan_result" class="block text-sm font-medium text-gray-700 mb-1">Hasil Scan</label>
            <input type="text" id="scan_result"
                class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 text-sm" readonly
                placeholder="Menunggu hasil..." />
        </div>

        <!-- Dua Tombol di bawah -->
        <div class="flex flex-col sm:flex-row gap-3">
            <button id="startScanBtn"
                class="w-full sm:w-1/2 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md font-semibold">
                📷 Mulai Scan
            </button>
            <button id="stopScanBtn"
                class="w-full sm:w-1/2 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md font-semibold"
                disabled>
                ✖️ Stop Scan
            </button>
        </div>
    </div>

    <!-- Script JS (Jangan di otak-atik kata Ilham) -->
    <script>
        const startScanBtn = document.getElementById('startScanBtn');
        const stopScanBtn = document.getElementById('stopScanBtn');
        const readerDiv = document.getElementById('reader');
        const resultInput = document.getElementById('scan_result');

        let html5QrCode;
        let scannerStarted = false;

        startScanBtn.addEventListener('click', () => {
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

                        Swal.fire({
                            title: 'Memproses...',
                            html: 'Mohon tunggu sebentar.',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });

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
                            .then(async response => {
                                const data = await response.json();
                                Swal.close();
                                if (response.ok) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: data.message || 'Presensi berhasil',
                                        timer: 3000,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Presensi gagal',
                                        text: data.message || 'Terjadi kesalahan saat presensi.',
                                        timer: 3000,
                                        showConfirmButton: false
                                    });
                                }
                                resultInput.value = '';
                            })
                            .catch(error => {
                                Swal.close();
                                console.error(error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal mengirim data',
                                    text: 'Terjadi kesalahan.',
                                });
                                resultInput.value = '';
                            });

                        html5QrCode.stop().then(() => {
                            scannerStarted = false;
                            stopScanBtn.disabled = true;
                        });
                    },
                    (errorMessage) => {
                        // skip
                    }
                ).then(() => {
                    scannerStarted = true;
                    stopScanBtn.disabled = false;
                    readerDiv.classList.remove('hidden'); // ✅ tampilkan reader
                })
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal membuka kamera',
                        text: err
                    });
                });
        });

        stopScanBtn.addEventListener('click', () => {
            if (scannerStarted && html5QrCode) {
                html5QrCode.stop().then(() => {
                    scannerStarted = false;
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
