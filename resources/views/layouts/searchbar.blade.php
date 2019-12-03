<nav class="navbar navbar-light bg-light fixed-top fixed-top-2 py-2" style="z-index:1000;">
    <div class="container">
        {{-- <div class="row"> --}}
        <div class="col-md-12 mx-auto">
            <form id="searchform" method="POST" action="{{ route('search') }}">
                @csrf
                <div class="form-row mb-0">
                    <div class="form-group col-md-4 px-0 mb-0">
                        <input type="text" name="searchdata" id="search" class="form-control">
                        <div class="searchList"></div>
                    </div>
                    <div class="form-group col-md-3 px-0 mb-0">
                        <select id="category" class="form-control" name="category">
                            <option selected value="0">All categories...</option>
                            {{-- Categories injected from CategoryComposer --}}
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-1 px-0 mb-0">
                        <input type="text" class="form-control" id="zip" name="zip" placeholder="Zipcode">
                    </div>
                    <div class="form-group col-md-3 px-0 mb-0">
                        <select id="distance" class="form-control" name="distance">
                            <option selected value="0">All distances...</option>
                            <option value="3">{{ __('< 3 km') }}</option>
                            <option value="5">{{ __('< 5 km') }}</option>
                            <option value="10">{{ __('< 10 km') }}</option>
                            <option value="15">{{ __('< 15 km') }}</option>
                            <option value="25">{{ __('< 25 km') }}</option>
                            <option value="50">{{ __('< 50 km') }}</option>
                            <option value="75">{{ __('< 75 km') }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-1 px-0 mb-0">
                        <button type="submit" class="btn btn-light border" style="color:blue;">Search</button>
                    </div>
                </div>
            </form>
        </div>
        {{-- </div> --}}
    </div>
</nav>