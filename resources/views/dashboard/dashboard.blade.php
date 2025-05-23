@extends('include/mainlayout')
@section('title', 'Dashboard')
@section('content')
    <div class="pagetitle">
      <h1>Dashboard Handling</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
        <div class="slider-container">
            <div class="slider-wrapper">
                <img src="assets/img/messbaru.png" class="slide" alt="Foto 1">
                <img src="assets/img/2.png" class="slide" alt="Foto 2">
                <img src="assets/img/3.png" class="slide" alt="Foto 3">
                <img src="assets/img/4.png" class="slide" alt="Foto 4">
                <img src="assets/img/5.png" class="slide" alt="Foto 5">

                <!-- Untuk layar kecil -->
                {{-- <img src="assets/img/sertif1.jpg" class="slide mobilee" alt="Foto HP 1">
                <img src="assets/img/mess.jpg" class="slide mobilee" alt="Foto HP 2">
                <img src="assets/img/web-5.jpg" class="slide mobilee" alt="Foto HP 3"> --}}
            </div>
            <button class="slider-button prev">&#10094;</button>
            <button class="slider-button next">&#10095;</button>
        </div>

        <br>
    <div class="row">
        <!-- Filter Tanggal dan Status -->
        <div class="col-12 mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="tanggalAwal">Tanggal Awal:</label>
                    <input type="date" id="tanggalAwal" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="tanggalAkhir">Tanggal Akhir:</label>
                    <input type="date" id="tanggalAkhir" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button id="buttonFilter" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </div>

    <!-- Left side columns -->
    <div class="col-lg-12">
        <div class="row">

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card" onclick="redirectToTotalComplain()">
            <div class="card-body">
                <h5 class="card-title">Jumlah Complain</h5>
                <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                    <h6 id="totalCount">Loading...</h6>
                </div>
            </div>
            </div>
            </div>
        </div><!-- End Sales Card -->

        <!-- Sales Card -->
        <!-- <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">On-Progress</h5>
                <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                    <h6 id="progresCount">Loading...</h6>
                </div>
            </div>
            </div>
            </div>
        </div>End Sales Card -->

        <div class="col-xxl-4 col-md-3">
            <div class="card info-card saless-card" onclick="redirectToComplain()">
                <div class="card-body">
                    <h5 class="card-title">On-Progress</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="progresCount">Loading...</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card" onclick="redirectToDoneComplain()">
            <div class="card-body">
                <h5 class="card-title">Done</h5>
                <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                    <h6 id="doneCount">Loading...</h6>
                </div>
            </div>
            </div>

            </div>
        </div><!-- End Sales Card -->

        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card revenue-card" onclick="redirectToPrioritasComplain()">
            <div class="card-body">
                <h5 class="card-title">Complain Prioritas</h5>
                <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                    <h6 id="prioritasCount">Loading...</h6>
                </div>
            </div>
            </div>
            </div>
        </div><!-- End Revenue Card -->

        <!-- Customers Card -->
        <div class="col-xxl-4 col-xl-3">
            <div class="card info-card customers-card" onclick="redirectToMayorComplain()">
            <div class="card-body">
                <h5 class="card-title">Complain Mayor</h5>
                <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                    <h6 id="mayorCount">Loading...</h6>
                </div>
            </div>
            </div>
            </div>
        </div><!-- End Customers Card -->
            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-3">
                <div class="card info-card customers-card" onclick="redirectToMinorComplain()">
                <div class="card-body">
                    <h5 class="card-title">Complain Minor</h5>
                    <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="minorCount">Loading...</h6>
                    </div>
                </div>
                </div>
                </div>
            </div><!-- End Customers Card -->

        <!-- Customers Card -->
        <div class="col-xxl-4 col-xl-3">
            <div class="card info-card cost-card" onclick="redirectToPendingComplain()">
            <div class="card-body">
                <h5 class="card-title">Complain Pending</h5>
                <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                    <h6 id="pendingCount">Loading...</h6> <!-- Menampilkan nilai 10 setelah mendapatkan data -->
                </div>
            </div>
            </div>
            </div>
        </div><!-- End Customers Card -->
    </div>
    </div>
    </section>

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <label for="categoryStartDate">Tanggal Awal:</label>
                        <input type="date" id="categoryStartDate" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="categoryEndDate">Tanggal Akhir:</label>
                        <input type="date" id="categoryEndDate" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label for="statusarea">Status:</label>
                        <select id="statusarea"a class="form-control">
                            <option value="">Semua</option>
                            <option value="done">Done</option>
                            <option value="on_progress">On Progress</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button id="filterCategoryButton" class="btn btn-primary w-100">Filter</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Area -->
            <div class="col-md-6 d-flex align-items-center">
                <div class="chart-container">
                    <h5 class="text-center">Jumlah per Area</h5>
                    <canvas id="areaPieChart" class="small-pie-chart"></canvas>
                </div>
                <div id="areaLabels" class="ms-3"></div>
            </div>

            <!-- Kategori -->
            <div class="col-md-6 d-flex align-items-center">
                <div class="chart-container">
                    <h5 class="text-center">Jumlah per Kategori</h5>
                    <canvas id="categoryPieChart" class="small-pie-chart"></canvas>
                </div>
                <div id="categoryLabels" class="ms-3"></div>
            </div>
        </div>

    </section>

    <br>

    <section class="section dashboard">
    <div class="row">
        <!-- Filter Tanggal dan Status -->
        <div class="col-12 mb-4">
            <div class="row">
                <div class="col-md-2">
                    <label for="startDate">Tanggal Awal:</label>
                    <input type="date" id="startDate" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="endDate">Tanggal Akhir:</label>
                    <input type="date" id="endDate" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="area_add">Area:</label>
                    <select class="form-control" id="area_add" name="area_add">
                        <option value="">Pilih Area</option>
                        <option value="Mess">MESS</option>
                        <option value="Office">Office</option>
                        <option value="CSA 1">CSA 1</option>
                        <option value="CSA 2">CSA 2</option>
                        <option value="CSA 3">CSA 3</option>
                        <option value="CSA FUEL">CSA FUEL</option>
                        <option value="PITSTOP">PITSTOP</option>
                        <option value="OTHER">Lainnya</option>
                    </select>
                </div>

                    <div class="col-md-3">
                        <label for="status">Status:</label>
                        <select id="status" class="form-control">
                            <option value="">Semua</option>
                            <option value="done">Done</option>
                            <option value="on_progress">On Progress</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button id="filterButton" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </div>

            <!-- Grafik Batang -->
            <div class="col-12">
                <canvas id="buildingBarChart"></canvas>
            </div>
        </div>
    </section>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script>

