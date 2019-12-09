<nav class="navbar navbar-light bg-light fixed-top fixed-top-2 pt-2 pb-0" style="z-index:1000;">
    <div class="container">
        {{-- @if (session('yes'))
        {{ dd(session('yes')) }}
        @endif --}}
        <div class="col-md-12 mx-auto">
            <form id="searchform" method="POST" action="{{ route('search') }}">
                @csrf
                <div class="form-row mb-0">
                    <div class="form-group col-md-4 px-0 mb-0">
                        <input type="text" name="searchquery" id="search" class="form-control"
                        {{-- again the > option where to place, in this case I can place it outside, but that means session->forget has to be placed outside aswell --}}
                        {{-- after testing, can't place it here, but after 2nd request for it on searchresult page, but the quest still remains --}}
                        @if (session('queryinput'))
                            value="{{ session('queryinput') }}"
                            {{-- this works like this tho, how? i've put it inside input element as an attribute? php code breaking out of element? --}}
                            {{-- {{ session()->forget('queryinput') }} --}}
                        @endif>
                        <div class="searchList"></div>
                    </div>
                    <div class="form-group col-md-3 px-0 mb-0">
                        <select id="category" class="form-control" name="category">
                            <option value="">All categories...</option>
                            {{-- Categories injected from CategoryComposer --}}
                            @foreach ($categories as $category)
                            {{-- categoryinput only need to exist when on search page, so have to use PHP_GET function and check if categoryinput is there? (permanent session storage, can't use flash, cause of F5) --}}
                            <option value="{{ $category->id }}" @if (session('categoryinput')) {{ $category->id == session('categoryinput') ? "selected" : "" }}@endif>{{ $category->name }}</option>
                            @endforeach
                            {{ session()->forget('categoryinput') }}
                        </select>
                    </div>
                    <div class="form-group col-md-1 px-0 mb-0">
                        {{-- if searchzip logged in usertable not null, put in value --}}
                        {{-- <input type="text" class="form-control" id="zipcode" name="zipcode" value="{{ auth()->user() ? auth()->user()->searchzip : "" }}" placeholder="Zipcode"> --}}
                        <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zipcode"
                        {{-- What to do with >, like this or after every value (like this = no repeat+good extension implementation@home, what could be the value of the other) --}}
                        @if (session('nozipflash'))
                        value=""
                        @elseif (request()->cookie('pc'))
                        value="{{ request()->cookie('pc') }}"
                        @elseif (session('invalidzip'))
                        value="{{ session('invalidzip') }}"
                        @endif>
                    </div>
                    <div class="form-group col-md-3 px-0 mb-0">
                        <select id="distance" class="form-control" name="distance">
                            <option selected value="">All distances...</option>
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
                <div class="row">
                    <div class="col-5">
                        <p class="mb-0 text-danger">
                            <strong>{{ session('noresultmsg') ? session('noresultmsg') : "" }}</strong>
                        </p>
                    </div>
                    <div class="col-5">
                        <p class="text-center mb-0 text-danger">
                            <strong>{{ session('invalidzipmsg') ? session('invalidzipmsg') : "" }}</strong>
                        </p>
                    </div>
                    <div class="col-2"></div>
                </div>

                <div class="row">
                    <div class="col-4" >
                        {{-- Input Error Msg --}}
                    </div>
                    <div class="col-3">
                        {{-- Category Column --}}
                    </div>
                    <div class="col-1">
                    </div>
                    <div class="col-3">
                        {{-- Distance Column --}}
                    </div>
                    <div class="col-1">
                        {{-- Search Button (clutter) --}}
                    </div>
                </div>

            </form>
        </div>
    </div>
</nav>