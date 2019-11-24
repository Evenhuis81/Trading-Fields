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
                    <p class="card-title">{{ views($advert)->count() }} / Times Saved / {{ $advert->created_at->toDayDateTimeString() }} </p>
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
        <div class="col-md-3">
            {{-- Advertiser Info + Bid System --}}
            <div class="card-body w-75" style="background-color: #fffbe2">
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
            @if ($advert->owner_id !== auth()->id())
            <div class="card-body mt-3 w-75" style="background-color: #fffbe2">
                <div class="row">
                    <h5 class="card-text ml-3">Bid</h5>
                    <p class="card-text ml-auto mr-3">(From €{{ $advert->startbid }},-)</p>
                </div>
                <form id="bidform">
                    @csrf
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">€</div>
                        </div>
                        @if (session('guestbid'))
                        <input type="number" id="getbid" name="inputbid" value="{{ session('guestbid') }}" class="form-control" :autofocus="'autofocus'" onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
                        @else
                        <input type="number" id="getbid" name="inputbid" class="form-control">
                        @endif
                    </div>
                    <span class="text-center" role="alert" style="color:red;">
                        <p id="print-error-msg"></p>
                    </span>
                    {{-- <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div> --}}
                    <div class="text-center">
                        @auth
                        <button type="submit" id="submitbutton" class="btn btn-light w-75 border">Place Bid</button>
                        @else
                        <button type="submit" id="visitorsubmit" class="btn btn-light w-75 border">Place Bid</button>
                        @endauth
                    </div>
                </form>
            </div>
            <div class="card bidcontent w-75">
            @include('partials.bidsshow')
            </div>
            @else
            <div style="height:100px;"></div>
            <div class="w-75">
            <a class="container-fluid btn btn-success btn-lg text-dark" href="{{ route('adverts.edit', [$advert->id]) }}" style="border: 2px solid black"><strong>Edit Advert</strong></a>
        </div>
            @endif
            
            
            
            {{-- @else
            <div class="card-body w-75">
                <h5 class="card-text ml-3 text-center">Log in to Bid on this</h5>
            </div>
            @endauth --}}
            @endif
        </div> {{-- /Column md-2 --}}
    </div> {{-- /Row --}}
</div> {{-- /Info-BidSystem --}}
</div> {{-- /Row --}}
<div class="col-md-2 ml-auto">
    {{-- Right side advertisement (Sticky) --}}
</div>
</div>


@endsection