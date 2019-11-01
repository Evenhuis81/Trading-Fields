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
                <a class="btn btn-success col-md-4 offset-md-4" href="{{ route('index.advert') }}">Manage Your Adverts</a>
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ route('store.advert') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" autofocus>

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
                            <div class="form-check col-md-4 text-md-right mt-2">
                                <label for="price">Asking Price:</label>
                            </div>
                            <div class="col-md-3 input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">€</div>
                                </div>
                                <input id="price" type="number"
                                    class="form-control @error('price') is-invalid @enderror" name="price"
                                    value="{{ old('price') }}">
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

                        <div class="form-group row">
                            <div class="form-check col-md-4">
                            </div>
                            <div class="col-md-6 ml-5">
                                <input class="form-check-input" type="checkbox" name="bids" id="bids"
                                    {{ session('bidcheck') ? "" : "checked" }}>
                                <label class="form-check-label" for="bids">
                                    Allow bids
                                </label>
                            </div>
                        </div>
                        <div class="form-group row" id="inputBid" style="display: none">
                            <div class="form-check col-md-4 text-md-right mt-2">
                                <label for="bid col-form-label">Starting bid:</label>
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
                        <hr>
                        <div class="container">
                            <h5 class="card-header mb-3">Add Image(s)</h5>
                            <div class="row">
                                <div class="col-sm-4 imgUp">
                                    <div class="imagePreview"></div>
                                    <label class="btn btn-primary" id="btn-primary">
                                        Upload<input type="file" name="images[]" class="uploadFile" value="Upload Photo"
                                            style="width: 0px;height: 0px;overflow: hidden;" accept="image/*">
                                    </label>
                                </div><!-- col-4 -->
                                <i class=" fa fa-plus imgAdd"></i>
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
                                    {{ __('Create Advert') }}
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