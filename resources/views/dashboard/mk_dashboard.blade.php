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
                <div class="col-md-12 col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h5><strong>Daily Order Departemen</strong></h5>
                        <div class="row">
                            <div class="col-md-3 col-12 mb-2">
                                <label for="departemen">Departemen:</label>
                                    <select id="departemen"a class="form-control">1</select>
                            </div>
                            <div class="col-md-3 col-12 mb-2">
                                <label for="tanggalAwal">Tanggal Awal:</label>
                                <input type="date" id="tanggalAwal" class="form-control">
                            </div>
                            <div class="col-md-3 col-12 mb-2">
                                <label for="tanggalAkhir">Tanggal Akhir:</label>
                                <input type="date" id="tanggalAkhir" class="form-control">
                            </div>
                            <div class="col-md-2 col-12 d-flex align-items-end">
                                <button id="buttonFilter" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                        <div class="card p-3 mt-3">
                            <div class="chart-container">
                                <div id="totalSummary">
                                    <p id="totalActual"></p>
                                    <p id="totalPlan"></p>
                                    <p id="totalTambahan"></p>
                                    <p id="totalCost"></p>
                                </div>
                                <canvas id="dailyDeptChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h5><strong>Monthly Order Departemen</strong></h5>
                        <div class="row">
                            <div class="col-md-3 col-12 mb-2">
                                <label for="departemenMonthly">Departemen:</label>
                                    <select id="departemenMonthly" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 mb-2">
                                <label for="bulanAwal">Bulan Awal:</label>
                                <select id="bulanAwal" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 mb-2">
                                <label for="bulanAkhir">Bulan Akhir:</label>
                                <select id="bulanAkhir" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 mb-2">
                                <label for="tahun">Tahun:</label>
                                <select id="tahun" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 d-flex align-items-end">
                                <button id="buttonFilterMonthlyDept" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                        <div class="card p-3 mt-3">
                            <div class="chart-container">
                                <canvas id="dailyMothlyDeptChart" width="400" height="200"></canvas>
                                {{-- <div id="totalSummary">
                                    <p id="totalActualMess"><strong>Actual Order:</strong> -</p>
                                    <p id="totalPlanMess"><strong>Plan Order:</strong> -</p>
                                    <p id="totalTambahanMess"><strong>Tambahan:</strong> -</p>
                                    <p id="totalCostMess"></p>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h5><strong>Monthly Order All Departemen</strong></h5>
                        <div class="row">
                            <div class="col-md-2 col-12 mb-2">
                                <label for="bulan">Bulan:</label>
                                <select id="bulanDept" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 mb-2">
                                <label for="tahunAllDept">Tahun:</label>
                                <select id="tahunAllDept" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 d-flex align-items-end">
                                <button id="buttonFilterMonthlyAllDept" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                        <div class="card p-3 mt-3">
                            <div class="chart-container">
                                <canvas id="dailyMothlyAllDeptChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h5><strong>Daily Order Mess</strong></h5>
                        <div class="row">
                            <div class="col-md-3 col-12 mb-2">
                                <label for="mess">Mess:</label>
                                    <select id="mess" class="form-control"></select>
                            </div>
                            <div class="col-md-3 col-12 mb-2">
                                <label for="tanggalAwalMess">Tanggal Awal:</label>
                                <input type="date" id="tanggalAwalMess" class="form-control">
                            </div>
                            <div class="col-md-3 col-12 mb-2">
                                <label for="tanggalAkhirMess">Tanggal Akhir:</label>
                                <input type="date" id="tanggalAkhirMess" class="form-control">
                            </div>
                            <div class="col-md-2 col-12 d-flex align-items-end">
                                <button id="buttonFilterMess" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                        <div class="card p-3 mt-3">
                            <div class="chart-container">
                                <canvas id="dailyMessChart" width="400" height="200"></canvas>
                                <div id="totalSummary">
                                    <p id="totalActualMess"><strong>Actual Order:</strong> -</p>
                                    <p id="totalPlanMess"><strong>Plan Order:</strong> -</p>
                                    <p id="totalTambahanMess"><strong>Tambahan:</strong> -</p>
                                    <p id="totalCostMess"></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h5><strong>Monthly Order Mess</strong></h5>
                        <div class="row">
                            <div class="col-md-3 col-12 mb-2">
                                <label for="messMonthly">Mess:</label>
                                    <select id="messMonthly" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 mb-2">
                                <label for="bulanAwalMess">Bulan Awal:</label>
                                <select id="bulanAwalMess" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 mb-2">
                                <label for="bulanAkhirMess">Bulan Akhir:</label>
                                <select id="bulanAkhirMess" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 mb-2">
                                <label for="tahunMess">Tahun:</label>
                                <select id="tahunMess" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 d-flex align-items-end">
                                <button id="buttonFilterMonthlyMess" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                        <div class="card p-3 mt-3">
                            <div class="chart-container">
                                <canvas id="dailyMothlyMessChart" width="400" height="200"></canvas>
                                {{-- <div id="totalSummary">
                                    <p id="totalActualMess"><strong>Actual Order:</strong> -</p>
                                    <p id="totalPlanMess"><strong>Plan Order:</strong> -</p>
                                    <p id="totalTambahanMess"><strong>Tambahan:</strong> -</p>
                                    <p id="totalCostMess"></p>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h5><strong>Monthly Order All Mess</strong></h5>
                        <div class="row">
                            <div class="col-md-2 col-12 mb-2">
                                <label for="bulanMess">Bulan:</label>
                                <select id="bulanMess" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 mb-2">
                                <label for="tahunAllMess">Tahun:</label>
                                <select id="tahunAllMess" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 d-flex align-items-end">
                                <button id="buttonFilterMonthlyAllMess" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                        <div class="card p-3 mt-3">
                            <div class="chart-container">
                                <canvas id="dailyMothlyAllMessChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h5><strong>Cost Daily Order</strong></h5>
                        <div class="row">
                            <div class="col-md-3 col-12 mb-2">
                                <label for="tanggalAwalAllCost">Tanggal Awal:</label>
                                <input type="date" id="tanggalAwalAllCost" class="form-control">
                            </div>
                            <div class="col-md-3 col-12 mb-2">
                                <label for="tanggalAkhirAllCost">Tanggal Akhir:</label>
                                <input type="date" id="tanggalAkhirAllCost" class="form-control">
                            </div>
                            <div class="col-md-2 col-12 d-flex align-items-end">
                                <button id="buttonFilterAllCost" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                        <div class="card p-3 mt-3">
                            <div class="chart-container">
                                <div id="totalSummary">
                                    <p id="fixedCost"></p>
                                    <p id="totalCostAllDept"></p>
                                    <p id="totalSisa"></p>
                                </div>
                                <canvas id="dailyAllCostChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {
    const departemen = document.getElementById('departemen');
    const departemenMonthly = document.getElementById('departemenMonthly');
    const messMonthly = document.getElementById('messMonthly');
    const mess = document.getElementById('mess');
    const bulanAwal = document.getElementById("bulanAwal");
    const tahun = document.getElementById("tahun");
    const tahunMess = document.getElementById("tahunMess");
    const bulanDept = document.getElementById("bulanDept");
    const tahunAllMess = document.getElementById("tahunAllMess");
    const bulanMess = document.getElementById("bulanMess");

    const bulanNama = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    bulanNama.forEach((bulan, i) => {
        const value = i + 1;
        bulanAwal.innerHTML += `<option value="${value}">${bulan}</option>`;
        bulanAkhir.innerHTML += `<option value="${value}">${bulan}</option>`;
        bulanAwalMess.innerHTML += `<option value="${value}">${bulan}</option>`;
        bulanAkhirMess.innerHTML += `<option value="${value}">${bulan}</option>`;
        bulanDept.innerHTML += `<option value="${value}">${bulan}</option>`;
        bulanMess.innerHTML += `<option value="${value}">${bulan}</option>`;
    });

    for (let t = 2025; t <= 2030; t++) {
        tahun.innerHTML += `<option value="${t}">${t}</option>`;
        tahunMess.innerHTML += `<option value="${t}">${t}</option>`;
        tahunAllDept.innerHTML += `<option value="${t}">${t}</option>`;
        tahunAllMess.innerHTML += `<option value="${t}">${t}</option>`;
    }

    ['hcga', 'pro', 'coe', 'plant', 'eng', 'falog', 'she'].forEach(dep => {
        departemen.innerHTML += `<option value="${dep}">${dep.toUpperCase()}</option>`;
    });

    ['hcga', 'pro', 'coe', 'plant', 'eng', 'falog', 'she'].forEach(dep => {
        departemenMonthly.innerHTML += `<option value="${dep}">${dep.toUpperCase()}</option>`;
    });

    ['mess putri', 'mess meicu', 'a1', 'c3'].forEach(dep => {
        messMonthly.innerHTML += `<option value="${dep}">${dep.toUpperCase()}</option>`;
    });

    for (let i = 1; i <= 10; i++) {
        let dep = `b${i}`;
        messMonthly.innerHTML += `<option value="${dep}">${dep.toUpperCase()}</option>`;

    }

    ['mess putri', 'mess meicu', 'a1', 'c3'].forEach(dep => {
    mess.innerHTML += `<option value="${dep}">${dep.toUpperCase()}</option>`;
    });

    for (let i = 1; i <= 10; i++) {
    let dep = `b${i}`;
    mess.innerHTML += `<option value="${dep}">${dep.toUpperCase()}</option>`;

    }
});

Chart.register(ChartDataLabels);
let dailyDeptChart;
let dailyMessChart;
let dailyMothlyDeptChart;
let dailyMothlyAllDeptChart;
let dailyMothlyMessChart;
let dailyMothlyAllMessChart;

let dailyAllCostChart;

document.addEventListener('DOMContentLoaded', function () {
    const today = new Date();
    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 2);

    const formatDate = (date) => date.toISOString().split('T')[0];

    const defaultParams = {
        departemen: 'hcga',
        tanggalAwal: formatDate(startOfMonth),
        tanggalAkhir: formatDate(today),
    };

    Object.keys(defaultParams).forEach(key => document.getElementById(key).value = defaultParams[key]);
    fetchData(defaultParams);

    document.getElementById('buttonFilter').addEventListener('click', function () {
        const departemen = document.getElementById('departemen').value;
        const tanggalAwal = document.getElementById('tanggalAwal').value;
        const tanggalAkhir = document.getElementById('tanggalAkhir').value;

        if (!departemen || !tanggalAwal || !tanggalAkhir) return alert("Silakan pilih departemen dan rentang tanggal!");

        fetchData({ departemen, tanggalAwal, tanggalAkhir });
    });

    function fetchData(params) {
        fetch('/get-daily-dept', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(params)
        })
        .then(response => response.json())
        .then(data => {
            updateChart(data);
            updateTotals(data);
        })
        .catch(console.error);
    }
});

