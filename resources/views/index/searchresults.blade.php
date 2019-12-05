@extends('layouts.main')

@section('content')
@section('searchbar')
@include('layouts.searchbar')
@endsection

<div class="container mt-2">
    <p class="text-center mb-0 text-success font-weight-bold">{{ $adverts->count() }} searchresult{{ $adverts->count()==1 ? "" : "s" }}</p>
    <div class="row">

        <div class="col-md-2">
            {{-- Left Side Panel --}}
        </div>
        <div class="col-md-8">
            @foreach ($adverts as $advert)
            <div class="row" style="border: 1px solid black;">
                <div class="col-md-2">
                    <img src="{{ asset('storage/'.$advert->pictures()->first()->file_name) }}" class="img" alt="card-img" style="height:140px;">

                    {{-- <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='{{ route('adverts.show', [1]) }}'></a> --}}
                </div>
                <div class="col-md-8">
                    bla
                </div>
                <div class="col-md-2">
                    di
                </div>
            </div>
            @endforeach

            <hr>

            <div class="row" style="border: 1px solid black; height: 140px;">
                <div class="col-md-2">
                    <img src="{{ asset('storage/advertimages/201911280858276742-Monitor.jpg') }}" class="card-img" alt="cardImg">
                    <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='{{ route('adverts.show', [1]) }}'></a>
                </div>
                <div class="col-md-8">
                    bla
                </div>
                <div class="col-md-2">
                    di
                </div>
            </div>


        </div>

        <div class="col-md-2">
            {{-- Right Side Panel --}}
        </div>

    </div> {{-- /Row --}}
</div> {{-- /Container --}}











@endsection