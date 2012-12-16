<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php { $title = Section::yield('page_title'); echo $title == '' ? '' : $title . ' < '; echo 'PNYX'; } ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- CSS -->
        <link rel="stylesheet" language="text/css" href="/css/main.css" />
        
        <!-- Require.js -->
        <script language="javascript" src="/js/lib/require/require.js"></script>
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
            <?php Anbu::render(); // Debugger ?>
        </div>

        <!-- Run main.js -->
        <script language="javascript" type="text/javascript" src="/js/main.js"></script>

        <!-- Run custom scripts -->
        @yield('scripts')
    </body>
</html>
