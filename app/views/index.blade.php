@extends('template')
@section('title', Lang::get('Prueba titulo'))


@section('content')

        <header class="business-header">
        <div class="jumbotron">
                <div class="title-header">
                        ¿Con qué ingredientes cuentas?
                </div>
                <div class="choose-ingredients" id = "choose-principal-ingredients">
                        <div class="text-jumbotron">Indica almenos 3 ingredientes principales<div class="beta">(Todos los platos sugeridos contendrán por lo menos uno de ellos)</div></div>
                </div>
                <div class="select2-select" id = "select-principal-ingredients">
                        <select onChange ="checkThreeIngredients()" class="js-example-basic-multiple" multiple="multiple" name="ingredients[]" id="tags">
                                @foreach($ingredients as $ingredient)
                                        <option value="{{$ingredient->id}}">{{$ingredient->name}}</option>
                                @endforeach

                        </select>
                        <script type="text/javascript">
                                $(".js-example-basic-multiple").select2();
                        </script>
                </div>

                <div id="button">
                        <button id="continue" disabled onClick="cont()" class="btn btn-primary center-block btn-lg" >
                                Continuar</button>
                </div>
                <div class="row">
                        <div class="col-md-12 count-results-index" id="count-results">
                        </div>
                </div>
                <div class="num-recipes" id="num-recipes">
                </div>
                <div class="choose-ingredients" id = "choose-secondary-ingredients">
                        <div class="text-jumbotron">Indica almenos 2 ingredientes adicionales</div>
                </div>
                <div class="select2-select" id = "select-secondary-ingredients">
                        <select onChange ="checkTwoIngredients()" class="js-example-basic-multiple" multiple="multiple" name="ingredients[]" id="tags2">
                        </select>
                        <script type="text/javascript">
                                $(".js-example-basic-multiple").select2();
                        </script>
                </div>
                <div class="center-block">
                        <div class="row">
                                <div class="col-md-12 col-lg-12" style="text-align: center; margin-bottom: 10px">
                                <button  id="buttonFindSuggestions" disabled onClick="findSuggestions()" class="btn btn-primary btn-lg " >
                                        Buscar recetas</button>
                                </div>
                                <div class="col-md-12 col-lg-12" style="text-align: center">
                                <a href=""><button  id="empezar" class="btn btn-primary btn-md" >
                                        Empezar de nuevo</button></a>
                                </div>
                                <script type="text/javascript">
                                        $('#count-results').hide();
                                        $('#choose-secondary-ingredients').hide();
                                        $('#select-secondary-ingredients').hide();
                                        $('#buttonFindSuggestions').hide();
                                        $('#empezar').hide();
                                </script>
                        </div>
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
                                        <button type="submit" onClick="ga('send', 'event', '_trackEvent', 'buscar_landing', '', '0', '');" class="btn btn-primary">Buscar recetas</button>
                                </div>
                                </form>
                        </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <script type="text/javascript">
                function checkThreeIngredients(){
                        var tags = $('#tags');
                        if(tags.val() != null && tags.val().length >= 3){
                                $('#continue').prop('disabled',false);
                        }
                }
                function checkTwoIngredients(){
                        var tags = $('#tags2');
                        if(tags.val() != null && tags.val().length >= 2){
                                $('#buttonFindSuggestions').prop('disabled',false);
                        }
                }
                function cont(){
                        var ingredients = $('#tags').val();
                        $.ajax({
                                method: 'POST',
                                dataType:'json',
                                url: window.location.pathname+'/findSecondary',
                                data: {ingredients: ingredients},
                                success: function(datas) {
                                        if(datas['error']){
                                                notificar(datas['message']);
                                        }else{
                                                $.each(datas['secondary'], function (i, data) {
                                                        $('#tags2').append($('<option>', {
                                                                value: data['id'],
                                                                text : data['name']
                                                        }));
                                                });
                                                $('#choose-principal-ingredients').hide();
                                                $('#select-principal-ingredients').hide();
                                                $('#tags').hide();
                                                $('#button').empty();
                                                $('#count-results').show();
                                                $('#choose-secondary-ingredients').show();
                                                $('#select-secondary-ingredients').show();
                                                $('#buttonFindSuggestions').show();
                                                $('#empezar').show();
                                                notificar("Se han encontrado "+datas['num_recipes']+" recetas con estos ingredientes principales." +
                                                        " Índicanos algunos ingredientes adicionales para continuar");

                                        }
                                },
                                error: function(datas){
                                        notificarError("<?= Lang::get('notifications.refresh') ?>")
                                }
                        });
                }

                function findSuggestions(){
                        var ingredients = $('#tags').val();
                        var secondary_ingredients = $('#tags2').val();
                        $.ajax({
                                method: 'POST',
                                dataType:'json',
                                url: window.location.pathname+'/findIngredients',
                                data: {ingredients: ingredients, secondary_ingredients: secondary_ingredients},
                                success: function(datas) {
                                        if(datas['error']){
                                                notificar(datas['message']);
                                        }else{
                                                $('#suggestions').empty();
                                                var selected_ingredients = $('#tags').val();
                                                var optional_ingredients = $('#tags2').val();
                                                var html = "";
                                                for(var i = 0; i<selected_ingredients.length;i++){
                                                        html = html + "<input name = primary-"+selected_ingredients[i]+" hidden value = 'on'>";
                                                }
                                                for(var i = 0; i<optional_ingredients.length;i++){
                                                        html = html + "<input name = "+optional_ingredients[i]+" hidden value = 'on'>";
                                                }
                                                var suggestions = datas['suggestions'];
                                                for(var i = 0;i<suggestions.length; i++){
                                                        html = html + "<input name = "+suggestions[i]['id']+" hidden value = 'off'>";
                                                }
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
                                                        $("#"+suggestions[i-1]['id']+"").bootstrapSwitch();
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
