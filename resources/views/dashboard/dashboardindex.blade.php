@extends('layout.app')

@section('title', 'Dashboard')

@section('content')

    <style>
        .slideshow-container {
            position: relative;
            width: 100%;
            margin: auto;
            overflow: hidden;
        }

        .slides {
            display: flex;
            width: 100%;
            /* height: 400px; */
            transition: transform 2s ease;
        }

        .slide {
            min-width: 100%;
            height: 100%;
        }

        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.3s;
            border-radius: 0 3px 3px 0;
            user-select: none;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .slide-indicators {
            text-align: center;
            padding: 10px;
        }

        .indicator {
            cursor: pointer;
            height: 12px;
            width: 12px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .active,
        .indicator:hover {
            background-color: #717171;
        }
    </style>
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Dashboard</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#0">Dashboard</a>
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
                <div class="col-6">
                    <div class="icon-card mb-30">
                        <div class="icon success">
                            <i class="lni lni-user"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">Presensi Hari Ini</h6>
                            <h3 class="text-bold mb-10">{{ $totalPresensi }} / {{ $totalUser }} User</h3>
                            {{-- <p class="text-sm text-success">
                                <i class="lni lni-arrow-up"></i> +2.00%
                                <span class="text-gray">(30 days)</span>
                            </p> --}}
                        </div>
                    </div>
                    <!-- End Icon Cart -->
                </div>
                <!-- End Col -->
                <div class="col-6">
                    <div class="icon-card mb-30">
                        <div class="icon orange">
                            <i class="lni lni-user"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">Sakit / Izin Hari Ini</h6>
                            <h3 class="text-bold mb-10">{{ $totalSakitIzin }} / {{ $totalUser }} User</h3>
                            {{-- <p class="text-sm text-success">
                                <i class="lni lni-arrow-up"></i> +5.45%
                                <span class="text-gray">Increased</span>
                            </p> --}}
                        </div>
                    </div>
                    <!-- End Icon Cart -->
                </div>
                <!-- End Col -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="slideshow-container">
                        <div class="slides">
                            <!-- Slide 1 -->
                            <div class="slide">
                                <div class="col-lg-12">
                                    <div class="card-style mb-30">
                                        <div class="title d-flex flex-wrap align-items-center justify-content-between">
                                            <div>
                                                <h4 class="text-medium mb-2">Chart Kehadiran</h4>
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <button id="prevMonth" class="btn btn-light">&lt;</button>
                                                    <h6 id="currentMonth" class="mx-3">July 2025</h6>
                                                    <button id="nextMonth" class="btn btn-light">&gt;</button>
                                                    <select id="monthPicker" class="form-select w-auto ms-3">
                                                        <!-- Isi bulan otomatis -->
                                                    </select>
                                                    <button id="btnCurrentMonth" class="btn ms-3 btn-secondary">Bulan
                                                        Sekarang</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Title -->
                                        <div class="chart">
                                            <canvas id="attendanceChart" height="100"></canvas>
                                        </div>
                                        <!-- End Chart -->
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 2 -->
                            <div class="slide">
                                <div class="col-lg-12">
                                    <div class="card-style mb-30">
                                        <div class="title d-flex flex-wrap align-items-center justify-content-between">
                                            <div class="left">
                                                <h6 class="text-medium mb-30"></h6>
                                            </div>
                                            <div class="right">
                                                <div class="select-style-1">
                                                    <div class="select-position select-sm">
                                                        <select class="light-bg">
                                                            <option value="">Today</option>
                                                            <option value="">Yesterday</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- end select -->
                                            </div>
                                        </div>
                                        <!-- End Title -->
                                        <div class="table-responsive">
                                            <table class="table top-selling-table">
                                                <thead>
                                                    <tr>
                                                        <th>Products</th>
                                                        <th>Nama</th>
                                                        <th>Masuk</th>
                                                        <th>Terlambat</th>
                                                        <th>Izin/Sakit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Isi table -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Tombol navigasi -->
                        <a class="prev" onclick="moveSlide(-1)">&#10094;</a>
                        <a class="next" onclick="moveSlide(1)">&#10095;</a>

                        <!-- Indikator slide -->
                        <div class="slide-indicators">
                            <span class="indicator active" onclick="goToSlide(0)"></span>
                            <span class="indicator" onclick="goToSlide(1)"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end container -->
    </section>
@endsection

@section('script')

    <script>
        let currentIndex = 0;
        let slideInterval;
        let userActivityTimeout;
        const autoSlideDelay = 10000;
        const inactivityDelay = 20000;
        const slides = document.querySelector('.slides');
        const slideItems = document.querySelectorAll('.slide');
        const indicators = document.querySelectorAll('.indicator');
        const totalSlides = slideItems.length;

        // Inisialisasi slideshow
        startAutoSlide();

        // Fungsi untuk menggerakkan slide
        function moveSlide(direction) {
            currentIndex += direction;

            if (currentIndex >= totalSlides) {
                currentIndex = 0;
            } else if (currentIndex < 0) {
                currentIndex = totalSlides - 1;
            }

            updateSlidePosition();
            updateIndicators();
            handleUserActivity();
        }

        // Fungsi untuk pergi ke slide tertentu
        function goToSlide(index) {
            currentIndex = index;
            updateSlidePosition();
            updateIndicators();
            handleUserActivity();
        }

        // Update posisi slide
        function updateSlidePosition() {
            slides.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        // Update indikator aktif
        function updateIndicators() {
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentIndex);
            });
        }

        // Memulai slideshow otomatis
        function startAutoSlide() {
            slideInterval = setInterval(() => {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateSlidePosition();
                updateIndicators();
            }, autoSlideDelay);
        }

        // Stop slideshow otomatis
        function stopAutoSlide() {
            clearInterval(slideInterval);
        }

        // Reset slideshow otomatis setelah 30 detik tidak ada interaksi
        function handleUserActivity() {
            stopAutoSlide(); // Stop auto slide saat ada interaksi

            clearTimeout(userActivityTimeout); // Reset timer inactivity
            userActivityTimeout = setTimeout(() => {
                startAutoSlide(); // Mulai auto slide lagi setelah 30 detik tidak ada interaksi
            }, inactivityDelay);
        }

        // Tambahkan event listener untuk semua interaksi di slideshow
        document.querySelector('.slideshow-container').addEventListener('click', handleUserActivity);
        document.querySelector('.slideshow-container').addEventListener('input', handleUserActivity);
    </script>

    <script>
        let currentMonth = dayjs().format('YYYY-MM'); // Default bulan ini
        let attendanceChart;

        // Isi dropdown bulan
        function populateMonthPicker() {
            const $monthPicker = $('#monthPicker');
            const year = dayjs().year();
            $monthPicker.empty();
            for (let m = 0; m < 12; m++) {
                const monthValue = dayjs().month(m).format('YYYY-MM');
                const monthName = dayjs().month(m).format('MMMM');
                $monthPicker.append(`<option value="${monthValue}">${monthName} ${year}</option>`);
            }
            $monthPicker.val(currentMonth);
        }

        // Load data ke chart
        function loadChartData(month) {
            $.ajax({
                url: '/dashboard/getdataChart',
                type: 'GET',
                data: {
                    month: month
                },
                success: function(response) {
                    const labels = response.chart.map(item => parseInt(item.tanggal.split('-')[
                        2])); // ambil tanggal saja
                    const terlambatData = response.chart.map(item => item.total_terlambat);
                    const sakitIzinData = response.chart.map(item => item.total_sakit_izin);

                    if (attendanceChart) {
                        // Update chart
                        attendanceChart.data.labels = labels;
                        attendanceChart.data.datasets[0].data = terlambatData;
                        attendanceChart.data.datasets[1].data = sakitIzinData;
                        attendanceChart.update();
                    } else {
                        // Buat chart baru
                        const ctx = document.getElementById('attendanceChart').getContext('2d');
                        attendanceChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                        label: 'Terlambat',
                                        data: terlambatData,
                                        backgroundColor: 'rgba(247, 132, 111, 0.8)',
                                        barPercentage: 0.9,
                                        categoryPercentage: 0.8
                                    },
                                    {
                                        label: 'Sakit/Izin',
                                        data: sakitIzinData,
                                        backgroundColor: 'rgba(241, 247, 111, 0.8)',
                                        barPercentage: 0.9,
                                        categoryPercentage: 0.8
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        suggestedMax: 5, // Y axis minimal 5 biar gak gepeng
                                        grace: '10%', // Tambah jarak atas
                                        ticks: {
                                            stepSize: 1,
                                            callback: function(value) {
                                                return Math.round(value); // Bulatkan angka
                                            }
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Tanggal'
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        position: 'top'
                                    },
                                    tooltip: {
                                        enabled: true
                                    }
                                }
                            }
                        });
                    }

                    $('#currentMonth').text(dayjs(month).format('MMMM YYYY'));
                }
            });
        }

        // Navigasi bulan
        $('#prevMonth').on('click', function() {
            currentMonth = dayjs(currentMonth).subtract(1, 'month').format('YYYY-MM');
            $('#monthPicker').val(currentMonth);
            loadChartData(currentMonth);
        });

        $('#nextMonth').on('click', function() {
            currentMonth = dayjs(currentMonth).add(1, 'month').format('YYYY-MM');
            $('#monthPicker').val(currentMonth);
            loadChartData(currentMonth);
        });

        $('#monthPicker').on('change', function() {
            currentMonth = $(this).val();
            loadChartData(currentMonth);
        });

        $('#btnCurrentMonth').on('click', function() {
            currentMonth = dayjs().format('YYYY-MM');
            $('#monthPicker').val(currentMonth);
            loadChartData(currentMonth);
        });

        // Init
        populateMonthPicker();
        loadChartData(currentMonth);
    </script>

@endsection
