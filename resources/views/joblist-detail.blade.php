@extends('layouts.app')
@push('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


@endpush
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('joblist')}}">Joblist</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Listing Page</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header  text-white">
                    <div class="row">
                        <div class="col-md-2">
                            <div>
                                @if(isset($original_data[0]->original_image))
                                <a href="{{ asset('store/' . $original_data[0]->jobcard_no . '/' . $original_data[0]->original_image) }}" target="_blank">
                                    <img class="img-thumbnail" src="{{ asset('store/' . $original_data[0]->jobcard_no . '/' . $original_data[0]->original_image) }}">
                                </a>
                                @else
                                <p>No image available</p>
                                @endif
                            </div>

                        </div>
                        <div class="col-md-6">
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
                            <div class="text-center alert-{{ $msg }} bg-warning text-black">
                                {{ Session::get('reservematter-' . $msg) }}
                            </div>
                            @endif
                            @endforeach
                            <form action="{{route('object_detailsave')}}" method="POST" enctype="multipart/form-data" class="form-control text-black">
                                @csrf
                                <input type="hidden" id="jobcard_no" name="jobcard_no" value="{{$original_data[0]->jobcard_no}}">
                                <input type="hidden" id="original_image" name="original_image" value="{{$original_data[0]->original_image}}">
                                <input type="file" id="upload" name="upload" class="form-control" required>
                                <input type="radio" name="comparetype" value="blackwhite" class="mt-3" checked> Black and White
                                <input type="radio" name="comparetype" value="coloured"> Colour<br>
                                <button type="submit" class="btn btn-md btn-warning mt-2" class="form-control">Save</button>
                            </form>
                        </div>
                        <div class="col-md-4 ">
                            <div class="text-center form-control text-black" style="height: 130px;">
                            <form action="{{route('jobdetail_live')}}" method="POST" enctype="multipart/form-data" >
                                @csrf
                                <input type="hidden" id="jobcard_no" name="jobcard_no" value="{{$original_data[0]->jobcard_no}}">
                                <input type="hidden" id="original_image" name="original_image" value="{{$original_data[0]->original_image}}">
                                <button type="submit" class="btn btn-lg btn-danger text-center mt-4 ">Live Feed <i class="fa fa-camera" style="font-size:48px;"></i> </button> 
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" style="font-size:10px !important;">
                        <thead>
                            <tr class="table-secondary">
                                <th>#</th>
                                <!-- <th>Uploaded Image</th> -->
                                <th>Output Image</th>
                                <th>Accuracy -Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_arrays as $key => $data)
                            <tr class="pb-5">
                                <td class="bg-secondary text-white">{{$data->id}}</td>
                                <!-- <td><a href="{{ asset('store/' . $original_data[0]->jobcard_no . '/' . $data->uploaded_image) }}" target="_blank" class="btn btn-outline-secondary">
                                        <img src="{{ asset('store/' . $original_data[0]->jobcard_no . '/' . $data->uploaded_image) }}" class="img-fluid"></a>
                                </td> -->
                                <td class="height:auto">
                                    <a href="{{ asset('store/' . $original_data[0]->jobcard_no . '/' . $data->output_image) }}" target="_blank" class="btn btn-outline-secondary">
                                        <img src="{{ asset('store/' . $original_data[0]->jobcard_no . '/' . $data->output_image) }}" class="img-fluid">
                                    </a>
                                </td>
                                <td>{{ $data->accuracy }} <br> <br>
                                    Date: {{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }} <br><br>
                                    By: {{$data->created_by}} <br> <br> <br>
                                    <a onclick="return confirm('Are you sure?')" href="{{ route('jobdetail_remove',['id' => $data->id]) }}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')

@endpush
@endsection