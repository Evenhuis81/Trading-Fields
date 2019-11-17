@extends('layouts.main')

@section('content')

<div class="container-fluid">
    <div class="row">
        {{-- Advertisement --}}
    </div>
    <div class="row">
        <div class="col-md-2">
            {{-- Left side advertisement (Sticky) --}}
        </div>
        <div class="col-md-5">
            {{-- Main Content Advert --}}
            <div class="card">
                <div class="card-header">
                    <p class="card-text font-weight-bold">{{ $advert->title }}</p>
                    <hr>
                    <p class="card-title">Views / Times Saved / {{ $advert->created_at }} </p>
                    <a href="#" class="btn btn-primary mb-3">Save <i class="far fa-heart"></i></a>
                    <div class="row">
                        <div class="col-md-7 pl-0">
                            {{-- Image --}}
                            <img class="img-fluid" src="{{ asset('storage/'.$advert->pictures[0]->file_name) }}" alt="card-img">
                        </div>
                        <div class="col-md-5">
                            {{-- Price / Type of delivery --}}
                            <h3 class="card-text font-weight-bold">€ {{ $advert->price }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                   <p class="card-text">Description:</p>
                <h5 class="card-text">{{ $advert->description }}</h5>
                </div>
                <div class="card-footer text-muted" style="height=15px;">
                    <div class="row">
                        <p class="card-text my-auto">Share buttons / advertlink</p><a href="#" class="btn btn-primary ml-auto">Save <i class="far fa-heart"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            {{-- Advertiser Info + Bid System --}}
        </div>
        <div class="col-md-2">
            {{-- Right side advertisement (Sticky) --}}
        </div>
    </div>
</div>


@endsection