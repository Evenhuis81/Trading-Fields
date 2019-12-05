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
            <div class="row my-1" style="border: 1px solid #dedede; background-color: white;">
                <div class="col-md-2">
                    <img src="{{ asset('storage/'.$advert->pictures()->first()->file_name) }}" class="" alt="img" style="object-fit: contain; width: 100%; height: 140px;">
                </div>
                <div class="col-md-6">
                    <p class="text-primary my-1 oneLineEllipsis" style="font-size: 1.0rem;">{{ $advert->title }}</p>
                    <p class="my-1 threeLineEllipsis" style="">{{ $advert->description }}</p>
                    <p class="my-1 font-weight-bold" style="position: absolute; bottom: 0px; width: 100%">{{ $advert->delivery->name }}</p>
                </div>
                <div class="col-md-2">
                    <p class="text-monospace mt-1 mb-0 float-right" style="font-size: 1.0rem;">€{{ $advert->price }}</p>
                    <p class="float-right" style="font-size:13px;">{{ $advert->created_at->toFormattedDateString() }}</p>
                </div>
                <div class="col-md-2">
                    <p class="mb-0 oneLineEllipsis" style="margin-top:5px;">{{ $advert->name }}</p>
                    <p class="oneLineEllipsis">{{ $advert->hometown($advert->zipcode) }}</p>
                </div>
                <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='{{ route('adverts.show', [$advert->id]) }}'></a>
            </div>
            @endforeach
        </div>
        <div class="col-md-2">
            {{-- Right Side Panel --}}
        </div>
    </div> {{-- /Row --}}
</div> {{-- /Container --}}

@endsection
