<!--view_input_text 1.0.0-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
        It helps to create html element "input type text":<br/>
        <b>&lt;input type=&quot;text&quot; value=&quot;some text&quot;&gt;</b>
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
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperInputText;
use TheFramework\Helpers\HelperDiv;
use TheFramework\Helpers\HelperButtonBasic;
use TheFramework\Helpers\HelperForm;

if(isset($_POST["emlEmail"]))//required
    //pr(): is an echo function
    pr("{email:{$_POST["emlEmail"]},phone:{$_POST["txtPhone"]}}","\$_POST");

//FIELD 1   PHONE
$oLabel = new HelperLabel();
$oLabel->set_for("txtPhone");
$oLabel->add_class("sr-only");//hides label
$oLabel->set_innerhtml("Phone");

$oPhone = new HelperInputText();
//$oPhone->set_type("tel"); //you can change to phone format.
//more examples: https://v4-alpha.getbootstrap.com/components/forms/#textual-inputs
$oPhone->set_id("txtPhone");
$oPhone->set_name("txtPhone");
$oPhone->add_class("form-control");
$oPhone->set_maxlength(100);
$oPhone->add_extras("placeholder","(0034) 654 333 222");
$oPhone->set_value((isset($_POST["txtPhone"])?$_POST["txtPhone"]:NULL));

$oDiv = new HelperDiv();
$oDiv->set_comments("divrow");
$oDiv->add_class("input-group mb-2 mr-sm-2 mb-sm-0");
$oDiv->add_inner_object(new HelperDiv("Phone",NULL,"input-group-addon"));
$oDiv->add_inner_object($oPhone);

//FIELD 2   EMAIL
$oLabel2 = clone $oLabel;
$oLabel2->set_for("emlEmail");
$oLabel2->set_class("sr-only");//hides label
$oLabel2->set_innerhtml("Username");

$oEmail = new HelperInputText();
$oEmail->set_type("email");//changed type
//more examples:https://v4-alpha.getbootstrap.com/components/forms/#textual-inputs
$oEmail->set_id("emlEmail");
$oEmail->set_name("emlEmail");
$oEmail->add_style("border: black 1px dashed");
$oEmail->add_class("form-control");
$oEmail->required();
$oEmail->set_value((isset($_POST["emlEmail"])?$_POST["emlEmail"]:NULL));
$oEmail->add_extras("placeholder","username@somedomain.io");
if(isset($_POST["emlEmail"]))
    $oEmail->add_extras("autofocus","autofocus");

$oDiv2 = new HelperDiv();
$oDiv2->add_class("input-group mb-2 mr-sm-2 mb-sm-0");
$oDiv2->add_inner_object(new HelperDiv("@",NULL,"input-group-addon","background:black;color:white"));
$oDiv2->add_inner_object($oEmail);

$oButton = new HelperButtonBasic();
$oButton->set_type("submit");
$oButton->add_class("btn btn-primary");
$oButton->set_innerhtml("Submit");

$oForm = new HelperForm();
$oForm->set_id("myForm");
$oForm->set_comments("This is a form");
$oForm->set_method("post");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->add_class("form-inline");
$oForm->add_inner_object($oLabel);
$oForm->add_inner_object($oDiv);
$oForm->add_inner_object($oLabel2);
$oForm->add_inner_object($oDiv2);
$oForm->add_inner_object($oButton);
$oForm->show(); //show() is the same as echo $oForm->get_html();
?>
        </div><!--example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&lt;?php
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperInputText;
use TheFramework\Helpers\HelperDiv;
use TheFramework\Helpers\HelperButtonBasic;
use TheFramework\Helpers\HelperForm;

if(isset($_POST[&quot;emlEmail&quot;]))//required
    //pr(): is an echo function
    pr(&quot;{email:{$_POST[&quot;emlEmail&quot;]},phone:{$_POST[&quot;txtPhone&quot;]}}&quot;,&quot;\$_POST&quot;);