function redirectToComplain() {
    window.location.href = "/complain?status=on-progress";
}

function redirectToDoneComplain() {
    window.location.href = "/complain?status=done";
}

function redirectToMayorComplain() {
    window.location.href = "/complain?status=mayor";
}

function redirectToMinorComplain() {
    window.location.href = "/complain?status=minor";
}

function redirectToPendingComplain() {
    window.location.href = "/complain?status=pending";
}

function redirectToTotalComplain() {
    window.location.href = "/complain?status=total";
}

function redirectToPrioritasComplain() {
    window.location.href = "/complain?status=prioritas";
}

let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

const showSlide = (index) => {
    if (index >= totalSlides) {
        currentSlide = 0;
    } else if (index < 0) {
        currentSlide = totalSlides - 1;
    } else {
        currentSlide = index;
    }
    const sliderWrapper = document.querySelector('.slider-wrapper');
    sliderWrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
    updateNavigationVisibility();
};

// Tombol navigasi
prevButton.addEventListener('click', () => showSlide(currentSlide - 1));
nextButton.addEventListener('click', () => showSlide(currentSlide + 1));

// Memastikan tombol navigasi hanya tampil jika gambar ada yang ditampilkan
const updateNavigationVisibility = () => {
    const isMobile = window.innerWidth <= 768;
    const mobileImages = document.querySelectorAll('.mobilee');
    const desktopImages = document.querySelectorAll('.desktop');
    const isAnyMobileVisible = Array.from(mobileImages).some(img => img.style.display !== 'none');
    const isAnyDesktopVisible = Array.from(desktopImages).some(img => img.style.display !== 'none');

    if ((isMobile && isAnyMobileVisible) || (!isMobile && isAnyDesktopVisible)) {
        prevButton.style.display = 'block';
        nextButton.style.display = 'block';
    } else {
        prevButton.style.display = 'none';
        nextButton.style.display = 'none';
    }
};

// Menampilkan gambar pertama
showSlide(currentSlide);

// Auto-slide (5 detik)
setInterval(() => {
    showSlide(currentSlide + 1);
}, 5000);

// Memanggil fungsi untuk memeriksa visibilitas tombol saat pertama kali load dan saat resize
window.addEventListener('resize', updateNavigationVisibility);
updateNavigationVisibility();



const ctx = document.getElementById('buildingBarChart').getContext('2d');
let buildingChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: 'Total Complain',
            data: [],
            backgroundColor: [],
            borderColor: [],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                enabled: true,
                callbacks: {
                    label: function (tooltipItem) {
                        const gedung = tooltipItem.label;
                        const dataIndex = tooltipItem.dataIndex;
                        const categories = buildingChart.data.datasets[0].categories[dataIndex];
                        const total = tooltipItem.raw;
                        const area = buildingChart.data.datasets[0].areas[dataIndex];
                        let tooltipText = [];
                        tooltipText.push(`Area: ${area}`);
                        tooltipText.push(`Total Complain: ${total}`);
                        tooltipText.push(`Detail Kategori:`);
                        categories.forEach(cat => {
                            tooltipText.push(`- ${cat.kategori}: ${cat.jumlah}`);
                        });
                        return tooltipText;
                    }
                }
            }
        },
        scales: {
            x: {
                title: { display: true, text: 'Gedung' },
                stacked: false
            },
            y: {
                title: { display: true, text: 'Jumlah Complain' },
                beginAtZero: true
            }
        }
    }
});

function processChartData(rawData) {
    const labels = [...new Set(rawData.map(item => {
        return (typeof item.gedung === 'string') ? item.gedung : String(item.gedung);
    }))];

    const gedungData = labels.map(gedung => {
        const categories = rawData.filter(item => item.gedung === gedung);
        const totalComplain = categories.reduce((sum, cat) => sum + cat.jumlah, 0);
        const areas = [...new Set(categories.map(item => item.area))];
        return { gedung, totalComplain, categories, areas };
    });

    const datasetData = gedungData.map(data => data.totalComplain);
    const backgroundColor = gedungData.map(data => getUniqueColor(data.gedung));
    const categories = gedungData.map(data => data.categories);
    const areas = gedungData.map(data => data.areas.join(', '));

    return { labels, datasetData, backgroundColor, categories, areas };
}

function getUniqueColor(label) {
    if (typeof label !== 'string') {
        console.warn('Label is not a valid string:', label);
        label = String(label);
    }

    const hash = [...label].reduce((acc, char) => acc + char.charCodeAt(0), 0);
    const r = (hash * 37) % 255;
    const g = (hash * 53) % 255;
    const b = (hash * 71) % 255;
    return `rgba(${r}, ${g}, ${b}, 0.7)`;
}
function updateChart(rawData) {
    const { labels, datasetData, backgroundColor, categories, areas } = processChartData(rawData);

    buildingChart.data.labels = labels;
    buildingChart.data.datasets[0].data = datasetData;
    buildingChart.data.datasets[0].backgroundColor = backgroundColor;
    buildingChart.data.datasets[0].categories = categories;
    buildingChart.data.datasets[0].areas = areas;
    buildingChart.update();
}

window.onload = async function() {
    const today = new Date();
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    const formattedStartDate = firstDayOfMonth.toISOString().split('T')[0];
    const formattedEndDate = today.toISOString().split('T')[0];

    await getFilteredData(formattedStartDate, formattedEndDate);
    await getFilteredDataForCategoryAndArea(formattedStartDate, formattedEndDate);
}

async function getFilteredData(startDate, endDate) {
    const status = document.getElementById('status').value;
    const area = document.getElementById('area_add').value;

    let url = '/api/complains';
    const queryParams = [];

    if (startDate) queryParams.push(`start_date=${startDate}`);
    if (endDate) queryParams.push(`end_date=${endDate}`);
    if (status) queryParams.push(`status=${status}`);
    if (area) queryParams.push(`area=${area}`);

    if (queryParams.length > 0) {
        url += '?' + queryParams.join('&');
    }

    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error('Gagal mengambil data dari server.');

        const result = await response.json();
        updateChart(result);
    } catch (error) {
        console.error('Gagal mengambil data:', error);
        alert('Terjadi kesalahan saat mengambil data. Silakan coba lagi.');
    }
}

