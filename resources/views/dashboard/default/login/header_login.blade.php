<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - {{ Config::get('qilara.site_name') }}</title>
    <link href='http://fonts.googleapis.com/css?family=Lato:900' rel='stylesheet' type='text/css'>
    {!! Theme::css("css/bootstrap.min.css") !!}
    {!! Theme::css("fonts/css/font-awesome.min.css") !!}
    {!! Theme::css("css/animate.min.css") !!}

    <!-- Custom styling plus plugins -->
    {!! Theme::css("css/custom.css") !!}
    {!! Theme::css("css/icheck/flat/green.css") !!}

    {!! Theme::js("js/jquery.min.js") !!}

    <!--[if lt IE 9]>
    {!! Theme::js("js/ie8-responsive-file-warning.js") !!}
    <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
