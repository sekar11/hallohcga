@extends('include/mainlayout')
@section('title', 'MK Catering')
@section('content')
    <div class="pagetitle">
      <h1>Dashboard MK Catering</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</a></li>
          <li class="breadcrumb-item active">Dashboard MK Catering</li>
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

        <!-- SEKAR -->
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 col-12 mb-4">
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h5><strong>Daily Order Snack & MK Spesial</strong></h5>
                        <div class="row">
                            <div class="col-md-3 col-12 mb-2">
                                <label for="departemen">Departemen:</label>
                                    <select id="departemenSnack"a class="form-control">1</select>
                            </div>
                            <div class="col-md-3 col-12 mb-2">
                                <label for="tanggalAwal">Tanggal Awal:</label>
                                <input type="date" id="tanggalAwalSnack" class="form-control">
                            </div>
                            <div class="col-md-3 col-12 mb-2">
                                <label for="tanggalAkhir">Tanggal Akhir:</label>
                                <input type="date" id="tanggalAkhirSnack" class="form-control">
                            </div>
                            <div class="col-md-2 col-12 d-flex align-items-end">
                                <button id="buttonFilterSnack" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                        <div class="card p-3 mt-3">
                            <div class="chart-container">
                                <canvas id="dailyDeptSnackChart" width="400" height="200"></canvas>
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
                        <h5><strong>Monthly Order Snack & MK Spesial</strong></h5>
                        <div class="row">
                            <div class="col-md-3 col-12 mb-2">
                                <label for="departemenMonthly">Departemen:</label>
                                    <select id="departemenMonthlySnack" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 mb-2">
                                <label for="bulanAwalSnack">Bulan Awal:</label>
                                <select id="bulanAwalSnack" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 mb-2">
                                <label for="bulanAkhirSnack">Bulan Akhir:</label>
                                <select id="bulanAkhirSnack" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 mb-2">
                                <label for="tahunSnakc">Tahun:</label>
                                <select id="tahunSnack" class="form-control"></select>
                            </div>
                            <div class="col-md-2 col-12 d-flex align-items-end">
                                <button id="buttonFilterSnackPerBulan" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                        <div class="card p-3 mt-3">
                            <div class="chart-container">
                                <canvas id="dailyMothlyDeptChartSnack" width="400" height="200"></canvas>
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
                        <h5><strong>Daily Order MK Reguler , MK Spesial, Snack </strong></h5>
                        <div class="row">
                            <div class="col-md-3 col-12 mb-2">
                                <label for="tanggalAkhirAll">Tanggal:</label>
                                <input type="date" id="tanggalAkhirAll" class="form-control">
                            </div>
                            <div class="col-md-2 col-12 d-flex align-items-end">
                                <button id="buttonFilterAll" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                        <div class="card p-3 mt-3">
                            <div class="chart-container">
                                <canvas id="dailyAllChart" width="400" height="200"></canvas>

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
    const departemenSnack = document.getElementById('departemenSnack');
    const departemenMonthly = document.getElementById('departemenMonthly');
    const departemenMonthlySnack = document.getElementById('departemenMonthlySnack');
    const messMonthly = document.getElementById('messMonthly');
    const mess = document.getElementById('mess');
    const bulanAwal = document.getElementById("bulanAwal");
    const bulanAwalSnack = document.getElementById("bulanAwalSnack");
    const bulanAkhirSnack = document.getElementById("bulanAkhirSnack");
    const tahun = document.getElementById("tahun");
    const tahunMess = document.getElementById("tahunMess");
    const tahunSnack = document.getElementById("tahunSnack");
    const bulanDept = document.getElementById("bulanDept");
    const tahunAllMess = document.getElementById("tahunAllMess");
    const bulanMess = document.getElementById("bulanMess");

    const bulanNama = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    bulanNama.forEach((bulan, i) => {
        const value = i + 1;
        bulanAwal.innerHTML += `<option value="${value}">${bulan}</option>`;
        bulanAkhir.innerHTML += `<option value="${value}">${bulan}</option>`;
        bulanAwalSnack.innerHTML += `<option value="${value}">${bulan}</option>`;
        bulanAkhirSnack.innerHTML += `<option value="${value}">${bulan}</option>`;
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
        tahunSnack.innerHTML += `<option value="${t}">${t}</option>`;
    }

    ['hcga', 'pro', 'coe', 'plant', 'eng', 'falog', 'she'].forEach(dep => {
        departemen.innerHTML += `<option value="${dep}">${dep.toUpperCase()}</option>`;
    });

    ['hcga', 'pro', 'coe', 'plant', 'eng', 'falog', 'she'].forEach(dep => {
        departemenSnack.innerHTML += `<option value="${dep}">${dep.toUpperCase()}</option>`;
    });

    ['hcga', 'prod', 'coe', 'plant', 'eng', 'falog', 'she'].forEach(dep => {
        departemenMonthly.innerHTML += `<option value="${dep}">${dep.toUpperCase()}</option>`;
    });

     ['hcga', 'prod', 'coe', 'plant', 'eng', 'falog', 'she'].forEach(dep => {
        departemenMonthlySnack.innerHTML += `<option value="${dep}">${dep.toUpperCase()}</option>`;
    });

    ['mess amm','mess putri', 'mess meicu', 'a1', 'c3'].forEach(dep => {
        messMonthly.innerHTML += `<option value="${dep}">${dep.toUpperCase()}</option>`;
    });

    for (let i = 1; i <= 10; i++) {
        let dep = `b${i}`;
        messMonthly.innerHTML += `<option value="${dep}">${dep.toUpperCase()}</option>`;

    }

    ['mess amm','mess putri', 'mess meicu', 'a1', 'c3'].forEach(dep => {
    mess.innerHTML += `<option value="${dep}">${dep.toUpperCase()}</option>`;
    });

    for (let i = 1; i <= 10; i++) {
    let dep = `b${i}`;
    mess.innerHTML += `<option value="${dep}">${dep.toUpperCase()}</option>`;

    }
});

