@extends('layouts.main')

@section('content')
@section('searchbar')
@include('layouts.searchbar')
@endsection



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
                    {{-- This is just dummy element (mostly) --}}
                    <p class="card-title">Views: {{ views($advert)->count() }} / Times Saved: / {{ $advert->created_at->toDayDateTimeString() }} </p>
                    <!-- save optie staat niet in user-stories. Probeer functionaliteit te beperken tot strict noodzakelijk / opgegeven user stories -->
                    <a href="#" class="btn btn-primary mb-3">Save <i class="far fa-heart"></i></a>
                    <div class="row">
                        <div class="col-md-7 pl-0">
                            {{-- Image --}}
                            <img class="img-fluid" src="{{ asset('storage/'.$advert->pictures[0]->file_name) }}" alt="card-img">
                        </div>
                        <div class="col-md-5">
                            {{-- Price / Type of delivery --}}

                            <!-- labels ontbreken voor prijs -->
                            <!-- meerdere talen (Engels, Nederlands) worden door elkaar gebruikt. Kies 1 taal. -->
                            <h3 class="card-text font-weight-bold">€ {{ $advert->price }}</h3>
                            <h4 class="card-text"><br>Delivery<br><small>{{ $advert->delivery->name }}</small></h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (!is_null($advert->condition))
                    <div class="row">
                        <div class="col-3">
                            <h5 class="card-text">Condition:</h5>
                        </div>
                        <h5 class="card-text">{{ $advert->condition->name }}</h5>
                    </div>
                    <hr>
                    @endif
                    <h5 class="card-text"><b>Description:</b></h5>
                    <h5 class="card-text">{{ $advert->description }}</h5>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <p class="card-text my-auto">Twitter-facebooklinks / Advertlink</p><a href="#" class="btn btn-primary ml-auto">Save <i class="far fa-heart"></i></a>
                    </div>
                </div>
            </div> {{-- /Card --}}
        </div> {{-- /Column 5 --}}
        <div class="col-md-3">
            {{-- Advertiser Info + Bid System --}}
            <div class="card-body w-75" style="background-color: #fffbe2">
                <p class="card-text">{{ $advert->owner->name }}</p>
                <p class="card-text">{{ str_replace("ago", "active on the site", $advert->owner->created_at->diffForHumans()) }}</p>
                <a href="#" class="card-text">View more adverts</a>
                <hr>
                <p><i class="fas fa-map-marker-alt"></i>
                    {{-- Hometown of advertiser --}}
                    {{ $advert->hometown($advert->zipcode) }}
                </p>
                @if (!is_null($advert->phonenr))
                <p><i class="fas fa-phone"></i> {{ $advert->phonenr }}</p>
                @endif
                @if (!is_null(request()->cookie('pc')))
                <p>&nbsp;&nbsp;&nbsp;{{ $advert->distance($advert->zipcode, request()->cookie('pc')) }} KM</p>
                @endif
                <a href="#" class="btn btn-primary w-100 pt-3" style="height:70px;"><i class="far fa-heart"><br>Bericht
                    </i></a>
            </div>
            {{-- Bid system --}}
            @if (!is_null($advert->startbid) && $advert->owner_id !== auth()->id())
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
            @elseif ($advert->owner_id == auth()->id())
            <div class="card bidcontent w-75">
                @include('partials.bidsshow')
            </div>
            {{-- {{ dd(session('nobidforowner')) }} --}}
            @if (session('nobidforowner'))
            {{-- <span class="invalid-feedback" role="alert">
                <strong>{{ session('nobidforowner') }}</strong>
            </span> --}}
            <p class="text-center" style="width:75%; border:1px solid red; margin-top:1rem; color:red; bold-weight:600;">{{ session('nobidforowner') }}</p>
            @endif
            <div style="height:100px;"></div>
            <div class="w-75">
                <a class="container-fluid btn btn-success btn-lg text-dark" href="{{ route('adverts.edit', [$advert->id]) }}" style="border: 2px solid black"><strong>Edit Advert</strong></a>
            </div>
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