function updateChart(response) {
    const labels = response.data.map(item => item.tanggal);
    const planData = response.data.map(item => item.total_plan);
    const actualData = response.data.map(item => item.total_actual);

    const actualWithinOrBelow = actualData.map((actual, i) => Math.min(actual, planData[i]));
    const actualSurplus = actualData.map((actual, i) => actual > planData[i] ? actual - planData[i] : 0);

    const ctx = document.getElementById('dailyDeptChart').getContext('2d');

    if (dailyDeptChart) {
        dailyDeptChart.destroy();
    }

    dailyDeptChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Actual Order',
                    data: actualWithinOrBelow,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    stack: 'actual',
                    datalabels: {
                        display: false
                    }
                },
                {
                    label: 'Surplus',
                    data: actualSurplus,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    stack: 'actual',
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'top',
                        font: {
                            weight: 'bold'
                        },
                        formatter: function(value, context) {
                            return actualData[context.dataIndex]; // total actual
                        }
                    }
                },
                {
                    label: 'Plan Order',
                    data: planData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    stack: 'plan',
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'top',
                        font: {
                            weight: 'bold'
                        },
                        formatter: Math.round
                    }
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Daily Plan Order and Actual Order by Department '
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            const index = context.dataIndex;
                            const datasetLabel = context.dataset.label;

                            const actualTotal = actualData[index];
                            const surplus = actualSurplus[index];
                            const plan = planData[index];

                            if (datasetLabel === 'Actual Order') {
                                return `Actual Order: ${actualTotal}`;
                            }

                            if (datasetLabel === 'Surplus' && surplus > 0) {
                                return `Surplus: ${surplus}`;
                            }

                            if (datasetLabel === 'Plan Order') {
                                return `Plan Order: ${plan}`;
                            }

                            return null;
                        }
                    }
                }
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                x: {
                    stacked: false
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    grace: '10%'
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}

