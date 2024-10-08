@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                <form action="{{route('update')}}" method="POST">
                    @csrf
                    <label for="code">Dealer Code:</label>
                    <input type="text" id="code" name="code" value="{{ session('data', '') }}">
                    <button type="submit">Search</button>
                </form></div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr class="table-secondary">
                                <th>Data</th>
                                <th>Code</th>
                                <th>Segment</th>
                                <th>AA</th>
                                <th>BB</th>
                                <th>CC</th>
                                <th>DD</th>
                                <th>EE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $value)
                            <tr>
                                <td> {{ data_get($value, 'Data') }}</td>
                                <td> {{ data_get($value, 'Code') }}</td>
                                <td> {{ data_get($value, 'Segment') }}</td>
                                <td> {{ data_get($value, 'AA') }}</td>
                                <td> {{ data_get($value, 'BB') }}</td>
                                <td> {{ data_get($value, 'CC') }}</td>
                                <td> {{ data_get($value, 'DD') }}</td>
                                <td> {{ data_get($value, 'EE') }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection