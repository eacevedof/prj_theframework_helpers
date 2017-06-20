<!--view_button_basic 1.0.0-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
        With this class you can create &#x3C;button&#x3E;..&#x3C;/button&#x3E; element
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
<?php
use TheFramework\Helpers\HelperButtonBasic;
$arButtons = [];
$arButton["1"] = new HelperButtonBasic("butFirst","Danger");
$arButton["1"]->set_js_onclick("console.log(this.id);alert('danger')");
$arButton["1"]->add_class("btn btn-danger");
//adding extra attributes
$arButton["1"]->add_extras("ng-click","count = count + 1");
$arButton["1"]->add_extras("ng-init","count=0");

$arButton["2"] = new HelperButtonBasic("butSecond","Submit");
$arButton["2"]->set_type("submit");
$arButton["2"]->set_style("margin-left:5px;");
$arButton["2"]->set_js_onclick("console.log(this.id);alert('Data submit');");
$arButton["2"]->add_class("btn btn-info");

foreach($arButton as $oButton)
    $oButton->show();
?>
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
use TheFramework\Helpers\HelperButtonBasic;
$arButtons = [];
$arButton[&#x22;1&#x22;] = new HelperButtonBasic(&#x22;butFirst&#x22;,&#x22;Danger&#x22;);
$arButton[&#x22;1&#x22;]-&#x3E;set_js_onclick(&#x22;console.log(this.id);alert(&#x27;danger&#x27;)&#x22;);
$arButton[&#x22;1&#x22;]-&#x3E;add_class(&#x22;btn btn-danger&#x22;);
//adding extra attributes
$arButton[&#x22;1&#x22;]-&#x3E;add_extras(&#x22;ng-click&#x22;,&#x22;count = count + 1&#x22;);
$arButton[&#x22;1&#x22;]-&#x3E;add_extras(&#x22;ng-init&#x22;,&#x22;count=0&#x22;);

$arButton[&#x22;2&#x22;] = new HelperButtonBasic(&#x22;butSecond&#x22;,&#x22;Submit&#x22;);
$arButton[&#x22;2&#x22;]-&#x3E;set_type(&#x22;submit&#x22;);
$arButton[&#x22;2&#x22;]-&#x3E;set_style(&#x22;margin-left:5px;&#x22;);
$arButton[&#x22;2&#x22;]-&#x3E;set_js_onclick(&#x22;console.log(this.id);alert(&#x27;Data submit&#x27;);&#x22;);
$arButton[&#x22;2&#x22;]-&#x3E;add_class(&#x22;btn btn-info&#x22;);

foreach($arButton as $oButton)
    $oButton-&#x3E;show();
?&#x3E;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;button type=&#x22;button&#x22; id=&#x22;butFirst&#x22; onclick=&#x22;console.log(this.id);alert(&#x27;danger&#x27;)&#x22; class=&#x22;btn btn-danger&#x22; ng-click=&#x22;count = count + 1&#x22; ng-init=&#x22;count=0&#x22;&#x3E;
Danger&#x3C;/button&#x3E;
&#x3C;button type=&#x22;submit&#x22; id=&#x22;butSecond&#x22; onclick=&#x22;console.log(this.id);alert(&#x27;Data submit&#x27;);&#x22; class=&#x22;btn btn-info&#x22; style=&#x22;margin-left:5px;&#x22;&#x3E;
Submit&#x3C;/button&#x3E;</pre>
    </div>
<!-------------------------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------------------------->
    <h3>
        <span>Example 2</span>
    </h3>
    <br/>
    <div>
        <h4>Live Html</h4>
<?php
use TheFramework\Helpers\HelperForm;

$oForm = new HelperForm();
$oForm->set_comments("This is a comment");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->set_id("myForm");

$oSpan = new TheFramework\Helpers\HelperSpan("@");
$oSpan->set_class("input-group-addon");

$sEmail = isset($_POST["txtEmail"])?$_POST["txtEmail"]:NULL;

$oAux = new TheFramework\Helpers\HelperInputText("txtEmail","txtEmail");
$oAux->set_type("email");
$oAux->required();
$oAux->set_value($sEmail);
$oAux->add_class("form-control");
$oAux->add_extras("placeholder","Recipient's email");
if($sEmail)
{
    $oAux->set_style("border:1px solid black");
    $oAux->add_style("background:#cc99ff");
    $oAux->add_style("color:black");
    $oAux->add_extras("autofocus","");
}

$oAux = new TheFramework\Helpers\HelperRaw("<div class=\"input-group\">{$oSpan->get_html()}{$oAux->get_html()}</div>");
$oForm->add_control($oAux);

$oAux = new HelperButtonBasic("butReset","Reset");
$oAux->set_type("reset");
$oAux->add_class("btn btn-info");
$oAux->add_style("margin:15px");
$oForm->add_control($oAux);

$oAux = new HelperButtonBasic("butSubmit","Submit");
$oAux->set_type("submit");
$oAux->add_style("margin:15px");
$oAux->add_class("btn btn-info");
$oForm->add_control($oAux);
$oForm->show();
?>
        <br/> 
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
use TheFramework\Helpers\HelperForm;

$oForm = new HelperForm();
$oForm-&#x3E;set_comments(&#x22;This is a comment&#x22;);
$oForm-&#x3E;add_style(&#x22;border:1px dashed #4f9fcf;&#x22;);
$oForm-&#x3E;add_style(&#x22;padding:5px;&#x22;);
$oForm-&#x3E;set_id(&#x22;myForm&#x22;);

$oSpan = new TheFramework\Helpers\HelperSpan(&#x22;@&#x22;);
$oSpan-&#x3E;set_class(&#x22;input-group-addon&#x22;);

$sEmail = isset($_POST[&#x22;txtEmail&#x22;])?$_POST[&#x22;txtEmail&#x22;]:NULL;

$oAux = new TheFramework\Helpers\HelperInputText(&#x22;txtEmail&#x22;,&#x22;txtEmail&#x22;);
$oAux-&#x3E;set_type(&#x22;email&#x22;);
$oAux-&#x3E;required();
$oAux-&#x3E;set_value($sEmail);
$oAux-&#x3E;add_class(&#x22;form-control&#x22;);
$oAux-&#x3E;add_extras(&#x22;placeholder&#x22;,&#x22;Recipient&#x27;s email&#x22;);
if($sEmail)
{
    $oAux-&#x3E;set_style(&#x22;border:1px solid black&#x22;);
    $oAux-&#x3E;add_style(&#x22;background:#cc99ff&#x22;);
    $oAux-&#x3E;add_style(&#x22;color:black&#x22;);
    $oAux-&#x3E;add_extras(&#x22;autofocus&#x22;,&#x22;&#x22;);
}

$oAux = new TheFramework\Helpers\HelperRaw(&#x22;&#x3C;div class=\&#x22;input-group\&#x22;&#x3E;{$oSpan-&#x3E;get_html()}{$oAux-&#x3E;get_html()}&#x3C;/div&#x3E;&#x22;);
$oForm-&#x3E;add_control($oAux);

$oAux = new HelperButtonBasic(&#x22;butReset&#x22;,&#x22;Reset&#x22;);
$oAux-&#x3E;set_type(&#x22;reset&#x22;);
$oAux-&#x3E;add_class(&#x22;btn btn-info&#x22;);
$oAux-&#x3E;add_style(&#x22;margin:15px&#x22;);
$oForm-&#x3E;add_control($oAux);

$oAux = new HelperButtonBasic(&#x22;butSubmit&#x22;,&#x22;Submit&#x22;);
$oAux-&#x3E;set_type(&#x22;submit&#x22;);
$oAux-&#x3E;add_style(&#x22;margin:15px&#x22;);
$oAux-&#x3E;add_class(&#x22;btn btn-info&#x22;);
$oForm-&#x3E;add_control($oAux);
$oForm-&#x3E;show();
?&#x3E;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;!-- This is a comment --&#x3E;
&#x3C;form id=&#x22;myForm&#x22; method=&#x22;post&#x22; style=&#x22;border:1px dashed #4f9fcf;;padding:5px;&#x22;&#x3E;
&#x3C;div class=&#x22;input-group&#x22;&#x3E;&#x3C;span class=&#x22;input-group-addon&#x22;&#x3E;@&#x3C;/span&#x3E;
&#x3C;input type=&#x22;email&#x22; id=&#x22;txtEmail&#x22; name=&#x22;txtEmail&#x22; value=&#x22;required@mail.com&#x22; maxlength=&#x22;50&#x22; required=&#x22;&#x22; class=&#x22;form-control&#x22; style=&#x22;border:1px solid black;background:#cc99ff;color:black&#x22; placeholder=&#x22;Recipient&#x27;s email&#x22; autofocus=&#x22;&#x22;&#x3E;
&#x3C;/div&#x3E;&#x3C;button type=&#x22;reset&#x22; id=&#x22;butReset&#x22; class=&#x22;btn btn-info&#x22; style=&#x22;margin:15px&#x22;&#x3E;
Reset&#x3C;/button&#x3E;&#x3C;button type=&#x22;submit&#x22; id=&#x22;butSubmit&#x22; class=&#x22;btn btn-info&#x22; style=&#x22;margin:15px&#x22;&#x3E;
Submit&#x3C;/button&#x3E;
&#x3C;/form&#x3E;</pre>
    </div>    
</div>
<!--/view_button_basic-->  