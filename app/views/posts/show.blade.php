@extends('template')
@section('title', Lang::get('Prueba titulo'))


@section('content')
@include('recipes.scriptList')
        <!-- Page Content -->
<div class="container">
        <div class="results row">
                <div class="result col-md-12" >
                        <div class="resultdiv col-md-12">
                                <div class="description-result col-md-12">
                                        <div class="title-result-post">
                                                {{$post->title}}
                                        </div>
                                        <div class = "col-md-12 subtitle">
                                                {{$post->description}}
                                        </div>
                                        <div class = "col-md-12">
                                                {{$post->text}}
                                        </div>
                                        <div class = "col-md-12 infografia">
                                                {{$post->foto}}
                                        </div>
                                        <div class = "col-md-12 parrafo">
                                                {{$post->text2}}
                                        </div>
                                </div>
                        </div>
                </div>
       </div>
</div>

@stop

