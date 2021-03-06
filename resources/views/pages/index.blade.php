@extends('layouts.master')

@section('title')

    <title>LC - Dev Homepage</title>

    @endsection

    @section('content')

    {!! Breadcrumb::withLinks(['Home' => '/', 'LC - Dev']) !!}
    <div class="baseMargin">
        <div
                class="fb-like"
                data-share="true"
                data-width="450"
                data-show-faces="true">
        </div>
    </div>

    @include('pages.slider')

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">

        <h1>LC - Dev</h1>

        <p>Use it as a starting point to create something more unique by
            building on or modifying it.
        </p>

    </div>

@endsection