<!--view_label 1.0.0-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
        It helps to create html element "label":<br/>
        <b>&lt;label&gt;...innerhtml...&lt;/label&gt;</b>
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
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperInputText;
use TheFramework\Helpers\HelperSelect;

$arFields = [];

$oLabel = new HelperLabel("txtSomeId","Label for text");
$oLabel->add_class("custom-control");
$arFields[] = $oLabel;

$oText = new HelperInputText();
$oText->add_class("col-4");
$oText->add_class("form-control");
$oText->add_extras("placeholder","...some text here");
$oText->set_id("txtSomeId");
$oText->set_name("txtSomeName");
$arFields[] = $oText;

$arFields["sel"] = new HelperSelect(
    [""=>"choose...","one"=>"One","two"=>"Two","three"=>"Three"],
    "idSelDemo","nameSelDemo",
    new HelperLabel("idSelDemo","Label for Select"));

$oForm = new HelperForm();
$oForm->add_class("col-6");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->set_id("myForm");
//$oForm->set_action("/");
$oForm->set_method("some_method");
$oForm->set_enctype("myEncType");
$oForm->add_controls($arFields);
$oForm->show();
?>
        </div><!--example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&lt;?php
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperInputText;
use TheFramework\Helpers\HelperSelect;

$arFields = [];

$oLabel = new HelperLabel(&quot;txtSomeId&quot;,&quot;Label for text&quot;);
$oLabel-&gt;add_class(&quot;custom-control&quot;);
$arFields[] = $oLabel;

$oText = new HelperInputText();
$oText-&gt;add_class(&quot;col-4&quot;);
$oText-&gt;add_class(&quot;form-control&quot;);
$oText-&gt;add_extras(&quot;placeholder&quot;,&quot;...some text here&quot;);
$oText-&gt;set_id(&quot;txtSomeId&quot;);
$oText-&gt;set_name(&quot;txtSomeName&quot;);
$arFields[] = $oText;

$arFields[&quot;sel&quot;] = new HelperSelect(
    [&quot;&quot;=&gt;&quot;choose...&quot;,&quot;one&quot;=&gt;&quot;One&quot;,&quot;two&quot;=&gt;&quot;Two&quot;,&quot;three&quot;=&gt;&quot;Three&quot;],
    &quot;idSelDemo&quot;,&quot;nameSelDemo&quot;,
    new HelperLabel(&quot;idSelDemo&quot;,&quot;Label for Select&quot;));

$oForm = new HelperForm();
$oForm-&gt;add_class(&quot;col-6&quot;);
$oForm-&gt;add_style(&quot;border:1px dashed #4f9fcf;&quot;);
$oForm-&gt;add_style(&quot;padding:5px;&quot;);
$oForm-&gt;set_id(&quot;myForm&quot;);
//$oForm-&gt;set_action(&quot;/&quot;);
$oForm-&gt;set_method(&quot;some_method&quot;);
$oForm-&gt;set_enctype(&quot;myEncType&quot;);
$oForm-&gt;add_controls($arFields);
$oForm-&gt;show();
?&gt;
</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&lt;form id=&quot;myForm&quot; method=&quot;some_method&quot; enctype=&quot;myEncType&quot; class=&quot;col-6&quot; style=&quot;border:1px dashed #4f9fcf;;padding:5px;&quot;&gt;
&lt;label for=&quot;txtSomeId&quot; class=&quot;custom-control&quot;&gt;Label for text&lt;/label&gt;
&lt;input type=&quot;text&quot; id=&quot;txtSomeId&quot; name=&quot;txtSomeName&quot; maxlength=&quot;50&quot; class=&quot;col-4 form-control&quot; placeholder=&quot;...some text here&quot;&gt;
&lt;label for=&quot;idSelDemo&quot;&gt;Label for Select&lt;/label&gt;
&lt;select id=&quot;idSelDemo&quot; name=&quot;nameSelDemo&quot; size=&quot;1&quot;&gt;
	&lt;option value=&quot;&quot; selected=&quot;&quot;&gt;choose...&lt;/option&gt;
	&lt;option value=&quot;one&quot;&gt;One&lt;/option&gt;
	&lt;option value=&quot;two&quot;&gt;Two&lt;/option&gt;
	&lt;option value=&quot;three&quot;&gt;Three&lt;/option&gt;
&lt;/select&gt;

&lt;/form&gt;</pre>
    </div>
<!-------------------------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------------------------->    
    <h3>
        <span>Example 2</span>
    </h3>
    <br/>
    <div>
        <h4>Live Html</h4>
        <div>      
       </div><!--/example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint"></pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint"></pre>
    </div>  
</div>
<!--/view_label-->  