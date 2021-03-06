@extends('template')
@section('title', Lang::get('Prueba titulo'))


@section('content')


        <header class="business-header">
        <div class="jumbotron" ng-app="app" ng-controller="RecipeController">
                <h2 class="title-header">
                        ¿Con qué ingredientes cuentas?
                </h2>
                <noscript><div class="alerta alert alert-danger">Sorry, your browser does not support JavaScript!</div></noscript>
                <div class="choose-ingredients" id = "choose-principal-ingredients">
                        <div class="text-jumbotron">Indica almenos 3 ingredientes principales<div class="beta">(Todos los platos sugeridos contendrán por lo menos uno de ellos)</div></div>
                </div>
                <div itemscope itemtype ="http://schema.org/Recipe" class="select2-select" id = "select-principal-ingredients">
                        <select ng-model="ingredients" itemprop="ingredients" onChange ="checkThreeIngredients()" class="js-example-basic-multiple" multiple="multiple" name="ingredients[]" id="tags">
                                @foreach($ingredients as $ingredient)
                                        <option value="{{$ingredient->id}}">{{$ingredient->name}}</option>
                                @endforeach

                        </select>
                        <script type="text/javascript">
                                $(".js-example-basic-multiple").select2();
                        </script>
                </div>

                <div id="button">
                        <button id="continue" ng-click="findSecondary()" disabled class="btn btn-primary center-block btn-lg" >
                                Continuar</button>
                </div>
                <div class="row">
                        <div class="col-md-12 count-results-index" id="count-results">
                        </div>
                </div>
                <div class="choose-ingredients" id = "choose-secondary-ingredients">
                        <div class="text-jumbotron">Indica almenos 2 ingredientes adicionales</div>
                </div>
                <div class="select2-select" id = "select-secondary-ingredients">
                        <select onChange ="checkTwoIngredients()" class="js-example-basic-multiple" multiple="multiple" name="ingredients[]" id="tags2">
                                <option ng-repeat="ing in secondary"
                                        value="@{{ing.id}}">
                                        @{{ing.name}}
                                </option>
                        </select>
                        <script type="text/javascript">
                                $(".js-example-basic-multiple").select2();
                        </script>
                </div>
                <div id="count-recipes" class="count-recipes">

                </div>
                <div class="center-block">
                        <div class="row">
                                <div class="col-md-12 col-lg-12 find-recipe">
                                <button  id="buttonFindSuggestions" disabled onClick="findSuggestions()" class="btn btn-primary btn-lg " >
                                        Buscar recetas</button>
                                </div>
                                <div class="col-md-12 col-lg-12 restart text-jumbotron3" id="o">
                                        o
                                </div>
                                <div class="col-md-12 col-lg-12 restart">
                                <a href="" id="empezar">
                                        <strong>Empezar de nuevo</strong></a>
                                </div>
                                <script type="text/javascript">
                                        $('#count-results').hide();
                                        $('#choose-secondary-ingredients').hide();
                                        $('#select-secondary-ingredients').hide();
                                        $('#buttonFindSuggestions').hide();
                                        $('#empezar').hide();
                                        $('#o').hide();
                                </script>
                        </div>
                </div>
        </div>
