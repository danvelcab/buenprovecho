@extends('template')
@section('title', Lang::get('Prueba titulo'))


@section('content')

<header class="business-header">
        <div class="jumbotron">
                <div class="title-header">
                        Tus ingredientes, tus reglas
                </div>
                <div class="choose-ingredients">
                        <div class="text-jumbotron">¿Con qué ingredientes cuentas?<div class="beta">(Indica almenos 4 ingredientes)</div></div>
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
                        <button onClick="findSuggestions()" class="btn btn-primary center-block btn-lg" >
                                Buscar recetas</button>

                </div>
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

        <div class="modal fade" tabindex="-1" role="dialog" id="modal">
                <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Necesitamos saber más...</h4>
                                </div>
                                <form method="post"
                                      action="{{URL::asset('findRecipesWithSuggestions')}}">
                                <div class="modal-body">
                                        <p>Los ingredientes que has introducido combinan bien con algunos de estos ¿Puedes decirnos si cuentas con alguno de ellos?</p>
                                        <div id="suggestions">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                        <button type="submit" onClick="_gaq.push(['_trackEvent', 'buscar_landing', '', '']);" class="btn btn-primary">Buscar recetas</button>
                                </div>
                                </form>
                        </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <script type="text/javascript">
                function findSuggestions(){
                        var ingredients = $('#tags').val();
                        $.ajax({
                                method: 'POST',
                                dataType:'json',
                                url: window.location.pathname+'/findIngredients',
                                data: {ingredients: ingredients},
                                success: function(datas) {
                                        if(datas['error']){
                                                notificar(datas['message']);
                                        }else{
                                                $('#suggestions').empty();
                                                var selected_ingredients = $('#tags').val();
                                                var html = "";
                                                for(var i = 0; i<selected_ingredients.length;i++){
                                                        html = html + "<input name = "+selected_ingredients[i]+" hidden value = 'on'>";
                                                }
                                                var suggestions = datas['suggestions'];
                                                for(var i = 1;i<=suggestions.length; i++){
                                                        if(i%3==1){
                                                                var html = html +  '<div class="results row">';
                                                        }
                                                        html = html + '<div class="col-md-4">' +
                                                                '<h2 class="h4">'+suggestions[i-1]['name']+'</h2>'+
                                                                        '<p>'+
                                                                                '<input name="'+suggestions[i-1]['id']+'" type="checkbox" id = "'+
                                                        suggestions[i-1]['id']+'"data-on-text="Yes" data-off-text="No" data-off-color="warning" data-on-color="success">'+
                                                                        '</p>'+
                                                                '</div>'
                                                        if(i%3==0){
                                                                html = html + '</div>';
                                                        }else if(i == suggestions.length){
                                                                html = html + '</div>';
                                                        }
                                                }
                                                $('#suggestions').append(html);
                                                for(var i = 1;i<=suggestions.length; i++){
                                                        $("[name="+suggestions[i-1]['id']+"]").bootstrapSwitch();
                                                }

                                                $('#modal').modal('show');

                                        }
                                },
                                error: function(datas){
                                        notificarError("<?= Lang::get('notifications.refresh') ?>")
                                }
                        });
                }
        </script>
@stop
