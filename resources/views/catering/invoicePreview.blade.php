@extends('include/mainlayout')
@section('title', 'Catering')
@section('content')

<div class="container">
    <h2>Invoice Catering WASTU</h2>

    <!-- Filter Tanggal -->
    <form method="GET" action="{{ route('invoice.index') }}">
        <div class="row">
            <div class="col-md-3">
                <label for="month">Bulan:</label>
                <select name="month" id="month" class="form-control">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ request('month', date('m')) == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-3">
                <label for="year">Tahun:</label>
                <select name="year" id="year" class="form-control">
                    @for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++)
                        <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <a href="{{ route('invoice.export', ['month' => request('month'), 'year' => request('year')]) }}" class="btn btn-warning">
                    Export Invoice
                </a>
            </div>
        </div>
    </form>

    <!-- Tampilan Word di Canvas -->
    {{-- <div class="mt-3">
        <h4>Preview Invoice</h4>
        <div id="word-container" class="border p-3 d-flex justify-content-center align-items-center text-center"
         style="min-height: 400px; background: #f8f9fa;">
    </div>
    </div> --}}

    <!-- Tampilan Word di Canvas -->
@if (!empty($data))
<div class="mt-3">
    <h4>Preview Invoice</h4>
    <div id="word-container" class="border p-3 d-flex justify-content-center align-items-center text-center"
         style="min-height: 400px; background: #f8f9fa;">
    </div>
</div>

<!-- Mammoth.js hanya dijalankan jika data ada -->
<script src="https://unpkg.com/mammoth/mammoth.browser.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("{{ asset('storage/' . $fileName) }}")
            .then(response => response.arrayBuffer())
            .then(data => mammoth.convertToHtml({arrayBuffer: data}))
            .then(result => {
                document.getElementById("word-container").innerHTML = result.value;
            })
            .catch(error => {
                document.getElementById("word-container").innerHTML = "Gagal memuat dokumen.";
                console.error("Error loading document:", error);
            });
    });
</script>
@else
<div class="alert alert-warning mt-4">
    Data invoice tidak ditemukan untuk bulan dan tahun yang dipilih.
</div>
@endif



</div>

<!-- Mammoth.js -->
{{-- <script src="https://unpkg.com/mammoth/mammoth.browser.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ asset('storage/invoice_preview.docx') }}") // Path ke file Word
            .then(response => response.arrayBuffer()) // Ambil file dalam bentuk binary
            .then(data => {
                return mammoth.convertToHtml({arrayBuffer: data});
            })
            .then(result => {
                document.getElementById("word-container").innerHTML = result.value;
            })
            .catch(error => console.error("Error loading document:", error));
    });
</script> --}}

@endsection
