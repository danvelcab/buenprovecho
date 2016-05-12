@extends('template')
@section('title', Lang::get('Prueba titulo'))


@section('content')
@include('recipes.scriptList')
<!-- Page Content -->
<div class="container">
        <div class="bg-danger" style="text-align: center;">
        La receta se ha creado correctamente
        </div>
        <div><a href="createRecipe"><button>Crear una nueva receta</button></a></div>
        <div><a href="../"><button >Ir a la página principal</button></a></div>
@stop

