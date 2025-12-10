@extends('templates.app')

@section('content')
    <div class="w-75 d-block mx-auto p-3 mt-5 m-3 shadow-3-strong">
        <span>Pengguna / Data / Tambah</span>
    </div>

    <div class="w-75 d-block mx-auto p-4 shadow-4-strong">
        <h5 class="text-center mb-3">Buat Data Staff</h5>

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Nama</label>
                <input type="text" name="name" id="name"
                    class="form-control @error('name') is-invalid
                @enderror">
                @error('name')
                    <small class="text-danger">{{ $message }} </small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Email</label>
                <input type="email" name="email" id="email"
                    class="form-control @error('email') is-invalid
                @enderror">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Password</label>
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid
                @enderror">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary fs-6">BUAT</button>
            </div>
        </form>
    </div>
@endsection
