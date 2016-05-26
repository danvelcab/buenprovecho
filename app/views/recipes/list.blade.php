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
                        @foreach($optional_selected_ingredients_object as $ingredient)
                                <span class="label label-warning">{{$ingredient->name}}</span>
                        @endforeach
                </div>
                <div class="count-results col-md-12">
                        {{sizeof($recipes)}} resultados encontrados
                        <button onclick="window.location = '../public', ga('send', 'event', '_trackEvent', 'busqueda_diferente', '', '0', '')" class="btn btn-primary center-block btn-lg busqueda-diferente" >Empezar nueva búsqueda</button>
                </div>
                <div class="count-results col-md-12">
                        <span class="ingredient label label-success"> Principal </span>
                        <span class="label label-warning"> Secundario </span>
                        <span class="ingredient label label-danger"> No coincidencia </span>
                </div>
                <hr>
        </div>
        @for($i = 1;$i<=sizeof($recipes);$i++)
                @if($i%3==1)
                        @if($i<=12)
                        <div class = "ads">
                                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                <!-- Primeros anuncios -->
                                <ins class="adsbygoogle"
                                     style="display:inline-block;width:728px;height:90px"
                                     data-ad-client="ca-pub-5060585163302076"
                                     data-ad-slot="9012834343"></ins>
                                <script>
                                        (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>
                        </div>
                        @endif
                        <div class="results row">
                                @endif
                                <div itemscope itemtype ="http://schema.org/Recipe" class="result col-md-4" >
                                        <div class="resultdiv col-md-12">
                                                <div itemprop="photo" class ="col-md-12">
                                                        <img class="img-result thumbnail foto"  src="{{$recipes[$i-1]->image_url}}">
                                                </div>
                                                <div class="description-result col-md-12">
                                                        <div itemprop="name" class="title-result">
                                                                {{$recipes[$i-1]->name}}
                                                        </div>
                                                        <div class = "col-md-12">
                                                                <div class="time-result">
                                                                        <i class="glyphicon glyphicon-hourglass"></i>{{$recipes[$i-1]->time}} min
                                                                </div>
                                                                <div itemprop="ingredients" class="ingredients-result">
                                                                        Ingredientes:
                                                                        @foreach($recipes[$i-1]->ingredients()->get() as $ingredient)
                                                                                @if(in_array($ingredient->id, $selected_ingredients))
                                                                                        <span itemprop="ingredient" class="label label-success">{{$ingredient->name}}</span>
                                                                                @else
                                                                                        @if(in_array($ingredient->id, $optional_selected_ingredients))
                                                                                                <span itemprop="ingredient" class="label label-warning">{{$ingredient->name}}</span>
                                                                                        @else
                                                                                                <span itemprop="ingredient" class="label label-danger">{{$ingredient->name}}</span>
                                                                                        @endif
                                                                                @endif

                                                                        @endforeach
                                                                </div>
                                                                <div class="button-result">
                                                                        <a href="{{$recipes[$i-1]->url}}" target="_blank">
                                                                                <button class="btn btn-primary btn-lg" onClick="ga('send', 'event', '_trackEvent', 'receta', '{{$recipes[$i-1]->web}}', '1', '');">Ver receta</button>
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
                                                        <input name = "primary-{{$ingredient}}" hidden value = 'on'>
                                                @endforeach
                                                @foreach($optional_selected_ingredients as $ingredient)
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
@endif




@stop

