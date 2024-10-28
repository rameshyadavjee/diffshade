@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Difference & Shading System</div>

                <div class="card-body">                    
                <h3>{{ __('Welcome To') }} Difference & Shading System</h3>
                <p class="px-2 py-2">The object and shade difference software offers significant benefits in various fields such as image processing, quality control, and design. By accurately detecting subtle differences between objects and variations in shading, it enhances precision in tasks like identifying defects in manufacturing, comparing digital designs, and improving automated visual inspection processes. The software can also assist in forensic analysis, helping to detect alterations in images or documents. Additionally, it aids graphic designers by ensuring color consistency across multiple versions of artwork, leading to improved quality control and overall efficiency in workflows.</p>
                <div class="text-center">
                    @guest
                        @if (Route::has('login'))
                            <a href="{{route('login')}}" class="btn btn-outline-primary">Login here</a>
                        @endif
                        
                    @endguest
                </div>    
                </div>
            </div>
        </div>
    </div>
    @endsection