<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- CSS -->
        <link rel="stylesheet" language="text/css" href="/css/main.css" />
        
        <!-- Require.js -->
        <script language="javascript" src="/javascript/Lib/Require/require.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        
        <!-- Navbar -->
        @render('partials.navbar')

        <!-- Main Content -->
        @yield('content')

        <!-- Run main.js -->
        <script language="javascript" type="text/javascript" src="/js/main.js"></script>
    </body>
</html>