</header>
<!-- Page Content -->
<div class="container">
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

        <!-- Marketing Icons Section -->
        <div class="row">
                <div class="col-lg-12">
                        <h1 class="page-header">
                                ¿No sabes qué cocinar? Te lo ponemos fácil
                        </h1>
                </div>
                <div class="col-md-4">
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <h4><i class="glyphicon glyphicon-apple"></i> Dinos qué tienes en la frigorífico </h4>
                                </div>
                                <div class="panel-body">
                                        <p>
                                                Mira dentro de tu frigorífico y dinos qué ingredientes tienes.
                                                Primero piensa en aquellos ingredientes principales que quieras gastar
                                                y añade una lista de ingredientes adicionales con los que combinarlos.
                                                Buen provecho es una solución para que tu comida no se heche más a perder.
                                                Nosotros te diremos que hacer con ella antes.
                                        </p>
                                </div>
                        </div>
                </div>
                <div class="col-md-4">
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <h4><i class="glyphicon glyphicon-book"></i> Elige una receta</h4>
                                </div>
                                <div class="panel-body">
                                        <p>
                                                En Buen provecho podrás elegir entre casi 1000 ingredientes y más
                                                de 200 recetas de toda clase. (cocina tradicional, fast food, tex-mex ...)
                                                Te propondremos únicamente recetas que podrás elaborar a partir de los
                                                ingredientes que introduzcas. Te ahorramos pensar qué cocinar.
                                                Solo tienes que elegir la receta que más te guste.</p>
                                </div>
                        </div>
                </div>
                <div class="col-md-4">
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <h4><i class="glyphicon glyphicon-hourglass"></i> ¡Buen provecho!</h4>
                                </div>
                                <div class="panel-body">
                                        <p>
                                                En tan solo unos simples pasos y en cuestion de un par de minutos,
                                                Buen provecho te asegura encontrar numerosas recetas para aquellos
                                                ingredientes con los que no sabes que hacer.
                                                Buen provecho es la mejor forma de aprovechar tus alimentos.<br>
                                                ¡Qué aproveches!

                                        </p>
                                </div>
                        </div>
                </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modal">
                <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Necesitamos saber más</h4>
                                </div>
                                <form method="post"
                                      action="{{URL::asset('findRecipesWithSuggestions')}}">
                                <div class="modal-body">
                                        <p>Los ingredientes que has introducido combinan bien con algunos de estos ¿Puedes decirnos si cuentas con alguno de ellos?</p>
                                        <div id="suggestions">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                        <div class="alerta alert alert-danger">Al indicar que no tienes un ingredientes excluyes todas aquellas recetas que lo contengan</div>
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
                                $('.select2-selection').css('border-width',1);
                                $('.select2-selection').css('border-color','rgb(170,170,170)');
                        }
                        var ingredients = $('#tags').val();
                        var secondary_ingredients = $('#tags2').val();
                        if(tags.val().length > 0){
                                $.ajax({
                                        method: 'POST',
                                        dataType:'json',
                                        url: window.location.pathname+'/countRecipes',
                                        data: {ingredients: ingredients, secondary_ingredients: secondary_ingredients},
                                        success: function(datas) {
                                                $('#count-recipes').empty();
                                                var count = datas['count'];
                                                if(count == 0){
                                                        $('#count-recipes').append('<div class="alert alert-danger count-recipes count-recipes2">' +
                                                                count + ' recetas. Sugerencias: '+ datas['s1'] + ', '+
                                                                datas['s2'] + ', '+ datas['s3'] + ' </div>');
                                                }else{
                                                        $('#count-recipes').append('<div class="alert alert-success count-recipes count-recipes2">' +
                                                                count + ' recetas. Sugerencias: '+ datas['s1'] + ', '+
                                                                datas['s2'] + ', '+ datas['s3'] + ' </div>');
                                                }

                                        },
                                        error: function(datas){
                                                notificarError("<?= Lang::get('notifications.refresh') ?>")
                                        }
                                });

                        }
                }
                function cont(){
                        $('#continue').prop('disabled',true);
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
                                                $('#choose-principal-ingredients').hide();
                                                $('#select-principal-ingredients').hide();
                                                $('#tags').hide();
                                                $('#button').empty();
                                                $('#count-results').show();
                                                $('#choose-secondary-ingredients').show();
                                                $('#select-secondary-ingredients').show();
                                                $('#buttonFindSuggestions').show();
                                                $('#empezar').show();
                                                $('#o').show();
                                                $('.select2-selection').css('border-width',1);
                                                $('.select2-selection').css('border-color','rgb(255,035,001)');
                                                notificar("Se han encontrado "+datas['num_recipes']+" recetas con estos ingredientes principales." +
                                                        " Índicanos algunos ingredientes adicionales para saber si puedes cocinarlas");

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
