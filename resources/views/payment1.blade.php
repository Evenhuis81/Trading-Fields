@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <select name="plan" class="form-control">
                        @foreach ($plans as $key => $plan)
                        <option value="{{ $key }}">{{ $plan }}</option>
                        @endforeach
                    </select>
                    <input placeholder="Card Holder" class="form-control" id="card-holder-name" type="text">

                    <!-- Stripe Elements Placeholder -->
                    <div class="ml-3 my-2" id="card-element"></div>

                    <button class="mt-2 btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">
                        Subscribe
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection