<!--view_form 1.1.0-->
<div class="col-lg-12">
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
<?php
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperInputText;
use TheFramework\Helpers\HelperSelect;

$arFields = [];

$oAux = new HelperLabel("txtNameId","My label for Name");
$oAux->add_class("custom-control");
$arFields[] = $oAux;

$oAux = new HelperInputText();
$oAux->add_class("col-4");
$oAux->add_class("form-control");
$oAux->add_extras("placeholder","Eg. Eduardo A. F.");
$oAux->set_id("txtNameId");
$oAux->set_name("txtName");
$arFields[] = $oAux;

$arFields["sel"] = new HelperSelect([""=>"choose...","one"=>"One","two"=>"Two","three"=>"Three"]);
$arFields["sel"]->add_class("form-control col-4");

$arFields["textarea"] = new TheFramework\Helpers\HelperTextarea();
$arFields["textarea"]->add_class("form-control");
$arFields["textarea"]->add_extras("placeholder","Your comments");
$arFields["textarea"]->set_id("txaComments");

$oForm = new HelperForm();
$oForm->add_class("col-6");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->set_id("myForm");
$oForm->set_method("some_method");
$oForm->set_enctype("myEncType");
$oForm->add_controls($arFields);
$oForm->show();
?>
        <br/> 
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperInputText;
use TheFramework\Helpers\HelperSelect;

$arFields = [];

