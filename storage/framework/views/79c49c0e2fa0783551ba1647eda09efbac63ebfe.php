<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">
        <title><?php echo $__env->yieldContent('title'); ?> | ASADELTECH</title>
        <link rel="icon" href="<?php echo e(asset('assets/favicon.ico')); ?>">
        <link href="<?php echo e(asset('assets/css/materialize.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
        <link href="<?php echo e(asset('assets/js/plugins/perfect-scrollbar/perfect-scrollbar.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
        <?php echo $__env->yieldContent('css'); ?>
        <link href="<?php echo e(asset('assets/css/style.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
    </head>

    <body onload="startTime()">
        <!--<div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>-->
		
        <header id="header" class="page-topbar">
            <div class="navbar-fixed">
                <nav class="navbar-color">
                    <div class="nav-wrapper">
                    <ul class="left">
                            <li><h1 class="logo-wrapper logohos"><a href="<?php echo e(route('dashboard')); ?>" class="brand-logo darken-1"><img src="<?php echo e(asset('assets/images/esiclogo.png')); ?>" alt="asadeltech logo"></a></h1></li>
                            
                        </ul>
                       <ul><li> <span class="textlogo">IMARECON<sup>&reg;</sup> AUTOMATIC QUEUE MANAGEMENT</span></li></ul>
                        <ul class="right hide-on-med-and-down">
                           <li><input class="pwdscreen" type="password" placeholder="Enter Password" ></li>
                            <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen1"><i class="mdi-action-settings-overscan"></i></a></li>
                        </ul>
                        <ul class="right">
                            <span class="truncate" style="margin-right:20px;font-size:20px"><?php echo e($settings->name); ?></span>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

        <div id="main" style="padding:15px;padding-bottom:0">
            <div class="wrapper">
                <section id="content">
                    <?php echo $__env->yieldContent('content'); ?>
                </section>
            </div>
        </div>

        <footer class="page-footer" style="padding:0;margin-top:0">
            <div class="footer-copyright">
                <div class="container">
                <span>Powered by <a class="grey-text text-lighten-3" href="https://www.asadeltech.com" target="_blank">ASADEL TECHNOLOGIES (P) Ltd.</a> All rights reserved.</span>
                    <span class="right"> <span class="grey-text text-lighten-3">Annual License Version</span> 1.1.1</span>
                </div>
            </div>
        </footer>
        <?php echo $__env->yieldContent('print'); ?>
        <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/jquery-1.11.2.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('assets/js/materialize.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins.min.js')); ?>"></script>

        <script>
       $(document).ready(function() {
    setInterval(timestamp, 1000);
});

function timestamp() {
    $.ajax({
        url: "<?php echo e(url('assets/files/timestamp.php')); ?>",
        success: function(data) {
            $('#timestamp').html(data);
			$('#gtime').html(data);
        },
    });
}
       </script>
        <?php echo $__env->yieldContent('script'); ?>
        <?php echo $__env->make('common.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </body>
</html>
