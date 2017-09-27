<!--view_img 1.1.0-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
        It helps to create html element "img":<br/>
        <b>&lt;img src=&quot;...&quot; class=&quot;img-fluid&quot; alt=&quot;Responsive image&quot;&gt;</b>
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
//https://cdn3.iconfinder.com/data/icons/inficons-round-brand-set-2/512/twitter-512.png
//https://cdn4.iconfinder.com/data/icons/miu-gloss-social/60/facebook-512.png
//<img src="..." class="img-fluid" alt="Responsive image">
use TheFramework\Helpers\HelperImage;
$oImage = new HelperImage();
$oImage->set_src("http://images.locanto.net/2105338549/Best-CDN-Providers-CDN-Solution-Provider_2.png");
$oImage->set_alt("Responsive image");
$oImage->set_class("img-fluid");
$oImage->show();
?>
        </div><!--example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&lt;?php
use TheFramework\Helpers\HelperImage;
$oImage = new HelperImage();
$oImage->set_src("http://images.locanto.net/2105338549/Best-CDN-Providers-CDN-Solution-Provider_2.png");
$oImage->set_alt("Responsive image");
$oImage->set_class("img-fluid");
$oImage->show();
?&gt;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&lt;img src=&quot;http://images.locanto.net/2105338549/Best-CDN-Providers-CDN-Solution-Provider_2.png&quot; alt=&quot;Responsive image&quot; class=&quot;img-fluid&quot;&gt;</pre>
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
</pre>
    </div>  
</div>
<!--/view_img-->  