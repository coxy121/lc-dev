@extends('layouts.master')

@section('title')
    <title>{{ $widget->widget_name }}</title>
@endsection

@section('content')

    <div class="container">

        {!! Breadcrumb::withLinks(['Home' => '/', 'Widgets' => '/widget', $widget->widget_name => $widget->id]) !!}


        <div><h1>{{ $widget->widget_name }}</h1></div>

        <div>
            <div class="baseMargin"> <a href="/widget/create"><button type="button" class="btn btn-lg btn-primary">
                        Create New</button></a></div>
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading"></div>
                <div class="panel-body ">

                </div>

                <!-- Table -->
                <table class="table table-striped">
                    <tr>

                        <th>Id</th>
                        <th>Name</th>
                        <th>Date Created</th>
                        <th>Edit</th>
                        <th>Delete</th>

                    </tr>


                    <tr>
                        <td>{{ $widget->id }} </td>

                        @if(Auth::user()->adminOrCurrentUserOwns($widget))

                            <td> <a href="/widget/{{ $widget->id }}/edit">

                                    {{ $widget->widget_name }}</a></td>

                        @else

                            <td>{{ $widget->widget_name }}</td>

                        @endif

                        <td>{{ $widget->showDateCreated($widget->created_at) }}</td>

                        <td> <a href="/widget/{{ $widget->id }}/edit">
                                <button type="button" class="btn btn-default">Edit</button></a></td>
                        <td>{!! Form::model($widget, ['route' => ['widget.destroy', $widget->id],
                            'method' => 'DELETE'
                            ]) !!}
                            <div class="form-group">

                                {!! Form::submit('Delete', array('class'=>'btn btn-danger', 'Onclick' => 'return ConfirmDelete();')) !!}

                            </div>
                            {!! Form::close() !!}</td>
                    </tr>

                </table>

            </div>
        </div>
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