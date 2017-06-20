<!--view_checkbox 1.1.1-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
     It helps to create html element "input type checkbox":<br/>
     &lt;input type="checkbox"&gt;
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
use TheFramework\Helpers\HelperCheckbox;
use TheFramework\Helpers\HelperRaw;

$arChoose = ["val_a"=>"Text a","val_b"=>"Text b","val_c"=>"Text c","val_d"=>"Text d","val_e"=>"Text e"];
$arChecks = [];
$i = 0;
foreach($arChoose as $sK=>$sLabel)
{
    $arChecks[] = new HelperRaw("<div class=\"form-check\"><label class=\"form-check-label\">");
    $arChecks[$sK] = new HelperCheckbox([$sK=>$sLabel]);
    $arChecks[$sK]->set_id("chkId_$i");
    $arChecks[$sK]->set_name("chkChooseName");
    $arChecks[$sK]->set_values_to_check("val_a|val_d");//or ["val_a","val_d"]
    $arChecks[$sK]->add_class("form-check-input");
    $arChecks[] = new HelperRaw("</label></div>");
    $i++;
}
$oForm = new HelperForm();
$oForm->set_comments("This is a comment");
$oForm->add_style("border:1px dashed #4f9fcf");
$oForm->add_style("padding:5px");
$oForm->set_id("myForm");
$oForm->add_controls($arChecks);
$oForm->show();
?>
        </div><!--example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperCheckbox;
use TheFramework\Helpers\HelperRaw;

