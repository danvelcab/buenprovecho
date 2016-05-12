@extends('template')
@section('title', Lang::get('Prueba titulo'))


@section('content')
@include('recipes.scriptList')
<!-- Page Content -->
<div class="container">
        <div class="bg-danger" style="text-align: center;">
        Aviso: Cuanto menos ingredientes tenga la receta será más fácil que los usuarios encuentren tus recetes.
                <br>Gracias por ayudarnos a crecer.
        </div>
        <br>
        <form method="post"
              action="{{URL::asset('saveRecipe')}}">
        <div style="text-align: center;">
                Nombre: <input name="name" required type="text">
        </div>
                <br>
        <div style="text-align: center;">
                URL: <input name="url" required type="text">
        </div>
                <br>
        <div style="text-align: center;">
                URL de la imagen: <input name="image-url" required type="text">
        </div>
                <br>
        <div style="text-align: center;">
                Tiempo de preparación: <input name="time" required type="text">
        </div>
                <br>
        <div class="select2-select">
                INGREDIENTES:
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
                <button type="submit" class="btn btn-primary center-block btn-lg" >
                        Editar receta</button>

        </div>
        </form>

@stop