function updateChart(rawData) {
    const { labels, datasetData, backgroundColor, categories, areas } = processChartData(rawData);

    buildingChart.data.labels = labels;
    buildingChart.data.datasets[0].data = datasetData;
    buildingChart.data.datasets[0].backgroundColor = backgroundColor;
    buildingChart.data.datasets[0].categories = categories;
    buildingChart.data.datasets[0].areas = areas;
    buildingChart.update();
}

document.getElementById('filterButton').addEventListener('click', async () => {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const status = document.getElementById('status').value;
    const area = document.getElementById('area_add').value;

    let url = '/api/complains';
    const queryParams = [];

    if (startDate) queryParams.push(`start_date=${startDate}`);
    if (endDate) queryParams.push(`end_date=${endDate}`);
    if (status) queryParams.push(`status=${status}`);
    if (area) queryParams.push(`area=${area}`);

    if (queryParams.length > 0) {
        url += '?' + queryParams.join('&');
    }

    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error('Gagal mengambil data dari server.');

        const result = await response.json();
        updateChart(result);
    } catch (error) {
        console.error('Gagal mengambil data:', error);
        alert('Terjadi kesalahan saat mengambil data. Silakan coba lagi.');
    }
});

const ctxCategory = document.getElementById('categoryPieChart').getContext('2d');
const ctxArea = document.getElementById('areaPieChart').getContext('2d');

let categoryChart = new Chart(ctxCategory, {
    type: 'pie',
    data: {
        labels: [],
        datasets: [{
            label: 'Jumlah per Kategori',
            data: [],
            backgroundColor: [],
            borderColor: [],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: true },
            tooltip: {
                callbacks: {
                    label: function (tooltipItem) {
                        const label = tooltipItem.label || '';
                        const value = tooltipItem.raw || 0;
                        return `${label}: ${value}`;
                    }
                }
            }
        },

        aspectRatio: 1,
    }
});

let areaChart = new Chart(ctxArea, {
    type: 'pie',
    data: {
        labels: [],
        datasets: [{
            label: 'Jumlah per Area',
            data: [],
            backgroundColor: [],
            borderColor: [],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: true },
            tooltip: {
                callbacks: {
                    label: function (tooltipItem) {
                        const label = tooltipItem.label || '';
                        const value = tooltipItem.raw || 0;
                        return `${label}: ${value}`;
                    }
                }
            }
        },
        aspectRatio: 1,
    }
});

function updatePieCharts(rawData) {

    const categoryData = rawData.reduce((acc, item) => {
        acc[item.kategori] = (acc[item.kategori] || 0) + item.jumlah;
        return acc;
    }, {});

    const categoryLabels = Object.keys(categoryData);
    const categoryValues = Object.values(categoryData);
    const categoryColors = categoryLabels.map(label => getUniqueColor(label));

    categoryChart.data.labels = categoryLabels;
    categoryChart.data.datasets[0].data = categoryValues;
    categoryChart.data.datasets[0].backgroundColor = categoryColors;
    categoryChart.update();

    const categoryLabelsContainer = document.getElementById('categoryLabels');
    categoryLabelsContainer.innerHTML = '';
    categoryLabels.forEach((label, index) => {
        const labelDiv = document.createElement('div');
        labelDiv.textContent = `${label}: ${categoryValues[index]} Complaints`;
        categoryLabelsContainer.appendChild(labelDiv);
    });

    const areaData = rawData.reduce((acc, item) => {
        acc[item.area] = (acc[item.area] || 0) + item.jumlah;
        return acc;
    }, {});

    const areaLabels = Object.keys(areaData);
    const areaValues = Object.values(areaData);
    const areaColors = areaLabels.map(label => getUniqueColor(label));

    areaChart.data.labels = areaLabels;
    areaChart.data.datasets[0].data = areaValues;
    areaChart.data.datasets[0].backgroundColor = areaColors;
    areaChart.update();

    const areaLabelsContainer = document.getElementById('areaLabels');
    areaLabelsContainer.innerHTML = '';
    areaLabels.forEach((label, index) => {
        const labelDiv = document.createElement('div');
        labelDiv.textContent = `${label}: ${areaValues[index]} Complaints`;
        areaLabelsContainer.appendChild(labelDiv);
    });
}

