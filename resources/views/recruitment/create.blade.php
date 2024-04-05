@extends('layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ $title }}</h4>
                    @if (session('failed'))
                        <div class="alert alert-danger text-danger font-weight-bold" role="alert">
                            {{ session('failet') }}
                        </div>
                    @endif
                    <form class="forms-sample" method="POST" action="{{ route('recruitments.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik"
                                placeholder="Nomor Induk Kependudukan">
                        </div>
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" placeholder="Nama Lengkap"
                                name="nama_lengkap">
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input type="text" class="form-control" id="pekerjaan" placeholder="Pekerjaan"
                                name="pekerjaan">
                        </div>
                        <div class="form-group">
                            <label for="umur">Umur</label>
                            <input type="number" class="form-control" id="umur" placeholder="21" name="umur">
                        </div>
                        <div class="form-group">
                            <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                            <select class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir">
                                <option>SD</option>
                                <option>SMP</option>
                                <option>SMA/SLTA</option>
                                <option>Sarjana</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="no_telp">No Telp</label>
                            <input type="text" class="form-control" id="no_telp" placeholder="081299229"
                                name="no_telp">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="4"></textarea>
                        </div>

                        <button type="submit" class="btn btn-sm btn-dark mr-2">Submit</button>
                        <button class="btn btn-sm btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
