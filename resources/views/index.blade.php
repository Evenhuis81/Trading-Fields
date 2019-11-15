@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-2">
        <div class="row w-100" style="height: 400px;">
        </div>
        <div class="row w-100">
            <div class="col-12">
                <div class="col-12 text-center w-100" style="font-size: 1.3em; border-top: 1px solid black; border-bottom: 1px solid black">
                    <h4 class="mt-2">Categories:</h4>
                </div>
                <div class="form-check text-center mt-2 pb-2 border-bottom">
                    <label class="form-check-label col-10" for="allCat">
                        All categories
                    </label>
                    <input class="form-check-input col-2" name="allCat" type="checkbox" id="allCat" checked disabled style="width:18px; height:18px;">
                </div>
                @foreach ($categories as $category)
                <div class="form-check text-center mt-2 pb-2 border-bottom">
                    <label class="form-check-label col-10" for="cat{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                    <input class="form-check-input col-2 selectCats" type="checkbox" name="cats[]" style="width:18px; height:18px;" id="cat{{ $category->id }}" value="{{ $category->id }}">
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-8">
        <div class="jumbotron">
            <h1 class="display-4">Hi there, @auth {{ auth()->user()->name }} @else {{ 'Guest' }} @endauth</h1>
            <p class="lead">This is the main index page, feel free to browse around and look at some adverts, login or create a new account if you want to respond to an advert or make your own.</p>
            <hr class="my-4">
            <p style="color:blueviolet;">Click on an advert to get more information on it.</p>
        </div>
        <hr style="height:2px;border:none;background-color:brown;" />

        <div id="advertIndex">
            @include('partials.advertindex')
        </div>

    </div>

    <div class="col-2">
    </div>

</div> {{-- /Row --}}

@endsection