window.dailyAllChart = null;

Chart.register(ChartDataLabels);
let dailyDeptChart;
let dailyMessChart;
let dailyMothlyDeptChart;
let dailyMothlyAllDeptChart;
let dailyMothlyMessChart;
let dailyMothlyAllMessChart;

// MK SNACK DAN MK SPESIAL
let dailyDeptSnackChart;

//COST
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
    // const planData = response.data.map(item => item.total_plan);
    // const actualData = response.data.map(item => item.total_actual);

    const planData = response.data.map(item => Number(item.total_plan));
    const actualData = response.data.map(item => Number(item.total_actual));
    const actualSurplus = actualData.map((actual, i) => actual > planData[i] ? actual - planData[i] : 0);
    const actualWithinOrBelow = actualData.map((actual, i) => Math.min(actual, planData[i]));
    // const actualSurplus = actualData.map((actual, i) => actual > planData[i] ? actual - planData[i] : 0);

    const ss6Data = labels.map(tanggal => {
        const found = response.total_ss6.data.find(item => item.tanggal === tanggal);
        return found ? found.total_actual : 0;
    });

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
                },
                {
                    label: 'SS6 Actual',
                    data: ss6Data,
                    backgroundColor: 'rgba(255, 206, 86, 0.7)', // kuning
                    stack: 'ss6',
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
                    text: 'Daily Plan, Actual, and SS6 Order by Department'
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
                            const ss6 = ss6Data[index];

                            if (datasetLabel === 'Actual Order') {
                                return `Actual Order: ${actualTotal}`;
                            }
                            if (datasetLabel === 'Surplus' && surplus > 0) {
                                return `Surplus: ${surplus}`;
                            }
                            if (datasetLabel === 'Plan Order') {
                                return `Plan Order: ${plan}`;
                            }
                            if (datasetLabel === 'SS6 Actual') {
                                return `SS6 Actual: ${ss6}`;
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
                    stacked: true
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
    const ss6Data = response.data.map(item => item.total_ss6); // ambil total_ss6

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
                },
                {
                    label: 'SS6 Order',
                    data: ss6Data,
                    backgroundColor: 'rgba(255, 206, 86, 0.7)', // warna kuning stabilo
                    stack: 'ss6',
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
                    text: 'Monthly Plan, Actual, Surplus & SS6 Order by Department'
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
                            const ss6 = ss6Data[index];

                            if (datasetLabel === 'Actual Order') {
                                return `Actual Order: ${actualTotal}`;
                            }
                            if (datasetLabel === 'Surplus' && surplus > 0) {
                                return `Surplus: ${surplus}`;
                            }
                            if (datasetLabel === 'Plan Order') {
                                return `Plan Order: ${plan}`;
                            }
                            if (datasetLabel === 'SS6 Order') {
                                return `SS6: ${ss6}`;
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
                    stacked: true // Kalau mau tumpuk, ganti jadi true
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
    const ss6Data = response.data.map(item => item.total_ss6);
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
                        font: { weight: 'bold' },
                        formatter: value => value
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
                        font: { weight: 'bold' },
                        formatter: Math.round
                    }
                },
                {
                    label: 'SS6 Order',
                    data: ss6Data,
                    backgroundColor: 'rgba(255, 206, 86, 0.7)',
                    stack: 'ss6',
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'top',
                        font: { weight: 'bold' },
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
                    text: 'Monthly Plan vs Actual vs SS6 Orders per Department'
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

                            if (datasetLabel === 'SS6 Order') {
                                return `SS6: ${ss6Data[index]}`;
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
                x: { stacked: false },
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
                    rotation: 0, 
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
        indexAxis: 'y', 
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

    // Set default input values
    document.getElementById('tanggalAwalAllCost').value = formatDate(startOfMonth);
    document.getElementById('tanggalAkhirAllCost').value = formatDate(today);

    // Load initial data
    loadData(formatDate(startOfMonth), formatDate(today));

    document.getElementById('buttonFilterAllCost').addEventListener('click', () => {
        const tanggalAwal = document.getElementById('tanggalAwalAllCost').value;
        const tanggalAkhir = document.getElementById('tanggalAkhirAllCost').value;

        if (!tanggalAwal || !tanggalAkhir) {
            alert("Silakan pilih rentang tanggal!");
            return;
        }

        loadData(tanggalAwal, tanggalAkhir);
    });

    function loadData(tanggalAwal, tanggalAkhir) {
        fetch('/get-daily-allcost-dept', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ tanggalAwalAllCost: tanggalAwal, tanggalAkhirAllCost: tanggalAkhir })
        })
        .then(res => res.json())
        .then(data => {
            updateChart(data.data_per_hari, tanggalAwal);
            updateTotals(data, tanggalAwal, tanggalAkhir); 
        })
        .catch(err => {
            console.error(err);
            alert('Gagal memuat data.');
        });
    }

    function updateChart(dataPerHari, tanggalAwal) {
        const labels = dataPerHari.map(item => item.tanggal);
        const totalCosts = dataPerHari.map(item => item.total_cost);
        const regulerCosts = dataPerHari.map(item => item.reguler_cost);
        const snackCosts = dataPerHari.map(item => (item.snack_cost ?? 0) + (item.spesial_cost ?? 0));

        const totalCostss = 2100000000;

        const startDate = new Date(tanggalAwal);
        const tahun = startDate.getFullYear();
        const bulan = startDate.getMonth();
        const jumlahHariDalamBulan = new Date(tahun, bulan + 1, 0).getDate();

        const avgCost = totalCostss / jumlahHariDalamBulan;

        const ctx = document.getElementById('dailyAllCostChart').getContext('2d');

        if (window.dailyAllCostChart && typeof window.dailyAllCostChart.destroy === 'function') {
            window.dailyAllCostChart.destroy();
        }

        window.dailyAllCostChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Total Cost per Hari',
                    data: totalCosts,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Total Cost Per Hari (All Department)'
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            title: ctx => `Tanggal: ${ctx[0].label}`,
                            label: ctx => {
                                const index = ctx.dataIndex;
                                const total = totalCosts[index] ?? 0;
                                const reguler = regulerCosts[index] ?? 0;
                                const snack = snackCosts[index] ?? 0;
                                return [
                                    `Total Cost: Rp ${total.toLocaleString('id-ID')}`,
                                    `Reguler Cost: Rp ${reguler.toLocaleString('id-ID')}`,
                                    `Snack & MK Spesial Cost: Rp ${snack.toLocaleString('id-ID')}`
                                ];
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: val => 'Rp ' + val.toLocaleString('id-ID'),
                        }
                    }
                },
                onClick: function(evt, elements) {
                if (elements.length > 0) {
                    const chart = elements[0].element.$context.chart;
                    const index = elements[0].index;
                    const tanggalDipilih = chart.data.labels[index];

                    // Set tanggal di input
                    document.getElementById('tanggalAkhirAll').value = tanggalDipilih;

                    // Load chart daily order
                    loadDailyOrderChart(tanggalDipilih);

                    // Scroll ke canvas dailyAllChart
                    document.getElementById('dailyAllChart').scrollIntoView({
                    behavior: 'smooth'
                    });
                }
                }

            },
            plugins: [
                {
                    id: 'customDataLabel',
                    afterDatasetsDraw(chart) {
                        const ctx = chart.ctx;
                        chart.data.datasets.forEach((dataset, i) => {
                            const meta = chart.getDatasetMeta(i);
                            if (!meta.hidden) {
                                meta.data.forEach((element, index) => {
                                    const { x, y } = element.tooltipPosition();
                                    const totalCost = dataset.data[index];
                                    ctx.fillStyle = 'rgba(54, 162, 235, 1)';
                                    ctx.font = 'bold 12px Arial';
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'bottom';
                                    ctx.fillText('Rp ' + totalCost.toLocaleString('id-ID'), x, y - 6);
                                });
                            }
                        });
                    }
                },
                {
                    id: 'avgLine',
                    afterDraw(chart) {
                        const { ctx, chartArea: { top, bottom, left, right }, scales: { y } } = chart;
                        const yPos = y.getPixelForValue(avgCost);

                        ctx.save();
                        ctx.beginPath();
                        ctx.setLineDash([5, 5]);
                        ctx.moveTo(left, yPos);
                        ctx.lineTo(right, yPos);
                        ctx.strokeStyle = 'rgba(255, 99, 132, 0.8)';
                        ctx.lineWidth = 2;
                        ctx.stroke();

                        ctx.font = 'bold 12px Arial';
                        ctx.fillStyle = 'rgba(255, 99, 132, 0.8)';
                        ctx.textAlign = 'right';
                        ctx.textBaseline = 'bottom';
                        ctx.fillText(`Rata-rata: Rp ${avgCost.toLocaleString('id-ID')}`, right - 5, yPos - 5);

                        ctx.restore();
                    }
                }
            ]
        });
    }

    function updateTotals(data, tanggalAwal, tanggalAkhir) {

    const startDate = new Date(tanggalAwal);
    const endDate = new Date(tanggalAkhir);

    if (isNaN(startDate) || isNaN(endDate)) {
        console.error('Tanggal awal atau akhir tidak valid');
        return;
    }

    const diffTime = endDate.getTime() - startDate.getTime();
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

    if (typeof data.cost !== 'number' || typeof data.sisa_cost !== 'number') {
        console.error('data.cost atau data.sisa_cost bukan angka');
        return;
    }

    const year = startDate.getFullYear();
    const month = startDate.getMonth();

    const totalHariBulan = new Date(year, month + 1, 0).getDate();

    const fixedCostPerHari = data.cost / totalHariBulan;
    const sisaCostPerHari = data.sisa_cost / totalHariBulan;

    const fixedCostProrata = fixedCostPerHari * diffDays;
    const sisaCostProrata = fixedCostProrata - data.total_semua_cost;

    const formatCurrency = val => 'Rp ' + val.toLocaleString('id-ID');

    document.getElementById('fixedCost').textContent = `Allocated Budget: ${formatCurrency(Math.round(fixedCostProrata))}`;
    document.getElementById('totalSisa').textContent = `Remaining Budget: ${formatCurrency(Math.round(sisaCostProrata))}`;
    document.getElementById('totalCostAllDept').textContent = `Actual Cost: ${formatCurrency(data.total_semua_cost)}`;
}

});

