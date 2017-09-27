<!--view_div 1.1.0-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
        It helps to create html element "div":<br/>
        <b>&lt;div&gt;...innerhtml...&lt;/div&gt;</b>
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
use TheFramework\Helpers\HelperDiv;
$oDivCell = new HelperDiv("1 of 2");
$oDivCell->add_class("col");
$oDivCell2 = new HelperDiv("2 of 2");
$oDivCell2->add_class("col");

$oDivRow = new HelperDiv();
$oDivRow->add_class("row");
$oDivRow->add_inner_object($oDivCell);
$oDivRow->add_inner_object($oDivCell2);

$oDivContainer = new HelperDiv();
$oDivContainer->add_class("container");
$oDivContainer->add_inner_object($oDivRow);
$oDivContainer->show();
?>
        </div><!--example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&lt;?php
use TheFramework\Helpers\HelperDiv;
$oDivCell = new HelperDiv("1 of 2");
$oDivCell-&gt;add_class("col");
$oDivCell2 = new HelperDiv("2 of 2");
$oDivCell2-&gt;add_class("col");

$oDivRow = new HelperDiv();
$oDivRow-&gt;add_class("row");
$oDivRow-&gt;add_inner_object($oDivCell);
$oDivRow-&gt;add_inner_object($oDivCell2);

$oDivContainer = new HelperDiv();
$oDivContainer-&gt;add_class("container");
$oDivContainer-&gt;add_inner_object($oDivRow);
$oDivContainer-&gt;show();
?&gt;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&lt;div class="container"&gt;
&lt;div class="row"&gt;
&lt;div class="col"&gt;
1 of 2&lt;/div&gt;
&lt;div class="col"&gt;
2 of 2&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;</pre>
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
$oDivCell = new HelperDiv("1 of 3");
$oDivCell->add_class("col col-lg-2");
$oDivCell->add_style("border:1px solid #ccc");
$oDivCell2 = new HelperDiv("Variable width content");
$oDivCell2->add_class("col");
$oDivCell2->add_style("border:1px solid #ccc");
$oDivCell3 = new HelperDiv("3 of 3");
$oDivCell3->add_class("col col-lg-2");
$oDivCell3->add_style("border:1px solid #ccc");

$oDivRow = new HelperDiv();
$oDivRow->add_class("row justify-content-md-center");
$oDivRow->add_inner_object($oDivCell);
$oDivRow->add_inner_object($oDivCell2);
$oDivRow->add_inner_object($oDivCell3);

$oDivRow2 = new HelperDiv();
$oDivRow2->add_class("row");
$oDivCell = new HelperDiv("1 of 3");
$oDivCell->add_class("col");
$oDivCell->add_style("border:1px solid #ccc");
$oDivCell2 = new HelperDiv("Variable width content");
$oDivCell2->add_class("col-12 col-md-auto");
$oDivCell2->add_style("border:1px solid #ccc");
$oDivCell3 = new HelperDiv("3 of 3");
$oDivCell3->add_class("col col-lg-2");
$oDivCell3->add_style("border:1px solid #ccc");
$oDivRow2->add_inner_object($oDivCell);
$oDivRow2->add_inner_object($oDivCell2);
$oDivRow2->add_inner_object($oDivCell3);

$oDivContainer = new HelperDiv();
$oDivContainer->add_class("container");
$oDivContainer->add_inner_object($oDivRow);
$oDivContainer->add_inner_object($oDivRow2);
$oDivContainer->show();
?>        
       </div><!--/example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&lt;?php
$oDivCell = new HelperDiv("1 of 3");
$oDivCell-&gt;add_class("col col-lg-2");
$oDivCell-&gt;add_style("border:1px solid #ccc");
$oDivCell2 = new HelperDiv("Variable width content");
$oDivCell2-&gt;add_class("col");
$oDivCell2-&gt;add_style("border:1px solid #ccc");
$oDivCell3 = new HelperDiv("3 of 3");
$oDivCell3-&gt;add_class("col col-lg-2");
$oDivCell3-&gt;add_style("border:1px solid #ccc");

$oDivRow = new HelperDiv();
$oDivRow-&gt;add_class("row justify-content-md-center");
$oDivRow-&gt;add_inner_object($oDivCell);
$oDivRow-&gt;add_inner_object($oDivCell2);
$oDivRow-&gt;add_inner_object($oDivCell3);

$oDivRow2 = new HelperDiv();
$oDivRow2-&gt;add_class("row");
$oDivCell = new HelperDiv("1 of 3");
$oDivCell-&gt;add_class("col");
$oDivCell-&gt;add_style("border:1px solid #ccc");
$oDivCell2 = new HelperDiv("Variable width content");
$oDivCell2-&gt;add_class("col-12 col-md-auto");
$oDivCell2-&gt;add_style("border:1px solid #ccc");
$oDivCell3 = new HelperDiv("3 of 3");
$oDivCell3-&gt;add_class("col col-lg-2");
$oDivCell3-&gt;add_style("border:1px solid #ccc");
$oDivRow2-&gt;add_inner_object($oDivCell);
$oDivRow2-&gt;add_inner_object($oDivCell2);
$oDivRow2-&gt;add_inner_object($oDivCell3);

$oDivContainer = new HelperDiv();
$oDivContainer-&gt;add_class("container");
$oDivContainer-&gt;add_inner_object($oDivRow);
$oDivContainer-&gt;add_inner_object($oDivRow2);
$oDivContainer-&gt;show();
?&gt;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&lt;div class="container"&gt;
&lt;div class="row justify-content-md-center"&gt;
&lt;div class="col col-lg-2" style="border:1px solid #ccc"&gt;
1 of 3&lt;/div&gt;
&lt;div class="col" style="border:1px solid #ccc"&gt;
Variable width content&lt;/div&gt;
&lt;div class="col col-lg-2" style="border:1px solid #ccc"&gt;
3 of 3&lt;/div&gt;
&lt;/div&gt;
&lt;div class="row"&gt;
&lt;div class="col" style="border:1px solid #ccc"&gt;
1 of 3&lt;/div&gt;
&lt;div class="col-12 col-md-auto" style="border:1px solid #ccc"&gt;
Variable width content&lt;/div&gt;
&lt;div class="col col-lg-2" style="border:1px solid #ccc"&gt;
3 of 3&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;</pre>
    </div>  
</div>
<!--/view_div-->  