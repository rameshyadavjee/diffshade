@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Liveview') }}</div>

                <div class="card-body text-center">
                    <video id="my-video" class="video-js vjs-default-skin" controls preload="auto" width="640" height="360">
                        <source src="http://localhost:8090/diffshade/public/output.m3u8" type="application/x-mpegURL">
                    </video>
                    <script src="https://vjs.zencdn.net/7.11.4/video.js"></script>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection