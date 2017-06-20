<!--view_form_fieldset 1.0.1-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
        It allows to create fieldset tag like &#x3C;fieldset&#x3E; ... &#x3C;/fieldset&#x3E;
    </p>
    <br/>
    <h3>
        <span>Example 1</span>
    </h3>
    <br/>
    <div>
        <h4>Live Html</h4>
        <div>
<?php
use TheFramework\Helpers\HelperFieldset;
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperInputText;
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperRaw;

$oForm = new HelperForm();
$oForm->set_comments("This is a comment");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->set_id("myForm");

$oFieldset = new HelperFieldset();
$oFieldset->add_class("form-group");
$oFieldset->add_inner_object(new HelperRaw("<legend>First fieldset</legend>"));
$oFieldset->add_inner_object(new HelperLabel("txtOne","Field one"));
$oFieldset->add_inner_object(new HelperInputText("txtOne","txtOne"));
$oFieldset->add_inner_object(new HelperLabel("txtTwo","Field two"));
$oFieldset->add_inner_object(new HelperInputText("txtTwo","txtTwo"));
$oForm->add_control($oFieldset);

$oFieldset = new HelperFieldset();
$oFieldset->add_class("form-group");
$oFieldset->add_inner_object(new HelperRaw("<legend>Second fieldset</legend>"));
$oFieldset->add_inner_object(new HelperLabel("txtThree","Field three"));
$oFieldset->add_inner_object(new HelperInputText("txtThree","txtThree"));
$oFieldset->add_inner_object(new HelperLabel("txtFour","Field four"));
$oFieldset->add_inner_object(new HelperInputText("txtFour","txtFour"));
$oForm->add_control($oFieldset);
$oForm->show();
?>
        </div>
        <br/> 
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
use TheFramework\Helpers\HelperFieldset;
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperInputText;
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperRaw;

$oForm = new HelperForm();
$oForm-&#x3E;set_comments(&#x22;This is a comment&#x22;);
$oForm-&#x3E;add_style(&#x22;border:1px dashed #4f9fcf;&#x22;);
$oForm-&#x3E;add_style(&#x22;padding:5px;&#x22;);
$oForm-&#x3E;set_id(&#x22;myForm&#x22;);

$oFieldset = new HelperFieldset();
$oFieldset-&#x3E;add_class(&#x22;form-group&#x22;);
$oFieldset-&#x3E;add_inner_object(new HelperRaw(&#x22;&#x3C;legend&#x3E;First fieldset&#x3C;/legend&#x3E;&#x22;));
$oFieldset-&#x3E;add_inner_object(new HelperLabel(&#x22;txtOne&#x22;,&#x22;Field one&#x22;));
$oFieldset-&#x3E;add_inner_object(new HelperInputText(&#x22;txtOne&#x22;,&#x22;txtOne&#x22;));
$oFieldset-&#x3E;add_inner_object(new HelperLabel(&#x22;txtTwo&#x22;,&#x22;Field two&#x22;));
$oFieldset-&#x3E;add_inner_object(new HelperInputText(&#x22;txtTwo&#x22;,&#x22;txtTwo&#x22;));
$oForm-&#x3E;add_control($oFieldset);

$oFieldset = new HelperFieldset();
$oFieldset-&#x3E;add_class(&#x22;form-group&#x22;);
$oFieldset-&#x3E;add_inner_object(new HelperRaw(&#x22;&#x3C;legend&#x3E;Second fieldset&#x3C;/legend&#x3E;&#x22;));
$oFieldset-&#x3E;add_inner_object(new HelperLabel(&#x22;txtThree&#x22;,&#x22;Field three&#x22;));
$oFieldset-&#x3E;add_inner_object(new HelperInputText(&#x22;txtThree&#x22;,&#x22;txtThree&#x22;));
$oFieldset-&#x3E;add_inner_object(new HelperLabel(&#x22;txtFour&#x22;,&#x22;Field four&#x22;));
$oFieldset-&#x3E;add_inner_object(new HelperInputText(&#x22;txtFour&#x22;,&#x22;txtFour&#x22;));
$oForm-&#x3E;add_control($oFieldset);
$oForm-&#x3E;show();
?&#x3E;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;!-- This is a comment --&#x3E;
&#x3C;form id=&#x22;myForm&#x22; method=&#x22;post&#x22; style=&#x22;border:1px dashed #4f9fcf;;padding:5px;&#x22;&#x3E;
&#x3C;fieldset class=&#x22;form-group&#x22;&#x3E;&#x3C;legend&#x3E;First fieldset&#x3C;/legend&#x3E;&#x3C;label for=&#x22;txtOne&#x22;&#x3E;Field one&#x3C;/label&#x3E;
&#x3C;input type=&#x22;text&#x22; id=&#x22;txtOne&#x22; name=&#x22;txtOne&#x22; maxlength=&#x22;50&#x22;&#x3E;
&#x3C;label for=&#x22;txtTwo&#x22;&#x3E;Field two&#x3C;/label&#x3E;
&#x3C;input type=&#x22;text&#x22; id=&#x22;txtTwo&#x22; name=&#x22;txtTwo&#x22; maxlength=&#x22;50&#x22;&#x3E;
&#x3C;/fieldset&#x3E;
&#x3C;fieldset class=&#x22;form-group&#x22;&#x3E;&#x3C;legend&#x3E;Second fieldset&#x3C;/legend&#x3E;&#x3C;label for=&#x22;txtThree&#x22;&#x3E;Field three&#x3C;/label&#x3E;
&#x3C;input type=&#x22;text&#x22; id=&#x22;txtThree&#x22; name=&#x22;txtThree&#x22; maxlength=&#x22;50&#x22;&#x3E;
&#x3C;label for=&#x22;txtFour&#x22;&#x3E;Field four&#x3C;/label&#x3E;
&#x3C;input type=&#x22;text&#x22; id=&#x22;txtFour&#x22; name=&#x22;txtFour&#x22; maxlength=&#x22;50&#x22;&#x3E;
&#x3C;/fieldset&#x3E;
&#x3C;/form&#x3E;</pre>
    </div>
</div>
<!--/view_form_fieldset-->  