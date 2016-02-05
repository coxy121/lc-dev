@extends('layouts.master')
@section('title')
    <title>LC - Dev Test Page</title>
@endsection
@section('content')
    <h1>Lee Test</h1>
    @if(!count($Names)>0)
        @foreach($Names as $name)
            {{$name}} <br>
        @endforeach
    @else
        <h1>Nothing to see here...</h1>
    @endif
@endsection