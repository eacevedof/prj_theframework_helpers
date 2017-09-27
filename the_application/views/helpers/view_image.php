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
//https://cdn3.iconfinder.com/data/icons/inficons-round-brand-set-2/512/twitter-512.png
//https://cdn4.iconfinder.com/data/icons/miu-gloss-social/60/facebook-512.png
//<img src="..." class="rounded float-left" alt="...">
//<img src="..." class="rounded float-right" alt="...">
//<div class="text-center">
//  <img src="..." class="rounded" alt="...">
//</div>
use TheFramework\Helpers\HelperDiv;

$oDiv = new HelperDiv();
$oDiv->add_extras("id","divContainer");

$arImage["facebook"] = new HelperImage();
$arImage["facebook"]->set_alt("Facebook alt prop");
$arImage["facebook"]->set_src("https://cdn4.iconfinder.com/data/icons/miu-gloss-social/60/facebook-512.png");
$arImage["facebook"]->add_class("rounded");
$arImage["facebook"]->add_class("float-left");
$arImage["facebook"]->add_extras("height","50");

$arImage["twitter"] = new HelperImage();
$arImage["twitter"]->add_extras("someattr","some value for attr");
$arImage["twitter"]->set_alt("twitter alt prop");
$arImage["twitter"]->set_src("https://cdn4.iconfinder.com/data/icons/miu-gloss-social/60/twitter-512.png");
$arImage["twitter"]->add_class("rounded");
$arImage["twitter"]->add_class("float-right");
$arImage["twitter"]->add_extras("height","50");

$oDiv->add_inner_object($arImage["facebook"]);
$oDiv->add_inner_object($arImage["twitter"]);

$oDiv->show();

?>        
       </div><!--/example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&lt;?php

?&gt;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
</pre>
    </div>  
</div>
<!--/view_img-->  