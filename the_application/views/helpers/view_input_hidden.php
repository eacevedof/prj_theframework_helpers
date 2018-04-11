<!--view_input_hidden 1.0.0-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
        It helps to create html element "input type hidden":<br/>
        <b>&lt;input type=&quot;hidden&quot; value=&quot;some value to hide&quot;&gt;</b>
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
use TheFramework\Helpers\HelperInputHidden;
use TheFramework\Helpers\HelperButtonBasic;
use TheFramework\Helpers\HelperForm;

if(isset($_POST["hidOne"]))//required
    //pr(): is an echo function
    pr("{_POST[hidOne]:{$_POST["hidOne"]}, _POST[hidTwo]:{$_POST["hidTwo"]}}","\$_POST");

$oHidden1 = new HelperInputHidden();
$oHidden1->set_id("hidOne");
$oHidden1->set_name("hidOne");
$oHidden1->set_value((isset($_POST["hidOne"])?$_POST["hidOne"]:"some value for one"));

$oHidden2 = new HelperInputHidden();
$oHidden2->set_id("hidTwo");
$oHidden2->set_name("hidTwo");
$oHidden2->set_value((isset($_POST["hidTwo"])?$_POST["hidTwo"]:"some value for two"));

$oButton = new HelperButtonBasic();
$oButton->set_type("submit");
$oButton->add_class("btn btn-primary");
$oButton->add_extras("autofocus","autofocus");
$oButton->set_innerhtml("Press to Test");

$oForm = new HelperForm();
$oForm->set_id("myForm");
//$oForm->set_action("/");
$oForm->set_method("post");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->add_inner_object($oHidden1);
$oForm->add_inner_object($oHidden2);
$oForm->add_inner_object($oButton);
$oForm->show(); 
?>
        </div><!--example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&lt;?php
use TheFramework\Helpers\HelperInputHidden;
use TheFramework\Helpers\HelperButtonBasic;
use TheFramework\Helpers\HelperForm;

if(isset($_POST[&quot;hidOne&quot;]))//required
    //pr(): is an echo function
    pr(&quot;{_POST[hidOne]:{$_POST[&quot;hidOne&quot;]}, _POST[hidTwo]:{$_POST[&quot;hidTwo&quot;]}}&quot;,&quot;\$_POST&quot;);

$oHidden1 = new HelperInputHidden();
$oHidden1-&gt;set_id(&quot;hidOne&quot;);
$oHidden1-&gt;set_name(&quot;hidOne&quot;);
$oHidden1-&gt;set_value((isset($_POST[&quot;hidOne&quot;])?$_POST[&quot;hidOne&quot;]:&quot;some value for one&quot;));

$oHidden2 = new HelperInputHidden();
$oHidden2-&gt;set_id(&quot;hidTwo&quot;);
$oHidden2-&gt;set_name(&quot;hidTwo&quot;);
$oHidden2-&gt;set_value((isset($_POST[&quot;hidTwo&quot;])?$_POST[&quot;hidTwo&quot;]:&quot;some value for two&quot;));

$oButton = new HelperButtonBasic();
$oButton-&gt;set_type(&quot;submit&quot;);
$oButton-&gt;add_class(&quot;btn btn-primary&quot;);
$oButton-&gt;add_extras(&quot;autofocus&quot;,&quot;autofocus&quot;);
$oButton-&gt;set_innerhtml(&quot;Press to Test&quot;);

$oForm = new HelperForm();
$oForm-&gt;set_id(&quot;myForm&quot;);
//$oForm-&gt;set_action(&quot;/&quot;);
$oForm-&gt;set_method(&quot;post&quot;);
$oForm-&gt;add_style(&quot;border:1px dashed #4f9fcf;&quot;);
$oForm-&gt;add_style(&quot;padding:5px;&quot;);
$oForm-&gt;add_inner_object($oHidden1);
$oForm-&gt;add_inner_object($oHidden2);
$oForm-&gt;add_inner_object($oButton);
$oForm-&gt;show(); 
?&gt;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&lt;form id=&quot;myForm&quot; method=&quot;post&quot; style=&quot;border:1px dashed #4f9fcf;;padding:5px;&quot;&gt;
&lt;input type=&quot;hidden&quot; id=&quot;hidOne&quot; name=&quot;hidOne&quot; value=&quot;some value for one&quot;&gt;
&lt;input type=&quot;hidden&quot; id=&quot;hidTwo&quot; name=&quot;hidTwo&quot; value=&quot;some value for two&quot;&gt;
&lt;button type=&quot;submit&quot; class=&quot;btn btn-primary&quot; autofocus=&quot;autofocus&quot;&gt;
Press to Test&lt;/button&gt;
&lt;/form&gt;</pre>
    </div>
<!-- example 2 -->  
</div>
<!--/view_input_hidden-->  