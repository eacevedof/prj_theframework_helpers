<?php
////index.php 1.0.1
////configura rutas de carga en includepath
//include_once("app_bootstrap.php");
//$oAppBoot = new ThePulic\AppBootstrap();
//$oAppBoot->load_paths();
//$oAppBoot->autoload();
////carga: functions_debug,functions_string,autoload,array_helpers,component_download
//$oAppBoot->load_files();
//$arHelpers = $oAppBoot->get_helpers_list();

//=====================
//CONTROLADOR PRINCIPAL
//=====================

//bugg();
//pr("homes/view_index.php");
?>
<!-- index 1.0.4 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php s($oAppMain->get_page("title"));?></title>
    <meta name="description" content="<?php s($oAppMain->get_page("description"));?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/style/google_prettify/prettify.css" />
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script src="/js/google_prettify/prettify.js"></script>
    <script>
    window.onload = (function(){ prettyPrint(); });
    </script>
<?php
include("elem_analytics.php");
?> 
</head>
<body>
    <div id="divMain" class="container-fluid">
<?php
include("elem_navbar.php");
?>        
    <div class="row"><br/><br/></div>
    <div class="jumbotron" style="padding:20px;">
        <h1 class="display-3"><?php s($oAppMain->get_page("h1"));?></h1>
        <p class="lead">
            <?php s($oAppMain->get_page("resume"))?>
        </p>
<?php
include("elem_buttondownload.php");
?>
    </div>        
<?php
//include("elem_breadscrumbs.php");
include("elem_gettingstarted.php");
?>         
        <div class="row">
<?php
include($oAppMain->get_view_file());
?>
        </div>
        <p class="text-center">
<?php
include("elem_totop.php");
?>
        </p>
    </div>
<?php
include("elem_footer.php");
?>    
    <script src="/js/bundles/bundle.js"></script>
</body>
</html>
