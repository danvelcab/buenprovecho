@extends('template')
@section('title', Lang::get('Prueba titulo'))


@section('content')
@include('recipes.scriptList')
<header class="find-others">
        <div class="jumbotron">
                <form method="post"
                      action="{{URL::asset('findRecipes')}}">
                        <div class="choose-ingredients">
                                <div class="text-jumbotron2">¿No encontraste lo que esperabas? Prueba con otros ingredientes</div>
                        </div>
                        <div class="select2-select">
                                <select class="js-example-basic-multiple" multiple="multiple" name="ingredients[]" id="tags">
                                        @foreach($ingredients as $ingredient)
                                                <option value="{{$ingredient->id}}">{{$ingredient->name}}</option>
                                        @endforeach
                                </select>
                                <script type="text/javascript">
                                        $(".js-example-basic-multiple").select2();
                                </script>
                        </div>
                        <div>
                                <button type="submit" class="btn btn-primary center-block btn-lg">Buscar recetas</button>
                        </div>
                </form>
        </div>
        @foreach($selected_ingredients as $ingredient)

        @endforeach
</header>
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
                                                                        <a href="{{$recipes[$i-1]->url}}" target="_blank"><button class="btn btn-primary btn-lg">Ver receta</button></a>
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
                <div class = "sugerencias bg-warning">
                        <div class="count-results"> ¿Puedes decirnos si cuentas con algunos de estos ingredientes para obtener mejores resultados?</div>
                        @foreach($selected_ingredients as $ingredient)
                                <input name = "{{$ingredient}}" hidden value = 'on'>
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
                                                <script>$("[name='<?php echo $id?>']").bootstrapSwitch();</script>
                                                @if($i%3==0)
                                        </div>
                                @elseif($i == sizeof($sugerencias))
                </div>
                @endif
                @endfor
                <div>
                        <button type="submit" class="btn btn-primary center-block btn-lg">Buscar más recetas</button>
                </div>
        </form>
        </div>
        @endif



@stop

