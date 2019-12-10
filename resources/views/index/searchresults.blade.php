@extends('layouts.main')

@section('content')
@section('searchbar')
@include('layouts.searchbar')
@endsection

<div class="container mt-2">
<p class="text-center mb-0 pt-2 text-success font-weight-bold">{{ $adverts->count() }} searchresult{{ $adverts->count()==1 ? "" : "s" }} {{ session('queryinput') ? "for " : "" }}<span class="text-monospace text-danger">'{{ session('queryinput') }}'</span></p>
    {{ session()->forget('queryinput') }}
    {{-- categoryfilter emptied/refreshed on each new search? --}}
    @if (session('categoryfilter'))
    <hr class="mx-auto w-25">
    <p class="text-center mb-2 text-primary font-weight-bold" style="font-size: 1rem;">Your filters: <span class="text-light bg-dark">&nbsp{{ session('categoryfilter')}}&nbsp</span></p>
    {{ session()->forget('categoryfilter') }}
    @endif
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
                     @if (!is_null(request()->cookie('pc')))
                        <p>&nbsp;&nbsp;&nbsp;{{ $advert->distance($advert->zipcode, request()->cookie('pc')) }} KM</p>
                    @endif</p>
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