function updateTotals(response) {
    const totalPlan = response.total_plan;
    const totalActual = response.total_actual;
    const totalTambahan = response.total_tambahan;
    const totalCost = response.total_cost;

    function formatCurrency(value) {
            return 'Rp ' + value.toLocaleString('id-ID');
        }
    document.getElementById('totalPlan').textContent = `Plan Order: ${totalPlan}`;
    document.getElementById('totalActual').textContent = `Actual Order: ${totalActual}`;
    document.getElementById('totalTambahan').textContent = `Tambahan Order: ${totalTambahan}`;
    document.getElementById('totalCost').textContent = `Cost: ${formatCurrency(totalCost)}`;
}

//Mess
document.addEventListener('DOMContentLoaded', function () {
    const today = new Date();
    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 2);

    const formatDate = (date) => date.toISOString().split('T')[0];

    const defaultParams = {
        mess: 'a1',
        tanggalAwalMess: formatDate(startOfMonth),
        tanggalAkhirMess: formatDate(today),
    };

    Object.keys(defaultParams).forEach(key => document.getElementById(key).value = defaultParams[key]);
    fetchData(defaultParams);

    document.getElementById('buttonFilterMess').addEventListener('click', function () {
        const mess = document.getElementById('mess').value;
        const tanggalAwal = document.getElementById('tanggalAwalMess').value;
        const tanggalAkhir = document.getElementById('tanggalAkhirMess').value;

        if (!mess || !tanggalAwal || !tanggalAkhir) return alert("Silakan pilih mess dan rentang tanggal!");

        fetchData({ mess, tanggalAwal, tanggalAkhir });
    });

    function fetchData(params) {
        fetch('/get-daily-mess', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(params)
        })
        .then(response => response.json())
        .then(data => {
            updateChartMess(data);
            updateTotalsMess(data);
        })
        .catch(console.error);
    }
});

