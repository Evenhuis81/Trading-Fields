@extends('layouts.main')

@section('content')

{{-- {{ dd(session('bidcheckon')) }} --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="w-100 text-center card-header" style="font-size: 1.4em">
                    <strong>{{ __('Edit Advert nr. ') }}{{ $advert->id }}</strong></div>
                @if(session('success'))
                <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <a class="btn btn-success col-md-4 offset-md-4 mt-2" href="{{ route('adverts.index') }}">Manage Your Adverts</a>
                @endif

                <div class="card-body">
                    <form action="/adverts/{{ $advert->id }}" method="post" enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <h5 class="card-header mb-3">{{ __('Title and Description') }}</h5>
                        <div class="form-group row my-0 align-items-center" id="titlehover">
                            <label for="title" class="col-md-2 offset-md-2 col-form-label text-md-right py-0 pz-0" id="titlehover2">{{ __('Title =>') }}</label>
                            <div class="col-md-6">
                                <p class="card-text mb-0" id="titleText" style="margin-left: 13px;">
                                    {{ old('title') ? old('title') : $advert->title }}
                                </p>
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ? old('title') : "$advert->title" }}" style="display: none; padding-bottom: 7px;" autofocus>
                            </div>
                        </div>
                        @error('title')
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <span style="color: red; font-size: 80%" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            </div>
                        </div>
                        @enderror

                        <div class="form-group row mt-2">
                            <label for="description"
                                class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                            <div class="col-md-6">
                                <textarea rows="3" cols="50" value="" id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description">@if (session('bidcheckoff') || session('bidcheckon') && (old('description')===null)){{ "" }}
                                @elseif (old('description')){{ old('description') }}
                                @else{{ $advert->description }}
                                @endif</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group col-md-4 text-md-right mt-2">
                                <label for="category col-form-label">Category:</label>
                            </div>
                            <div class="col-md-6">
                                <select name="category" id="category"
                                    class="form-control @error('category') is-invalid @enderror">
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @if (old('category')==$category->id)
                                        {{ "selected" }}
                                        @elseif (!old('category') && $category->id == $advert->categories()->first()->id)
                                        {{ "selected" }}
                                        @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <h5 class="card-header mb-3">{{ __('Characteristics') }}</h5>
                        <div class="form-group row mb-0">
                            <div class="form-group col-md-4 text-md-right">
                                <label for="condition" class="col-form-label">{{ __('Condition') }}</label>
                            </div>
                            <div class="col-md-6">
                                <select name="condition_id" id="condition" class="form-control">
                                    <option
                                        @if (session('bidcheckoff') || session('bidcheckon') && (old('condition_id')===null))
                                        {{ "selected" }}
                                        @endif>{{ __('Choose...') }}</option>
                                    @foreach ($conditions as $condition)
                                    <option value="{{ $condition->id }}"
                                        @if (!session('bidcheckoff') && !session('bidcheckon') && old('condition_id')==$condition->id)
                                        {{ "selected" }}
                                        @elseif (!session('bidcheckoff') && !session('bidcheckon') && $condition->id == $advert->condition_id)
                                        {{ "selected" }}
                                        @elseif (old('condition_id')==$condition->id)
                                        {{ "selected" }}
                                        @elseif ($condition->id == $advert->condition_id)
                                        {{ "selected" }}
                                        @endif>{{ $condition->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <h5 class="card-header mb-3">{{ __('Price') }}</h5>
                        <div class="form-group row">
                            <div class="form-check col-md-4 text-md-right mt-2">
                                <label for="price">Asking Price:</label>
                            </div>
                            <div class="col-md-3 input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                                <input id="price" type="number"
                                    class="form-control @error('price') is-invalid @enderror" name="price"
                                    value="{{ old('price') ? old('price') : $advert->price }}">
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <div class="form-check col-md-4">
                            </div>
                            <div class="col-md-6 ml-4">
                                <input class="form-check-input" type="checkbox" name="bids" id="bids"
                                    @if (session('bidcheckon'))
                                    {{ "checked" }}>
                                @elseif (session('bidcheckoff'))
                                {{ "" }}>
                                @else
                                {{ $advert->startbid === null ? "" : "checked" }}>
                                @endif
                                <label class="form-check-label" for="bids">
                                    Allow bids{{ $advert->startbid === null ? "" : " (current startbid = ".$advert->startbid.")" }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group row" id="inputBid" style="display: none">
                            <div class="form-check col-md-4 text-md-right mt-2">
                                <label for="bid col-form-label">Change Starting bid:</label>
                            </div>
                            <div class="col-md-3 input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                                <input id="bid" type="number"
                                    class="form-control @error('startbid') is-invalid @enderror" name="startbid"
                                    value="{{ old('startbid') ? old('startbid') : "0" }}">
                                @error('startbid')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <h5 class="card-header mb-3">{{ __('Delivery') }}</h5>
                        <div class="form-group row mb-0">
                            <div class="form-group col-md-4 text-md-right">
                                <label for="delivery" class="col-form-label">{{ __('Delivery') }}</label>
                            </div>
                            <div class="col-md-6">
                                <select name="delivery_id" id="delivery" class="form-control">
                                    @foreach ($deliveries as $delivery)
                                    <option value="{{ $delivery->id }}"
                                        @if (old('delivery_id')==$delivery->id)
                                        {{ "selected" }}
                                        @elseif ($delivery->id == $advert->delivery_id)
                                        {{ "selected" }}
                                        @endif>{{ $delivery->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <h5 class="card-header mb-3">{{ __('Contact Information') }}</h5>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name for Advert') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : auth()->user()->name }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <p class="col-md-4 text-md-right">{{ __('E-mail') }}</p>
                            <div class="col-md-6">
                                <p>&nbsp&nbsp{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phonenr" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number (optional)') }}</label>
                            <div class="col-md-6">
                                <input id="phonenr" type="telnr" class="form-control @error('phonenr') is-invalid @enderror" name="phonenr"
                                    @if (session('bidcheckoff') || session('bidcheckon') && (old('phonenr')===null))
                                    value="">
                                @else
                                value="{{ old('phonenr') ? old('phonenr') : $advert->phonenr }}">
                                @endif
                                @error('phonenr')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="zipcode" class="col-md-4 col-form-label text-md-right">{{ __('Zipcode') }}</label>
                            <div class="col-md-6">
                                <input id="zipcode" type="text" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode"
                                    value="{{ old('zipcode') ? old('zipcode') : $advert->zipcode }}">
                                @error('zipcode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="container">
                                <h5 class="card-header mb-3">Change Image</h5>
                                <div class="row">
                                    <div class="col-sm-4 offset-sm-4 imgUp">
                                        @if (session('images') )
                                        <div class="imagePreview" style="background-image: url('{{ session('images')[0] }}')"></div>
                                        <input type="hidden" name="{{ session('imagekey') }}" value="{{ session('images')[0] }}">
                                        <input type="hidden" name="imagename" value="{{ session('imagename') }}">
                                        @else
                                        <div class="imagePreview" style="background-image: url('{{ $base64Img[0] }}')"></div>
                                        <input id="imagename" type="hidden" name="unchanged" value="true">
                                        @endif
                                        <label class="btn btn-primary" id="btn-primary">
                                            Change<input type="file" name="images[]" class="uploadFile" value="Upload Photo"
                                                style="width: 0px;height: 0px;overflow: hidden;" accept="image/*">
                                        </label>
                                    </div><!-- col-4 -->
                                    {{-- <i class=" fa fa-plus imgAdd"></i> --}}
                                    {{-- <div style="height:140px;">
                                        <h2 class="card-text text-center mt-5">Missing Image</h2>
                                        <h4 class="card-text text-center">Contact</h4>
                                        <h5 class="card-text text-center">Administrator</h4>
                                    </div> --}}
                                    {{-- </div><!-- col-4 --> --}}
                                    {{-- <i class=" fa fa-plus imgAdd"></i> --}}
                                    {{-- @endif --}}
                                </div><!-- row -->
                            </div><!-- container -->
                            <div class="imgVal  mx-auto col-sm-4">
                                <span class="card-text" id="imgMsg" style="visibility: visible; color: red">
                                    <strong>@error('images') At least 1 image is required @enderror &nbsp;</strong>
                                </span>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save Changes') }}
                                    </button>
                                </div>
                            </div>
                    </form>
                </div> {{-- Card Body --}}
            </div> {{-- Card --}}
        </div> {{-- Column --}}
    </div> {{-- Row --}}
</div> {{-- Container --}}


@endsection