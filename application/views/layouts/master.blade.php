<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php { $title = Section::yield('page_title'); echo $title == '' ? '' : $title . ' < '; echo 'PNYX'; } ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- CSS -->
        @if(Request::env() == 'srcf')
        <link rel="stylesheet" language="text/css" href="/dist/main.min.css" />
        @else
        <link rel="stylesheet" language="text/css" href="/dist/main.dev.css" />
        @endif
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        
        <!-- Navbar -->
        @render('partials.navbar')

        <!-- Alerts -->
        <?php
            $alerts = array(
                'error'     => Session::get('alert_error'),
                'info'      => Session::get('alert_info'),
                'success'   => Session::get('alert_success')
            );

            foreach($alerts as $type => $alert) {
                if(!is_null($alert)) {
                    echo render('partials.alert', array('type'=>$type, 'message'=>$alert));
                }
            }
        ?>

        <!-- Main Content -->
        <div class="container">
            @yield('content')
        </div>
        
        <!-- Footer -->
        <div class="footer">
        </div>

        <!-- Run main.js -->
        @if(Request::env() == 'srcf')
        <script language="javascript" type="text/javascript" src="lib/requirejs/require.js" data-main="/dist/main.js"></script>
        @else
        <script language="javascript" type="text/javascript" src="lib/requirejs/require.js" data-main="/js/main.js"></script>
        @endif

        <!-- Run custom scripts -->
        @yield('scripts')
    </body>
</html>