function updateChartMess(response) {
    const labels = response.data.map(item => item.tanggal);
    const planData = response.data.map(item => item.total_plan);
    const actualData = response.data.map(item => item.total_actual);

    const actualWithinOrBelow = actualData.map((actual, i) => Math.min(actual, planData[i]));
    const actualSurplus = actualData.map((actual, i) => actual > planData[i] ? actual - planData[i] : 0);

    const ctx = document.getElementById('dailyMessChart').getContext('2d');

    if (dailyMessChart) {
        dailyMessChart.destroy();
    }

    dailyMessChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Actual Order',
                    data: actualWithinOrBelow,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    stack: 'actual',
                    datalabels: {
                        display: false
                    }
                },
                {
                    label: 'Surplus',
                    data: actualSurplus,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    stack: 'actual',
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'top',
                        font: {
                            weight: 'bold'
                        },
                        formatter: function(value, context) {
                            return actualData[context.dataIndex]; // total actual
                        }
                    }
                },
                {
                    label: 'Plan Order',
                    data: planData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    stack: 'plan',
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'top',
                        font: {
                            weight: 'bold'
                        },
                        formatter: Math.round
                    }
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Daily Plan Order and Actual Order by Mess'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            const index = context.dataIndex;
                            const datasetLabel = context.dataset.label;

                            const actualTotal = actualData[index];
                            const surplus = actualSurplus[index];
                            const plan = planData[index];

                            if (datasetLabel === 'Actual Order') {
                                return `Actual Order: ${actualTotal}`;
                            }

                            if (datasetLabel === 'Surplus' && surplus > 0) {
                                return `Surplus: ${surplus}`;
                            }

                            if (datasetLabel === 'Plan Order') {
                                return `Plan Order: ${plan}`;
                            }

                            return null;
                        }
                    }
                }
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                x: {
                    stacked: false
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    grace: '10%'
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}

function updateTotalsMess(response) {
    const totalPlan = response.total_plan_mess;
    const totalActual = response.total_actual_mess;
    const totalTambahan = response.total_tambahan_mess;
    const totalCost = response.total_cost_mess;

    function formatCurrency(value) {
            return 'Rp ' + value.toLocaleString('id-ID');
        }
    document.getElementById('totalPlanMess').textContent = `Plan Order: ${totalPlan}`;
    document.getElementById('totalActualMess').textContent = `Actual Order: ${totalActual}`;
    document.getElementById('totalTambahanMess').textContent = `Tambahan Order: ${totalTambahan}`;
    document.getElementById('totalCostMess').textContent = `Cost: ${formatCurrency(totalCost)}`;
}

