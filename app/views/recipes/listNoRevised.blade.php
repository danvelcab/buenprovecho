@extends('template')
@section('title', Lang::get('Prueba titulo'))


@section('content')
@include('recipes.scriptList')
        <!-- Page Content -->
<div class="container">
    <div class="row">

        <div class="count-results col-md-12">
            {{sizeof($recipes)}} resultados encontrados
        </div>
        <hr>
    </div>
    @for($i = 1;$i<=sizeof($recipes);$i++)
        @if($i%3==1)
            <div class="results row">
                @endif
                <div class="result col-md-4" >
                    <div class="resultdiv col-md-12">
                        <a href="editRecipe/{{$recipes[$i-1]->id}}" target="_self">
                            <button class="btn btn-primary btn-lg">Ver receta</button>
                        </a>
                        <div class ="col-md-12">
                            <img class="img-result thumbnail" style="width: 100%" src="{{$recipes[$i-1]->image_url}}">
                        </div>
                        <div class="description-result col-md-12">
                            <div class="title-result">
                                {{$recipes[$i-1]->name}}
                            </div>
                            <div class = "col-md-12">
                                <div class="button-result">

                                </div>
                                <div class="time-result">
                                    <i class="glyphicon glyphicon-hourglass"></i>{{$recipes[$i-1]->time}} min
                                </div>
                                <div class="ingredients-result">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                @if($i%3==0)
            </div>
        @elseif($i == sizeof($recipes))
</div>
@endif
@endfor

@stop

