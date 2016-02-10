<div class="form-group">

    {!! Form::label('title', 'Article Title') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}

</div>

<div class="form-group">

    {!! Form::label('body', 'Article Body') !!}
    {!! Form::textarea('body', null, ['class' => 'form-control']) !!}

</div>

<div class="form-group">

    {!! Form::label('published_at', 'Publish Date') !!}
    <div class="input-group date">
        {!! Form::text('published_at', null, ['type' => 'text','class' => 'form-control','placeholder' =>'mm/dd/yyyy', 'id' => 'published_at']) !!}
        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
    </div>
</div>

<div class="form-group">

    {!! Form::label('tagList', 'Tags') !!}
    {!! Form::select('tagList[]', $tags ,null, ['class' => 'form-control', 'multiple']) !!}

</div>

<div class="form-group">

    {!! Form::submit($submitButtonText, ['class'=>'btn btn-primary']) !!}

</div>