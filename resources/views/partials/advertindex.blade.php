{{ $adverts->links() }}
@foreach ($adverts as $advert)
@if ($loop->index % 4 == 0)
<div class="row">
    @endif
    <div class="card mb-3 col-md-3 w-75" style="border: 1px solid black; height: 140px;">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="{{ asset('storage/'.$advert->pictures[0]->file_name) }}" class="card-img" alt="cardImg">
                <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='{{ route('adverts.show', [$advert->id]) }}'></a>
            </div>
            <div class="col-md-8">
                <div class="card-body mr-0 pr-0">
                    <h5 class="card-title oneLineEllipsis mr-0">{{ $advert->title }}</h5>
                    <p class="card-text mb-0">Category: {{ $advert->categories()->first()->name }}</p>
                    <p class="card-text mb-1">Asking Price: €{{ $advert->price }}</p>
                    <p class="card-text"><small class="text-muted">Highest Bid: €{{ $advert->price }}</small></p>
                    <a style='position:absolute;top:0px;left:0px;width:100%;height:100%;display:inline;' href='{{ route('adverts.show', [$advert->id]) }}'></a>
                </div>
            </div>
        </div>
    </div>
    @if ($loop->index % 4 == 3 || $loop->last)
</div>
@endif
@endforeach
{{ $adverts->links() }}