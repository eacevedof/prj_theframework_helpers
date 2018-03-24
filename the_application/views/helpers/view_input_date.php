<!--view_input_date 1.0.0-->
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
use TheFramework\Helpers\HelperRaw;

if(isset($_POST["datDate"]))//required
    //pr(): is an echo function
    pr("{date:{$_POST["datDate"]},time:{$_POST["datTime"]}}","\$_POST");

//FIELD 1   PHONE
$oLabel = new HelperLabel();
$oLabel->set_for("datDate");
$oLabel->add_class("sr-only");//hides label

$oDate = new HelperDate();
$oDate->set_type("date"); //you can change to phone format.
$oDate->set_id("datDate");
$oDate->set_name("datDate");
$oDate->add_class("form-control");
$oDate->set_value((isset($_POST["datDate"])?$_POST["datDate"]:NULL));

$oDiv = new HelperDiv();
$oDiv->set_comments("divrow");
$oDiv->add_class("col-4 input-group mb-2 mr-sm-2 mb-sm-0");
$oDiv->add_inner_object(new HelperDiv("Date",NULL,"input-group-addon"));
$oDiv->add_inner_object($oDate);

//FIELD 2   TIME
$oLabel2 = clone $oLabel;
$oLabel2->set_for("datTimeX");
$oLabel2->set_class("sr-only");//hides label

$oTime = new HelperDate();
$oTime->set_type("time");//changed type
$oTime->set_id("datTimeX");
$oTime->set_name("datTimeX");
$oTime->add_class("form-control");
$oTime->add_style("border: black 1px dashed");
$oTime->required();
$oTime->set_value((isset($_POST["datTimeX"])?$_POST["datTimeX"]:NULL));
if(isset($_POST["datTimeX"]))
    $oTime->add_extras("autofocus","autofocus");

$oDiv2 = new HelperDiv();
$oDiv2->add_class("col-4 input-group mb-2 mr-sm-2 mb-sm-0");
$oDiv2->add_inner_object(new HelperDiv("Time",NULL,"input-group-addon","background:black;color:white"));
$oDiv2->add_inner_object($oTime);

$oButton = new HelperButtonBasic();
$oButton->set_type("submit");
$oButton->add_class("btn btn-primary");
$oButton->set_innerhtml("Submit");

$oForm = new HelperForm();
$oForm->set_id("myForm");
$oForm->set_method("post");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->add_class("form-inline");
$oForm->add_inner_object($oLabel);
$oForm->add_inner_object($oDiv);
$oForm->add_inner_object(new HelperRaw("<br/>"));
$oForm->add_inner_object($oLabel2);
$oForm->add_inner_object($oDiv2);
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