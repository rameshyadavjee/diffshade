@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="container mt-5">
        <div class="row signin-margin">
            <div class="col-lg-4 col-md-8 col-12 mx-auto">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Session Expired</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Session Expired due to Inactivity</p>
                        <p><a href="{{url('/')}}">Click to refresh</a></p>
                    </div>
                </div>
            </div>
        </div>
        <x-footers.guest></x-footers.guest>
    </div>
</div>
@endsection