<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Aplikasi Parkir')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">
        Aplikasi Parkir — {{ ucfirst(auth()->user()->role) }}
    </span>

    <div class="d-flex align-items-center">
        <span class="text-white me-3">
            {{ auth()->user()->nama_lengkap }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-outline-light">Logout</button>
        </form>
    </div>
</nav>

@section('content')

    <div class="card body p-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold mb-2">
                    Selamat Datang,
                    {{ auth()->user()->nama_lengkap }}!
                </h2>
                <p class="mb-0">
                    Kelola Data User, Tarif Parkir, Area Parkir, Kendaraan, dan Pantau Aktivitas Terbaru dengan mudah.
                </p>
            </div>
        </div>
    </div>

@endsection


<div class="container-fluid">
    <div class="row">

        <div class="col-md-2 bg-white min-vh-100 p-3">

            <div class="nav flex-column">

                @if(auth()->user()->role == 'admin')

                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link rounded mb-2 {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-dark' : 'text-dark' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('admin.user.index') }}"
                       class="nav-link rounded mb-2 {{ request()->routeIs('admin.user.*') ? 'bg-primary text-dark' : 'text-dark' }}">
                        Data User
                    </a>

                    <a href="{{ route('admin.tarif.index') }}"
                       class="nav-link rounded mb-2 {{ request()->routeIs('admin.tarif.*') ? 'bg-primary text-dark' : 'text-dark' }}">
                        Tarif Parkir
                    </a>

                    <a href="{{ route('admin.area.index') }}"
                       class="nav-link rounded mb-2 {{ request()->routeIs('admin.area.*') ? 'bg-primary text-dark' : 'text-dark' }}">
                        Area Parkir
                    </a>

                    <a href="{{ route('admin.kendaraan.index') }}"
                       class="nav-link rounded mb-2 {{ request()->routeIs('admin.kendaraan.*') ? 'bg-primary text-dark' : 'text-dark' }}">
                        Kendaraan
                    </a>

                    <a href="{{ route('admin.log.index') }}"
                       class="nav-link rounded mb-2 {{ request()->routeIs('admin.log.*') ? 'bg-primary text-dark' : 'text-dark' }}">
                        Log Aktivitas
                    </a>

                @elseif(auth()->user()->role == 'petugas')

                    <a href="{{ route('petugas.dashboard') }}"
                       class="nav-link rounded mb-2 {{ request()->routeIs('petugas.dashboard') ? 'bg-primary text-dark' : 'text-dark' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('petugas.transaksi.index') }}"
                       class="nav-link rounded mb-2 {{ request()->routeIs('petugas.transaksi.*') ? 'bg-primary text-dark' : 'text-dark' }}">
                        Transaksi
                    </a>

                @elseif(auth()->user()->role == 'owner')

                    <a href="{{ route('owner.dashboard') }}"
                       class="nav-link rounded mb-2 {{ request()->routeIs('owner.dashboard') ? 'bg-primary text-dark' : 'text-dark' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('owner.rekap.index') }}"
                       class="nav-link rounded mb-2 {{ request()->routeIs('owner.rekap.*') ? 'bg-primary text-dark' : 'text-dark' }}">
                        Rekap Transaksi
                    </a>

                @endif

            </div>
        </div>

        <div class="col-md-10 p-4">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')

        </div>

    </div>
</div>

</body>
</html>