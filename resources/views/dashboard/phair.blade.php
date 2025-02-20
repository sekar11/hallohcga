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
        <div class="card p-3">
            <canvas id="phChart"></canvas>
        </div>
        </div>
        

    </section>

    <script>
    let phChart = null; // Variabel untuk menyimpan chart

document.getElementById('buttonFilter').addEventListener('click', function() {
    const tanggalAwal = document.getElementById('tanggalAwal').value;
    const tanggalAkhir = document.getElementById('tanggalAkhir').value;

    if (!tanggalAwal || !tanggalAkhir) {
        alert("Silakan pilih tanggal awal dan tanggal akhir!");
        return;
    }

    // Fetch data dari server
    fetch('/get-ph-air', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Pastikan token CSRF ada
        },
        body: JSON.stringify({ tanggalAwal, tanggalAkhir })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Data dari server:", data); // Debugging, pastikan data sudah benar
        updatePhChart(data);
    })
    .catch(error => console.error('Error fetching data:', error));
});

function updatePhChart(data) {
    const ctx = document.getElementById('phChart').getContext('2d');

    // Ambil semua lokasi unik sebagai labels (sumbu X)
    const labels = data.map(item => item.lokasi);

    // Ambil semua tanggal unik dari seluruh data
    let tanggalSet = new Set();
    data.forEach(item => item.data.forEach(entry => tanggalSet.add(entry.tanggal)));
    tanggalSet = [...tanggalSet]; // Konversi ke array

    // Buat dataset berdasarkan tanggal
    const datasets = tanggalSet.map(tanggal => ({
        label: `Tanggal ${tanggal}`,
        data: data.map(item => {
            const found = item.data.find(entry => entry.tanggal === tanggal);
            return found ? found.ph : null; // Isi null jika tidak ada data
        }),
        borderColor: getRandomColor(),
        borderWidth: 2,
        fill: false,
        tension: 0.4
    }));

    if (phChart) {
        phChart.destroy(); // Hapus chart lama sebelum membuat yang baru
    }

    phChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels, // Sumbu X adalah lokasi
            datasets: datasets
        },
        options: {
            responsive: true,
            scales: {
                x: { 
                    type: 'category',
                    title: { display: true, text: "Lokasi" }
                },
                y: { 
                    beginAtZero: false,
                    title: { display: true, text: "pH Air" }
                }
            },
            plugins: {
                legend: { display: true }
            }
        }
    });
}

function getRandomColor() {
    return `hsl(${Math.random() * 360}, 100%, 50%)`; // Warna random untuk setiap garis
}
</script>





@endsection
