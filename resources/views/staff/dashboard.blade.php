@extends('templates.app')

@section('content')
    <div class="container mt-5">
        <h5>Dashboard Petugas</h5>
        @if (Session::get('success'))
            <div class="alert alert-success">Selamat Datang, <b>{{Auth::user()->name}}</b></div>
        @endif
    </div>
@endsection
