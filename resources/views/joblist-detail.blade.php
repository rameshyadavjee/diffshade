@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        #camera { width: 100%; max-width: 480px; }
        button { margin-top: 10px; }
    </style>
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
                                    <img class="img-thumbnail" src="{{ asset('store/' . $original_data[0]->jobcard_no . '/' . 'original.jpg') }}">
                                </a>
                                @else
                                <p>No image available</p>
                                @endif
                            </div>

                        </div>
                        <div class="col-md-4">
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
                        <div class="col-md-6">                            
                            <!-- Video Element for Camera Preview -->
                            <video id="camera" autoplay ></video>                                                                
                            <canvas id="preview" style="display: none;"></canvas>
                            <!-- Single Button to Capture and Save Image -->
                            <button id="save" class="btn btn-primary">Capture and Save Image</button>
                            <script>
                                const video = document.getElementById('camera');
                                const canvas = document.getElementById('preview');
                                const saveButton = document.getElementById('save');
                                const context = canvas.getContext('2d');

                                // Access the device camera and stream to video element
                                navigator.mediaDevices.getUserMedia({ video: true })
                                    .then(stream => {
                                        video.srcObject = stream;
                                    })
                                    .catch(error => {
                                        console.error("Error accessing camera:", error);
                                    });

                                // Capture and save image when save button is clicked
                                saveButton.addEventListener('click', () => {
                                    // Set canvas dimensions same as video dimensions
                                    canvas.width = video.videoWidth;
                                    canvas.height = video.videoHeight;

                                    // Draw video frame to canvas
                                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                                    // Convert canvas content to a data URL (base64 encoded image)
                                    const dataURL = canvas.toDataURL('image/jpeg');

                                    // Generate a file name with the current date and time
                                    const now = new Date();
                                    const dateTime = now.toISOString().replace(/[-:.]/g, "").slice(0, 15); // Format as YYYYMMDDTHHMMSS
                                    const fileName = `{{$original_data[0]->jobcard_no}}_${dateTime}.jpg`; 

                                    // Create an anchor element and trigger a download
                                    const link = document.createElement('a');
                                    link.href = dataURL;
                                    link.download = fileName;  // File name for the download
                                    link.click();
                                });
                            </script>                              
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body mt-2">
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
@endsection