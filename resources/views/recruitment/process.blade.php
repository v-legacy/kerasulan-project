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
                                {{-- <a href="#predicted" class="btn btn-dark btn-sm float-left">Prediksi Nilai Baru</a> --}}
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
    <div class="row mb-2">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Confusion Matrix</h4>
                    <table class="table table-bordered text-center">
                        <thead>
                            <th></th>
                            <th>Positives</th>
                            <th>Negatives</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Positives</td>
                                <td>
                                    True Positives : {{ $matrix['truePositives'] }}
                                </td>
                                <td>
                                    False Positives : {{ $matrix['falsePositives'] }}
                                </td>
                            </tr>
                            <tr>
                                <td>Negatives</td>
                                <td>
                                    False Negatives : {{ $matrix['falseNegatives'] }}
                                </td>
                                <td>
                                    True Negatives : {{ $matrix['trueNegatives'] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Results</h4>
                    <div class="row justify-content-between">
                        <div class="col-md-4">
                            <div class="aligner-wrapper">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="myChart" height="546" width="782" class="chartjs-render-monitor"
                                    style="display: block; height: 273px; width: 391px;"></canvas>
                                <div class="wrapper d-flex flex-column justify-content-center absolute absolute-center">
                                    <h3 class="text-center mb-0 font-weight-bold text-sm">Results</h3>
                                    <small class="d-block text-center text-muted  font-weight-semibold mb-0">Total
                                    </small>
                                </div>
                            </div>
                        </div>
                        <style>
                            .bg-code {
                                background-color: #fafafa;
                            }
                        </style>
                        <div class="col-md-8 p-4 bg-code">
                            <div class="row justify-content-center text-center">
                                <div class="col-md-4">
                                    <div class="font-weight-bold">
                                        <h3>Accuracy</h3>
                                        <h6 class="my-4">Accuracy = TP + TN / (TP+TN+FP+FN)</h6>
                                        <hr class="mb-4">
                                        <h5 class="my-4">Accuracy =
                                            {{ $matrix['truePositives'] . ' + ' . $matrix['trueNegatives'] }} /
                                            (
                                            {{ $matrix['truePositives'] . ' + ' . $matrix['trueNegatives'] . ' + ' . $matrix['falsePositives'] . ' + ' . $matrix['falseNegatives'] }}
                                            )
                                        </h5>
                                        <h5 class="my-5">
                                            Accuracy = {{ $matrix['truePositives'] + $matrix['trueNegatives'] }} /
                                            {{ $matrix['truePositives'] + $matrix['trueNegatives'] + $matrix['falsePositives'] + $matrix['falseNegatives'] }}
                                            = {{ $akurate }}%
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="font-weight-bold">
                                        <h3>Precision</h3>
                                        <h5 class="my-4">Precision = TP / (TP + FP)</h5>
                                        <hr class="mb-4">
                                        <h5 class="my-4">Precision =
                                            {{ $matrix['truePositives'] }} /
                                            (
                                            {{ $matrix['truePositives'] . ' + ' . $matrix['falsePositives'] }}
                                            )
                                        </h5>
                                        <h5 class="my-5">
                                            Precision = {{ $matrix['truePositives'] }} /
                                            {{ $matrix['truePositives'] + $matrix['falsePositives'] }}
                                            = {{ $precision }}%
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="font-weight-bold">
                                        <h3>Recall</h3>
                                        <h5 class="my-4">Recall = TP / (TP + FN)</h5>
                                        <hr class="mb-4">
                                        <h5 class="my-4">Recall =
                                            {{ $matrix['truePositives'] }} /
                                            (
                                            {{ $matrix['truePositives'] . ' + ' . $matrix['falseNegatives'] }}
                                            )
                                        </h5>
                                        <h5 class="my-5">
                                            Recall = {{ $matrix['truePositives'] }} /
                                            {{ $matrix['truePositives'] + $matrix['falseNegatives'] }}
                                            = {{ $recall }}%
                                        </h5>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart');
        const data = {
            labels: [
                {!! json_encode($akurate) !!} + '%' + ' Accuracy', {!! json_encode($precision) !!} + '%' + ' Precision',
                {!! json_encode($recall) !!} + '%' + ' Recall'
            ],
            datasets: [{
                // label: 'My First Dataset',
                data: [{!! json_decode($akurate) !!}, {!! json_decode($precision) !!}, {!! json_decode($recall) !!}],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        };
        new Chart(ctx, {
            type: 'doughnut',
            data: data,

        });
    </script>
@endsection
