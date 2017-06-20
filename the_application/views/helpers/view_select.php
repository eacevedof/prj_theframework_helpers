<!--view_select 1.0.0-->
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
        <pre>
<?php
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperSelect;
$oForm = new HelperForm();
$oForm->add_class("form-inline");
//$_GET["warning"]=1 test: http://helpers.theframework.es/index.php?example=helperselect&warning=1
//bugg();
if($oAppMain->get_get("warning"))
    $oForm->add_style("border:1px solid red;");

$oLabel = new HelperLabel("","Date:");
$oForm->add_control($oLabel);

$arOptions = [""=>"Month..."
    ,"1"=>"January","February","March","April","May"
    ,"June","July","August","September","October","November"
    ,"December"
];
//creating an instance of helper select
$oSelect = new HelperSelect($arOptions,"selMonth","selMonth");
$oSelect->set_class("custom-select mb-2 mr-sm-2 mb-sm-0");
$oSelect->set_value_to_select("7");// default selection
$oForm->add_control($oSelect);

$arOptions = [""=>"Year..."
    ,"2014"=>"2014","2015"=>"2015"
    ,"2016"=>"2016","2017"=>"2017"
    ,"2018"=>"2018","2019"=>"2019"
];
$oSelect = new HelperSelect($arOptions,"selYear","selYear");
$oSelect->set_class("custom-select mb-2 mr-sm-2 mb-sm-0");
$oSelect->set_value_to_select("2019");// default selection

