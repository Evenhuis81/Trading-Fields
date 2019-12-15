@extends('layouts.main')

@section('searchbar')
@include('layouts.searchbar')
@endsection

@section('content')

<div class="container">
    <chats :user="{{ auth()->user() }}"></chats>
</div>

@endsection
