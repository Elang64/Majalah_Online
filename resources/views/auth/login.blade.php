<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Majalah Online</title>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
   <style>
        :root {
            --primary: #2c5f7d;
            --secondary: #4a89ac;
            --light: #f8f9fa;
            --dark: #212529;
            --shadow: 0 15px 45px rgba(44, 95, 125, 0.2);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #e3edf7 0%, #d9e2ec 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            position: relative;
            width: 100%;
            max-width: 1100px;
            height: 620px;
            background: white;
            border-radius: 32px;
            box-shadow: var(--shadow);
            overflow: hidden;
            z-index: 1;
        }

        /* Tombol Kembali */
        .back-btn {
            position: absolute;
            top: 22px;
            left: 28px;
            z-index: 10;
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        .back-btn:hover {
            background: rgba(44, 95, 125, 0.12);
            color: var(--primary);
            transform: translateX(-4px);
        }

        /* Form Area */
        .form-control {
            position: absolute;
            top: 0; left: 0;
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 40px;
            background: white;
        }

        h2 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            text-align: center;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #64748b;
            text-align: center;
            margin-bottom: 35px;
            font-size: 0.95rem;
        }

        .input-field {
            position: relative;
            margin-bottom: 20px;
        }
        .input-field i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary);
            font-size: 1.1rem;
        }
        .input-field input {
            width: 100%;
            padding: 16px 20px 16px 56px;
            border: 2px solid #dfe6ed;
            border-radius: 50px;
            background: #f8fbff;
            font-size: 0.98rem;
            transition: all 0.3s ease;
        }
        .input-field input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 5px rgba(44, 95, 125, 0.15);
        }

        /* Alert */
        .alert {
            border-radius: 16px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.05rem;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 10px 30px rgba(44, 95, 125, 0.35);
        }
        .btn-submit:hover {
            background: #1e4a66;
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(44, 95, 125, 0.45);
        }

        /* Panel Kanan */
        .panel {
            position: absolute;
            top: 0; right: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 50px;
            color: white;
            border-radius: 0 32px 32px 0;
        }
        .icon-large {
            font-size: 4.5rem;
            margin-bottom: 22px;
            opacity: 0.95;
        }
        .panel h3 {
            font-size: 1.9rem;
            font-weight: 700;
            margin-bottom: 16px;
        }
        .panel p {
            font-size: 0.98rem;
            line-height: 1.7;
            margin-bottom: 35px;
            opacity: 0.92;
        }
        .btn-transparent {
            padding: 14px 50px;
            border: 2.5px solid white;
            background: transparent;
            color: white;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.4s ease;
        }
        .btn-transparent:hover {
            background: white;
            color: var(--primary);
            transform: scale(1.05);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .container { height: auto; min-height: 680px; }
            .form-control, .panel {
                position: relative;
                width: 100%;
            }
            .panel {
                border-radius: 32px 32px 0 0;
                order: -1;
                padding: 60px 40px;
            }
        }
        @media (max-width: 576px) {
            .container { border-radius: 24px; }
            .back-btn { top: 16px; left: 20px; }
            h2 { font-size: 1.8rem; }
            .panel h3 { font-size: 1.6rem; }
            .btn-submit { padding: 14px; font-size: 1rem; }
        }
    </style>
</head>

<body>
    <div class="container">
          <a href="{{route('home')}}" class="back-btn" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
        <!-- Background Decorative Elements -->
        <div class="bg-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>

        <!-- Forms Container -->
        <div class="forms-container">
            <div class="form-control signin-form">
                <form  method="POST" action="{{ route('auth') }}">
                    <h2>Selamat Datang Kembali!</h2>
                    <p class="subtitle">Masuk untuk terhubung dan menikmati konten majalah favorit Anda</p>

                    @csrf
                    @if (Session::get('success'))
                        <div class="alert alert-success my-3">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::get('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif


                    <!-- Email Input -->
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email Address" name="email"
                            @error('email') is-invalid @enderror">
                    </div>

                    <!-- Password Input with Show/Hide Toggle -->
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" class="password-input"
                        @error('password') is-invalid @enderror>
                    </div>

                    <!-- Remember Me & Forgot Password -->


                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">Login</button>

                </form>
            </div>


        </div>

        <!-- Side Panel with Info -->
        <div class="panels-container">

            <div class="panel right-panel">
                <div class="content">
                    <i class="fas fa-users-between-lines icon-large"></i>
                    <h3>Pengguna baru?</h3>
                    <p>Buat akun untuk mengakses dan membeli majalah.</p>

                       <a href="{{route('signup')}}"> <button class="btn-transparent" id="signup-btn"> Sign Up </button></a>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
</body>

</html>
