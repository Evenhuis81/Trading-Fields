@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row">
        <div class="w-100 text-center card-header mb-2" style="font-size: 1.4em">
            <strong>{{ __('Manage Adverts') }}</strong></div>
        @if(session('success'))
        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div> {{-- Row --}}
    @if (count($adverts) == 0)
    <div class="col-md-8 offset-2">
        <div class="card-body">
            <div class="card-title text-center">
                <legend>{{ __('You don\'t have any Adverts!') }}</legend>
                <hr>
                <a href="{{ route('create.advert') }}" class="btn btn-success" style="font-size: 1.5em; color: white">{{ __('Make an Advert') }}</a>
            </div>
        </div>
    </div>
    @else
    @php $position = 0 @endphp
    @for($rowNumber = 0; $rowNumber < count($adverts) / 3; $rowNumber++) <div class="row mt-2">
        @for($columnNumber = 1; $columnNumber < 4; $columnNumber++)
            @if ($position==count($adverts))
            @php break @endphp
            @endif
            @if ($columnNumber==1)
            <div class="card col-md-3 offset-1 mr-4 hoverer poss{{ $adverts[$position]->id }}">
            @elseif ($columnNumber==2)
            <div class="card col-md-3 ml-3 mr-4 hoverer poss{{ $adverts[$position]->id }}">
                @else
                <div class="card col-md-3 ml-3 hoverer poss{{ $adverts[$position]->id }}">
                    @endif
                    @if ($adverts[$position]->pictures->count())
                    <img class="card-img-top cssimg mt-2" src="{{ url($adverts[$position]->pictures[0]->filename) }}" alt="Card image cap">
                    @else
                    <div style="height: 150px;">
                        <h2 class="card-text text-center mt-5">Missing Image</h2>
                        <h4 class="card-text text-center">Contact</h4>
                        <h5 class="card-text text-center">Administrator</h4>
                    </div>
                    @endif
                    <a class="fas fa-trash fa-2x text-danger delete" data-toggle="tooltip" data-placement="top" title="Delete!" data-id="{{ $adverts[$position]->id }}"></a>
                    <a class="fas fa-edit fa-2x text-primary edit" data-toggle="tooltip" data-placement="top" title="Edit" href="/adverts/{{ $adverts[$position]->id }}/edit" onclick></a>
                    <div class="card-body">
                        <h5 class="card-title oneLineEllipsis">{{ $adverts[$position]->title }}</h5>
                        <p class="card-text threeLineEllipsis">
                            {{ $adverts[$position]->description }}
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="card-text">Price: {{ $adverts[$position]->price }}</p>
                            </div>
                            <div class="col-md-6">
                                @if (is_null($adverts[$position]->startbid))
                                <p class="card-text">Bid = Off</p>
                                @else
                                <p class="card-text">Last Bid: {{ $adverts[$position]->startbid }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div> {{-- Column --}}
                @php $position++ @endphp
                @endfor
            </div> {{-- Row --}}
            @endfor
            @endif
</div> {{-- Container --}}

@endsection