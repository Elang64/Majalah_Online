@extends('templates.app')

@section('content')
    <style>
        :root {
            --primary: #2c5f7d;
            --radius: 16px;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .magazine-card {
            max-width: 960px;
            margin: 3rem auto;
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card-header {
            background: var(--primary);
            color: white;
            padding: 1.25rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .card-body {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(44, 95, 125, 0.15);
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #e74c3c;
        }

        .btn {
            border-radius: 30px;
            padding: 0.7rem 2rem;
            font-weight: 600;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
        }

        .btn-primary:hover {
            background: #1e4a66;
        }


        .current-cover {
            margin-top: 0.5rem;
        }

        .current-cover img {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .magazine-card {
                margin: 1rem;
                border-radius: 12px;
            }

            .card-body {
                padding: 1.5rem;
            }

            .card-header {
                padding: 1rem 1.5rem;
                font-size: 1rem;
            }
        }
    </style>

    <div class="magazine-card">
        <div class="card-header">
            <a href="{{ route('admin.magazines.index') }}" style="color: white;">Data Petugas </a>\ Edit
        </div>

        <div class="card-body">


            <form method="POST" action="{{ route('admin.users.update', ['id' => $user['id']]) }}">
                @csrf

                @method('PUT')
                <div class="mb-3">
                    <label for="" class="form-label">Nama</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid
                @enderror"
                        value="{{ $user['name'] }}">
                    @error('name')
                        <small class="text-danger">{{ $message }} </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid
                @enderror"
                        value="{{ $user['email'] }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('email') is-invalid
                @enderror">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary fs-6">BUAT</button>

            </form>
        </div>
    </div>
@endsection
