<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title', 'Admin Growdesa')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    <!-- Type -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <style>
            :root {
                --green-900: #1B4D20;
                --green-800: #1F5A24;
                --green-700: #2E7D32;
                --green-600: #3C8E41;
                --gold-500: #D4A017;
                --gold-600: #B8860F;
                --cream-50: #FBF9F3;
                --ink-900: #1C2B1F;
                --ink-600: #57685A;
                --ink-400: #8A968C;
                --danger: #D14343;
            }

            html, body {
                height: 100%;
            }

            body {
                font-family: 'Inter', -apple-system, sans-serif;
                background:
                    linear-gradient(135deg, transparent 48%, rgba(255,255,255,.05) 49%, rgba(255,255,255,.05) 51%, transparent 52%),
                    linear-gradient(45deg, transparent 48%, rgba(255,255,255,.05) 49%, rgba(255,255,255,.05) 51%, transparent 52%),
                    radial-gradient(120% 120% at 15% 0%, var(--green-600) 0%, var(--green-700) 45%, var(--green-900) 100%);
                background-size: 42px 42px, 42px 42px, 100% 100%;
                background-attachment: fixed;
                min-height: 100vh;
            }

            .section {
                min-height: 100vh;
                display: flex;
                align-items: center;
            }

            .login-wrap {
                width: 100%;
                max-width: 440px;
                margin: 0 auto;
                animation: rise .55s cubic-bezier(.2,.7,.3,1) both;
            }

            @keyframes rise {
                from { opacity: 0; transform: translateY(14px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @media (prefers-reduced-motion: reduce) {
                .login-wrap { animation: none; }
            }

            /* ---- Dual logo header ---- */
            .brand-row {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 18px;
                margin-bottom: 22px;
            }

            .brand-badge {
                width: 74px;
                height: 74px;
                border-radius: 50%;
                background: var(--cream-50);
                border: 3px solid rgba(255,255,255,.55);
                box-shadow: 0 8px 20px rgba(0,0,0,.18);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 10px;
            }

            .brand-badge img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .brand-divider {
                width: 1px;
                height: 40px;
                background: rgba(255,255,255,.4);
                position: relative;
            }

            .brand-divider::after {
                content: '×';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: var(--gold-500);
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-weight: 700;
                font-size: 18px;
                background: transparent;
            }

            .brand-caption {
                text-align: center;
                color: rgba(255,255,255,.85);
                font-size: 12.5px;
                font-weight: 600;
                letter-spacing: .12em;
                text-transform: uppercase;
                margin-bottom: 28px;
            }

            /* ---- Card ---- */
            .card-primary {
                border: none;
                border-radius: 18px;
                overflow: hidden;
                box-shadow: 0 24px 55px rgba(0,0,0,.28);
                background: var(--cream-50);
            }

            .tumpal-strip {
                display: block;
                width: 100%;
                height: 14px;
            }

            .card-primary .card-header {
                background: transparent;
                border: none;
                padding: 34px 36px 16px;
                text-align: center;
            }

            .card-primary .card-header h4 {
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-size: 22px;
                font-weight: 800;
                color: var(--ink-900);
                margin: 0;
                letter-spacing: .01em;
            }

            .card-primary .card-body {
                padding: 10px 36px 34px;
            }

            .card-primary .form-group {
                margin-bottom: 22px;
            }

            .card-primary .form-group:last-child {
                margin-bottom: 0;
            }

            .card-primary label {
                display: block;
                font-size: 13px;
                font-weight: 700;
                color: var(--ink-900);
                letter-spacing: .01em;
                margin-bottom: 8px;
            }

            .input-icon-group {
                display: flex;
                align-items: center;
                border: 1.5px solid #DDE3DA;
                border-radius: 10px;
                background: #fff;
                overflow: hidden;
                transition: border-color .15s ease, box-shadow .15s ease;
            }

            .input-icon-group:focus-within {
                border-color: var(--green-700);
                box-shadow: 0 0 0 3px rgba(46, 125, 50, .16);
            }

            .input-icon-group.is-invalid {
                border-color: var(--danger);
            }

            .input-icon-group .field-icon {
                width: 44px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--ink-400);
                font-size: 15px;
            }

            .card-primary .form-control {
                flex: 1;
                min-width: 0;
                font-size: 15.5px;
                color: var(--ink-900);
                height: 48px;
                padding-left: 4px !important;
                padding-right: 16px;
                border: none;
                border-radius: 0;
                background: transparent;
                box-shadow: none !important;
                outline: none !important;
            }

            .card-primary .form-control::placeholder {
                color: var(--ink-400);
            }

            .card-primary .invalid-feedback {
                font-size: 13px;
                font-weight: 500;
                margin-top: 6px;
            }

            .password-toggle {
                flex-shrink: 0;
                width: 40px;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                background: none;
                border: none;
                color: var(--ink-400);
                font-size: 14px;
                cursor: pointer;
            }

            .password-toggle:hover {
                color: var(--ink-600);
            }

            .card-primary .btn-primary {
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-size: 16px;
                font-weight: 700;
                letter-spacing: .01em;
                height: 50px;
                border: none;
                border-radius: 10px;
                background: linear-gradient(135deg, var(--green-700), var(--green-900));
                transition: transform .12s ease, box-shadow .12s ease, filter .12s ease;
                margin-top: 6px;
            }

            .card-primary .btn-primary:hover {
                filter: brightness(1.06);
                transform: translateY(-1px);
                box-shadow: 0 10px 22px rgba(27, 77, 32, .35);
            }

            .card-primary .btn-primary:focus-visible,
            .card-primary .form-control:focus-visible {
                outline: 3px solid var(--gold-500);
                outline-offset: 2px;
            }

            .simple-footer {
                font-size: 13px;
                color: rgba(255,255,255,.75);
                font-weight: 500;
                text-align: center;
                margin-top: 22px;
            }

            @media (max-width: 480px) {
                .brand-badge { width: 62px; height: 62px; }
                .card-primary .card-header,
                .card-primary .card-body { padding-left: 24px; padding-right: 24px; }
            }
        </style>

        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="login-wrap">

                            <!-- Dua logo berdampingan: Kabupaten Takalar x GrowDesa -->
                            <div class="brand-row">
                                <div class="brand-badge">
                                    <img src="{{ asset('assets/img/logo_takalar.png') }}" alt="Logo Kabupaten Takalar">
                                </div>
                                <div class="brand-divider"></div>
                                <div class="brand-badge">
                                    <img src="{{ asset('assets/img/logo_gd.jpeg') }}" alt="Logo GrowDesa">
                                </div>
                            </div>
                            <p class="brand-caption">Pemerintah Kabupaten Takalar &middot; GrowDesa</p>

                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>Login Admin</h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('admin.login.post') }}" class="needs-validation"
                                        novalidate>
                                        @csrf

                                        <!-- Email -->
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <div class="input-icon-group @error('email') is-invalid @enderror">
                                                <i class="fas fa-envelope field-icon"></i>
                                                <input id="email" type="email"
                                                    class="form-control" name="email"
                                                    value="{{ old('email') }}" placeholder="nama@instansi.go.id"
                                                    tabindex="1" required autofocus>
                                            </div>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Password -->
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <div class="input-icon-group @error('password') is-invalid @enderror">
                                                <i class="fas fa-lock field-icon"></i>
                                                <input id="password" type="password"
                                                    class="form-control" name="password"
                                                    placeholder="Masukkan password" tabindex="2" required>
                                                <button type="button" class="password-toggle" id="togglePassword" tabindex="-1" aria-label="Tampilkan password">
                                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Button -->
                                        <div class="form-group mb-0">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                                Login
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="simple-footer">
                                Copyright &copy; growdesa 2026
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraries -->
    <script src="{{ asset('assets/modules/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/modules/chart.min.js') }}"></script>
    <script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/index.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        if (togglePassword) {
            togglePassword.addEventListener('click', function () {
                const isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';
                toggleIcon.classList.toggle('fa-eye');
                toggleIcon.classList.toggle('fa-eye-slash');
                togglePassword.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
            });
        }
    </script>

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '{{ session('error') }}',
                confirmButtonColor: '#e3342f'
            });
        </script>
    @endif

</body>

</html>