document.addEventListener('DOMContentLoaded', function () {
    const pad2 = (n) => n.toString().padStart(2, '0');
    const today = new Date();
    const startOfMonth = new Date(today.getFullYear(), 0, 1);
    const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    const formatDate = (date) => date.toISOString().split('T')[0];

    const defaultParams = {
        departemenMonthly: 'hcga',
        tahun: today.getFullYear(),
        bulanAwal: '1',
        bulanAkhir: '12'
    };

    document.getElementById('departemenMonthly').value = defaultParams.departemenMonthly;
    document.getElementById('tahun').value = defaultParams.tahun;
    document.getElementById('bulanAwal').value = defaultParams.bulanAwal;
    document.getElementById('bulanAkhir').value = defaultParams.bulanAkhir;

    fetchData(defaultParams);

    document.getElementById('buttonFilterMonthlyDept').addEventListener('click', function () {
        const departemenMonthly = document.getElementById('departemenMonthly').value;
        const tahun = document.getElementById('tahun').value;
        const bulanAwal = document.getElementById('bulanAwal').value;
        const bulanAkhir = document.getElementById('bulanAkhir').value;

        if (!departemenMonthly || !bulanAwal || !bulanAkhir || !tahun) {
            return alert("Silakan pilih departemen, tahun, dan rentang bulan!");
        }

        fetchData({ departemenMonthly, tahun, bulanAwal, bulanAkhir });
    });

    function fetchData(params) {
        fetch('/get-monthly-dept', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(params)
        })
        .then(response => response.json())
        .then(data => {
            //console.log(data);
            updateChartMonthly(data);
        })
        .catch(console.error);
    }
});

function updateChartMonthly(response) {
    const labels = response.data.map(item => item.bulan);
    const planData = response.data.map(item => item.total_plan);
    const actualData = response.data.map(item => item.total_actual);

    const actualWithinOrBelow = actualData.map((actual, i) => Math.min(actual, planData[i]));
    const actualSurplus = actualData.map((actual, i) => actual > planData[i] ? actual - planData[i] : 0);

    const ctx = document.getElementById('dailyMothlyDeptChart').getContext('2d');

    if (dailyMothlyDeptChart) {
        dailyMothlyDeptChart.destroy();
    }

    dailyMothlyDeptChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Actual Order',
                    data: actualWithinOrBelow,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    stack: 'actual',
                    datalabels: {
                        display: false
                    }
                },
                {
                    label: 'Surplus',
                    data: actualSurplus,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    stack: 'actual',
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'top',
                        font: {
                            weight: 'bold'
                        },
                        formatter: function (value, context) {
                            return actualData[context.dataIndex];
                        }
                    }
                },
                {
                    label: 'Plan Order',
                    data: planData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    stack: 'plan',
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'top',
                        font: {
                            weight: 'bold'
                        },
                        formatter: Math.round
                    }
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Monthly Plan Order and Actual Order by Department'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function (context) {
                            const index = context.dataIndex;
                            const datasetLabel = context.dataset.label;

                            const actualTotal = actualData[index];
                            const surplus = actualSurplus[index];
                            const plan = planData[index];

                            if (datasetLabel === 'Actual Order') {
                                return `Actual Order: ${actualTotal}`;
                            }

                            if (datasetLabel === 'Surplus' && surplus > 0) {
                                return `Surplus: ${surplus}`;
                            }

                            if (datasetLabel === 'Plan Order') {
                                return `Plan Order: ${plan}`;
                            }

                            return null;
                        }
                    }
                }
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                x: {
                    stacked: false
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    grace: '10%'
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const today = new Date();

    const bulanSekarang = (today.getMonth() + 1).toString();
    const defaultParams = {
        tahunAllDept: today.getFullYear(),
        bulanDept: bulanSekarang, // pakai bulan sekarang secara dinamis
    };

    document.getElementById('tahunAllDept').value = defaultParams.tahunAllDept;
    document.getElementById('bulanDept').value = defaultParams.bulanDept;

    fetchData(defaultParams);

    document.getElementById('buttonFilterMonthlyAllDept').addEventListener('click', function () {
        const tahunAllDept = document.getElementById('tahunAllDept').value;
        const bulanDept = document.getElementById('bulanDept').value;

        if (!tahunAllDept || !bulanDept) {
            return alert("Silakan pilih bulan dan tahun!");
        }

        fetchData({ tahunAllDept, bulanDept });
    });

    function fetchData(params) {
        fetch('/get-monthly-all-dept', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(params)
        })
        .then(response => response.json())
        .then(data => {
            updateChartMonthlyAllDept(data);
        })
        .catch(console.error);
    }
});

