@extends('include/mainlayout')
@section('title', 'Ph Air')
@section('content')
    <div class="pagetitle">
      <h1>Dashboard Ph Air</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard Ph Air</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <!-- Filter Tanggal Mess -->
                <div class="col-md-6 col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h5><strong>Mess</strong></h5>
                        <div class="row">
                            <div class="col-md-4 col-12 mb-2">
                                <label for="tanggalAwal">Tanggal Awal:</label>
                                <input type="date" id="tanggalAwal" class="form-control">
                            </div>
                            <div class="col-md-4 col-12 mb-2">
                                <label for="tanggalAkhir">Tanggal Akhir:</label>
                                <input type="date" id="tanggalAkhir" class="form-control">
                            </div>
                            <div class="col-md-2 col-12 d-flex align-items-end">
                                <button id="buttonFilter" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                        <div class="card p-3 mt-3">
                            <div class="chart-container">
                                <canvas id="phChart" style="width: 100%; height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Tanggal Non-Mess -->
                <div class="col-md-6 col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h5><strong>Non Mess</strong></h5>
                        <div class="row">
                            <div class="col-md-4 col-12 mb-2">
                                <label for="tanggalAwalWeek">Tanggal Awal:</label>
                                <input type="date" id="tanggalAwalWeek" class="form-control">
                            </div>
                            <div class="col-md-4 col-12 mb-2">
                                <label for="tanggalAkhirWeek">Tanggal Akhir:</label>
                                <input type="date" id="tanggalAkhirWeek" class="form-control">
                            </div>
                            <div class="col-md-2 col-12 d-flex align-items-end">
                                <button id="buttonFilterWeek" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                        <div class="card p-3 mt-3">
                            <div class="chart-container">
                                <canvas id="phChartWeek" style="width: 100%; height: 300px;"></canvas>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <!-- Filter Tanggal Mess -->
                <div class="col-md-6 col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h5><strong>Mess</strong></h5>
                        <div class="row">
                            <div class="col-md-4 col-12 mb-2">
                                <label for="tanggalAwalPer">Tanggal Awal:</label>
                                <input type="date" id="tanggalAwalPer" class="form-control">
                            </div>
                            <div class="col-md-4 col-12 mb-2">
                                <label for="tanggalAkhirPer">Tanggal Akhir:</label>
                                <input type="date" id="tanggalAkhirPer" class="form-control">
                            </div>
                            <div class="col-md-2 col-12 mb-2">
                                <label for="lokasi">Lokasi:</label>
                                <select id="lokasi"a class="form-control">
                                    <option value="MESS" selected>Mess</option>
                                    <option value="WT">WT</option>
                                    <option value="WTP">WTP</option>
                                    <option value="STP">STP</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-12 d-flex align-items-end">
                                <button id="buttonFilterPer" class="btn btn-primary w-100">Filter</button>
                            </div>

                        </div>
                        <div class="card p-3 mt-3">
                            <div class="chart-container">
                                <canvas id="phChartPer" style="width: 100%; height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Tanggal Non-Mess -->
                <div class="col-md-6 col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h5><strong>Non Mess</strong></h5>
                        <div class="row">
                            <div class="col-md-4 col-12 mb-2">
                                <label for="tanggalAwalWeekPer">Tanggal Awal:</label>
                                <input type="date" id="tanggalAwalWeekPer" class="form-control">
                            </div>
                            <div class="col-md-4 col-12 mb-2">
                                <label for="tanggalAkhirWeekPer">Tanggal Akhir:</label>
                                <input type="date" id="tanggalAkhirWeekPer" class="form-control">
                            </div>
                            <div class="col-md-2 col-12 mb-2">
                                <label for="lokasiPer">Lokasi:</label>
                                <select id="lokasiPer"a class="form-control">
                                    <option value="PIT_1" selected>PIT 1</option>>
                                    <option value="PIT_2">PIT 2</option>
                                    <option value="PIT_3">PIT 3</option>
                                    <option value="WORKSHOP">Workshop</option>
                                    <option value="WAREHOUSE">Warehouse</option>
                                    <option value="OFFICE_PLANT">Office Plant</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-12 d-flex align-items-end">
                                <button id="buttonFilterWeekPer" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                        <div class="card p-3 mt-3">
                            <div class="chart-container">
                                <canvas id="phChartWeekPer" style="width: 100%; height: 300px;"></canvas>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
<script>
let phChart = null;
let phChartWeek = null;
let phChartPer = null;
let phChartWeekPer = null;

