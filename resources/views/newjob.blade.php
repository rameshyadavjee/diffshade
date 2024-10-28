@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('joblist')}}">Job Listing</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Job</li>
                </ol>
            </nav>
            <div class="card">
                <!-- Display validation msg -->
                @if($errors->any())
                <div class="mx-3 mt-2 alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="card-body">
                    <div class="card-header bg-success text-white p-3">
                        <form action="{{route('jobsave')}}" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                @csrf
                                <div class="col-md-3">
                                    <label for="code">New Job Code: <span style="color:red">*</span></label>
                                    <input class="form-control" type="text" id="jobcard_no" name="jobcard_no" required autofocus>
                                </div>

                                <div class="col-md-3">
                                    <label for="code">Dept: </label>
                                    <select class="form-select" name="dept" required>
                                        <option value="Corrugation">Corrugation</option>
                                        <option value="Folded Cartoon">Folded Cartoon</option>
                                        <option value="Graviour">Graviour</option>
                                        <option value="Paper Bag">Paper Bag</option>
                                        <option value="Rigid Box">Rigid Box</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="code">Upload Image: <span style="color:red">*</span></label>
                                    <input class="form-control" type="file" id="upload" name="upload" requied>
                                </div>

                                <div class="col-md-3 mt-4">
                                    <button type="submit" class="btn btn-lg btn-primary ">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection