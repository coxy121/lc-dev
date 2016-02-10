@extends('layouts.master')

@section('title')

    <title>The Article Page</title>

@endsection

@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'Articles' => '/articles']) !!}

        <h1>Articles</h1>

        <!--include('widget.datatable')-->
        @foreach($articles as $article)
            <article>
                <h2>
                    <a href="{{url('/articles',$article->id)}}">{{ $article->title }}</a>
                </h2>
                <div class="body">{{ $article->body }}</div>
            </article>
        @endforeach

    </div>

@endsection

@section('scripts')

    <!--include('widget.datatable-script')-->

@endsection