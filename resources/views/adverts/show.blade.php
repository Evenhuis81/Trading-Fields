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
                    <p class="card-title">Views / Times Saved / {{ $advert->created_at->toDayDateTimeString() }} </p>
                    <a href="#" class="btn btn-primary mb-3">Save <i class="far fa-heart"></i></a>
                    <div class="row">
                        <div class="col-md-7 pl-0">
                            {{-- Image --}}
                            <img class="img-fluid" src="{{ asset('storage/'.$advert->pictures[0]->file_name) }}" alt="card-img">
                        </div>
                        <div class="col-md-5">
                            {{-- Price / Type of delivery --}}
                            <h3 class="card-text font-weight-bold">€ {{ $advert->price }}</h3>
                            <p class="card-text"><br>Levering<br><small>Ophalen</small></p>
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
            </div> {{-- /Card --}}
        </div> {{-- /Column 5 --}}
        <div class="col-md-2">
            {{-- Advertiser Info + Bid System --}}
            <div class="card-body" style="background-color: #fffbe2">
                <p class="card-text">{{ $advert->owner->name }}</p>
                <p class="card-text">{{ str_replace("ago", "active on the site", $advert->owner->created_at->diffForHumans()) }}</p>
                <a href="" class="card-text">View more adverts</a>
                <hr>
                <p><i class="fas fa-map-marker-alt"></i>Advertiser hometown</p>
                <a href="" class="btn btn-primary w-100 pt-3" style="height:70px;"><i class="far fa-heart"><br>Bericht
                    </i></a>
            </div>
            {{-- Bid system --}}
            @if (!is_null($advert->startbid))
            @auth
            <div class="card-body mt-3" style="background-color: #fffbe2">
                <div class="row">
                    <h5 class="card-text ml-3">Bieden</h5>
                    <p class="card-text ml-auto mr-3">(From €{{ $advert->startbid }},-)</p>
                    {{-- <p class="card-text ml-3" style="background-color: white;">Login or Register to see and place Bids</p> --}}
                </div>
                <form id="bid-form">
                    @csrf
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">€</div>
                        </div>
                        <input type="number" name="value" class="form-control">

                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-light w-75 text-center">Place Bid</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card bidcont">
        @include('partials.bidsshow')
    </div>
    @endauth
    @endif
    {{-- <p class="card-text">{{ str_replace("ago", "active on the site", $advert->owner->created_at->diffForHumans()) }}</p>
    <a href="" class="card-text">View more adverts</a>
    <hr>
    <p><i class="fas fa-map-marker-alt"></i>Advertiser hometown</p>
    <a href="" class="btn btn-primary w-50"><i class="far fa-heart"><br>Bericht</i></a> --}}
</div> {{-- /Info-BidSystem --}}
</div> {{-- /Row --}}
<div class="col-md-3">
    {{-- Right side advertisement (Sticky) --}}
</div>
</div>
</div>


@endsection