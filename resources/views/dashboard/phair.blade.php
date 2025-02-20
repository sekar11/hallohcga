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
    <div class="container">
    <div class="row g-10 justify-content-between">
            <!-- Filter Tanggal -->
            <div class="col-6 mb-4">
                
                <div class="row bg-white p-4 rounded shadow-sm">
                <h5><strong>Mess</strong></h5>
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
                    <div class="w-100 mb-4"></div> 
                    <div class="card p-3">
                        <canvas id="phChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-6 mb-4">
                <div class="row bg-white p-4 rounded shadow-sm">
                <h5><strong>Non Mess</strong></h5>
                    <div class="col-md-4">
                        <label for="tanggalAwalWeek">Tanggal Awal:</label>
                        <input type="date" id="tanggalAwalWeek" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="tanggalAkhirWeek">Tanggal Akhir:</label>
                        <input type="date" id="tanggalAkhirWeek" class="form-control">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button id="buttonFilterWeek" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="w-100 mb-4"></div> 
                    <div class="card p-3">
                        <canvas id="phChartWeek"></canvas>
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

document.addEventListener("DOMContentLoaded", function () {
    const today = new Date();
    const todayFormatted = today.toISOString().split('T')[0]; 

    const pastDate = new Date();
    pastDate.setDate(today.getDate() - 7);
    const pastDateFormatted = pastDate.toISOString().split('T')[0];

    document.getElementById('tanggalAwal').value = todayFormatted;
    document.getElementById('tanggalAkhir').value = todayFormatted;
    document.getElementById('tanggalAwalWeek').value = pastDateFormatted; 
    document.getElementById('tanggalAkhirWeek').value = todayFormatted;
    fetchPhAirData();  
    fetchPhAirDataWeek();  
});


document.getElementById('buttonFilter').addEventListener('click', fetchPhAirData);
document.getElementById('buttonFilterWeek').addEventListener('click', fetchPhAirDataWeek);

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
            scales: {
                x: { title: { display: true, text: "Lokasi" }},
                y: { min: 0, max: 14, title: { display: true, text: "pH Air" }}
            },
            plugins: { legend: { display: true } }
        }
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
            scales: {
                x: { title: { display: true, text: "Lokasi" }},
                y: { min: 0, max: 14, title: { display: true, text: "pH Air" }}
            },
            plugins: { legend: { display: true } }
        }
    });
}

function getRandomColor() {
    return `hsl(${Math.random() * 360}, 100%, 50%)`;
}


</script>





@endsection
