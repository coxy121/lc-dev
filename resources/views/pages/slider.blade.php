<div class="baseMargin">

    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

        <!-- Indicators -->

        <ol class="carousel-indicators">

            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>

            @foreach(range(1, $count) as $number)

                <li data-target="#carousel-example-generic" data-slide-to="{{ $number }}"></li>

            @endforeach

        </ol>

        <!-- Wrapper for slides -->


        <div class="carousel-inner" role="listbox">

            <div class="item active">

                <img src="/imgs/marketing/{{ $featuredImage->image_name
                                        . '.' .
                                        $featuredImage->image_extension }}" alt="...">

                <div class="carousel-caption">
                    <h1></h1>
                </div>

            </div>

            @foreach($activeImages as $image)

                <div class="item">



                    <img src="/imgs/marketing/{{ $image->image_name
                                        . '.' .
                                        $image->image_extension }}" alt="...">


                    <div class="carousel-caption">
                        <h1> </h1>
                    </div>

                </div>

            @endforeach

        </div>

        <!-- Controls -->

        <a class="left carousel-control" href="#carousel-example-generic" role="button"
           data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button"
           data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>