$oForm->add_control($oSelect);
$oForm->show();
?>
        </pre>
        <br/>    
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperSelect;
$oForm = new HelperForm();
$oForm-&#x3E;add_class(&#x22;form-inline&#x22;);
//$_GET[&#x22;warning&#x22;]=1 test: http://helpers.theframework.es/index.php?example=helperselect&#x26;warning=1
//bugg();
if($oAppMain-&#x3E;get_get(&#x22;warning&#x22;))
    $oForm-&#x3E;add_style(&#x22;border:1px solid red;&#x22;);

$oLabel = new HelperLabel(&#x22;&#x22;,&#x22;Date:&#x22;);
$oForm-&#x3E;add_control($oLabel);

$arOptions = [&#x22;&#x22;=&#x3E;&#x22;Month...&#x22;
    ,&#x22;1&#x22;=&#x3E;&#x22;January&#x22;,&#x22;February&#x22;,&#x22;March&#x22;,&#x22;April&#x22;,&#x22;May&#x22;
    ,&#x22;June&#x22;,&#x22;July&#x22;,&#x22;August&#x22;,&#x22;September&#x22;,&#x22;October&#x22;,&#x22;November&#x22;
    ,&#x22;December&#x22;
];
//creating an instance of helper select
$oSelect = new HelperSelect($arOptions,&#x22;selMonth&#x22;,&#x22;selMonth&#x22;);
$oSelect-&#x3E;set_class(&#x22;custom-select mb-2 mr-sm-2 mb-sm-0&#x22;);
$oSelect-&#x3E;set_value_to_select(&#x22;7&#x22;);// default selection
$oForm-&#x3E;add_control($oSelect);

$arOptions = [&#x22;&#x22;=&#x3E;&#x22;Year...&#x22;
    ,&#x22;2014&#x22;=&#x3E;&#x22;2014&#x22;,&#x22;2015&#x22;=&#x3E;&#x22;2015&#x22;
    ,&#x22;2016&#x22;=&#x3E;&#x22;2016&#x22;,&#x22;2017&#x22;=&#x3E;&#x22;2017&#x22;
    ,&#x22;2018&#x22;=&#x3E;&#x22;2018&#x22;,&#x22;2019&#x22;=&#x3E;&#x22;2019&#x22;
];
$oSelect = new HelperSelect($arOptions,&#x22;selYear&#x22;,&#x22;selYear&#x22;);
$oSelect-&#x3E;set_class(&#x22;custom-select mb-2 mr-sm-2 mb-sm-0&#x22;);
$oSelect-&#x3E;set_value_to_select(&#x22;2019&#x22;);// default selection

$oForm-&#x3E;add_control($oSelect);
$oForm-&#x3E;show();
?&#x3E;
        </pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;form method=&#x22;post&#x22; class=&#x22;form-inline&#x22;&#x3E;
&#x3C;label&#x3E;Date:&#x3C;/label&#x3E;
&#x3C;select id=&#x22;selMonth&#x22; name=&#x22;selMonth&#x22; size=&#x22;1&#x22; class=&#x22;custom-select mb-2 mr-sm-2 mb-sm-0&#x22;&#x3E;
&#x9;&#x3C;option value=&#x22;&#x22;&#x3E;Month...&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;1&#x22;&#x3E;January&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;2&#x22;&#x3E;February&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;3&#x22;&#x3E;March&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;4&#x22;&#x3E;April&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;5&#x22;&#x3E;May&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;6&#x22;&#x3E;June&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;7&#x22; selected=&#x22;&#x22;&#x3E;July&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;8&#x22;&#x3E;August&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;9&#x22;&#x3E;September&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;10&#x22;&#x3E;October&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;11&#x22;&#x3E;November&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;12&#x22;&#x3E;December&#x3C;/option&#x3E;
&#x3C;/select&#x3E;
&#x3C;select id=&#x22;selYear&#x22; name=&#x22;selYear&#x22; size=&#x22;1&#x22; class=&#x22;custom-select mb-2 mr-sm-2 mb-sm-0&#x22;&#x3E;
&#x9;&#x3C;option value=&#x22;&#x22;&#x3E;Year...&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;2014&#x22;&#x3E;2014&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;2015&#x22;&#x3E;2015&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;2016&#x22;&#x3E;2016&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;2017&#x22;&#x3E;2017&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;2018&#x22;&#x3E;2018&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;2019&#x22; selected=&#x22;&#x22;&#x3E;2019&#x3C;/option&#x3E;
&#x3C;/select&#x3E;
&#x3C;/form&#x3E;
        </pre>
    </div>
<!-------------------------------------------------------------------------------------------------->
<!----------------------------------------------- 2 ------------------------------------------------>
    <h3>
        <span>Example 2</span>
    </h3>
    <br/>
    <div>
        <h4>Live Html</h4>
        <pre>
<?php
use TheFramework\Helpers\HelperRaw;
//https://v4-alpha.getbootstrap.com/components/forms/#form-layouts (customized)
$oForm = new HelperForm();
$oForm->add_class("form-inline");

$oLabel = new HelperLabel("inlineFormCustomSelect","Preference");
$oForm->add_control($oLabel);

$arOptions = [""=>"Choose..."
    ,"1"=>"One","Two","Three"
];
//creating an instance of helper select
$oSelect = new HelperSelect($arOptions,"inlineFormCustomSelect","inlineFormCustomSelect");
$oSelect->set_class("custom-select mb-2 mr-sm-2 mb-sm-0");
$oForm->add_control($oSelect);

$oLabel = new HelperLabel();
$oLabel->add_class("custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0");
$oLabel->add_inner_object(new HelperRaw("<input type=\"checkbox\" class=\"custom-control-input\">"));
$oLabel->add_inner_object(new HelperRaw("<span class=\"custom-control-indicator\"></span>"));
$oLabel->add_inner_object(new HelperRaw("<span class=\"custom-control-description\">Remember my preference</span>"));
$oForm->add_control($oLabel);
$oForm->add_control(new HelperRaw("<button type=\"submit\" class=\"btn btn-primary\">Submit</button>"));
$oForm->show();
?>
        </pre>    
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperSelect;
use TheFramework\Helpers\HelperRaw;
//https://v4-alpha.getbootstrap.com/components/forms/#form-layouts (customized)
$oForm = new HelperForm();
$oForm-&#x3E;add_class(&#x22;form-inline&#x22;);

$oLabel = new HelperLabel(&#x22;inlineFormCustomSelect&#x22;,&#x22;Preference&#x22;);
$oForm-&#x3E;add_control($oLabel);

$arOptions = [&#x22;&#x22;=&#x3E;&#x22;Choose...&#x22;
    ,&#x22;1&#x22;=&#x3E;&#x22;One&#x22;,&#x22;Two&#x22;,&#x22;Three&#x22;
];
//creating an instance of helper select
$oSelect = new HelperSelect($arOptions,&#x22;inlineFormCustomSelect&#x22;,&#x22;inlineFormCustomSelect&#x22;);
$oSelect-&#x3E;set_class(&#x22;custom-select mb-2 mr-sm-2 mb-sm-0&#x22;);
$oForm-&#x3E;add_control($oSelect);

$oLabel = new HelperLabel();
$oLabel-&#x3E;add_class(&#x22;custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0&#x22;);
$oLabel-&#x3E;add_inner_object(new HelperRaw(&#x22;&#x3C;input type=\&#x22;checkbox\&#x22; class=\&#x22;custom-control-input\&#x22;&#x3E;&#x22;));
$oLabel-&#x3E;add_inner_object(new HelperRaw(&#x22;&#x3C;span class=\&#x22;custom-control-indicator\&#x22;&#x3E;&#x3C;/span&#x3E;&#x22;));
$oLabel-&#x3E;add_inner_object(new HelperRaw(&#x22;&#x3C;span class=\&#x22;custom-control-description\&#x22;&#x3E;Remember my preference&#x3C;/span&#x3E;&#x22;));
$oForm-&#x3E;add_control($oLabel);
$oForm-&#x3E;add_control(new HelperRaw(&#x22;&#x3C;button type=\&#x22;submit\&#x22; class=\&#x22;btn btn-primary\&#x22;&#x3E;Submit&#x3C;/button&#x3E;&#x22;));
$oForm-&#x3E;show();
?&#x3E;
        </pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;form method=&#x22;post&#x22; class=&#x22;form-inline&#x22;&#x3E;
&#x3C;label for=&#x22;inlineFormCustomSelect&#x22;&#x3E;Preference&#x3C;/label&#x3E;
&#x3C;select id=&#x22;inlineFormCustomSelect&#x22; name=&#x22;inlineFormCustomSelect&#x22; size=&#x22;1&#x22; class=&#x22;custom-select mb-2 mr-sm-2 mb-sm-0&#x22;&#x3E;
&#x9;&#x3C;option value=&#x22;&#x22; selected=&#x22;&#x22;&#x3E;Choose...&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;1&#x22;&#x3E;One&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;2&#x22;&#x3E;Two&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;3&#x22;&#x3E;Three&#x3C;/option&#x3E;
&#x3C;/select&#x3E;
&#x3C;label class=&#x22;custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0&#x22;&#x3E;&#x3C;input type=&#x22;checkbox&#x22; class=&#x22;custom-control-input&#x22;&#x3E;&#x3C;span class=&#x22;custom-control-indicator&#x22;&#x3E;&#x3C;/span&#x3E;&#x3C;span class=&#x22;custom-control-description&#x22;&#x3E;Remember my preference&#x3C;/span&#x3E;&#x3C;/label&#x3E;
&#x3C;button type=&#x22;submit&#x22; class=&#x22;btn btn-primary&#x22;&#x3E;Submit&#x3C;/button&#x3E;
&#x3C;/form&#x3E;
        </pre>
    </div>  
</div>
<!--/view_select-->  