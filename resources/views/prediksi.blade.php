@extends('layouts.main')

@section('contents')
@include('layouts.sidebar')
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Penyiraman</h3>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data Penyiraman</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                {{-- <th>Suhu</th>
                                <th>Humidity</th>
                                <th>Soil</th> --}}
                                <th>Waktu Penyiraman</th>
                                <th>Selisih waktu (Jam)</th> <!-- Kolom Baru -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                {{-- <td>{{ $item->suhu }}</td>
                                <td>{{ $item->humidity }}</td>
                                <td>{{ $item->soil }}</td> --}}
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->time_difference }}</td> <!-- Tampilkan Selisih Waktu -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p><strong>Prediksi Waktu Penyiraman Selanjutnya:</strong> {{ $predictedNextWatering }}</p>
                </div>
            </div>
        </section>
    </div>

    @include('layouts.footer')
</div>
@endsection
