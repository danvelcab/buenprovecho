@extends('template')
@section('title', Lang::get('Prueba titulo'))


@section('content')
@include('recipes.scriptList')
<!-- Page Content -->
<div class="container">
        <div>
        @foreach($recipe->ingredients()->get() as $ingredient)
                <span class="label label-success">{{$ingredient->name}}</span>
        @endforeach
        </div>
        <div>
                <a href="#" onClick="window.open('{{$recipe->url}}}','MyWindow',width=600,height=300); return false;"><button>Ver receta</button></a>
        </div>
        <form method="post"
              action="{{URL::asset('updateRecipe')}}">
        <div class="select2-select">
                <input hidden name="id" value="{{$recipe->id}}">
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

