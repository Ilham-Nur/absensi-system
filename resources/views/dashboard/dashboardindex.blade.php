@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
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
            <!-- End Row -->
            <div class="row">

                <!-- End Col -->
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
                                    <button id="btnCurrentMonth" class="btn ms-3 btn-secondary">Bulan Sekarang</button>
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
                <!-- End Col -->
            </div>
            <!-- End Row -->
            <div class="row">

                <!-- End Col -->
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="title d-flex flex-wrap align-items-center justify-content-between">
                            <div class="left">
                                <h6 class="text-medium mb-30">Sales History</h6>
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
                                        <th>
                                            <h6 class="text-sm text-medium">Products</h6>
                                        </th>
                                        <th class="min-width">
                                            <h6 class="text-sm text-medium">
                                                Category <i class="lni lni-arrows-vertical"></i>
                                            </h6>
                                        </th>
                                        <th class="min-width">
                                            <h6 class="text-sm text-medium">
                                                Revenue <i class="lni lni-arrows-vertical"></i>
                                            </h6>
                                        </th>
                                        <th class="min-width">
                                            <h6 class="text-sm text-medium">
                                                Status <i class="lni lni-arrows-vertical"></i>
                                            </h6>
                                        </th>
                                        <th>
                                            <h6 class="text-sm text-medium text-end">
                                                Actions <i class="lni lni-arrows-vertical"></i>
                                            </h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="product">
                                                <div class="image">
                                                    <img src="assets/images/products/product-mini-1.jpg" alt="" />
                                                </div>
                                                <p class="text-sm">Bedroom</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm">Interior</p>
                                        </td>
                                        <td>
                                            <p class="text-sm">$345</p>
                                        </td>
                                        <td>
                                            <span class="status-btn close-btn">Pending</span>
                                        </td>
                                        <td>
                                            <div class="action justify-content-end">
                                                <button class="edit">
                                                    <i class="lni lni-pencil"></i>
                                                </button>
                                                <button class="more-btn ml-10 dropdown-toggle" id="moreAction1"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="lni lni-more-alt"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction1">
                                                    <li class="dropdown-item">
                                                        <a href="#0" class="text-gray">Remove</a>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <a href="#0" class="text-gray">Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product">
                                                <div class="image">
                                                    <img src="assets/images/products/product-mini-2.jpg" alt="" />
                                                </div>
                                                <p class="text-sm">Arm Chair</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm">Interior</p>
                                        </td>
                                        <td>
                                            <p class="text-sm">$345</p>
                                        </td>
                                        <td>
                                            <span class="status-btn warning-btn">Refund</span>
                                        </td>
                                        <td>
                                            <div class="action justify-content-end">
                                                <button class="edit">
                                                    <i class="lni lni-pencil"></i>
                                                </button>
                                                <button class="more-btn ml-10 dropdown-toggle" id="moreAction1"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="lni lni-more-alt"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction1">
                                                    <li class="dropdown-item">
                                                        <a href="#0" class="text-gray">Remove</a>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <a href="#0" class="text-gray">Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product">
                                                <div class="image">
                                                    <img src="assets/images/products/product-mini-3.jpg" alt="" />
                                                </div>
                                                <p class="text-sm">Sofa</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm">Interior</p>
                                        </td>
                                        <td>
                                            <p class="text-sm">$345</p>
                                        </td>
                                        <td>
                                            <span class="status-btn success-btn">Completed</span>
                                        </td>
                                        <td>
                                            <div class="action justify-content-end">
                                                <button class="edit">
                                                    <i class="lni lni-pencil"></i>
                                                </button>
                                                <button class="more-btn ml-10 dropdown-toggle" id="moreAction1"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="lni lni-more-alt"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction1">
                                                    <li class="dropdown-item">
                                                        <a href="#0" class="text-gray">Remove</a>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <a href="#0" class="text-gray">Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="product">
                                                <div class="image">
                                                    <img src="assets/images/products/product-mini-4.jpg" alt="" />
                                                </div>
                                                <p class="text-sm">Kitchen</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm">Interior</p>
                                        </td>
                                        <td>
                                            <p class="text-sm">$345</p>
                                        </td>
                                        <td>
                                            <span class="status-btn close-btn">Canceled</span>
                                        </td>
                                        <td>
                                            <div class="action justify-content-end">
                                                <button class="edit">
                                                    <i class="lni lni-pencil"></i>
                                                </button>
                                                <button class="more-btn ml-10 dropdown-toggle" id="moreAction1"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="lni lni-more-alt"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction1">
                                                    <li class="dropdown-item">
                                                        <a href="#0" class="text-gray">Remove</a>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <a href="#0" class="text-gray">Edit</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>
@endsection

@section('script')
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
