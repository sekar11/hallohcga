@extends('include/mainlayout')
@section('title', 'Dashboard')
@section('content')
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
        {{-- <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="assets/img/HalloHCGA.png" alt="Foto 1"></div>
                <div class="swiper-slide"><img src="image2.jpg" alt="Foto 2"></div>
                <div class="swiper-slide"><img src="image3.jpg" alt="Foto 3"></div>
                <div class="swiper-slide"><img src="image4.jpg" alt="Foto 4"></div>
                <div class="swiper-slide"><img src="image5.jpg" alt="Foto 5"></div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div> --}}
        {{-- </div> --}}
        <div class="slider-container">
            <div class="slider-wrapper">
                <img src="assets/img/mess.jpg" class="slide" alt="Foto 1">
                <img src="assets/img/web-1.jpg" class="slide" alt="Foto 2">
                <img src="assets/img/web-2.jpg" class="slide" alt="Foto 3">
                <img src="assets/img/web-3.jpg" class="slide" alt="Foto 4">
                <img src="assets/img/web-4.jpg" class="slide" alt="Foto 5">
                <img src="assets/img/web-5.jpg" class="slide" alt="Foto 6">
            </div>
            {{-- <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
            <button class="next" onclick="moveSlide(1)">&#10095;</button> --}}
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
            <div class="card info-card sales-card">
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
        <div class="col-xxl-4 col-md-3">
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
        </div><!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
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
            <div class="card info-card revenue-card">
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
            <div class="card info-card customers-card">
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
                <div class="card info-card customers-card">
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
            <div class="card info-card cost-card">
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


<script src="https://cdn.jsdelivr.net/npm/chart.js"></>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
// document.addEventListener("DOMContentLoaded", function () {
//     let sliderWrapper = document.querySelector(".slider-wrapper");
//     let slides = document.querySelectorAll(".slide");
//     let currentIndex = 0;

//     function nextSlide() {
//         currentIndex = (currentIndex + 1) % slides.length;
//         sliderWrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
//     }

//     setInterval(nextSlide, 3000);
// });


function moveSlide(direction) {
    currentIndex += direction;

    if (currentIndex < 0) {
        currentIndex = totalSlides - 1;
    } else if (currentIndex >= totalSlides) {
        currentIndex = 0;
    }

    document.querySelector('.slider-wrapper').style.transform = `translateX(-${currentIndex * 100}%)`;
}

document.addEventListener("DOMContentLoaded", function () {
    let slides = document.querySelectorAll(".slide");
    let currentIndex = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? "block" : "none";
        });
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    }

    // Tampilkan slide pertama saat halaman dimuat
    showSlide(currentIndex);

    // Ganti slide setiap 3 detik
    setInterval(nextSlide, 3000);
});


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

</script>

@endsection