function updateChartMonthlyAllDept(response) {
    const labels = response.data.map(item => item.departemen);
    const planData = response.data.map(item => item.total_plan);
    const actualData = response.data.map(item => item.total_actual);
    const surplusData = response.data.map(item => item.surplus);

    const backgroundColors = surplusData.map(surplus =>
        surplus > 0 ? 'rgba(255, 99, 132, 0.7)' : 'rgba(75, 192, 192, 0.7)'
    );

    const ctx = document.getElementById('dailyMothlyAllDeptChart').getContext('2d');

    if (dailyMothlyAllDeptChart) {
        dailyMothlyAllDeptChart.destroy();
    }

    dailyMothlyAllDeptChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Actual Order',
                    data: actualData,
                    backgroundColor: backgroundColors,
                    stack: 'actual',
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'top',
                        font: {
                            weight: 'bold'
                        },
                        formatter: function (value) {
                            return value; // tampilkan total actual
                        }
                    }
                },
                {
                    label: 'Plan Order',
                    data: planData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    stack: 'plan',
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'top',
                        font: {
                            weight: 'bold'
                        },
                        formatter: Math.round
                    }
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Monthly Plan vs Actual Orders per Department'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function (context) {
                            const index = context.dataIndex;
                            const datasetLabel = context.dataset.label;

                            if (datasetLabel === 'Actual Order') {
                                const actual = actualData[index];
                                const surplus = surplusData[index];
                                return surplus > 0
                                    ? `Actual: ${actual} (Surplus: ${surplus})`
                                    : `Actual: ${actual}`;
                            }

                            if (datasetLabel === 'Plan Order') {
                                return `Plan: ${planData[index]}`;
                            }

                            return null;
                        }
                    }
                }
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                x: {
                    stacked: false
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    grace: '10%'
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}

document.addEventListener('DOMContentLoaded', function () {

    const today = new Date();
    const startOfMonth = new Date(today.getFullYear(), 0, 1);
    const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    const formatDate = (date) => date.toISOString().split('T')[0];

    const defaultParams = {
        messMonthly: 'a1',
        tahunMess: today.getFullYear(),
        bulanAwalMess: '1',
        bulanAkhirMess: '12'
    };

    document.getElementById('messMonthly').value = defaultParams.messMonthly;
    document.getElementById('tahunMess').value = defaultParams.tahunMess;
    document.getElementById('bulanAwalMess').value = defaultParams.bulanAwalMess;
    document.getElementById('bulanAkhirMess').value = defaultParams.bulanAkhirMess;

    fetchData(defaultParams);

    document.getElementById('buttonFilterMonthlyMess').addEventListener('click', function () {
        const messMonthly = document.getElementById('messMonthly').value;
        const tahunMess = document.getElementById('tahunMess').value;
        const bulanAwalMess = document.getElementById('bulanAwalMess').value;
        const bulanAkhirMess = document.getElementById('bulanAkhirMess').value;

        if (!messMonthly || !bulanAwalMess || !bulanAkhirMess || !tahunMess) {
            return alert("Silakan pilih mess, tahun, dan rentang bulan!");
        }

        fetchData({ messMonthly, tahunMess, bulanAwalMess, bulanAkhirMess });
    });

    function fetchData(params) {
        fetch('/get-monthly-mess', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(params)
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            updateChartMonthlyMess(data);
        })
        .catch(console.error);
    }
});

function updateChartMonthlyMess(response) {
    const labels = response.data.map(item => item.bulan);
    const planData = response.data.map(item => item.total_plan);
    const actualData = response.data.map(item => item.total_actual);

    const actualWithinOrBelow = actualData.map((actual, i) => Math.min(actual, planData[i]));
    const actualSurplus = actualData.map((actual, i) => actual > planData[i] ? actual - planData[i] : 0);

    const ctx = document.getElementById('dailyMothlyMessChart').getContext('2d');

    if (dailyMothlyMessChart) {
        dailyMothlyMessChart.destroy();
    }

    dailyMothlyMessChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Actual Order',
                    data: actualWithinOrBelow,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    stack: 'actual',
                    datalabels: {
                        display: false
                    }
                },
                {
                    label: 'Surplus',
                    data: actualSurplus,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    stack: 'actual',
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'top',
                        font: {
                            weight: 'bold'
                        },
                        formatter: function (value, context) {
                            return actualData[context.dataIndex];
                        }
                    }
                },
                {
                    label: 'Plan Order',
                    data: planData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    stack: 'plan',
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'top',
                        font: {
                            weight: 'bold'
                        },
                        formatter: Math.round
                    }
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Monthly Plan Order and Actual Order by Department'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function (context) {
                            const index = context.dataIndex;
                            const datasetLabel = context.dataset.label;

                            const actualTotal = actualData[index];
                            const surplus = actualSurplus[index];
                            const plan = planData[index];

                            if (datasetLabel === 'Actual Order') {
                                return `Actual Order: ${actualTotal}`;
                            }

                            if (datasetLabel === 'Surplus' && surplus > 0) {
                                return `Surplus: ${surplus}`;
                            }

                            if (datasetLabel === 'Plan Order') {
                                return `Plan Order: ${plan}`;
                            }

                            return null;
                        }
                    }
                }
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                x: {
                    stacked: false
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    grace: '10%'
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const today = new Date();
    const bulanSekarang = (today.getMonth() + 1).toString();
    const defaultParams = {
        tahunAllMess: today.getFullYear(),
        bulanMess: bulanSekarang, // pakai bulan sekarang secara dinamis
    };

    document.getElementById('tahunAllMess').value = defaultParams.tahunAllMess;
    document.getElementById('bulanMess').value = defaultParams.bulanMess;

    fetchData(defaultParams);

    document.getElementById('buttonFilterMonthlyAllMess').addEventListener('click', function () {
        const tahunAllMess = document.getElementById('tahunAllMess').value;
        const bulanMess = document.getElementById('bulanMess').value;

        if (!tahunAllMess || !bulanMess) {
            return alert("Silakan pilih bulan dan tahun!");
        }

        fetchData({ tahunAllMess, bulanMess });
    });

    function fetchData(params) {
        fetch('/get-monthly-all-mess', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(params)
        })
        .then(response => response.json())
        .then(data => {
            updateChartMonthlyAllMess(data);
        })
        .catch(console.error);
    }
});

