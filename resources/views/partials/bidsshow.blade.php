{{-- @foreach ($advert->bids->sortByDesc('value') as $bid) --}}
@if (!$advert->bids()->count())
<p class="mx-auto my-auto">No bids placed</p>
@endif
{{-- @foreach ($advert->bids->sortByDesc(function($bid) {
return [$bid->value, $bid->created_at];
}) as $bid) --}}
{{-- @php
$bids = $advert->bids->sortBy('value')->sortByDesc('created_at');
@endphp --}}
{{-- @foreach ($bids as $bid) --}}
@foreach ($advert->bids->sortByDesc('created_at')->sortByDesc('value') as $bid)

@if ($bid->owner->id == auth()->id())
<div class="row mx-0" style="height: 2.5rem;color:green;">
    <p class="card-text ml-3 font-weight-bold my-auto">{{ $bid->owner->name }}</p>
    <p class="card-text ml-3 font-weight-bold my-auto">€ {{ $bid->value }}</p>
    <p class="card-text ml-auto my-auto mr-3">{{ $bid->created_at->toFormattedDateString() }}</p>
</div>
<div class="container border-bottom">
    <form class="deletebid" action="{{ $bid->id }}">
        <button type="submit" class="btn btn-light btn-sm border mb-2">Delete Bid</button>
    </form>
</div>
@else
<div class="row border-bottom mx-0" style="height: 2.5rem;">
    <p class="card-text ml-3 font-weight-bold my-auto">{{ $bid->owner->name }}</p>
    <p class="card-text ml-3 font-weight-bold my-auto">€ {{ $bid->value }}</p>
    <p class="card-text ml-auto my-auto mr-3">{{ $bid->created_at->toFormattedDateString() }}</p>
</div>
@endif
@endforeach