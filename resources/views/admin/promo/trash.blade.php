@extends('templates.app')

@section('content')
    <div class="container-main mt-5">
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.promos.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <h5 class="mt-3">Data Promo</h5>
        <table class="table table-bordered ">
            {{-- jika ingin seperti sebelumnya hapus class di tr nya --}}
            <tr class="text-center">
                <th>No</th>
                <th>Kode Promo</th>
                <th>Total Potongan</th>
                <th>Aksi</th>
            </tr>
            @foreach ($promoTrash as $index => $item)
                <tr>
                    <th class="text-center">{{ $index + 1 }}</th>
                    <th>{{ $item['promo_code'] }}</th>
                    <th>
                        @if ($item['type'] == 'percent')
                            {{ $item['discount'] }}%
                        @else
                            Rp {{ number_format($item['discount'], 0, ',', '.') }}
                        @endif
                    </th>

                    <th class="d-flex">
                        <form action="{{route('admin.promos.restore', $item->id)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button
                            class="btn btn-success mx-2">Kembalikan</button>
                        </form>

                        <form action="{{route('admin.promos.delete_permanent', $item->id)}}" method="POST">
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
