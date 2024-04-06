@extends('layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="card col-md-6">
            <div class="card-body">
                <div class="py-4">
                    <div class="d-flex align-items-center justify-content-around mb-2">
                        <span class="text-md"> Nama Lengkap </span>
                        <span class="text-md"> {{ $recruitment->nama_lengkap }} </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-around mb-2">
                        <span class="text-md"> NIK </span>
                        <span class="text-md"> {{ $recruitment->nik }} </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-around mb-2">
                        <span class="text-md"> Status </span>
                        <span class="text-md"> Active </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-around mb-2">
                        <span class="text-md"> Status </span>
                        <span class="text-md"> Active </span>
                    </div>
                    <div class="d-flex align-items-center justify-content-around mb-2">
                        <span class="text-md"> Status </span>
                        <span class="text-md"> Active </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
