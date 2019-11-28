@extends('layouts.main')

@section('content')
@section('searchbar')
@include('layouts.searchbar')
@endsection

<div class="container">
    <div class="row">

        <div class="col-md-2">
            {{-- Left Side Panel --}}
        </div>

        <div class="col-md-8">
            <div class="row" style="border: 1px solid black; height: 140px;">
                <div class="card">
                    <div class="col-md-2">
                        <img src="{{ asset('storage/advertimages/201911280858276742-Monitor.jpg') }}" class="card-img" alt="cardImg" style="">
                        <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='{{ route('adverts.show', [1]) }}'></a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card-body mr-0 pr-0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="border: 1px solid black; height: 140px;">
                <div class="card">
                    <div class="col-md-2">
                        <img src="{{ asset('storage/advertimages/201911280858276742-Monitor.jpg') }}" class="card-img" alt="cardImg" style="">
                        <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='{{ route('adverts.show', [1]) }}'></a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card-body mr-0 pr-0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="border: 1px solid black; height: 140px;">
                <div class="card">
                    <div class="col-md-2">
                        <img src="{{ asset('storage/advertimages/201911280858276742-Monitor.jpg') }}" class="card-img" alt="cardImg" style="">
                        <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='{{ route('adverts.show', [1]) }}'></a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card-body mr-0 pr-0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="border: 1px solid black; height: 140px;">
                <div class="card">
                    <div class="col-md-2">
                        <img src="{{ asset('storage/advertimages/201911280858276742-Monitor.jpg') }}" class="card-img" alt="cardImg" style="">
                        <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='{{ route('adverts.show', [1]) }}'></a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card-body mr-0 pr-0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="border: 1px solid black; height: 140px;">
                <div class="card">
                    <div class="col-md-2">
                        <img src="{{ asset('storage/advertimages/201911280858276742-Monitor.jpg') }}" class="card-img" alt="cardImg" style="">
                        <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='{{ route('adverts.show', [1]) }}'></a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card-body mr-0 pr-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            {{-- Right Side Panel --}}
        </div>

    </div> {{-- /Row --}}
</div> {{-- /Container --}}











@endsection