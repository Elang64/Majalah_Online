@extends('templates.app')

@section('content')
    <!-- HERO SECTION -->
    <section class="hero">
        <!-- Alert Messages -->
        <div class="hero-alerts">
            @if (Session::get('success'))
                <div class="alert alert-success d-flex align-items-center gap-3 ">
                    <i class="fas fa-check-circle fa-2x"></i>
                    <div>
                        {{ Session::get('success') }}
                        @if (Auth::check())
                            <br><strong>Selamat Datang, {{  Auth::user()->name }}!</strong>
                        @endif
                    </div>
                </div>
            @endif

            @if (Session::get('logout'))
                <div class="alert alert-warning d-flex align-items-center gap-3">
                    <i class="fas fa-sign-out-alt fa-2x"></i>
                    <div>{{ Session::get('logout') }}</div>
                </div>
            @endif
        </div>

        <div class="hero-container">
            <!-- Left: Text + Icon -->
            <div class="hero-text">
                <h1>
                    <i class="fas fa-book-open-reader me-3 text-light"></i>
                    Selamat Datang di ModernMag
                </h1>
                <p>
                    <i class="fas fa-quote-left fa-lg me-2 opacity-75"></i>
                    Temukan artikel terbaru, inspiratif, dan mendalam dari berbagai kategori pilihan —
                    semuanya dalam satu tempat.
                    <i class="fas fa-quote-right fa-lg ms-2 opacity-75"></i>


                </p>
                @if (Auth::check() == 'user')
                    <div class="mt-4">
                        <a href="{{ route('home.magazines.all') }}"
                            class="btn btn-light btn-lg rounded-pill px-5 py-3 shadow-lg"
                            >
                            <i class="fas fa-book-open-reader me-2 fs-5"></i>
                            Jelajahi Majalah
                        </a>
                    </div>
                @endif

            </div>

            <!-- Right: Image -->
            <div class="hero-image">
                <img src="https://images.pexels.com/photos/1595391/pexels-photo-1595391.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                    alt="Orang sedang membaca majalah dengan nyaman">
            </div>


        </div>
    </section>

    <!-- Content below hero -->
    <div class="content-below">
        <div class="container">
            <div class="text-center py-5">
                <h2>
                    <i class="fas fa-fire text-danger me-3"></i>
                    Featured Articles
                </h2>
                <p class="text-muted">
                    <i class="fas fa-clock fa-spin me-2"></i>
                    Coming soon...
                </p>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <style>
        /* :root {
            --primary: #1B3C53;
            --secondary: #234C6A;
            --secondary-2: #456882;
            --light: #E3E3E3;
            --white: #ffffff;
        } */

        /* HERO SECTION */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: linear-gradient(135deg, #1B3C53 0%, #234C6A 45%, #456882 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 70% 30%, rgba(255, 255, 255, 0.18) 0%, transparent 50%);
            pointer-events: none;
            z-index: 1;
        }

        .hero-alerts {
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 0 2rem;
        }

        .hero-alerts .alert {
            max-width: 1280px;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            font-weight: 500;
        }

        .hero-container {
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .hero-text h1 {
            font-size: 4.8rem;
            font-weight: 900;
            line-height: 1.1;
            color: var(--light);
            margin-bottom: 1.8rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .hero-text p {
            font-size: 1.45rem;
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.7;
            max-width: 520px;
            font-weight: 300;
            margin-bottom: 2rem;
        }

        .hero-image img {
            width: 100%;
            max-width: 580px;
            height: auto;
            border-radius: 28px;
            box-shadow: 0 35px 90px rgba(0, 0, 0, 0.4);
            object-fit: cover;
        }

        .content-below {
            background: var(--white);
            padding-top: 3rem;
        }

          .btn-light {
            background: var(--light);
            border: 1px solid var(--light);
            color: var(--primary);
        }

        .btn-light:hover {
            background: transparent;
            border: 1px solid var(--light);
            color: white;
        }

        /* Responsive tetap sama seperti aslinya */
        @media (max-width: 992px) {
            .hero-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-text p {
                margin: 0 auto;
            }

            .hero-image {
                justify-content: center;
            }
        }
    </style>
@endpush