function loadDailyOrderChart(tanggalDipilih) {
  fetch('/get-daily-all', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ tanggalAkhirAll: tanggalDipilih })
  })
  .then(res => res.json())
  .then(data => {
    const tanggal = Object.keys(data)[0];
    const departemenList = Object.keys(data[tanggal]);

    const labels = [];
    const regulerData = [];
    const snackData = [];
    const spesialData = [];

    departemenList.forEach(dept => {
      labels.push(dept);
      regulerData.push(data[tanggal][dept]['reguler']);
      snackData.push(data[tanggal][dept]['snack']);
      spesialData.push(data[tanggal][dept]['spesial']);
    });

    if (Chart.getChart("dailyAllChart")) {
        Chart.getChart("dailyAllChart").destroy();
    }

    const ctx = document.getElementById('dailyAllChart').getContext('2d');
    window.dailyAllChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
        {
            label: 'Reguler',
            data: regulerData,
            backgroundColor: '#2196F3',
        },
        {
            label: 'Snack',
            data: snackData,
            backgroundColor: '#FF9800',
        },
        {
            label: 'Spesial',
            data: spesialData,
            backgroundColor: '#4CAF50',
        }
        ]
    },
    options: {
        responsive: true,
        plugins: {
        legend: { position: 'top' },
        tooltip: { mode: 'index', intersect: false },
        title: {
            display: true,
            text: 'Total Order MK Reguler, MK Spesial & Snack ' + tanggal,
            padding: {
            bottom: 20
            }
        },
        datalabels: {
            anchor: 'end',
            align: 'end',
            color: '#000',
            font: {
                weight: 'bold'
            },
            formatter: function(value) {
                return value > 0 ? value : '';}
           }
        },
        scales: {
            x: { stacked: false, ticks: { autoSkip: false } },
            y: { beginAtZero: true, stacked: false }
        }
    },
    plugins: [ChartDataLabels]
    });

  })
  .catch(err => {
    console.error(err);
    alert('Gagal memuat data.');
  });
}


