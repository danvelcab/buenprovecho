@extends('template')
@section('title', Lang::get('Prueba titulo'))


@section('content')

<header class="business-header">
        <div class="jumbotron">
                <form method="post"
                      action="{{URL::asset('findRecipes')}}">
                        <div class="title-header">
                                Tus ingredientes, tus reglas
                        </div>
                        <div class="choose-ingredients">
                                <div class="text-jumbotron">¿Con qué ingredientes cuentas?</div>
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
                                <button type="submit" onClick="_gaq.push(['_trackEvent', 'buscar_landing', '', '']);" class="btn btn-primary center-block btn-lg" >
                                        Buscar recetas</button>
                        </div>
                </form>
        </div>
</header>
<!-- Page Content -->
<div class="container">

        <!-- Marketing Icons Section -->
        <div class="row">
                <div class="col-lg-12">
                        <h1 class="page-header">
                                ¿No sabes qué cocinar? Te lo ponemos fácil ...
                        </h1>
                </div>
                <div class="col-md-4">
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <h4><i class="glyphicon glyphicon-apple"></i> Dinos qué tienes en la cocina </h4>
                                </div>
                                <div class="panel-body">
                                        <p>Mira dentro de tu frigorífico y dinos qué ingredientes tienes. Buen provecho es la mejor forma de aprovechar tus alimentos. Elige entre más de 1000 tipos de ingredientes y todo tipo de platos (cocina tradicional, fast food, tex-mex ...)</p>
                                </div>
                        </div>
                </div>
                <div class="col-md-4">
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <h4><i class="glyphicon glyphicon-book"></i> Elige una receta</h4>
                                </div>
                                <div class="panel-body">
                                        <p>Te propondremos recetas que podrás elaborar a partir de los ingredientes que introduzcas. Te ahorramos pensar qué cocinar. Solo tienes que elegir la que más te guste</p>
                                </div>
                        </div>
                </div>
                <div class="col-md-4">
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <h4><i class="glyphicon glyphicon-hourglass"></i> ¡Buen provecho!</h4>
                                </div>
                                <div class="panel-body">
                                        <p>Solo te queda empezar a cocinar y sacarle el mejor partido a tus alimentos. ¡Buen provecho!</p>
                                </div>
                        </div>
                </div>
        </div>

@stop