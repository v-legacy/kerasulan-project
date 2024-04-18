@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="d-inline card-title">{{ $title }}</h4>
                    @if (DB::table('predicted')->count() == 0)
                        <p class="d-inline alert-warning"><i class="icon-info"></i> Data Training Belum
                            dilakukan
                        </p>
                    @endif
                    @if (session()->has('failed'))
                        <div class="alert alert-danger text-danger font-weight-bold" role="alert">
                            {{ session('failed') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success text-success font-weight-bold" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('recruitments.import') }}" method="POST" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-between mt-2">
                            <div class="col-md-8">
                                <a href="{{ route('recruitments.create') }}" class="btn btn-dark btn-sm mb-2"><i
                                        class="icon-plus"></i> Add
                                    Data</a>
                                @if (\DB::table('predicted')->count() > 0)
                                    <a href="{{ route('recruitments.process') }}" class="btn btn-info btn-sm mb-2"><i
                                            class="icon-check"></i>
                                        Process
                                    </a>
                                @else
                                    <a href="#" class="btn btn-secondary btn-sm mb-2"><i class="icon-check"></i>
                                        Process
                                    </a>
                                    Data Training Belum dilakukan
                                @endif

                            </div>
                            <div class="input-group col-md-3">
                                <input type="file" class="form-control form-control-sm" placeholder="Upload File"
                                    name="file">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-dark btn-sm" type="submit">Upload</button>
                                </span>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Nama </th>
                                <th> Pecah Suara </th>
                                <th> Audio Video </th>
                                <th> Bidang </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $dt)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $dt->nama }} </td>
                                    <td> {{ $dt->pecah_suara }} </td>
                                    <td> {{ $dt->audio_video }} </td>
                                    <td> {{ $dt->bidang }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
