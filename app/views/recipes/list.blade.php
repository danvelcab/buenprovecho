@extends('template')
@section('title', Lang::get('Prueba titulo'))


@section('content')
@include('recipes.scriptList')
<!-- Page Content -->
<div class="container">
        <div class="row">
                <div class="count-results col-md-12">
                        Tus ingredientes:
                        @foreach($selected_ingredients_object as $ingredient)
                                <span class="label label-success">{{$ingredient->name}}</span>
                        @endforeach
                </div>
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
                                                <div class ="col-md-12">
                                                        <img class="img-result thumbnail" style="width: 100%" src="{{$recipes[$i-1]->image_url}}">
                                                </div>
                                                <div class="description-result col-md-12">
                                                        <div class="title-result">
                                                                {{$recipes[$i-1]->name}}
                                                        </div>
                                                        <div class = "col-md-12">
                                                                <div class="time-result">
                                                                        <i class="glyphicon glyphicon-hourglass"></i>{{$recipes[$i-1]->time}} min
                                                                </div>
                                                                <div class="ingredients-result">
                                                                        Ingredientes:
                                                                        @foreach($recipes[$i-1]->ingredients()->get() as $ingredient)
                                                                                @if(in_array($ingredient->id, $selected_ingredients))
                                                                                        <span class="label label-success">{{$ingredient->name}}</span>
                                                                                @else
                                                                                        <span class="label label-warning">{{$ingredient->name}}</span>
                                                                                @endif

                                                                        @endforeach
                                                                </div>
                                                                <div class="button-result">
                                                                        <a href="{{$recipes[$i-1]->url}}" target="_blank">
                                                                                <button class="btn btn-primary btn-lg" onClick="ga('send', 'event', '_trackEvent', 'receta', 'cookpad', '1', '');">Ver receta</button>
                                                                        </a>
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
@if(sizeof($sugerencias) > 0)
        <form method="post"
              action="{{URL::asset('findRecipesWithSuggestions')}}">
                @if(sizeof($recipes) != 0)
                        <div class = "sugerencias bg-warning">
                                <div class="count-results"> Hemos encontrado recetas que también contienen estos ingredientes. ¿Cuentas con alguno de ellos?</div>
                @else
                        <div class = "sugerencias bg-danger">
                                <div class="count-results"> No se han obtenido recetas con los ingredientes indicados.
                                        Sin embargo hemos encontrados recetas que además llevan éstos. ¿Cuentas con alguno de ellos?</div>
                @endif
                        @foreach($selected_ingredients as $ingredient)
                                <input name = "{{$ingredient}}" hidden value = 'on'>
                        @endforeach
                        @foreach($no_selected_ingredients as $ingredient)
                                <input name = "{{$ingredient}}" hidden value = 'off'>
                        @endforeach
                        @foreach($sugerencias as $ingredient)
                                <input name = "{{$ingredient->id}}" hidden value = 'off'>
                        @endforeach
                        @for($i = 1;$i<=sizeof($sugerencias);$i++)
                                @if($i%3==1)
                                        <div class="results row">
                                                @endif
                                                <div class="col-md-4">
                                                        <h2 class="h4">{{$sugerencias[$i-1]->name}}</h2>
                                                        <p>
                                                                <input name="{{$sugerencias[$i-1]->id}}" type="checkbox" id = "{{$sugerencias[$i-1]->id}}"
                                                                       data-on-text="Yes" data-off-text="No"
                                                                       data-off-color="warning" data-on-color="success">
                                                                <?php $id = $sugerencias[$i-1]->id?>
                                                        </p>
                                                </div>
                                                <script>$("#"+"<?php echo $id?>").bootstrapSwitch();</script>
                                                @if($i%3==0)
                                        </div>
                                @elseif($i == sizeof($sugerencias))
                </div>
                @endif
                @endfor
                <div>
                        <button type="submit" class="btn btn-primary center-block btn-lg" onClick="ga('send', 'event', '_trackEvent', 'segundas_busquedas', '', '0', '');">Buscar más recetas</button>
                </div>
        </form>
        </div>
        <button style="margin-top: 20px" onclick="window.location = '../public', ga('send', 'event', '_trackEvent', 'busqueda_diferente', '', '0', '')" class="btn btn-primary center-block btn-lg" >Empezar nueva búsqueda</button>
        @endif



@stop

