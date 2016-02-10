@extends('layouts.master')

@section('title')

    <title>Edit an Article</title>

@endsection

@section('content')
    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'Articles' => '/articles', $article->title]) !!}

        <h1>Update an Article</h1>

        <hr/>

        @include('errors.list')

        {!! Form::model($article, ['route' => ['articles.update', $article->id],
                                  'method' => 'PATCH',
                                  'class' => 'form',
                             ]) !!}

        @include('articles.partials.articles-form', ['submitButtonText' => 'Update Article'])

        {!! Form::close() !!}

    </div>

@endsection
@section('scripts')

    @include('articles.datepicker-script')

@endsection