$arChoose = [&#x22;val_a&#x22;=&#x3E;&#x22;Text a&#x22;,&#x22;val_b&#x22;=&#x3E;&#x22;Text b&#x22;,&#x22;val_c&#x22;=&#x3E;&#x22;Text c&#x22;,&#x22;val_d&#x22;=&#x3E;&#x22;Text d&#x22;,&#x22;val_e&#x22;=&#x3E;&#x22;Text e&#x22;];
$arChecks = [];
$i = 0;
foreach($arChoose as $sK=&#x3E;$sLabel)
{
    $arChecks[] = new HelperRaw(&#x22;&#x3C;div class=\&#x22;form-check\&#x22;&#x3E;&#x3C;label class=\&#x22;form-check-label\&#x22;&#x3E;&#x22;);
    $arChecks[$sK] = new HelperCheckbox([$sK=&#x3E;$sLabel]);
    $arChecks[$sK]-&#x3E;set_id(&#x22;chkId_$i&#x22;);
    $arChecks[$sK]-&#x3E;set_name(&#x22;chkChooseName&#x22;);
    $arChecks[$sK]-&#x3E;set_values_to_check(&#x22;val_a|val_d&#x22;);//or [&#x22;val_a&#x22;,&#x22;val_d&#x22;]
    $arChecks[$sK]-&#x3E;add_class(&#x22;form-check-input&#x22;);
    $arChecks[] = new HelperRaw(&#x22;&#x3C;/label&#x3E;&#x3C;/div&#x3E;&#x22;);
    $i++;
}
$oForm = new HelperForm();
$oForm-&#x3E;set_comments(&#x22;This is a comment&#x22;);
$oForm-&#x3E;add_style(&#x22;border:1px dashed #4f9fcf&#x22;);
$oForm-&#x3E;add_style(&#x22;padding:5px&#x22;);
$oForm-&#x3E;set_id(&#x22;myForm&#x22;);
$oForm-&#x3E;add_controls($arChecks);
$oForm-&#x3E;show();
?&#x3E;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;!-- This is a comment --&#x3E;
&#x3C;form id=&#x22;myForm&#x22; method=&#x22;post&#x22; style=&#x22;border:1px dashed #4f9fcf;padding:5px;&#x22;&#x3E;
&#x3C;div class=&#x22;form-check&#x22;&#x3E;&#x3C;label class=&#x22;form-check-label&#x22;&#x3E;&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkId_0&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_a&#x22; class=&#x22;form-check-input&#x22; checked=&#x22;&#x22;&#x3E;Text a&#x3C;/label&#x3E;&#x3C;/div&#x3E;&#x3C;div class=&#x22;form-check&#x22;&#x3E;&#x3C;label class=&#x22;form-check-label&#x22;&#x3E;&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkId_1&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_b&#x22; class=&#x22;form-check-input&#x22;&#x3E;Text b&#x3C;/label&#x3E;&#x3C;/div&#x3E;&#x3C;div class=&#x22;form-check&#x22;&#x3E;&#x3C;label class=&#x22;form-check-label&#x22;&#x3E;&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkId_2&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_c&#x22; class=&#x22;form-check-input&#x22;&#x3E;Text c&#x3C;/label&#x3E;&#x3C;/div&#x3E;&#x3C;div class=&#x22;form-check&#x22;&#x3E;&#x3C;label class=&#x22;form-check-label&#x22;&#x3E;&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkId_3&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_d&#x22; class=&#x22;form-check-input&#x22; checked=&#x22;&#x22;&#x3E;Text d&#x3C;/label&#x3E;&#x3C;/div&#x3E;&#x3C;div class=&#x22;form-check&#x22;&#x3E;&#x3C;label class=&#x22;form-check-label&#x22;&#x3E;&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkId_4&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_e&#x22; class=&#x22;form-check-input&#x22;&#x3E;Text e&#x3C;/label&#x3E;&#x3C;/div&#x3E;
&#x3C;/form&#x3E;</pre>
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
<?php
$arChecks = [];
foreach($arChoose as $sK=>$sLabel)
{
    $arChecks[] = new HelperRaw("<div class=\"form-check form-check-inline\"><label class=\"form-check-label\">");
    $arChecks[$sK] = new HelperCheckbox([$sK=>$sLabel]);
    $arChecks[$sK]->set_id("chkId_$i");
    $arChecks[$sK]->set_name("chkChooseName");
    $arChecks[$sK]->set_values_to_check("val_a|val_d");//or ["val_a","val_d"]
    $arChecks[$sK]->add_class("form-check-input");
    $arChecks[] = new HelperRaw("</label></div>");
    $i++;
}

$oForm = new HelperForm();
$oForm->add_style("border:1px dashed #4f9fcf");
$oForm->add_style("padding:5px");
$oForm->set_id("myForm1");
$oForm->add_controls($arChecks);
$oForm->show();
?>      </div><!--/example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
$arChecks = [];
foreach($arChoose as $sK=&#x3E;$sLabel)
{
    $arChecks[] = new HelperRaw(&#x22;&#x3C;div class=\&#x22;form-check form-check-inline\&#x22;&#x3E;&#x3C;label class=\&#x22;form-check-label\&#x22;&#x3E;&#x22;);
    $arChecks[$sK] = new HelperCheckbox([$sK=&#x3E;$sLabel]);
    $arChecks[$sK]-&#x3E;set_id(&#x22;chkId_$i&#x22;);
    $arChecks[$sK]-&#x3E;set_name(&#x22;chkChooseName&#x22;);
    $arChecks[$sK]-&#x3E;set_values_to_check(&#x22;val_a|val_d&#x22;);//or [&#x22;val_a&#x22;,&#x22;val_d&#x22;]
    $arChecks[$sK]-&#x3E;add_class(&#x22;form-check-input&#x22;);
    $arChecks[] = new HelperRaw(&#x22;&#x3C;/label&#x3E;&#x3C;/div&#x3E;&#x22;);
    $i++;
}

$oForm = new HelperForm();
$oForm-&#x3E;add_style(&#x22;border:1px dashed #4f9fcf&#x22;);
$oForm-&#x3E;add_style(&#x22;padding:5px&#x22;);
$oForm-&#x3E;set_id(&#x22;myForm1&#x22;);
$oForm-&#x3E;add_controls($arChecks);
$oForm-&#x3E;show();
?&#x3E; </pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;form id=&#x22;myForm1&#x22; method=&#x22;post&#x22; style=&#x22;border:1px dashed #4f9fcf;padding:5px;&#x22;&#x3E;
&#x3C;div class=&#x22;form-check form-check-inline&#x22;&#x3E;&#x3C;label class=&#x22;form-check-label&#x22;&#x3E;&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkId_5&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_a&#x22; class=&#x22;form-check-input&#x22; checked=&#x22;&#x22;&#x3E;Text a&#x3C;/label&#x3E;&#x3C;/div&#x3E;&#x3C;div class=&#x22;form-check form-check-inline&#x22;&#x3E;&#x3C;label class=&#x22;form-check-label&#x22;&#x3E;&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkId_6&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_b&#x22; class=&#x22;form-check-input&#x22;&#x3E;Text b&#x3C;/label&#x3E;&#x3C;/div&#x3E;&#x3C;div class=&#x22;form-check form-check-inline&#x22;&#x3E;&#x3C;label class=&#x22;form-check-label&#x22;&#x3E;&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkId_7&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_c&#x22; class=&#x22;form-check-input&#x22;&#x3E;Text c&#x3C;/label&#x3E;&#x3C;/div&#x3E;&#x3C;div class=&#x22;form-check form-check-inline&#x22;&#x3E;&#x3C;label class=&#x22;form-check-label&#x22;&#x3E;&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkId_8&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_d&#x22; class=&#x22;form-check-input&#x22; checked=&#x22;&#x22;&#x3E;Text d&#x3C;/label&#x3E;&#x3C;/div&#x3E;&#x3C;div class=&#x22;form-check form-check-inline&#x22;&#x3E;&#x3C;label class=&#x22;form-check-label&#x22;&#x3E;&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkId_9&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_e&#x22; class=&#x22;form-check-input&#x22;&#x3E;Text e&#x3C;/label&#x3E;&#x3C;/div&#x3E;
&#x3C;/form&#x3E;</pre>
    </div>    
<!-------------------------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------------------------->
    <h3>
        <span>Example 3</span>
    </h3>
    <br/>
    <div>
        <h4>Live Html</h4>
<?php
use TheFramework\Helpers\HelperFieldset;
use TheFramework\Helpers\HelperLegend;

$oForm = new HelperForm();
$oForm->set_comments("This is a comment");
$oForm->add_style("border:1px dashed #4f9fcf");
$oForm->add_style("padding:5px");
$oForm->set_id("myForm");

$arChoose = ["val_a"=>"Text a","val_b"=>"Text b","val_c"=>"Text c","val_d"=>"Text d","val_e"=>"Text e"];
$oCheckbox = new HelperCheckbox($arChoose);
$oCheckbox->set_id("chkChooseId");
$oCheckbox->set_name("chkChooseName");
$oCheckbox->add_class("form-check-input");
$oCheckbox->set_style("margin:3px;");
$arValschecked = ["val_b","val_c"];
$oCheckbox->set_values_to_check($arValschecked);
//$oCheckbox->show();
$oFieldset = new HelperFieldset();
$oFieldset->add_class("form-group");
$oCheckbox->set_fieldset($oFieldset);
$oCheckbox->set_legend(new HelperLegend("Legend for checkboxes"));
$oForm->add_control($oCheckbox);
$oForm->show();
//Warning: Overlapping is because of missing bootstrap wrapping divs
?>
        <br/> 
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
use TheFramework\Helpers\HelperFieldset;
use TheFramework\Helpers\HelperLegend;

$oForm = new HelperForm();
$oForm-&#x3E;set_comments(&#x22;This is a comment&#x22;);
$oForm-&#x3E;add_style(&#x22;border:1px dashed #4f9fcf&#x22;);
$oForm-&#x3E;add_style(&#x22;padding:5px&#x22;);
$oForm-&#x3E;set_id(&#x22;myForm&#x22;);

$arChoose = [&#x22;val_a&#x22;=&#x3E;&#x22;Text a&#x22;,&#x22;val_b&#x22;=&#x3E;&#x22;Text b&#x22;,&#x22;val_c&#x22;=&#x3E;&#x22;Text c&#x22;,&#x22;val_d&#x22;=&#x3E;&#x22;Text d&#x22;,&#x22;val_e&#x22;=&#x3E;&#x22;Text e&#x22;];
$oCheckbox = new HelperCheckbox($arChoose);
$oCheckbox-&#x3E;set_id(&#x22;chkChooseId&#x22;);
$oCheckbox-&#x3E;set_name(&#x22;chkChooseName&#x22;);
$oCheckbox-&#x3E;add_class(&#x22;form-check-input&#x22;);
$oCheckbox-&#x3E;set_style(&#x22;margin:3px;&#x22;);
$arValschecked = [&#x22;val_b&#x22;,&#x22;val_c&#x22;];
$oCheckbox-&#x3E;set_values_to_check($arValschecked);
//$oCheckbox-&#x3E;show();
$oFieldset = new HelperFieldset();
$oFieldset-&#x3E;add_class(&#x22;form-group&#x22;);
$oCheckbox-&#x3E;set_fieldset($oFieldset);
$oCheckbox-&#x3E;set_legend(new HelperLegend(&#x22;Legend for checkboxes&#x22;));
$oForm-&#x3E;add_control($oCheckbox);
$oForm-&#x3E;show();
?&#x3E;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;form id=&#x22;myForm&#x22; method=&#x22;post&#x22; style=&#x22;border:1px dashed #4f9fcf;padding:5px;&#x22;&#x3E;
&#x3C;fieldset class=&#x22;form-group&#x22;&#x3E;&#x3C;legend&#x3E;Legend for checkboxes&#x3C;/legend&#x3E;
&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkChooseId_0&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_a&#x22; class=&#x22;form-check-input&#x22; style=&#x22;margin:3px;&#x22;&#x3E;Text a&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkChooseId_1&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_b&#x22; class=&#x22;form-check-input&#x22; style=&#x22;margin:3px;&#x22; checked=&#x22;&#x22;&#x3E;Text b&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkChooseId_2&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_c&#x22; class=&#x22;form-check-input&#x22; style=&#x22;margin:3px;&#x22; checked=&#x22;&#x22;&#x3E;Text c&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkChooseId_3&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_d&#x22; class=&#x22;form-check-input&#x22; style=&#x22;margin:3px;&#x22;&#x3E;Text d&#x3C;input type=&#x22;checkbox&#x22; id=&#x22;chkChooseId_4&#x22; name=&#x22;chkChooseName[]&#x22; value=&#x22;val_e&#x22; class=&#x22;form-check-input&#x22; style=&#x22;margin:3px;&#x22;&#x3E;Text e&#x3C;/fieldset&#x3E;
&#x3C;/form&#x3E;</pre>
    </div>    
</div>
<!--/view_checkbox-->  