//=============================================== ORDER ALL Reguler, Snack, SPesial===============================================
document.addEventListener('DOMContentLoaded', function () {
    const today = new Date();
    const formatDate = (date) => date.toISOString().split('T')[0];

    document.getElementById('tanggalAkhirAll').value = formatDate(today);
    loadData(formatDate(today));

    document.getElementById('buttonFilterAll').addEventListener('click', () => {
        const tanggalAkhir = document.getElementById('tanggalAkhirAll').value;

        if (!tanggalAkhir) {
            alert("Silakan pilih tanggal!");
            return;
        }

        loadData(tanggalAkhir);
    });

    function loadData(tanggalAkhir) {
        fetch('/get-daily-all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ tanggalAkhirAll: tanggalAkhir })
        })
        .then(res => res.json())
        .then(data => {
            renderChart(data);
        })
        .catch(err => {
            console.error(err);
            alert('Gagal memuat data.');
        });
    }

    // let dailyAllChart;

    function renderChart(data) {
        const tanggal = Object.keys(data)[0];
        const departemenList = Object.keys(data[tanggal]);

        const labels = [];
        const regulerData = [];
        const snackData = [];
        const spesialData = [];

        departemenList.forEach(dept => {
            labels.push(dept);
            regulerData.push(data[tanggal][dept]['reguler']);
            snackData.push(data[tanggal][dept]['snack']);
            spesialData.push(data[tanggal][dept]['spesial']);
        });

        // if (dailyAllChart) {
        //     dailyAllChart.destroy();
        // }

       if (Chart.getChart("dailyAllChart")) {
            Chart.getChart("dailyAllChart").destroy();
        }

        const ctx = document.getElementById('dailyAllChart').getContext('2d');
        dailyAllChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Reguler',
                        data: regulerData,
                        backgroundColor: '#2196F3',
                    },
                    {
                        label: 'Snack',
                        data: snackData,
                        backgroundColor: '#FF9800',
                    },
                    {
                        label: 'Spesial',
                        data: spesialData,
                        backgroundColor: '#4CAF50',
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    },
                    title: {
                        display: true,
                        text: 'Total Order MK Reguler, MK Spesial & Snak ' + tanggal
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        color: '#000',
                        font: {
                            weight: 'bold'
                        },
                        formatter: Math.round
                    }
                },
                scales: {
                    x: {
                        stacked: false,
                        ticks: {
                            autoSkip: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        stacked: false
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }
});


