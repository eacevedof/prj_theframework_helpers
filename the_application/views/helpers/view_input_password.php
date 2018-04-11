<!--view_input_password 1.0.0-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
        It helps to create html element "input type password":<br/>
        <b>&lt;input type=&quot;password&quot; value=&quot;some password&quot;&gt;</b>
    </p>
    <h2>
        <span class="badge badge-default">Examples:</span>
    </h2>
    <br/>
    <h3>
        <span>Example 1</span>
    </h3>
    <br/>
    <div>
        <h4>Live Html</h4>
        <div>
<?php
use TheFramework\Helpers\HelperInputPassword;
use TheFramework\Helpers\HelperButtonBasic;
use TheFramework\Helpers\HelperForm;

if(isset($_POST["passOne"]))//required
    //pr(): is an echo function
    pr("{_POST[passOne]:{$_POST["passOne"]}, _POST[passTwo]:{$_POST["passTwo"]}}","\$_POST");

$oPass = new HelperInputPassword();
$oPass->set_id("passOne");
$oPass->set_name("passOne");
$oPass->add_extras("placeholder","Your password");
$oPass->set_value((isset($_POST["passOne"])?$_POST["passOne"]:NULL));

$oPassConf = new HelperInputPassword();
$oPassConf->set_id("passTwo");
$oPassConf->set_name("passTwo");
$oPassConf->add_extras("placeholder","Confirm your password");
$oPassConf->set_value((isset($_POST["passTwo"])?$_POST["passTwo"]:NULL));

$oButton = new HelperButtonBasic();
$oButton->set_type("submit");
$oButton->add_class("btn btn-primary");
$oButton->add_extras("autofocus","autofocus");
$oButton->set_innerhtml("Submit");

$oForm = new HelperForm();
$oForm->set_id("myForm");
//$oForm->set_action("/index.php");
$oForm->set_method("post");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->add_inner_object($oPass);
$oForm->add_inner_object($oPassConf);
$oForm->add_inner_object($oButton);
//$oForm->add_inner_object(new TheFramework\Helpers\HelperRaw("&nbsp;&nbsp;<input type=\"reset\" class=\"btn btn-primary\">"));
$oForm->show(); 
?>
        </div><!--example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&lt;?php
use TheFramework\Helpers\HelperInputPassword;
use TheFramework\Helpers\HelperButtonBasic;
use TheFramework\Helpers\HelperForm;

if(isset($_POST["passOne"]))//required
    //pr(): is an echo function
    pr("{_POST[passOne]:{$_POST["passOne"]}, _POST[passTwo]:{$_POST["passTwo"]}}","\$_POST");

$oPass = new HelperInputPassword();
$oPass->set_id("passOne");
$oPass->set_name("passOne");
$oPass->add_extras("placeholder","Your password");
$oPass->set_value((isset($_POST["passOne"])?$_POST["passOne"]:NULL));

$oPassConf = new HelperInputPassword();
$oPassConf->set_id("passTwo");
$oPassConf->set_name("passTwo");
$oPassConf->add_extras("placeholder","Confirm your password");
$oPassConf->set_value((isset($_POST["passTwo"])?$_POST["passTwo"]:NULL));

$oButton = new HelperButtonBasic();
$oButton->set_type("submit");
$oButton->add_class("btn btn-primary");
$oButton->add_extras("autofocus","autofocus");
$oButton->set_innerhtml("Submit");

$oForm = new HelperForm();
$oForm->set_id("myForm");
//$oForm->set_action("/index.php");
$oForm->set_method("post");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->add_inner_object($oPass);
$oForm->add_inner_object($oPassConf);
$oForm->add_inner_object($oButton);
//$oForm->add_inner_object(new TheFramework\Helpers\HelperRaw("&nbsp;&nbsp;&lt;input type=\&quot;reset\&quot; class=\&quot;btn btn-primary\&quot;&gt;"));
$oForm->show();  
?&gt;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&lt;form id=&quot;myForm&quot; method=&quot;post&quot; style=&quot;border:1px dashed #4f9fcf;;padding:5px;&quot;&gt;
&lt;input type=&quot;password&quot; id=&quot;passOne&quot; name=&quot;passOne&quot; maxlength=&quot;50&quot; placeholder=&quot;Your password&quot;&gt;
&lt;input type=&quot;password&quot; id=&quot;passTwo&quot; name=&quot;passTwo&quot; maxlength=&quot;50&quot; placeholder=&quot;Confirm your password&quot;&gt;
&lt;button type=&quot;submit&quot; class=&quot;btn btn-primary&quot; autofocus=&quot;autofocus&quot;&gt;
Submit&lt;/button&gt;
&lt;/form&gt;</pre>
    </div>
<!-- example 2 -->  
</div>
<!--/view_input_password-->  