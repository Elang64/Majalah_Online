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
            --shadow: 0 15px 40px rgba(44, 95, 125, 0.18);
            --shadow-hover: 0 20px 50px rgba(44, 95, 125, 0.25);
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

        /* Back Button */
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
            padding: 40px;
            transition: all 0.6s ease-in-out;
        }
        .signin-form { z-index: 2; }

        /* Input Styling */
        .input-field {
            position: relative;
            margin-bottom: 16px;
        }
        .input-field i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary);
            font-size: 1rem;
        }
        .input-field input {
            width: 100%;
            padding: 15px 20px 15px 52px;
            border: 2px solid #dfe6ed;
            border-radius: 50px;
            background: #f8fbff;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .input-field input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 5px rgba(44, 95, 125, 0.15);
        }

        h2 {
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--primary);
            text-align: center;
            margin-bottom: 8px;
        }
        .subtitle {
            color: #64748b;
            text-align: center;
            margin-bottom: 30px;
            font-size: 0.92rem;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 8px 25px rgba(44, 95, 125, 0.35);
        }
        .btn-submit:hover {
            background: #1e4a66;
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(44, 95, 125, 0.45);
        }

        /* Right Panel */
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
            padding: 40px;
            color: white;
            border-radius: 0 32px 32px 0;
        }
        .icon-large {
            font-size: 4.2rem;
            margin-bottom: 20px;
            opacity: 0.95;
        }
        .panel h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 14px;
        }
        .panel p {
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 32px;
            opacity: 0.92;
        }
        .btn-transparent {
            padding: 12px 48px;
            border: 2.5px solid white;
            background: transparent;
            color: white;
            border-radius: 50px;
            font-weight: 600;
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
            .form-control, .panel { position: relative; width: 100%; }
            .panel { border-radius: 32px 32px 0 0; order: -1; padding: 50px 30px; }
        }
        @media (max-width: 576px) {
            .container { border-radius: 24px; }
            .back-btn { top: 16px; left: 20px; font-size: 0.9rem; }
            h2 { font-size: 1.7rem; }
            .panel h3 { font-size: 1.5rem; }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Tombol Kembali -->
        <a href="{{ route('home') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>

        <!-- Background Decorative Elements -->
        <div class="bg-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>


        <div class="forms-container">
            <div class="form-control signin-form">
                <form method="POST" action="{{ route('signup.send_data') }}">
                      @csrf
                    <h2>Buat Akun Baru!</h2>
                    <p class="subtitle">Daftar untuk menikmati konten majalah secara penuh</p>


                    @if (Session::get('success'))
                        <div class="alert alert-success my-3">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::get('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif

                    <div class="row">
                        <div class="col">
                             @error('first_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div  data-mdb-ripple-init class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="First Name" name="first_name"
                                @error('first_name') is-invalid @enderror">
                        </div>
                        </div>


                        <div class="col">
                             @error('last_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div  data-mdb-ripple-init class="input-field">
                            <input type="text" placeholder="Last Name" name="last_name"
                                @error('last_name') is-invalid @enderror">
                        </div>
                        </div>

                    </div>

                    <!-- Email Input -->
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email Address" name="email"
                            @error('email') is-invalid @enderror>
                    </div>

                    <!-- Password Input -->
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div  data-mdb-ripple-init class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" class="password-input"
                            @error('password') is-invalid @enderror>

                    </div>
                    <!-- Submit Button -->
                    <button  data-mdb-ripple-init type="submit" class="btn-submit">Sign Up</button>

                </form>
            </div>
        </div>

        <!-- Side Panel with Info -->
        <div class="panels-container">
             <div class="panel right-panel">
                <div class="content">
                    <i class="fas fa-user-check icon-large"></i>
                    <h3>Sudah Punya Akun?</h3>
                    <p>Selamat datang kembali! Masuk untuk mengakses akun Anda dan menikmati berbagai konten majalah terbaru.</p>
                   <a href="{{route('login')}}">
                    <button class="btn-transparent" id="login-btn">Login</button>
                </a>
                </div>
            </div>
        </div>
    </div>


    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
</body>

</html>