async function getFilteredDataForCategoryAndArea(startDate, endDate) {
    const statusarea = document.getElementById('statusarea').value;

    try {
        const response = await fetch(`/api/complainsarea?start_date=${startDate}&end_date=${endDate}&statusarea=${statusarea}`);
        if (!response.ok) throw new Error('Gagal mengambil data.');

        const result = await response.json();
        updatePieCharts(result);
    } catch (error) {
        console.error('Gagal mengambil data:', error);
        alert('Terjadi kesalahan saat mengambil data.');
    }
}

document.getElementById('filterCategoryButton').addEventListener('click', async () => {
    const startDate = document.getElementById('categoryStartDate').value;
    const endDate = document.getElementById('categoryEndDate').value;
    const statusarea = document.getElementById('statusarea').value;

    try {
        const response = await fetch(`/api/complainsarea?start_date=${startDate}&end_date=${endDate}&statusarea=${statusarea}`);
        if (!response.ok) throw new Error('Gagal mengambil data.');

        const result = await response.json();
        updatePieCharts(result);
    } catch (error) {
        console.error('Gagal mengambil data:', error);
        alert('Terjadi kesalahan saat mengambil data.');
    }
});

function getUniqueColor(label) {
    const hash = [...label].reduce((acc, char) => acc + char.charCodeAt(0), 0);
    const r = (hash * 37) % 255;
    const g = (hash * 53) % 255;
    const b = (hash * 71) % 255;
    return `rgba(${r}, ${g}, ${b}, 0.7)`;
}

$.ajax({
        type: 'GET',
        url: '/complain/mayor-count',
        success: function(response) {
            $('#mayorCount').text(response.mayor_count);
        },
        error: function(error) {
            $('#mayorCount').text('Error');
        }
    });

    $.ajax({
        type: 'GET',
        url: '/complain/minor-count',
        success: function(response) {
            $('#minorCount').text(response.minor_count);
        },
        error: function(error) {
            $('#minorCount').text('Error');
        }
    });

    $.ajax({
        type: 'GET',
        url: '/complain/prioritas-count',
        success: function(response) {
            $('#prioritasCount').text(response.prioritas_count);
        },
        error: function(error) {
            $('#prioritasCount').text('Error');
        }
    });

    $.ajax({
        type: 'GET',
        url: '/complain/pending-count',
        success: function(response) {
            $('#pendingCount').text(response.pending_count);
        },
        error: function(error) {
            $('#pendingCount').text('Error');
        }
    });

    $.ajax({
        type: 'GET',
        url: '/complain/total-count',
        success: function(response) {
            $('#totalCount').text(response.total_count);
        },
        error: function(error) {
            $('#totalCount').text('Error');
        }
    });

    $.ajax({
        type: 'GET',
        url: '/complain/progres-count',
        success: function(response) {
            $('#progresCount').text(response.progres_count);
        },
        error: function(error) {
            $('#progresCount').text('Error');
        }
    });

    $.ajax({
        type: 'GET',
        url: '/complain/done-count',
        success: function(response) {
            $('#doneCount').text(response.done_count);
        },
        error: function(error) {
            $('#doneCount').text('Error');
        }
    });

    document.getElementById('buttonFilter').addEventListener('click', function () {
    const tanggalAwal = document.getElementById('tanggalAwal').value;
    const tanggalAkhir = document.getElementById('tanggalAkhir').value;

    if (!tanggalAwal || !tanggalAkhir) {
        alert('Silakan pilih tanggal awal dan akhir!');
        return;
    }

    const url = "/filter-complain";
    const params = { tanggal_awal: tanggalAwal, tanggal_akhir: tanggalAkhir };

    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(params),
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('totalCount').textContent = data.total_count || 0;
        document.getElementById('progresCount').textContent = data.progres_count || 0;
        document.getElementById('doneCount').textContent = data.done_count || 0;
        document.getElementById('prioritasCount').textContent = data.prioritas_count || 0;
        document.getElementById('mayorCount').textContent = data.mayor_count || 0;
        document.getElementById('minorCount').textContent = data.minor_count || 0;
        document.getElementById('pendingCount').textContent = data.pending_count || 0;
    })
    .catch(error => console.error('Error:', error));
});

// document.addEventListener('DOMContentLoaded', function() {
//     document.querySelector('.info-card.saless-card').addEventListener('click', function() {
//         window.location.href = "/complain?status=on-progress";
//     });
// });



</script>

@endsection
