@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="w-100 text-center card-header" style="font-size: 1.4em">
                    <strong>{{ __('Make a New Advert') }}</strong></div>

                @if(session('success'))
                <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row col-md-12 my-2">
                    <a class="btn btn-success col-md-3 offset-md-1" href="{{ route('adverts.index') }}">{{ __('Manage your Adverts') }}</a>
                    <a class="btn btn-warning col-md-3 offset-md-1" href="{{ route('adverts.edit', [session('advertid')]) }}">{{ __('Edit new Advert') }}</a>
                    <a class="btn btn-info col-md-3 offset-md-1" href="{{ route('adverts.show', [session('advertid')]) }}">{{ __('Show new Advert') }}</a>
                </div>
                <div class="row col-md-12 my-2">
                    <a class="btn btn-dark col-md-5 offset-md-4" href="{{ route('adverts.create') }}">{{ __('Create new Advert') }}</a>
                </div>
                @else

                <div class="card-body">
                    <form method="POST" action="{{ route('adverts.store') }}" enctype="multipart/form-data">
                        @csrf

                        <h5 class="card-header mb-3">{{ __('Title and Description') }}</h5>
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" :autofocus="'autofocus'">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description"
                                class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                            <div class="col-md-6">
                                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-md-4 text-md-right">
                                <label for="category" class="col-form-label">{{ __('Category') }}</label>
                            </div>
                            <div class="col-md-6">
                                <select name="category" id="category"
                                    class="form-control @error('category') is-invalid @enderror">
                                    <option selected disabled>Choose...</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if (old('category')==$category->id)
                                        {{ "selected" }} @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <hr>

                        <h5 class="card-header mb-3">{{ __('Characteristics') }}</h5>
                        <div class="form-group row">
                            <div class="form-group col-md-4 text-md-right">
                                <label for="condition" class="col-form-label">{{ __('Condition') }}</label>
                            </div>
                            <div class="col-md-6">
                                <select name="condition" id="condition" class="form-control">
                                    <option selected>{{ __('Choose...') }}</option>
                                    <option value="new">{{ __('New') }}</option>
                                    <option value="asgoodasnew">{{ __('As good as new') }}</option>
                                    <option value="used">{{ __('Used') }}</option>
                                </select>
                            </div>
                        </div>
                        <hr>

                        <h5 class="card-header mb-3">{{ __('Price') }}</h5>
                        <div class="form-group row">
                            <div class="form-check col-md-4 text-md-right mt-2">
                                <label for="price">{{ __('Asking Price') }}</label>
                            </div>
                            <div class="col-md-3 input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{ __('€') }}</div>
                                </div>
                                <input id="price" type="number"
                                    class="form-control @error('price') is-invalid @enderror" name="price"
                                    value="{{ old('price') ? old('price') : "0" }}">
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-check col-md-4">
                            </div>
                            <div class="col-md-6 ml-5">
                                <input class="form-check-input" type="checkbox" name="bids" id="bids"
                                    @if (session('bidcheckon')) {{ "checked" }}>
                                @elseif (session('bidcheckoff')) {{ "" }}>
                                @else {{ "checked" }}>
                                @endif
                                <label class="form-check-label" for="bids">
                                    {{ __('Allow bids') }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group row" id="inputBid" style="display: none">
                            <div class="form-check col-md-4 text-md-right">
                                <label for="bid" class="col-form-label">{{ __('Starting Bid') }}</label>
                            </div>
                            <div class="col-md-3 input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{ __('€') }}</div>
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
                        <hr>

                        <h5 class="card-header mb-3">{{ __('Delivery') }}</h5>
                        <div class="form-group row">
                            <div class="form-group col-md-4 text-md-right">
                                <label for="delivery" class="col-form-label">{{ __('Delivery') }}</label>
                            </div>
                            <div class="col-md-6">
                                <select name="delivery" id="delivery" class="form-control">
                                    <option selected value="collect">{{ __('Collect') }}</option>
                                    <option value="dispatch">{{ __('Dispatch') }}</option>
                                    <option value="collectordispatch">{{ __('Collect or Dispatch') }}</option>
                                </select>
                            </div>
                        </div>
                        <hr>

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
                        <div class="form-group row">
                            <label for="phonenr" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number (optional)') }}</label>
                            <div class="col-md-6">
                                <input id="phonenr" type="telnr" class="form-control @error('phonenr') is-invalid @enderror" name="phonenr"
                                    value="{{ old('phonenr') ? old('phonenr') : auth()->user()->phonenr }}">
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
                                    value="{{ old('zipcode') ? old('zipcode') : auth()->user()->zipcode }}">
                                @error('zipcode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <h5 class="card-header mb-3">Add Image</h5>
                        <div class="form-group row">
                            <div class="col-sm-4 offset-sm-4 imgUp">
                                @if (session('images') )
                                <div class="imagePreview" style="background-image: url('{{ session('images')[0] }}')"></div>
                                <input type="hidden" name="{{ session('imagekey') }}" value="{{ session('images')[0] }}">
                                <input type="hidden" name="imagename" value="{{ session('imagename') }}">
                                @else
                                <div class="imagePreview"></div>
                                <input id="imagename" type="hidden" name="" value="">
                                @endif
                                <label class="btn btn-primary" id="btn-primary">
                                    Upload<input type="file" name="images[]" class="uploadFile" value="Upload Photo"
                                        style="width: 0px;height: 0px;overflow: hidden;" accept="image/*">
                                </label>
                            </div><!-- col-4 -->
                            {{-- <i class=" fa fa-plus imgAdd"></i> --}}
                        </div><!-- row -->
                        <div class="imgVal mx-auto col-sm-4">
                            <span class="card-text" id="imgMsg" style="visibility: visible; color: red">
                                <strong>@error('images') An image is required @enderror &nbsp;</strong>
                            </span>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <button type="submit" class="btn btn-primary mx-auto">
                                {{ __('Create Advert') }}
                            </button>
                        </div>
                    </form>
                </div> {{-- Card Body --}}
                @endif
            </div> {{-- Card --}}
        </div> {{-- Column --}}
    </div> {{-- Row --}}
</div> {{-- Container --}}
@endsection