//=============================================== SNACK & SPESIAL ===============================================

document.addEventListener('DOMContentLoaded', function () {
    const today = new Date();
    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 2);

    const formatDate = (date) => date.toISOString().split('T')[0];

    const defaultParams = {
        tanggalAwalSnack: formatDate(startOfMonth),
        tanggalAkhirSnack: formatDate(today),
    };

    // Set default value ke input
    Object.keys(defaultParams).forEach(key => {
        const el = document.getElementById(key);
        if (el) el.value = defaultParams[key];
    });

    // Variabel chart global
    let dailyDeptSnackChart;

    // Fungsi ambil data & tampilkan grafik
    function ambilDataSnack() {
        const tanggalAwal = document.getElementById('tanggalAwalSnack').value;
        const tanggalAkhir = document.getElementById('tanggalAkhirSnack').value;
        const departemen = document.getElementById('departemenSnack').value;

        if (!tanggalAwal || !tanggalAkhir || !departemen) {
            return alert('Lengkapi semua input!');
        }

        fetch('/get-snackspesial-data', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ tanggalAwal, tanggalAkhir, departemen })
        })
        .then(res => res.json())
        .then(data => tampilkanGrafik(data))
        .catch(console.error);
    }


    document.getElementById('buttonFilterSnack').addEventListener('click', ambilDataSnack);

    function tampilkanGrafik(data) {
    const hargaDefault = {
        "Snack Biasa": 13000,
        "Snack Spesial": 25000,
        "Parcel Buah Biasa": 100000,
        "Parcel Buah Spesial": 150000,
        "Aqua botol 330 ml": 50000,
        "Aqua botol 600 ml": 55000,
        "Pempek": 6000,
        "Kopi": 10000,
        "Teh": 10000,
        "Aqua Cup 220 ml": 40000,
        "Wedang Jahe": 10000,
        "MK Spesial": 25000,
        "Nasi Liwet": 35000,
        "Ayam Bakar": 35000,
        "Prasmanan": 35000,
        "Bubur Jubaidah": 9500,
    };

    const labels = data.map(item => item.jenis);
    const totalJumlah = data.map(item => item.total);

    const totalHarga = data.map(item => {
        const hargaDb = item.harga;
        const hargaValue = hargaDb !== null
            ? hargaDb
            : (hargaDefault[item.jenis] || 15000);
        return item.total * hargaValue;
    });

    const totalCostSemua = totalHarga.reduce((a, b) => a + b, 0);

    const ctx = document.getElementById('dailyDeptSnackChart').getContext('2d');

    if (dailyDeptSnackChart instanceof Chart) {
        dailyDeptSnackChart.destroy();
    }

    if (labels.length === 0) {
        alert('Data tidak ditemukan untuk periode tersebut!');
    }

    dailyDeptSnackChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Jumlah Pesanan',
                    data: totalJumlah,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: `Grafik Snack & MK Spesial (Total Cost: Rp ${totalCostSemua.toLocaleString('id-ID')})`,
                    font: {
                        size: 18
                    },
                        padding: {
                        top: 0,
                        bottom: 20
                    }

                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let jumlah = totalJumlah[context.dataIndex];
                            let hargaValue = totalHarga[context.dataIndex];
                            return `Jumlah: ${jumlah}, Harga: Rp ${hargaValue.toLocaleString('id-ID')}`;
                        }
                    }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'end',
                    formatter: function (value, context) {
                        let jumlah = totalJumlah[context.dataIndex];
                        let hargaValue = totalHarga[context.dataIndex];
                        return `${jumlah}x | Rp ${hargaValue.toLocaleString('id-ID')}`;
                    },
                    font: {
                        weight: 'bold'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}


    ambilDataSnack();
});