//FIELD 1   PHONE
$oLabel = new HelperLabel();
$oLabel-&gt;set_for(&quot;txtPhone&quot;);
$oLabel-&gt;add_class(&quot;sr-only&quot;);//hides label
$oLabel-&gt;set_innerhtml(&quot;Phone&quot;);

$oPhone = new HelperInputText();
//$oPhone-&gt;set_type(&quot;tel&quot;); //you can change to phone format.
//more examples: https://v4-alpha.getbootstrap.com/components/forms/#textual-inputs
$oPhone-&gt;set_id(&quot;txtPhone&quot;);
$oPhone-&gt;set_name(&quot;txtPhone&quot;);
$oPhone-&gt;add_class(&quot;form-control&quot;);
$oPhone-&gt;set_maxlength(100);
$oPhone-&gt;add_extras(&quot;placeholder&quot;,&quot;(0034) 654 333 222&quot;);
$oPhone-&gt;set_value((isset($_POST[&quot;txtPhone&quot;])?$_POST[&quot;txtPhone&quot;]:NULL));

$oDiv = new HelperDiv();
$oDiv-&gt;set_comments(&quot;divrow&quot;);
$oDiv-&gt;add_class(&quot;input-group mb-2 mr-sm-2 mb-sm-0&quot;);
$oDiv-&gt;add_inner_object(new HelperDiv(&quot;Phone&quot;,NULL,&quot;input-group-addon&quot;));
$oDiv-&gt;add_inner_object($oPhone);

//FIELD 2   EMAIL
$oLabel2 = clone $oLabel;
$oLabel2-&gt;set_for(&quot;emlEmail&quot;);
$oLabel2-&gt;set_class(&quot;sr-only&quot;);//hides label
$oLabel2-&gt;set_innerhtml(&quot;Username&quot;);

$oEmail = new HelperInputText();
$oEmail-&gt;set_type(&quot;email&quot;);//changed type
//more examples:https://v4-alpha.getbootstrap.com/components/forms/#textual-inputs
$oEmail-&gt;set_id(&quot;emlEmail&quot;);
$oEmail-&gt;set_name(&quot;emlEmail&quot;);
$oEmail-&gt;add_style(&quot;border: black 1px dashed&quot;);
$oEmail-&gt;add_class(&quot;form-control&quot;);
$oEmail-&gt;required();
$oEmail-&gt;set_value((isset($_POST[&quot;emlEmail&quot;])?$_POST[&quot;emlEmail&quot;]:NULL));
$oEmail-&gt;add_extras(&quot;placeholder&quot;,&quot;username@somedomain.io&quot;);
if(isset($_POST[&quot;emlEmail&quot;]))
    $oEmail-&gt;add_extras(&quot;autofocus&quot;,&quot;autofocus&quot;);

$oDiv2 = new HelperDiv();
$oDiv2-&gt;add_class(&quot;input-group mb-2 mr-sm-2 mb-sm-0&quot;);
$oDiv2-&gt;add_inner_object(new HelperDiv(&quot;@&quot;,NULL,&quot;input-group-addon&quot;,&quot;background:black;color:white&quot;));
$oDiv2-&gt;add_inner_object($oEmail);

$oButton = new HelperButtonBasic();
$oButton-&gt;set_type(&quot;submit&quot;);
$oButton-&gt;add_class(&quot;btn btn-primary&quot;);
$oButton-&gt;set_innerhtml(&quot;Submit&quot;);

