@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-2">
        <div class="row w-100" style="height: 400px;">
            {{-- <div class="col-2 offset-1 text-center" style="font-size: 1.3em; border-bottom: 1px solid black; visibility:hidden;"
                        id="subHead">Sub Category:</div>
                    <div class="col-2 offset-1 text-center" style="font-size: 1.3em; border-bottom: 1px solid black; visibility:hidden;"
                        id="columnHead">Column Category:</div>
                    <div class="col-3 offset-1 text-center" style="font-size: 1.3em; border-bottom: 1px solid black; visibility:hidden;"
                        id="adjHead">Adjust selected
                        Category:</div> --}}
        </div>
        <div class="row w-100">
            <div class="col-12">
                <div class="col-12 text-center w-100" style="font-size: 1.3em; border-top: 1px solid black; border-bottom: 1px solid black">
                    <h4 class="mt-2">Categories:</h4>
                </div>
                <div class="form-check text-center my-3 border-bottom">
                    <label class="form-check-label col-10" for="defaultCheck1">
                        All categories
                    </label>
                    <input class="form-check-input col-2" type="checkbox" value="" id="defaultCheck1">
                </div>
                @foreach ($categories as $category)
                <div class="form-check text-center my-3 border-bottom">
                    <label class="form-check-label col-10" for="defaultCheck1">
                        {{ $category->name }}
                    </label>
                    <input class="form-check-input col-2" type="checkbox" value="" id="defaultCheck1">
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-8">
        <div class="jumbotron">
            <h1 class="display-4">Hi there, Welcome!</h1>
            <p class="lead">This is the main index page, feel free to browse around and look at some adverts, login or create a new account if you want to respond to an advert or make your own.</p>
            <hr class="my-4">
            <p style="color:blueviolet;">Click on an advert to get more information on it.</p>
            {{-- <a class="btn btn-primary btn-lg" href="#" role="button"></a> --}}
        </div>
        <hr style="height:2px;border:none;background-color:brown;" />

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>

        @php
        $position = 0;
        // $path = 'storage/advertimages/'.$file_name
        @endphp
        @for($rowNumber = 0; $rowNumber < count($adverts) / 4; $rowNumber++) <div class="row">
            @for($columnNumber = 1; $columnNumber < 5; $columnNumber++)
                @if ($position==count($adverts))
                @php break @endphp
                @endif

                <div class="card mb-3 col-md-3 w-75" style="border: 1px solid black; height: 140px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/'.$adverts[$position]->pictures[0]->file_name) }}" class="card-img" alt="...">
                        <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='#'></a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body mr-0 pr-0">
                            <h5 class="card-title oneLineEllipsis mr-0">{{ $adverts[$position]->title }}</h5>
                            <p class="card-text">Asking Price: €{{ $adverts[$position]->price }}</p>
                            <p class="card-text"><small class="text-muted">Highest Bid: €{{ $adverts[$position]->price }}</small></p>
                            <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='#'></a>
                        </div>
                    </div>
                </div>
    </div>

    @php $position++ @endphp
    @endfor
</div>
@endfor
</div>

</div>
<div class="col-2">
</div>
</div>

@endsection