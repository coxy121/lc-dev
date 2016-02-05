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

                <!-- widget_name Form Input -->

        <div class="form-group">

            {!! Form::label('widget_name', 'Widget Name') !!}
            {!! Form::text('widget_name', null, ['class' => 'form-control']) !!}

        </div>

        <div class="form-group">

            <label>Category:</label><br>

            <select class="form-control input-md" name="category_id" id="category_id">

                <option value="">Select Category</option>

                @foreach($categories as $category)

                    <option value="{{ $category->id }}"> {{$category->category_name}}</option>

                @endforeach

            </select>

        </div>


        <div class="form-group">

            <label>Subcategory:</label><br>

            <select class="form-control input-md" name="subcategory_id" id="subcategory_id">

                <option value="">First Select a Category</option>

            </select>

        </div>

        <div class="form-group">

            {!! Form::submit('Create Widget', ['class'=>'btn btn-primary']) !!}

        </div>

        {!! Form::close() !!}

    </div>

@endsection

@section('scripts')

    @include('widget.dropdown-script')

@endsection