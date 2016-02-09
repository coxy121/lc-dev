<div class="form-group">

    {!! Form::label('widget_name', 'Widget Name') !!}
    {!! Form::text('widget_name', null, ['class' => 'form-control']) !!}

</div>

<div class="form-group">

    {!! Form::label('category_id', 'Category') !!}
    {!! Form::select('category_id', $categories, null, ['class' => 'form-control','placeholder' => 'Select Category','id' => 'category_id']) !!}

</div>


<div class="form-group">
    {!! Form::label('subcategory_id', 'Subcategory') !!}
    {!! Form::select('subcategory_id', $subcategories, null, ['class' => 'form-control','placeholder' => 'First Select a Category','id' => 'subcategory_id']) !!}

</div>

<div class="form-group">

    {!! Form::submit($submitButtonText, ['class'=>'btn btn-primary']) !!}

</div>