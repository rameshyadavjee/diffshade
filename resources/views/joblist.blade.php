@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Job Listing</li>                                    
                </ol>                
            </nav>            
            <div class="card">                 
                    <!-- Display validation msg --> 
                    @foreach (['error', 'warning', 'success'] as $msg)
                        @if(Session::has($msg))
                        <div class="mx-3 mt-2 alert alert-success alert-dismissible fade show" role="alert">  
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>                          
                            {{ Session::get($msg) }}
                        </div> 
                        @endif
                    @endforeach               

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width:100%">
                            <thead>
                                <tr class="table-secondary">
                                    <th>#</th>
                                    <th>Jobcard No</th>
                                    <th>Original Image</th>
                                    <th>Dept</th>
                                    <th>Date</th>
                                    <!-- <th>Uploaded By</th> -->
                                    <td align="center"><strong>Action</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data_arrays as $key => $data)
                                <tr>
                                    <td valign="middle" class="bg-secondary text-white">{{ $data->id }} </td>
                                    <td valign="middle"><a href="{{ route('jobdetail', ['id' => $data->jobcard_no]) }}" class="btn btn-outline-secondary btn-sm">
                                            {{ $data->jobcard_no }}
                                        </td>
                                    <td valign="middle"><a href="{{ asset('store') }}/{{ $data->jobcard_no }}/{{ $data->original_image }}" target="_blank"><img src="{{ asset('store') }}/{{ $data->jobcard_no }}/original.jpg" height="50" width="150"></a> </td>
                                    <td>{{ $data->dept }} </td>
                                    <td valign="middle">{{ \Carbon\Carbon::parse($data->created_at)->format('d-M-Y') }}<br>{{ \Carbon\Carbon::parse($data->created_at)->format('h:m:s A') }}</td>
                                    <!-- <td valign="middle">{{ $data->uploaded_by }} </td> -->
                                    <td align="center" width="20%">
                                        <a href="{{ route('jobdetail', ['id' => $data->jobcard_no]) }}" class="btn btn-outline-secondary btn-sm">View Detail</a>
                                        <a onclick="return confirm('Are you sure?')" href="{{ route('joblist_remove',['id' => $data->id]) }}" class="btn btn-danger btn-sm">Delete</a>
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
</div>
@endsection