@extends('layouts.master')

@section('title')

    <title>Create a Widget</title>

@endsection

@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'Widgets' => '/widget', 'Create']) !!}

        <h2>Create a New Widget</h2>

        <hr/>

        @include('errors.list')

        {!! Form::open(array('url' => '/widget', 'class' => 'form')) !!}

        @include('widget.partials.widget-form', ['submitButtonText' => 'Create Widget'])

        {!! Form::close() !!}

    </div>

@endsection

@section('scripts')

    @include('widget.dropdown-script')

@endsection