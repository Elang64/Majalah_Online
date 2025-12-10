@extends('templates.app')

@section('content')
     <div class="w-75 d-block mx-auto p-3 mt-5 m-3 shadow-3-strong">
        <span>Pengguna / Data / Edit</span>
     </div>
    <div class="w-75 d-block mx-auto p-4 shadow-4-strong">

        <h5 class="text-center mb-3">Ubah Data Staff</h5>

        <form method="POST" action="{{route('admin.users.update', ['id' => $user['id']])}}">
            @csrf

            @method('PUT')
            <div class="mb-3">
                <label for="" class="form-label">Nama</label>
                <input type="text" name="name" id="name"
                    class="form-control @error('name') is-invalid
                @enderror"  value="{{ $user['name'] }}">
                @error('name')
                    <small class="text-danger">{{ $message }} </small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Email</label>
                <input type="email" name="email" id="email"
                    class="form-control @error('email') is-invalid
                @enderror" value="{{ $user['email'] }}">
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
            <div class="d-grid">
            <button type="submit" class="btn btn-primary fs-6">BUAT</button>
            </div>
        </form>
    </div>
@endsection