function updateChartMonthlyAllMess(response) {
    const labels = response.data.map(item => item.departemen);
    const planData = response.data.map(item => item.total_plan);
    const actualData = response.data.map(item => item.total_actual);
    const surplusData = response.data.map(item => item.surplus);

    const backgroundColors = surplusData.map(surplus =>
        surplus > 0 ? 'rgba(255, 99, 132, 0.7)' : 'rgba(75, 192, 192, 0.7)'
    );

    const ctx = document.getElementById('dailyMothlyAllMessChart').getContext('2d');

    if (dailyMothlyAllMessChart) {
        dailyMothlyAllMessChart.destroy();
    }

    // dailyMothlyAllMessChart = new Chart(ctx, {
    //     type: 'bar',
    //     data: {
    //         labels: labels,
    //         datasets: [
    //             {
    //                 label: 'Actual Order',
    //                 data: actualData,
    //                 backgroundColor: backgroundColors,
    //                 stack: 'actual',
    //                 datalabels: {
    //                     color: '#000',
    //                     anchor: 'end',
    //                     align: 'top',
    //                     rotation: -90,  // 👈 Bikin vertikal
    //                     font: {
    //                         weight: 'bold'
    //                     },
    //                     formatter: function (value) {
    //                         return value.toLocaleString('id-ID'); // 👈 angka pakai titik ribuan
    //                     }
    //                 }
    //             },
    //             {
    //                 label: 'Plan Order',
    //                 data: planData,
    //                 backgroundColor: 'rgba(54, 162, 235, 0.7)',
    //                 stack: 'plan',
    //                 datalabels: {
    //                     color: '#000',
    //                     anchor: 'end',
    //                     rotation: -90,  // 👈 Bikin vertikal
    //                     align: 'top',
    //                     font: {
    //                         weight: 'bold'
    //                     },
    //                     formatter: function (value) {
    //                         return value.toLocaleString('id-ID'); // 👈 angka pakai titik ribuan
    //                     }
    //                 }
    //             }
    //         ]
    //     },
    //     options: {
    //         responsive: true,
    //         plugins: {
    //             title: {
    //                 display: true,
    //                 text: 'Monthly Plan vs Actual Orders per Department'
    //             },
    //             tooltip: {
    //                 mode: 'index',
    //                 intersect: false,
    //                 callbacks: {
    //                     label: function (context) {
    //                         const index = context.dataIndex;
    //                         const datasetLabel = context.dataset.label;

    //                         if (datasetLabel === 'Actual Order') {
    //                             const actual = actualData[index];
    //                             const surplus = surplusData[index];
    //                             return surplus > 0
    //                                ? `Actual: ${actual} (Surplus: ${surplus.toLocaleString('id-ID')})`
    //                                 : `Actual: ${actual}`;
    //                         }

    //                         if (datasetLabel === 'Plan Order') {
    //                             return `Plan: ${planData[index].toLocaleString('id-ID')}`;
    //                         }

    //                         return null;
    //                     }
    //                 }
    //             }
    //         },
    //         interaction: {
    //             mode: 'index',
    //             intersect: false
    //         },
    //         scales: {
    //             x: {
    //                 stacked: false
    //             },
    //             y: {
    //                 stacked: true,
    //                 beginAtZero: true,
    //                 grace: '10%'
    //             }
    //         }
    //     },
    //     plugins: [ChartDataLabels]
    // });

    dailyMothlyAllMessChart = new Chart(ctx, {
    type: 'bar',  // tetap bar
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Actual Order',
                data: actualData,
                backgroundColor: backgroundColors,
                stack: 'actual',
                datalabels: {
                    color: '#000',
                    align: 'right',
anchor: 'end',
offset: 4,
                    rotation: 0, // 👈 nggak perlu rotasi
                    font: {
                        weight: 'bold'
                    },
                    formatter: function (value) {
                        return value.toLocaleString('id-ID');
                    }
                }
            },
            {
                label: 'Plan Order',
                data: planData,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                stack: 'plan',
                datalabels: {
                    color: '#000',
                    align: 'right',
anchor: 'end',
offset: 4,
                    rotation: 0,
                    font: {
                        weight: 'bold'
                    },
                    formatter: function (value) {
                        return value.toLocaleString('id-ID');
                    }
                }
            }
        ]
    },
    options: {
        indexAxis: 'y', // 👈 ini yang bikin horizontal
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Monthly Plan vs Actual Orders per Department'
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function (context) {
                        const index = context.dataIndex;
                        const datasetLabel = context.dataset.label;

                        if (datasetLabel === 'Actual Order') {
                            const actual = actualData[index];
                            const surplus = surplusData[index];
                            return surplus > 0
                                ? `Actual: ${actual.toLocaleString('id-ID')} (Surplus: ${surplus.toLocaleString('id-ID')})`
                                : `Actual: ${actual.toLocaleString('id-ID')}`;
                        }

                        if (datasetLabel === 'Plan Order') {
                            return `Plan: ${planData[index].toLocaleString('id-ID')}`;
                        }

                        return null;
                    }
                }
            }
        },
        interaction: {
            mode: 'index',
            intersect: false
        },
        scales: {
            x: {
                stacked: true,
                beginAtZero: true,
                grace: '10%'
            },
            y: {
                stacked: false
            }
        }
    },
    plugins: [ChartDataLabels]
});

}


