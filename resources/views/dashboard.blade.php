@extends('layouts.main')

@section('contents')
@include('layouts.sidebar')
<div class="page-heading">
    <h3>Dashboard</h3>
</div>
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="row">
        <!-- Card 1 -->
        @if(auth()->user()->role === "admin") <!-- Role 1 untuk Admin -->
        <div class="col-6 col-lg-3 col-md-6">
            <a href="/users" class="card text-decoration-none">
                <div class="card-body text-center py-4">
                    <i class="bi bi-person-lines-fill fs-1"></i>
                    <h6 class="mt-3 text-muted font-semibold">Data User</h6>
                </div>
            </a>
        </div>
        @endif
    
        <!-- Card 2 -->
        <div class="col-6 col-lg-3 col-md-6">
            <a href="/monitoring" class="card text-decoration-none">
                <div class="card-body text-center py-4">
                    <i class="bi bi-speedometer2 fs-1"></i>
                    <h6 class="mt-3 text-muted font-semibold">Monitoring</h6>
                </div>
            </a>
        </div>
    
        <!-- Card 3 -->
        <div class="col-6 col-lg-3 col-md-6">
            <a href="/prediksi-penyiraman" class="card text-decoration-none">
                <div class="card-body text-center py-4">
                    <i class="bi bi-calendar2-week fs-1"></i>
                    <h6 class="mt-3 text-muted font-semibold">Prediksi Penyiraman</h6>
                </div>
            </a>
        </div>
    
        <!-- Card 4 -->
        <div class="col-6 col-lg-3 col-md-6">
            <form id="logout-form" action="/logout" method="post" class="card text-decoration-none">
                @csrf
                <button type="button" onclick="confirmLogout()" class="card-body text-center py-4 btn btn-link text-dark">
                    <i class="bi bi-box-arrow-right fs-1"></i>
                    <h6 class="mt-3 text-muted font-semibold">Logout</h6>
                </button>
            </form>
        </div>
    </div>
</div>


<script>
    function confirmLogout() {
        if (confirm('Apakah Anda yakin ingin keluar?')) {
            document.getElementById('logout-form').submit();
        }
    }
</script>
@endsection
