@extends('layouts.main')

@section('content')

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
                <a class="btn btn-success col-md-4 offset-md-4 mt-2" href="{{ route('index.advert') }}">Manage Your Adverts</a>
                @endif

                <div class="card-body">
                    <form action="/adverts/{{ $advert->id }}" method="post" enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="form-group row my-0 align-items-center" id="titlehover">
                            <label for="title" class="col-md-2 offset-md-2 col-form-label text-md-right py-0 pz-0" id="titlehover2">{{ __('Title =>') }}</label>
                            <div class="col-md-6">
                                <p class="card-text mb-0" id="titleText" style="margin-left: 13px;">{{ old('title') ? old('title') : $advert->title }}</p>
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
                                <textarea rows="3" cols="50" value="" id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') ? old('description') : $advert->description }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

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

                        <div class="form-group row">
                            <div class="form-group col-md-4 text-md-right mt-2">
                                <label for="category col-form-label">Category:</label>
                            </div>
                            <div class="col-md-6">
                                <select name="category" id="category"
                                    class="form-control @error('category') is-invalid @enderror">
                                    {{-- <option selected disabled>Choose...</option> --}}
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @if (old('category')==$category->id)
                                        {{ "selected" }}
                                        @else
                                        {{ $category->id == $advert->category ? "selected" : "" }}
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

                        <div class="form-group row">
                            <div class="form-check col-md-4">
                            </div>
                            <div class="col-md-6 ml-5">
                                <input class="form-check-input" type="checkbox" name="bids" id="bids"
                                    @if (session('bidcheckon'))
                                    {{ "checked" }}>
                                @elseif (session('bidcheckoff'))
                                {{ "" }}>
                                @else
                                {{ $advert->startbid == null ? '' : 'checked' }}>
                                @endif
                                {{-- {{ old('bids') == "on" ? ' checked' : (($advert->startbid == null) ? '' : ' checked') }}> --}}
                                <label class="form-check-label" for="bids">
                                    Allow bids
                                </label>
                            </div>
                        </div>
                        {{-- <div class="form-group row" id="inputBid" style="display: none">
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
            </div> --}}

            <div class="card-body">
                <div class="container">
                    <h5 class="card-header mb-3">Change/Add Image(s)</h5>
                    <div class="row">
                        <div class="col-sm-4 imgUp">
                            @if ($base64Img)
                            <div class="imagePreview" style="background-image: url('{{ $base64Img[0] }}')"></div>
                            <label class="btn btn-primary" id="btn-primary">
                                Change<input type="file" name="images[]" class="uploadFile" value="Upload Photo"
                                    style="width: 0px;height: 0px;overflow: hidden;" accept="image/*">
                            </label>
                        </div><!-- col-4 -->
                        <i class=" fa fa-plus imgAdd"></i>
                        @else
                        <div style="height:140px;">
                            <h2 class="card-text text-center mt-5">Missing Image</h2>
                            <h4 class="card-text text-center">Contact</h4>
                            <h5 class="card-text text-center">Administrator</h4>
                        </div>
                    </div><!-- col-4 -->
                    <i class=" fa fa-plus imgAdd"></i>
                    @endif
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