document.addEventListener('DOMContentLoaded', function () {
    const today = new Date();
    const startOfYear = new Date(today.getFullYear(), 0, 1);

    const formatDate = (date) => date.toISOString().split('T')[0];

    const defaultParams = {
        bulanAwalSnack: startOfYear.getMonth() + 1,
        bulanAkhirSnack: 12,
        tahunSnack: today.getFullYear()
    };

    Object.keys(defaultParams).forEach(key => {
        const el = document.getElementById(key);
        if (el) el.value = defaultParams[key];
    });

    let dailyMothlyDeptChartSnack;

    function ambilDataSnackPerBulan() {
        const bulanAwal = document.getElementById('bulanAwalSnack').value;
        const bulanAkhir = document.getElementById('bulanAkhirSnack').value;
        const tahun = document.getElementById('tahunSnack').value;
        const departemen = document.getElementById('departemenMonthlySnack').value;

        if (!bulanAwal || !bulanAkhir || !tahun || !departemen) {
            return alert('Lengkapi semua input!');
        }

        fetch('/get-snackspesial-perbulan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ bulanAwal, bulanAkhir, tahun, departemen })
        })
        .then(res => res.json())
        .then(data => tampilkanGrafikPerBulan(data))
        .catch(console.error);
    }

    document.getElementById('buttonFilterSnackPerBulan').addEventListener('click', ambilDataSnackPerBulan);

    function tampilkanGrafikPerBulan(data) {
    const hargaDefault = {
        "Snack Biasa": 13000,
        "Snack Spesial": 25000,
        "Parcel Buah Biasa": 100000,
        "Parcel Buah Spesial": 150000,
        "Aqua botol 330 ml": 50000,
        "Aqua botol 600 ml": 55000,
        "Pempek": 6000,
        "Kopi": 10000,
        "Teh": 10000,
        "Aqua Cup 220 ml": 40000,
        "Wedang Jahe": 10000,
        "MK Spesial": 25000,
        "Nasi Liwet": 35000,
        "Ayam Bakar": 35000,
        "Prasmanan": 35000,
        "Bubur Jubaidah": 9500
    };

    let labels = data.labels;
    const datasets = [];

    for (const [jenis, values] of Object.entries(data.datasets)) {
        datasets.push({
            label: jenis,
            data: values.data,
            harga: values.harga,
            backgroundColor: getRandomColor()
        });
    }

    for (let i = labels.length - 1; i >= 0; i--) {
        const totalPerBulan = datasets.reduce((sum, ds) => sum + ds.data[i], 0);
        if (totalPerBulan === 0) {
            labels.splice(i, 1);
            datasets.forEach(ds => ds.data.splice(i, 1));
        }
    }

    let totalSeluruhHarga = 0;
    datasets.forEach(ds => {
        const hargaPerItem = ds.harga !== null ? ds.harga : (hargaDefault[ds.label] || 0);
        const totalPerJenis = ds.data.reduce((sum, jumlah) => sum + (jumlah * hargaPerItem), 0);
        totalSeluruhHarga += totalPerJenis;
    });

    const judulGrafik = `Grafik Snack & MK Spesial | Total: Rp ${totalSeluruhHarga.toLocaleString('id-ID')}`;

    const maxValue = Math.max(0, ...datasets.flatMap(ds => ds.data));
    const yMax = maxValue + 1;

    const ctx = document.getElementById('dailyMothlyDeptChartSnack').getContext('2d');


    if (window.dailyMothlyDeptChartSnack instanceof Chart) {
        window.dailyMothlyDeptChartSnack.destroy();
    }

    if (labels.length === 0) {
        alert('Data tidak ditemukan untuk periode tersebut!');
        return;
    }

    // Buat chart baru
    window.dailyMothlyDeptChartSnack = new Chart(ctx, {
        type: 'bar',
        data: { labels, datasets },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: judulGrafik,
                    font: { size: 18 },
                        padding: {
                        top: 0,
                        bottom: 50
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const jumlah = context.raw;
                            const jenis = context.dataset.label;
                            const hargaDb = context.dataset.harga;
                            const hargaValue = hargaDb !== null ? hargaDb : (hargaDefault[jenis] || 0);
                            const total = jumlah * hargaValue;
                            return `${jumlah}x | Rp ${total.toLocaleString('id-ID')} | ${jenis}`;
                        }
                    }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: function (value, context) {
                        if (value > 0) {
                            const jenis = context.dataset.label;
                            const hargaDb = context.dataset.harga;
                            const hargaValue = hargaDb !== null ? hargaDb : (hargaDefault[jenis] || 0);
                            const total = value * hargaValue;
                            return `${jenis}\n${value}x | Rp ${total.toLocaleString('id-ID')}`;
                        }
                        return '';
                    },
                    font: { weight: 'bold' },
                    display: context => context.dataset.data.length > 0
                },
                legend: { display: false }
            },
            scales: {
                x: { display: labels.length > 0 },
                y: {
                    beginAtZero: true,
                    max: yMax,
                    ticks: { precision: 0 }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}


    ambilDataSnackPerBulan();

    function getRandomColor() {
        const colors = [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)'
        ];
        return colors[Math.floor(Math.random() * colors.length)];
    }
});


</script>

@endsection
