<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scholarship Management System - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* 1. Reset body to take up full height */
        body, html {
            height: 100%;
            margin: 0;
            background-color: #f8f9fa;
        }
        
        /* 2. The Full-Screen Background Image */
        .hero-section {
            /* I added a placeholder image of graduates. You can replace this URL with your own image later! */
            background-image: url('/images/graduate.jpg'); 
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
        }

        /* 3. Dark semi-transparent overlay so the white text is readable */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* 70% dark */
            z-index: 1;
        }

        /* 4. Keep our text and form above the dark overlay */
        .content-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        /* 5. Styling the Login Card to look premium */
        .login-card {
            background-color: rgba(255, 255, 255, 0.95); /* Slightly see-through white */
            border-radius: 12px;
            border: none;
            border-top: 6px solid #8b0000; /* Dark red accent from your screenshot */
        }

        /* 6. Custom Red Button */
        .btn-custom-red {
            background-color: #8b0000;
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-custom-red:hover {
            background-color: #660000;
            color: white;
            transform: translateY(-2px);
        }

        /* 7. Typography matching the screenshot */
        .hero-title {
            font-weight: 900;
            font-style: italic;
            letter-spacing: 1px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }
    </style>
</head>
<body>

    <!-- Optional: A simple top Navbar to complete the look -->
    <nav class="navbar navbar-expand-lg py-3 fixed-top z-3" style="background-color: rgba(255,255,255,0.95);">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark" href="#">
                <span style="color: #8b0000;">St. Cecilia's</span> Scholarship SYSTEM
            </a>
        </div>
    </nav>

    <!-- The Main Background Section -->
    <div class="hero-section">
        <div class="overlay"></div> <!-- The dark tint -->
        
        <div class="container content-wrapper mt-5">
            <div class="row align-items-center justify-content-between">
                
                <!-- LEFT SIDE: The Inspiring Quote -->
                <div class="col-lg-6 text-white text-center text-lg-start mb-5 mb-lg-0">
                    <h1 class="display-4 hero-title mb-4">"CHALLENGES MINDS...<br>MOVES HEARTS...<br>CHANGES LIVES"</h1>
                    <p class="lead fw-normal mb-4" style="color: #e0e0e0;">
                        Empowering students to reach their full potential through transformative education and community support.
                    </p>
                </div>

                <!-- RIGHT SIDE: Your Login Form -->
                <div class="col-lg-5">
                    <div class="card shadow-lg login-card">
                        <div class="card-body p-5">
                            <h3 class="mb-1 text-center fw-bold text-dark">Welcome Back</h3>
                            <p class="text-muted text-center mb-4">Login to your scholarship portal</p>

                            <!-- Laravel Alerts -->
                            @if ($errors->any())
                                <div class="alert alert-danger">{{ $errors->first() }}</div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form method="POST" action="{{ route('login.submit') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label text-dark fw-semibold">Email Address</label>
                                    <input type="email" name="email" class="form-control form-control-lg bg-light" value="{{ old('email') }}" placeholder="student@example.com" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label text-dark fw-semibold">Password</label>
                                    <input type="password" name="password" class="form-control form-control-lg bg-light" placeholder="••••••••" required>
                                </div>
                                
                                <div class="mb-4 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                                        <label class="form-check-label text-dark" for="remember">Remember me</label>
                                    </div>
                                    <a href="#" class="text-decoration-none" style="color: #8b0000; font-size: 0.9em;">Forgot Password?</a>
                                </div>
                                
                                <button type="submit" class="btn btn-custom-red btn-lg w-100 fw-bold rounded-1">LOGIN NOW</button>
                                
                                <!-- Added the Register Link here! -->
                                <div class="mt-4 text-center">
                                    <p class="mb-0 text-dark">Don't have an account? 
                                        {{-- Update 'register' to your actual route name if it's different --}}
                                        <a href="{{ url('/register') }}" class="text-decoration-none fw-bold" style="color: #8b0000;">Register Here</a>
                                    </p>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>