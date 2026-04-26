<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scholarship Management - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html { height: 100%; margin: 0; background-color: #f8f9fa; }
        
        .hero-section {
            background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop'); 
            background-size: cover; background-position: center; min-height: 100vh; position: relative; display: flex; align-items: center;
        }
        .overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 1;
        }
        .content-wrapper { position: relative; z-index: 2; width: 100%; }
        
        .register-card {
            background-color: rgba(255, 255, 255, 0.95); border-radius: 12px; border: none; border-top: 6px solid #8b0000;
        }
        .btn-custom-red { background-color: #8b0000; color: white; border: none; transition: all 0.3s ease; }
        .btn-custom-red:hover { background-color: #660000; color: white; transform: translateY(-2px); }
    </style>
</head>
<body>

    <div class="hero-section">
        <div class="overlay"></div>
        
        <div class="container content-wrapper py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow-lg register-card">
                        <div class="card-body p-5">
                            <h3 class="mb-1 text-center fw-bold text-dark">Apply for a Scholarship</h3>
                            <p class="text-muted text-center mb-4">Create your applicant account</p>

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form method="POST" action="{{ route('register.submit') }}">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-dark fw-semibold">First Name</label>
                                        <input type="text" name="first_name" class="form-control bg-light @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-dark fw-semibold">Last Name</label>
                                        <input type="text" name="last_name" class="form-control bg-light @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required>
                                        @error('last_name')
                                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-dark fw-semibold">Email Address</label>
                                    <input type="email" name="email" class="form-control bg-light @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-dark fw-semibold">Password</label>
                                    <input type="password" name="password" class="form-control bg-light @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-dark fw-semibold">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control bg-light" required>
                                    </div>
                                
                                <button type="submit" class="btn btn-custom-red btn-lg w-100 fw-bold rounded-1">CREATE ACCOUNT</button>
                                
                                <div class="mt-4 text-center">
                                    <p class="mb-0 text-dark">Already have an account? 
                                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #8b0000;">Login Here</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>