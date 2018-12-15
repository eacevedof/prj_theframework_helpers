<!-- hot reload -->
<meta http-equiv="refresh" content="5">
<a href="https://github.com/eacevedof/prj_theframework_helpers/tree/develop" target="_blank">Repo</a>
<a href="https://github.com/eacevedof/prj_theframework_helpers/blob/develop/theframework/helpers/EXAMPLES.md" target="_blank">Examples</a>
<pre>php -S localhost:3000 -t tests</pre>

<?php
//index.php
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Html\Script;

$oScript = new Script();
$oScript->add_srcext("https://code.jquery.com/jquery-3.3.1.js",[
        "integrity"=>"sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=",
        "crossorigin"=>"anonymous",
        "media"=>"all",
        "id"=>"idJquery331"
    ]);
$oScript->add_src("https://cdnjs.cloudflare.com/ajax/libs/ramda/0.26.1/ramda.js");
$oScript->add_srcext("https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js",["comm"=>"vue2 v2"]);
$oScript->show_htmlsrc();

$oScript->add_inner_object("var i=0");
$oScript->add_inner_object("i++");
$oScript->add_inner_object("function my_alert(s){console.log('myalert:',s)}");
$oScript->add_inner_object("my_alert(i)");
$oScript->show();


?>