//=============================================== COST===============================================

document.addEventListener('DOMContentLoaded', function () {
    const today = new Date();
    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 2);

    const formatDate = (date) => date.toISOString().split('T')[0];

    const defaultParams = {
        tanggalAwalAllCost: formatDate(startOfMonth),
        tanggalAkhirAllCost: formatDate(today),
    };

    Object.keys(defaultParams).forEach(key => document.getElementById(key).value = defaultParams[key]);
    fetchData(defaultParams);

    document.getElementById('buttonFilterAllCost').addEventListener('click', function () {
        const tanggalAwalAllCost = document.getElementById('tanggalAwalAllCost').value;
        const tanggalAkhirAllCost = document.getElementById('tanggalAkhirAllCost').value;

        if (!tanggalAwalAllCost || !tanggalAkhirAllCost) return alert("Silakan pilih departemen dan rentang tanggal!");

        fetchData({tanggalAwalAllCost, tanggalAkhirAllCost });
    });

    function fetchData(params) {
        fetch('/get-daily-allcost-dept', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(params)
        })
        .then(response => response.json())
        .then(data => {
            updateChartAllCost(data);
            updateTotalsAllCost(data);
        })
        .catch(console.error);
    }
});

function updateChartAllCost(response) {
    const labels = response.data_per_hari.map(item => item.tanggal);
    const costData = response.data_per_hari.map(item => item.total_cost);

    const ctx = document.getElementById('dailyAllCostChart').getContext('2d');

    if (window.dailyAllCostChart instanceof Chart) {
        window.dailyAllCostChart.destroy();
    }

    window.dailyAllCostChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Total Cost per Hari',
                    data: costData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Total Cost Per Hari (All Department)'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Rp ${context.parsed.y.toLocaleString('id-ID')}`;
                        }
                    }
                }
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
}

function updateTotalsAllCost(response) {
    const totalCost = response.total_semua_cost;
    const fixedCost = response.cost;
    const remainingCost = response.sisa_cost;

    function formatCurrency(value) {
        return 'Rp ' + value.toLocaleString('id-ID');
    }

    document.getElementById('fixedCost').textContent = `Allocated Budget: ${formatCurrency(fixedCost)}`;
    document.getElementById('totalSisa').textContent = `Remaining Budget: ${formatCurrency(remainingCost)}`;
    document.getElementById('totalCostAllDept').textContent = `Actual Cost: ${formatCurrency(totalCost)}`;
}



</script>

@endsection
