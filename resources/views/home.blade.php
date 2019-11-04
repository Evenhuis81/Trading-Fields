@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="text-center card-header" style="font-size: 1.4em">
                    <strong>{{ __('Success') }}</strong></div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="text-center">
                        @adman
                        <p>You are logged in as an Advertiser</p>
                        <a href="{{ route('index') }}" class="btn btn-info">Index Page</a>
                        <a href="{{ route('adverts.create') }}" class="btn btn-secondary ml-3">Create Advert</a>
                        <a href="{{ route('adverts.index') }}" class="btn btn-success ml-3">Manage Adverts</a>
                        @endadman
                        @admin
                        <p>You are logged in as an Administrator</p>
                        <a href="{{ route('index') }}" class="btn btn-info">Index Page</a>
                        <a href="/" class="btn btn-dark">Admin Dashboard</a>
                        @endadmin
                        @visitor
                        <p>You are logged in as a Visitor</p>
                        <a href="{{ route('index') }}" class="btn btn-primary">Index Page</a>
                        @endvisitor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection