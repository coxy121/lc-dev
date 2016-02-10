@extends('layouts.master')

@section('title')
    <title>{{ $article->widget_name }}</title>
@endsection

@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'Articles' => '/articles', $article->title => $article->id]) !!}


        <div><h1>{{ $article->title }}</h1></div>
        <article>
            {{ $article->body }}
        </article>

        @unless ($article->tags->isEmpty())
            <h5>Tags:</h5>
            <ul>
                @foreach($article->tags as $tag)
                    <li>{{ $tag->tag_name }}</li>
                @endforeach
            </ul>
        @endunless
    </div>

@endsection
@section('scripts')
    <script>

        function ConfirmDelete()
        {
            var x = confirm("Are you sure you want to delete?");
            if (x)
                return true;
            else
                return false;
        }

    </script>

@endsection