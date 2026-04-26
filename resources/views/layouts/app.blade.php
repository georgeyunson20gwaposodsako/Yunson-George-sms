<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Scholarship Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row min-vh-100">
            <aside class="col-md-3 col-lg-2 bg-dark text-white p-3">
                <h5 class="mb-4">SMS</h5>

                @if(auth()->user()->role === 'admin')
                    <a class="d-block text-white text-decoration-none mb-2" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a class="d-block text-white text-decoration-none mb-2" href="{{ route('admin.applicants') }}">Applicants</a>
                    <a class="d-block text-white text-decoration-none mb-2" href="{{ route('admin.secretaries') }}">Secretary Users</a>
                @else
                    <a class="d-block text-white text-decoration-none mb-2" href="{{ route('secretary.dashboard') }}">Dashboard</a>
                    <a class="d-block text-white text-decoration-none mb-2" href="{{ route('secretary.applicants') }}">Applicants</a>
                    <a class="d-block text-white text-decoration-none mb-2" href="{{ route('secretary.applicants.create') }}">Add Applicant</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </aside>
            <main class="col-md-9 col-lg-10 p-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
