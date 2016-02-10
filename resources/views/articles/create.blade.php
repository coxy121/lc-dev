@extends('layouts.master')

@section('title')

    <title>Create an Article</title>

@endsection

@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'Articles' => '/articles', 'Create']) !!}

        <h2>Create a New Article</h2>

        <hr/>

        @include('errors.list')

        {!! Form::open(array('url' => '/articles', 'class' => 'form')) !!}

        @include('articles.partials.articles-form', ['submitButtonText' => 'Create Article'])

        {!! Form::close() !!}

    </div>

@endsection
@section('scripts')

    @include('articles.datepicker-script')

@endsection