document.addEventListener("DOMContentLoaded", function () {
    const today = new Date();
    const todayFormatted = today.toISOString().split('T')[0];

    const pastDate = new Date();
    pastDate.setDate(today.getDate() - 7);
    const pastDateFormatted = pastDate.toISOString().split('T')[0];

    const pastMonth = new Date();
    pastMonth.setMonth(today.getMonth() - 1);
    const pastMonthFormatted = pastMonth.toISOString().split('T')[0];

    document.getElementById('tanggalAwal').value = todayFormatted;
    document.getElementById('tanggalAkhir').value = todayFormatted;
    document.getElementById('tanggalAwalWeek').value = pastDateFormatted;
    document.getElementById('tanggalAkhirWeek').value = todayFormatted;
    document.getElementById('tanggalAwalPer').value = pastDateFormatted;
    document.getElementById('tanggalAkhirPer').value = todayFormatted;
    document.getElementById('lokasi').value = "MESS";
    document.getElementById('tanggalAwalWeekPer').value = pastDateFormatted;
    document.getElementById('tanggalAkhirWeekPer').value = todayFormatted;
    document.getElementById('lokasiPer').value = "OFFICE_PLANT";
    fetchPhAirData();
    fetchPhAirDataWeek();
    fetchPhAirDataPer();
    fetchPhAirDataWeekPer();
});

document.getElementById('buttonFilter').addEventListener('click', fetchPhAirData);
document.getElementById('buttonFilterWeek').addEventListener('click', fetchPhAirDataWeek);
document.getElementById('buttonFilterPer').addEventListener('click', fetchPhAirDataPer);
document.getElementById('buttonFilterWeekPer').addEventListener('click', fetchPhAirDataWeekPer);

function fetchPhAirData() {
    const tanggalAwal = document.getElementById('tanggalAwal').value;
    const tanggalAkhir = document.getElementById('tanggalAkhir').value;

    if (!tanggalAwal || !tanggalAkhir) {
        alert("Silakan pilih tanggal awal dan tanggal akhir!");
        return;
    }

    fetch('/get-ph-air', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ tanggalAwal, tanggalAkhir })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Data harian dari server:", data);
        updatePhChart(data);
    })
    .catch(error => console.error('Error fetching data:', error));
}

function updatePhChart(data) {
    const ctx = document.getElementById('phChart').getContext('2d');
    const locations = ["MESS", "WT", "WTP", "STP"];

    let tanggalSet = new Set();
    data.forEach(item => tanggalSet.add(item.tanggal));
    tanggalSet = [...tanggalSet];

    const datasets = tanggalSet.map(tanggal => ({
        label: `Tanggal ${tanggal}`,
        data: locations.map(lokasi => data.find(d => d.tanggal === tanggal)?.lokasi[lokasi] ?? null),
        borderColor: getRandomColor(),
        borderWidth: 2,
        fill: false,
        tension: 0
    }));

    if (phChart) phChart.destroy();

    phChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: locations,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: { display: true, text: "Lokasi" },
                    ticks: { display: window.innerWidth > 768 }
                     // Sembunyikan label jika layar kecil
                },
                y: {
                    min: 0, max: 14,
                    title: { display: true, text: "pH Air" }
                }
            },
            plugins: { legend: { display: true } }
        }
    });

    // Perbarui grafik saat layar di-resize
    window.addEventListener("resize", function() {
        phChart.options.scales.x.ticks.display = window.innerWidth > 768;
        phChart.update();
    });
}

function fetchPhAirDataWeek() {
    const tanggalAwalWeek = document.getElementById('tanggalAwalWeek').value;
    const tanggalAkhirWeek = document.getElementById('tanggalAkhirWeek').value;

    if (!tanggalAwalWeek || !tanggalAkhirWeek) {
        alert("Silakan pilih tanggal awal dan tanggal akhir!");
        return;
    }

    fetch('/get-ph-air', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ tanggalAwal: tanggalAwalWeek, tanggalAkhir: tanggalAkhirWeek })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Data mingguan dari server:", data);
        updatePhChartWeek(data);
    })
    .catch(error => console.error('Error fetching data:', error));
}

function updatePhChartWeek(data) {
    const ctx = document.getElementById('phChartWeek').getContext('2d');
    const locations = ["PIT_1", "PIT_2","PIT_3", "WORKSHOP", "WAREHOUSE", "OFFICE_PLANT"];

    let tanggalSet = new Set();
    data.forEach(item => tanggalSet.add(item.tanggal));
    tanggalSet = [...tanggalSet];

    const datasets = tanggalSet.map(tanggal => ({
        label: `Tanggal ${tanggal}`,
        data: locations.map(lokasi => data.find(d => d.tanggal === tanggal)?.lokasi[lokasi] ?? null),
        borderColor: getRandomColor(),
        borderWidth: 2,
        fill: false,
        tension: 0
    }));

    if (phChartWeek) phChartWeek.destroy();

    phChartWeek = new Chart(ctx, {
        type: 'line',
        data: {
            labels: locations,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: { display: true, text: "Lokasi" },
                    ticks: { display: window.innerWidth > 768 } // Sembunyikan label jika layar kecil
                },
                y: {
                    min: 0, max: 14,
                    title: { display: true, text: "pH Air" }
                }
            },
            plugins: { legend: { display: true } }
        }
    });

    // Perbarui grafik saat layar di-resize
    window.addEventListener("resize", function() {
        phChartWeek.options.scales.x.ticks.display = window.innerWidth > 768;
        phChartWeek.update();
    });
}

