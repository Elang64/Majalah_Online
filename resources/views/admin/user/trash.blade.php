@extends('templates.app')

@section('content')
    <div class="container mt-5">
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <h5 class="mt-3">Data Pengguna Admin  </h5>
        <table class="table table-bordered">
            <tr class="text-center">
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
            @foreach ($userTrash as $index => $item)
                <tr>
                    <th class="text-center">{{ $index + 1 }}</th>
                    <th>{{ $item['name'] }}</th>
                    <th>{{ $item['email'] }}</th>
                    <th class="fw-bold" style="font-size: 0.655rem;">
                        @if ($item['role'] == 'admin')
                            <span class="alert alert-primary  py-1 px-2 m-0 d-inline-block">admin</span>
                        @endif
                    </th>

                    <th class="d-flex justify-content-center">
                        <form action="{{ route('admin.users.restore', $item->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success mx-2">Kembalikan</button>
                        </form>

                        <form action="{{route('admin.users.delete_permanent', $item->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </th>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