$oForm = new HelperForm();
$oForm-&gt;set_id(&quot;myForm&quot;);
$oForm-&gt;set_comments(&quot;This is a form&quot;);
$oForm-&gt;set_method(&quot;post&quot;);
$oForm-&gt;add_style(&quot;border:1px dashed #4f9fcf;&quot;);
$oForm-&gt;add_style(&quot;padding:5px;&quot;);
$oForm-&gt;add_class(&quot;form-inline&quot;);
$oForm-&gt;add_inner_object($oLabel);
$oForm-&gt;add_inner_object($oDiv);
$oForm-&gt;add_inner_object($oLabel2);
$oForm-&gt;add_inner_object($oDiv2);
$oForm-&gt;add_inner_object($oButton);
$oForm-&gt;show(); //show() is the same as echo $oForm-&gt;get_html();
?&gt;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&lt;!-- This is a form --&gt;
&lt;form id=&quot;myForm&quot; method=&quot;post&quot; class=&quot;form-inline&quot; style=&quot;border:1px dashed #4f9fcf;;padding:5px;&quot;&gt;
&lt;label for=&quot;txtPhone&quot; class=&quot;sr-only&quot;&gt;Phone&lt;/label&gt;
&lt;div class=&quot;input-group mb-2 mr-sm-2 mb-sm-0&quot;&gt;
&lt;div class=&quot;input-group-addon&quot;&gt;
Phone&lt;/div&gt;
&lt;input type=&quot;text&quot; id=&quot;txtPhone&quot; name=&quot;txtPhone&quot; maxlength=&quot;100&quot; class=&quot;form-control&quot; placeholder=&quot;(0034) 654 333 222&quot;&gt;
&lt;/div&gt;
&lt;label for=&quot;emlEmail&quot; class=&quot;sr-only&quot;&gt;Username&lt;/label&gt;
&lt;div class=&quot;input-group mb-2 mr-sm-2 mb-sm-0&quot;&gt;
&lt;div class=&quot;input-group-addon&quot; style=&quot;background:black;color:white&quot;&gt;@&lt;/div&gt;
&lt;input type=&quot;email&quot; id=&quot;emlEmail&quot; name=&quot;emlEmail&quot; maxlength=&quot;50&quot; required=&quot;&quot; class=&quot;form-control&quot; style=&quot;border: black 1px dashed&quot; placeholder=&quot;username@somedomain.io&quot;&gt;
&lt;/div&gt;
&lt;button type=&quot;submit&quot; class=&quot;btn btn-primary&quot;&gt;Submit&lt;/button&gt;
&lt;/form&gt;</pre>
    </div>
<!-- example 2 -->
    <h3>
        <span>Example 2</span>
    </h3>    
    <div>
        <h4>Live Html</h4>
        <div>
<?php
//use TheFramework\Helpers\HelperLabel;
//use TheFramework\Helpers\HelperInputText;
//input text types
//https://v4-alpha.getbootstrap.com/components/forms/#textual-inputs
$arTypes = ["text","search","email","url","tel","password","number"
    ,"datetime-local","date","month","week","time"
    ,"color"];

foreach($arTypes as $sType)
{
    $oLabel = new HelperLabel("txt-$sType");
    $oLabel->set_innerhtml("<b>$sType: </b>");
    echo $oLabel->get_html();
    
    $oInput = new HelperInputText("txt-$sType");
    $oInput->set_type($sType);
    $oInput->add_class("form-control");
    $oInput->show();
    //echo "<hr/>";
}
?>
        </div>
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&lt;?php
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperInputText;
//input text types
//https://v4-alpha.getbootstrap.com/components/forms/#textual-inputs
$arTypes = [&quot;text&quot;,&quot;search&quot;,&quot;email&quot;,&quot;url&quot;,&quot;tel&quot;,&quot;password&quot;,&quot;number&quot;
    ,&quot;datetime-local&quot;,&quot;date&quot;,&quot;month&quot;,&quot;week&quot;,&quot;time&quot;
    ,&quot;color&quot;];

foreach($arTypes as $sType)
{
    $oLabel = new HelperLabel(&quot;txt-$sType&quot;);
    $oLabel-&gt;set_innerhtml(&quot;&lt;b&gt;$sType: &lt;/b&gt;&quot;);
    echo $oLabel-&gt;get_html();
    
    $oInput = new HelperInputText(&quot;txt-$sType&quot;);
    $oInput-&gt;set_type($sType);
    $oInput-&gt;add_class(&quot;form-control&quot;);
    $oInput-&gt;show();
    //echo &quot;&lt;hr/&gt;&quot;;
}
?&gt;
</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&lt;label for=&quot;txt-text&quot;&gt;&lt;b&gt;text: &lt;/b&gt;&lt;/label&gt;
&lt;input type=&quot;text&quot; id=&quot;txt-text&quot; maxlength=&quot;50&quot; class=&quot;form-control&quot;&gt;
&lt;label for=&quot;txt-search&quot;&gt;&lt;b&gt;search: &lt;/b&gt;&lt;/label&gt;
&lt;input type=&quot;search&quot; id=&quot;txt-search&quot; maxlength=&quot;50&quot; class=&quot;form-control&quot;&gt;
&lt;label for=&quot;txt-email&quot;&gt;&lt;b&gt;email: &lt;/b&gt;&lt;/label&gt;
&lt;input type=&quot;email&quot; id=&quot;txt-email&quot; maxlength=&quot;50&quot; class=&quot;form-control&quot;&gt;
&lt;label for=&quot;txt-url&quot;&gt;&lt;b&gt;url: &lt;/b&gt;&lt;/label&gt;
&lt;input type=&quot;url&quot; id=&quot;txt-url&quot; maxlength=&quot;50&quot; class=&quot;form-control&quot;&gt;
&lt;label for=&quot;txt-tel&quot;&gt;&lt;b&gt;tel: &lt;/b&gt;&lt;/label&gt;
&lt;input type=&quot;tel&quot; id=&quot;txt-tel&quot; maxlength=&quot;50&quot; class=&quot;form-control&quot;&gt;
&lt;label for=&quot;txt-password&quot;&gt;&lt;b&gt;password: &lt;/b&gt;&lt;/label&gt;
&lt;input type=&quot;password&quot; id=&quot;txt-password&quot; maxlength=&quot;50&quot; class=&quot;form-control&quot;&gt;
&lt;label for=&quot;txt-number&quot;&gt;&lt;b&gt;number: &lt;/b&gt;&lt;/label&gt;
&lt;input type=&quot;number&quot; id=&quot;txt-number&quot; maxlength=&quot;50&quot; class=&quot;form-control&quot;&gt;
&lt;label for=&quot;txt-datetime-local&quot;&gt;&lt;b&gt;datetime-local: &lt;/b&gt;&lt;/label&gt;
&lt;input type=&quot;datetime-local&quot; id=&quot;txt-datetime-local&quot; maxlength=&quot;50&quot; class=&quot;form-control&quot;&gt;
&lt;label for=&quot;txt-date&quot;&gt;&lt;b&gt;date: &lt;/b&gt;&lt;/label&gt;
&lt;input type=&quot;date&quot; id=&quot;txt-date&quot; maxlength=&quot;50&quot; class=&quot;form-control&quot;&gt;
&lt;label for=&quot;txt-month&quot;&gt;&lt;b&gt;month: &lt;/b&gt;&lt;/label&gt;
&lt;input type=&quot;month&quot; id=&quot;txt-month&quot; maxlength=&quot;50&quot; class=&quot;form-control&quot;&gt;
&lt;label for=&quot;txt-week&quot;&gt;&lt;b&gt;week: &lt;/b&gt;&lt;/label&gt;
&lt;input type=&quot;week&quot; id=&quot;txt-week&quot; maxlength=&quot;50&quot; class=&quot;form-control&quot;&gt;
&lt;label for=&quot;txt-time&quot;&gt;&lt;b&gt;time: &lt;/b&gt;&lt;/label&gt;
&lt;input type=&quot;time&quot; id=&quot;txt-time&quot; maxlength=&quot;50&quot; class=&quot;form-control&quot;&gt;
&lt;label for=&quot;txt-color&quot;&gt;&lt;b&gt;color: &lt;/b&gt;&lt;/label&gt;
&lt;input type=&quot;color&quot; id=&quot;txt-color&quot; maxlength=&quot;50&quot; class=&quot;form-control&quot;&gt;</pre>
    </div>    
</div>
<!--/view_input_text-->  