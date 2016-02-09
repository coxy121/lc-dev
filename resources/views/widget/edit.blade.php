@extends('layouts.master')

@section('title')

    <title>Edit a Widget</title>

@endsection

@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'Widgets' => '/widget', $widget->widget_name]) !!}

        <h1>Update</h1>

        <hr/>

        @include('errors.list')

        {!! Form::model($widget, ['route' => ['widget.update', $widget->id],
                                  'method' => 'PATCH',
                                  'class' => 'form',
                             ]) !!}

        @include('widget.partials.widget-form', ['submitButtonText' => 'Update Widget'])

        {!! Form::close() !!}

    </div>

@endsection

@section('scripts')

    @include('widget.dropdown-script', ['subcategory' => $widget->subcategory_id])

@endsection