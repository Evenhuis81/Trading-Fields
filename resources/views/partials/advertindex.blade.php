<div id="load" style="position: relative;">
    @foreach ($adverts as $advert)
        @if ($loop->index % 4 == 0)
            <div class="row">
        @endif

        <div class="col-md-3 px-2 py-2">
            <div class="card box">
                <img class="card-img-top" src="{{ asset('storage/'.$advert->pictures[0]->file_name) }}" alt="Card image cap"
                style="object-fit: contain; width: 100%; height: 140px;">
                <p class="card-text text-primary mx-3 my-1 oneLineEllipsis box" style="font-size: 1.0rem;">{{ $advert->title }}</p>
                <p class="card-text mx-3 mb-2 text-monospace" style="font-size: 1.2rem;">€{{ $advert->price }}</p>
                <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='{{ route('adverts.show', [$advert->id]) }}'></a>
            </div>
        </div>

        @if ($loop->index % 4 == 3 || $loop->last)
            </div>
        @endif
    @endforeach
</div>
{{ $adverts->links() }}



{{-- <div class="card mb-3 col-md-3 w-75" style="border: 1px solid black;">
    <div class="row no-gutters">
        <div class="col-md-4">
            <img src="{{ asset('storage/'.$advert->pictures[0]->file_name) }}" class="mx-auto card-img" alt="cardImg"
            style="display: block; max-width: 300px; max-height: 140px; width: 100%; height: auto;">
            <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='{{ route('adverts.show', [$advert->id]) }}'></a>
        </div>
        <div class="col-md-8">
            <div class="card-body mr-0 pr-0">
                <h5 class="card-title oneLineEllipsis mr-0">{{ $advert->title }}</h5>
                <p class="card-text mb-0">Category: {{ $advert->categories()->first()->name }}</p>
                <p class="card-text mb-1">Asking Price: €{{ $advert->price }}</p>
                @if (!is_null($advert->startbid))
                <p class="card-text"><small class="text-muted">Highest Bid: €{{ $advert->price }}</small></p>
                @endif
                <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='{{ route('adverts.show', [$advert->id]) }}'></a>
            </div>
        </div>
    </div>
</div> --}}