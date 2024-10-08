@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Job Listing Page</li>
                </ol>
            </nav>
            <div class="card">
                <!-- Display validation errors -->
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @foreach (['error', 'warning', 'success'] as $msg)
                @if(Session::has('reservematter-' . $msg))
                <div class="text-center alert-{{ $msg }}">
                    {{ Session::get('reservematter-' . $msg) }}
                </div>
                @endif
                @endforeach

                <div class="card-header bg-success text-white p-3">

                    <form action="{{route('jobsave')}}" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        @csrf
                        <div class="col-md-3">
                            <label for="code">New JobCode: </label> 
                            <input class="form-control" type="text" id="jobcard_no" name="jobcard_no" value="" required>
                        </div>

                        <div class="col-md-3">
                            <label for="code">Dept: </label>
                            <select class="form-select" name="dept" required >
                                <option value="Folded Cartoon">Folded Cartoon</option>
                                <option value="Corrugation">Corrugation</option>
                                <option value="Graviour">Graviour</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="code">Upload Image: </label>
                            <input class="form-control" type="file" id="upload" name="upload">
                        </div>
                        <div class="col-md-2 mt-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" style="font-size:10px !important;">
                            <thead>
                                <tr class="table-secondary">
                                    <th>#</th>
                                    <th>Jobcard No</th>
                                    <th>Original Image</th>
                                    <!-- <th>Dept</th> -->
                                    <th>View Details</th>
                                    <th>Date</th>
                                    <th>Uploaded By</th>
                                    <!-- <th>Delete</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data_arrays as $key => $data)
                                <tr>
                                    <td class="bg-secondary text-white">{{ $data->id }} </td>
                                    <td><a href="{{ route('jobdetail', ['id' => $data->jobcard_no]) }}" class="btn btn-outline-secondary">
                                            {{ $data->jobcard_no }}
                                        </a> </td>
                                    <td><a href="{{ asset('store') }}/{{ $data->jobcard_no }}/{{ $data->original_image }}" target="_blank"><img src="{{ asset('store') }}/{{ $data->jobcard_no }}/{{ $data->original_image }}" height="50" width="150"></a> </td>
                                    <!-- <td>{{ $data->dept }} </td> -->
                                    <td><a href="{{ route('jobdetail', ['id' => $data->jobcard_no]) }}" class="btn btn-outline-secondary">View Detail</a></td>
                                    <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-M-Y') }}<br>{{ \Carbon\Carbon::parse($data->created_at)->format('h:m:s') }}</td>
                                    <td>{{ $data->uploaded_by }} </td>
                                    <!-- <td><a onclick="return confirm('Are you sure?')" href="{{ route('joblist_remove',['id' => $data->id]) }}" class="btn btn-danger">Delete</a> </td> -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection