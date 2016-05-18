<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Buen provecho. Dinos que tienes en frigorífico y te diremos que cocinar. En Buen provecho no queremos que tus alimentos se pongan en mal estado">
    <meta name="author" content="Daniel Velazquez">

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-77124252-1', 'auto');
        ga('send', 'pageview');

    </script>

    <title>Buen provecho - ¿qué hay para comer?</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="bootstrap-switch/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">
    {{HTML::script('/js/jquery.js')}}
    <script src="bootstrap-switch/js/bootstrap-switch.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <!--start Select2-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
    {{--end Select2--}}
    {{--<![endif]-->--}}

    {{HTML::script('js/jquery-scrolltofixed.js')}}
    {{HTML::script('js/noty/packaged/jquery.noty.packaged.js')}}
    {{HTML::script('js/noty/layouts/top.js')}}
    {{HTML::script('js/noty/layouts/topLeft.js')}}
    {{HTML::script('js/noty/layouts/topRight.js')}}
    <script type="text/javascript">
        function notificar(texto) {
            var n = noty({
                text: texto,
                theme: 'relax',
                type: 'information',
                layout: 'topCenter',
                timeout: 6000
            });
        }
        function notificarError(texto) {
            var n = noty({
                text: texto,
                type: 'error',
                theme: 'relax',
                layout: 'topCenter',
                timeout: 6000
            });
        }
    </script>


</head>

<body>

@include('header')


<!-- Page Content -->
@yield('content')

@include('footer')
</div>

<!-- /.container -->

<script src="js/bootstrap.min.js"></script>

</body>

</html>