function fetchPhAirDataPer() {
    const tanggalAwal = document.getElementById('tanggalAwalPer').value;
    const tanggalAkhir = document.getElementById('tanggalAkhirPer').value;
    const lokasi = document.getElementById('lokasi').value;

    if (!tanggalAwal || !tanggalAkhir || !lokasi) {
        alert("Silakan pilih tanggal awal, tanggal akhir, dan lokasi!");
        return;
    }

    fetch('/get-ph-air-per', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ tanggalAwal, tanggalAkhir, lokasi })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Data dari server:", data);
        updatePhChartPer(data);
    })
    .catch(error => console.error('Error fetching data:', error));
}

function updatePhChartPer(response) {
    if (!response.dataHarian || response.dataHarian.length === 0) {
        console.error("Data pH Harian kosong!");
        return;
    }

    const ctx = document.getElementById('phChartPer').getContext('2d');

    const labels = response.dataHarian.map(item => item.tanggal);
    const values = response.dataHarian.map(item => item.pH);
    const avgPh = response.rataRata || 0; // Jika tidak ada, set ke 0

    if (phChartPer) phChartPer.destroy();

    phChartPer = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: `pH Air - ${document.getElementById('lokasi').value}`,
                    data: values,
                    borderColor: 'blue',
                    borderWidth: 2,
                    fill: false,
                    tension: 0
                },
                {
                    label: "Rata-rata pH",
                    data: Array(labels.length).fill(avgPh),
                    borderColor: 'red',
                    borderWidth: 2,
                    borderDash: [5, 5], // Garis putus-putus
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { title: { display: true, text: "Tanggal" } },
                y: {
                    min: 0,
                    max: 14,
                    title: { display: true, text: "pH Air" },
                    ticks: {
                        stepSize: 1 // Menampilkan angka 1,2,3, ... 14 di sumbu Y
                    }
                }
            },
            plugins: { legend: { display: true } }
        }
    });

    window.addEventListener("resize", function () {
        phChartPer.options.scales.x.ticks.display = window.innerWidth > 768;
        phChartPer.update();
    });
}

function fetchPhAirDataWeekPer() {
    const tanggalAwal = document.getElementById('tanggalAwalWeekPer').value;
    const tanggalAkhir = document.getElementById('tanggalAkhirWeekPer').value;
    const lokasi = document.getElementById('lokasiPer').value;

    if (!tanggalAwal || !tanggalAkhir || !lokasi) {
        alert("Silakan pilih tanggal awal, tanggal akhir, dan lokasi!");
        return;
    }

    fetch('/get-ph-air-per', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ tanggalAwal, tanggalAkhir, lokasi })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Data dari server:", data);
        updatePhChartWeekPer(data);
    })
    .catch(error => console.error('Error fetching data:', error));
}

function updatePhChartWeekPer(response) {
    if (!response.dataHarian || response.dataHarian.length === 0) {
        console.error("Data pH Mingguan kosong!");
        return;
    }

    const ctx = document.getElementById('phChartWeekPer').getContext('2d');

    const labels = response.dataHarian.map(item => item.tanggal);
    const values = response.dataHarian.map(item => item.pH);
    const avgPh = response.rataRata || 0; // Jika tidak ada, set ke 0

    if (phChartWeekPer) phChartWeekPer.destroy();

    phChartWeekPer = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: `pH Air - ${document.getElementById('lokasiPer').value}`,
                    data: values,
                    borderColor: 'blue',
                    borderWidth: 2,
                    fill: false,
                    tension: 0
                },
                {
                    label: "Rata-rata pH",
                    data: Array(labels.length).fill(avgPh),
                    borderColor: 'red',
                    borderWidth: 2,
                    borderDash: [5, 5], // Garis putus-putus
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { title: { display: true, text: "Tanggal" } },
                y: { min: 0, max: 14, title: { display: true, text: "pH Air" } }
            },
            plugins: { legend: { display: true } }
        }
    });

    window.addEventListener("resize", function () {
        phChartWeekPer.options.scales.x.ticks.display = window.innerWidth > 768;
        phChartWeekPer.update();
    });
}

function getRandomColor() {
    return `hsl(${Math.random() * 360}, 100%, 50%)`;
}

</script>

@endsection
