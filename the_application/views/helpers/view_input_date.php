<!--view_input_date 1.1.0-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
        It helps to create html element "input type date|time":<br/>
        <b>&lt;input type=&quot;date&quot; value=&quot;2011-08-19&quot;&gt;</b><br/>
        <b>&lt;input type=&quot;time&quot; value=&quot;13:45:00&quot;&gt;</b>
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
//<input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
//<input class="form-control" type="month" value="2011-08" id="example-month-input">
//<input class="form-control" type="week" value="2011-W33" id="example-week-input">
//<input class="form-control" type="date" value="2011-08-19" id="example-date-input">
//<input class="form-control" type="time" value="13:45:00" id="example-time-input">
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperDate;
use TheFramework\Helpers\HelperDiv;
use TheFramework\Helpers\HelperButtonBasic;
use TheFramework\Helpers\HelperForm;

if(isset($_POST["datDate"]))//required
    //pr(): is an echo function
    pr("{datDate:{$_POST["datDate"]},datTime:{$_POST["datTime"]}}","\$_POST");

//FIELD 1   PHONE
$oLabel = new HelperLabel();
$oLabel->set_for("datDate");
$oLabel->add_class("col-2 col-form-label");
$oLabel->set_innerhtml("Date:");

$oDate = new HelperDate();
$oDate->set_type("date"); //you can change to phone format.
$oDate->set_separator("/");
$oDate->set_id("datDate");
$oDate->set_name("datDate");
$oDate->add_class("form-control col-2");
$oDate->set_value((isset($_POST["datDate"])?$_POST["datDate"]:NULL));

$oDivrow = new HelperDiv();
$oDivrow->add_class("form-group row");

$oTmp = new HelperDiv();
$oTmp->set_class("col-10");
$oTmp->add_inner_object($oDate);

$oDivrow->add_inner_object($oLabel);
$oDivrow->add_inner_object($oTmp);

//FIELD 2   TIME
$oLabel2 = clone $oLabel;
$oLabel2->set_for("datTime");
$oLabel2->add_class("col-2 col-form-label");
$oLabel2->set_innerhtml("Time:");

$oTime = new HelperDate();
$oTime->set_type("time");
$oTime->set_separator(":");
$oTime->set_id("datTime");
$oTime->set_name("datTime");
$oTime->add_class("form-control col-2");
//$oTime->add_style("border: black 1px dashed");
$oTime->required();
$oTime->set_value((isset($_POST["datTime"])?$_POST["datTime"]:NULL));
if(isset($_POST["datTime"]))
    $oTime->add_extras("autofocus","autofocus");

$oDivrow2 = new HelperDiv();
$oDivrow2->add_class("form-group row");

$oTmp = new HelperDiv();
$oTmp->set_class("col-10");
$oTmp->add_inner_object($oTime);

$oDivrow2->add_inner_object($oLabel2);
$oDivrow2->add_inner_object($oTmp);

$oButton = new HelperButtonBasic();
$oButton->set_type("submit");
$oButton->add_class("btn btn-primary");
$oButton->set_innerhtml("Submit");

$oForm = new HelperForm();
$oForm->set_id("myForm");
$oForm->set_method("post");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
//$oForm->add_class("form-inline");
$oForm->add_inner_object($oDivrow);
$oForm->add_inner_object($oDivrow2);
$oForm->add_inner_object($oButton);
$oForm->show(); //show() is the same as echo $oForm->get_html();
?>
        </div><!--example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
</pre>
    </div>
<!-- example 2 -->  
</div>
<!--/view_input_date-->  