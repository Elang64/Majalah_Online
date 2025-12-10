@extends('templates.app')

@section('content')
    <div class="w-75 d-block mx-auto my-5">
        <form action="{{ route('admin.promos.store') }}" method="POST" >
             {{-- mengambil file secara utuh bukan hanya nama filenya saja --}}
            @csrf
            <div class="row mb-3">

                <div>
                    <label for="promo_code" class="form-label"> Kode Promo </label>
                    <input type="text" name="promo_code" id="promo_code" class="form-control @error('promo_code') is-invalid @enderror">
                    @error('promo_code')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label for="type" class="form-label"> Tipe Promo </label>
                    <select type="enum" name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                        <option value="">Pilih</option>
                        <option value="percent">%</option>
                        <option value="rupiah">Rupiah</option>
                    </select>
                    @error('type')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div>
                    <label for="discount" class="form-label"> Jumlah Potongan </label>
                    <input type="number" name="discount" id="discount" class="form-control @error('discount') is-invalid @enderror">
                    @error('discount')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            </div>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
    </div>
@endsection
 {{-- for,name,id menyesuaikan fillable di MODEL --}}