$oAux = new HelperLabel(&#x22;txtNameId&#x22;,&#x22;My label for Name&#x22;);
$oAux-&#x3E;add_class(&#x22;custom-control&#x22;);
$arFields[] = $oAux;

$oAux = new HelperInputText();
$oAux-&#x3E;add_class(&#x22;col-4&#x22;);
$oAux-&#x3E;add_class(&#x22;form-control&#x22;);
$oAux-&#x3E;add_extras(&#x22;placeholder&#x22;,&#x22;Eg. Eduardo A. F.&#x22;);
$oAux-&#x3E;set_id(&#x22;txtNameId&#x22;);
$oAux-&#x3E;set_name(&#x22;txtName&#x22;);
$arFields[] = $oAux;

$arFields[&#x22;sel&#x22;] = new HelperSelect([&#x22;&#x22;=&#x3E;&#x22;choose...&#x22;,&#x22;one&#x22;=&#x3E;&#x22;One&#x22;,&#x22;two&#x22;=&#x3E;&#x22;Two&#x22;,&#x22;three&#x22;=&#x3E;&#x22;Three&#x22;]);
$arFields[&#x22;sel&#x22;]-&#x3E;add_class(&#x22;form-control col-4&#x22;);

$arFields[&#x22;textarea&#x22;] = new TheFramework\Helpers\HelperTextarea();
$arFields[&#x22;textarea&#x22;]-&#x3E;add_class(&#x22;form-control&#x22;);
$arFields[&#x22;textarea&#x22;]-&#x3E;add_extras(&#x22;placeholder&#x22;,&#x22;Your comments&#x22;);
$arFields[&#x22;textarea&#x22;]-&#x3E;set_id(&#x22;txaComments&#x22;);

$oForm = new HelperForm();
$oForm-&#x3E;add_class(&#x22;col-6&#x22;);
$oForm-&#x3E;add_style(&#x22;border:1px dashed #4f9fcf;&#x22;);
$oForm-&#x3E;add_style(&#x22;padding:5px;&#x22;);
$oForm-&#x3E;set_id(&#x22;myForm&#x22;);
$oForm-&#x3E;set_method(&#x22;some_method&#x22;);
$oForm-&#x3E;set_enctype(&#x22;myEncType&#x22;);
$oForm-&#x3E;add_controls($arFields);
$oForm-&#x3E;show();
?&#x3E;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;form id=&#x22;myForm&#x22; method=&#x22;some_method&#x22; enctype=&#x22;myEncType&#x22; class=&#x22;col-6&#x22; style=&#x22;border:1px dashed #4f9fcf;;padding:5px;&#x22;&#x3E;
&#x3C;label for=&#x22;txtNameId&#x22; class=&#x22;custom-control&#x22;&#x3E;My label for Name&#x3C;/label&#x3E;
&#x3C;input type=&#x22;text&#x22; id=&#x22;txtNameId&#x22; name=&#x22;txtName&#x22; maxlength=&#x22;50&#x22; class=&#x22;col-4 form-control&#x22; placeholder=&#x22;Eg. Eduardo A. F.&#x22;&#x3E;
&#x3C;select name=&#x22;&#x22; size=&#x22;1&#x22; class=&#x22;form-control col-4&#x22;&#x3E;
&#x9;&#x3C;option value=&#x22;&#x22; selected=&#x22;&#x22;&#x3E;choose...&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;one&#x22;&#x3E;One&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;two&#x22;&#x3E;Two&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;three&#x22;&#x3E;Three&#x3C;/option&#x3E;
&#x3C;/select&#x3E;
&#x3C;textarea id=&#x22;txaComments&#x22; rows=&#x22;8&#x22; cols=&#x22;40&#x22; class=&#x22;form-control&#x22; maxlength=&#x22;-1&#x22; placeholder=&#x22;Your comments&#x22;&#x3E;&#x3C;/textarea&#x3E;
&#x3C;span id=&#x22;sptxaComments&#x22;&#x3E;&#x3C;/span&#x3E;
&#x3C;/form&#x3E;</pre>
    </div>
    <h3>
        <span>Example 2</span>
    </h3>    
    <div>
        <h4>Live Html</h4>
        <div>
<?php
$iBorder = 1;
$sAutofocus = "";
$oForm = new TheFramework\Helpers\HelperForm();
$oForm->set_id("frmIdSomeForm");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px");
$oForm->set_class("col-7");
$oForm->set_enctype("multipart/form-data");
$oForm->set_method("post");
$oForm->set_action("index.php?example=helperform");
if(isset($_POST["border"]))
{
    $sAutofocus = "autofocus=\"\" ";
    $iBorder = (int)$_POST["border"];
    //rewrite stack of styles
    $oForm->set_style("border:{$iBorder}px solid #4f9fcf;");
    $oForm->add_style("padding:15px");
    $oForm->set_class("col-6");
}
$oButton = new \TheFramework\Helpers\HelperButtonBasic();
$oButton->set_innerhtml("Test tborder");
$oButton->set_type("submit");

$oForm->show_opentag();
echo "<label>Border</lable><input type=\"number\" name=\"border\" value=\"$iBorder\"$sAutofocus><br/>";
echo "<input type=\"email\" placeholder=\"your email\"><br/>";
echo "<input type=\"time\"><br/>";
$oButton->add_class("btn btn-danger");
$oButton->show();
$oForm->show_closetag();
?>
        </div>
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
$iBorder = 1;
$sAutofocus = &#x22;&#x22;;
$oForm = new TheFramework\Helpers\HelperForm();
$oForm-&#x3E;set_id(&#x22;frmIdSomeForm&#x22;);
$oForm-&#x3E;add_style(&#x22;border:1px dashed #4f9fcf;&#x22;);
$oForm-&#x3E;add_style(&#x22;padding:5px&#x22;);
$oForm-&#x3E;set_class(&#x22;col-7&#x22;);
$oForm-&#x3E;set_enctype(&#x22;multipart/form-data&#x22;);
$oForm-&#x3E;set_method(&#x22;post&#x22;);
$oForm-&#x3E;set_action(&#x22;index.php?example=helperform&#x22;);
if(isset($_POST[&#x22;border&#x22;]))
{
    $sAutofocus = &#x22;autofocus=\&#x22;\&#x22; &#x22;;
    $iBorder = (int)$_POST[&#x22;border&#x22;];
    //rewrite stack of styles
    $oForm-&#x3E;set_style(&#x22;border:{$iBorder}px solid #4f9fcf;&#x22;);
    $oForm-&#x3E;add_style(&#x22;padding:15px&#x22;);
    $oForm-&#x3E;set_class(&#x22;col-6&#x22;);
}
$oButton = new \TheFramework\Helpers\HelperButtonBasic();
$oButton-&#x3E;set_innerhtml(&#x22;Test tborder&#x22;);
$oButton-&#x3E;set_type(&#x22;submit&#x22;);

$oForm-&#x3E;show_opentag();
echo &#x22;&#x3C;label&#x3E;Border&#x3C;/lable&#x3E;&#x3C;input type=\&#x22;number\&#x22; name=\&#x22;border\&#x22; value=\&#x22;$iBorder\&#x22;$sAutofocus&#x3E;&#x3C;br/&#x3E;&#x22;;
echo &#x22;&#x3C;input type=\&#x22;email\&#x22; placeholder=\&#x22;your email\&#x22;&#x3E;&#x3C;br/&#x3E;&#x22;;
echo &#x22;&#x3C;input type=\&#x22;time\&#x22;&#x3E;&#x3C;br/&#x3E;&#x22;;
$oButton-&#x3E;add_class(&#x22;btn btn-danger&#x22;);
$oButton-&#x3E;show();
$oForm-&#x3E;show_closetag();
?&#x3E;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;form id=&#x22;frmIdSomeForm&#x22; method=&#x22;post&#x22; action=&#x22;index.php?example=helperform&#x22; enctype=&#x22;multipart/form-data&#x22; class=&#x22;col-7&#x22; style=&#x22;border:1px dashed #4f9fcf;;padding:5px&#x22;&#x3E;
&#x3C;label&#x3E;Border&#x3C;/lable&#x3E;&#x3C;input type=&#x22;number&#x22; name=&#x22;border&#x22; value=&#x22;1&#x22;&#x3E;&#x3C;br/&#x3E;&#x3C;input type=&#x22;email&#x22; placeholder=&#x22;your email&#x22;&#x3E;&#x3C;br/&#x3E;&#x3C;input type=&#x22;time&#x22;&#x3E;&#x3C;br/&#x3E;&#x3C;button type=&#x22;submit&#x22; class=&#x22;btn btn-danger&#x22;&#x3E;
Test tborder&#x3C;/button&#x3E;&#x3C;/form&#x3E;</pre>
    </div>
</div>
<!--/view_form-->  