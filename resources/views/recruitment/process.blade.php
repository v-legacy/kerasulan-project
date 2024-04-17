@extends('layouts.master')
@section('content')
    <div class="row mb-2">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $title }}</h4>


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

                    <form action="{{ route('data-training.import') }}" method="POST" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-between">
                            <div class="col-md-2">
                                <a href="#predicted" class="btn btn-dark btn-sm float-left">Prediksi Nilai Baru</a>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Nama </th>
                                <th> X1 </th>
                                <th> X2 </th>
                                <th> V </th>
                                <th> Luaran Y </th>
                                <th> Y </th>
                                <th> Error </th>
                                <th> W-1 Baru </th>
                                <th> W-2 Baru </th>
                                <th> Delta W-1</th>
                                <th> Delta W-2 </th>
                            </tr>
                        </thead>
                        <tbody>
                            <style>
                                .bg-green-light {
                                    background-color: #b3fcbd;
                                }

                                .bg-danger-light {
                                    background-color: #fcb3b3;
                                }
                            </style>
                            @foreach ($results as $key => $result)
                                <tr class="{{ $key % 2 == 0 ? 'bg-light' : 'bg-gray' }}">

                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $result['nama'] }} </td>
                                    <td> {{ $result['x1'] }} </td>
                                    <td> {{ $result['x2'] }} </td>
                                    <td> {{ $result['v'] }} </td>
                                    @if ($result['y_luaran'] != $result['y_target'])
                                        <td class="bg-danger-light"> {{ $result['y_luaran'] }} </td>
                                        <td class="bg-danger-light"> {{ $result['y_target'] }} </td>
                                    @else
                                        <td class="bg-green-light"> {{ $result['y_luaran'] }} </td>
                                        <td class="bg-green-light"> {{ $result['y_target'] }} </td>
                                    @endif
                                    <td> {{ $result['error'] }} </td>
                                    <td> {{ $result['w1_baru'] }} </td>
                                    <td> {{ $result['w2_baru'] }} </td>
                                    <td> {{ $result['delta_w1'] }} </td>
                                    <td> {{ $result['delta_w2'] }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
