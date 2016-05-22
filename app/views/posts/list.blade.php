@extends('template')
@section('title', Lang::get('Prueba titulo'))


@section('content')
@include('recipes.scriptList')
        <!-- Page Content -->
<div class="container">
        @for($i = 1;$i<=sizeof($posts);$i++)
                @if($i%3==1)
                        <div class="results row">
                                @endif
                                <div class="result col-md-6" >
                                        <div class="resultdiv col-md-12">
                                                <div class="description-result col-md-12">
                                                        <div class="title-result">
                                                                {{$posts[$i-1]->title}}
                                                        </div>
                                                        <div class = "col-md-12">
                                                                {{$posts[$i-1]->description}}
                                                        </div>
                                                        <div class = "button-result col-md-12">
                                                                <a href="show/{{$posts[$i-1]->id}}">
                                                                        <button class="btn btn-primary btn-lg" >Leer</button>
                                                                </a>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        @if(($i%3==0) || ($i == sizeof($posts)))
                        </div>
                        @endif

        @endfor
</div>

@stop

