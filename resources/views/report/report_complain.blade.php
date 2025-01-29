@extends('include/mainlayout')
@section('title', 'Laporan Complain')
@section('content')
    <div class="pagetitle">
        <h1>Laporan Digital Complain</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Laporan Digital Complain</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fa-solid fa-square-poll-vertical"></i> Laporan Digital Complain</h5>

                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('report.index') }}" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="Start Date">
                                </div>
                                <div class="col-md-4">
                                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="End Date">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>

                        <!-- Tombol Ekspor -->
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('report.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-success btn-sm">
                                <i class="bi bi-file-earmark-excel"></i> Ekspor ke Excel
                            </a>
                        </div>


                        <!-- Tabel -->
                        <table class="table dt_complain" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Departemen</th>
                                    <th>Tanggal</th>
                                    <th>Area</th>
                                    <th>Gedung</th>
                                    <th>Lokasi</th>
                                    <th>Permasalahan</th>
                                    <th>Foto Deviasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($complainData as $index => $complain)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $complain->nama }}</td>
                                        <td>{{ $complain->departemen }}</td>
                                        <td>{{ $complain->tanggal }}</td>
                                        <td>{{ $complain->area }}</td>
                                        <td>{{ $complain->gedung }}</td>
                                        <td>{{ $complain->lokasi }}</td>
                                        <td>{{ $complain->permasalahan }}</td>
                                        <td>
                                            @if(Storage::exists('public/' . $complain->foto_deviasi))
                                                <img src="{{ Storage::url('public/' . $complain->foto_deviasi) }}" alt="Foto Deviasi" style="max-width: 100px; max-height: 100px;">
                                            @else
                                                Tidak ada gambar
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
