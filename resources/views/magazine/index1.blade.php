@extends('templates.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Majalah Saya</h3>

    @if($purchasedMagazines->isEmpty())
         <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        Anda belum membeli majalah apapun.
        <a href="{{ route('home.magazines.all') }}" class="alert-link">Lihat semua majalah</a>
    </div>
    @else
        <div class="list-group">
            @foreach($purchasedMagazines as $magazine)
            <div class="list-group-item">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img src="{{ asset('storage/' . $magazine->cover) }}"
                             width="80" height="100"
                             style="object-fit: cover;"
                             class="rounded">
                    </div>
                    <div class="col">
                        <h6 class="mb-1">{{ $magazine->title }}</h6>
                        <small class="text-muted">
                            {{ $magazine->category }} • {{ $magazine->publication_year }}
                        </small>
                    </div>
                    <div class="col-auto">
                        <div class="btn-group">
                            <a href="{{ route('magazines.detail', $magazine->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($magazine->file_path)
                            <a href="{{ asset('storage/' . $magazine->file_path) }}"
                               class="btn btn-sm btn-success" download>
                                <i class="fas fa-download"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $purchasedMagazines->links() }}
        </div>
    @endif
</div>
@endsection

