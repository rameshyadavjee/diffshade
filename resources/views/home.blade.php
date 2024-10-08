@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body text-center">  
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <h3><a href="{{route('joblist')}}" class="btn btn-outline-secondary">Job Listing</a> | 
                    <a href="{{route('joblist')}}" class="btn btn-outline-secondary">Add New Job</a></h3>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection