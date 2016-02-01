<h1>Lee Test</h1>
@if(!count($Names)>0)
    @foreach($Names as $name)
        {{$name}} <br>
    @endforeach
@else
    <h1>Nothing to see here...</h1>
@endif