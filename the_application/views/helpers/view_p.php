<!--view_p 1.0.0-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
        It helps to create html element "p":<br/>
        <b>&lt;p&gt;...innerhtml...&lt;/p&gt;</b>
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
use TheFramework\Helpers\HelperP;
$arParagraphs = [];

$arParagraphs[] = new HelperP("h1. Bootstrap heading","p1","h1");
$arParagraphs[] = new HelperP("h2. Bootstrap heading","p2","h2");
$arParagraphs[] = new HelperP("h3. Bootstrap heading","p3","h3");
$arParagraphs[] = new HelperP("h4. Bootstrap heading","p4","h4");
$arParagraphs[] = new HelperP("h5. Bootstrap heading","p5","h5");
$arParagraphs[] = new HelperP("h6. Bootstrap heading","p6","h6");

foreach($arParagraphs as $oP)
    $oP->show();
?>
        </div><!--example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&lt;?php
use TheFramework\Helpers\HelperP;
$arParagraphs = [];

$arParagraphs[] = new HelperP(&quot;h1. Bootstrap heading&quot;,&quot;p1&quot;,&quot;h1&quot;);
$arParagraphs[] = new HelperP(&quot;h2. Bootstrap heading&quot;,&quot;p2&quot;,&quot;h2&quot;);
$arParagraphs[] = new HelperP(&quot;h3. Bootstrap heading&quot;,&quot;p3&quot;,&quot;h3&quot;);
$arParagraphs[] = new HelperP(&quot;h4. Bootstrap heading&quot;,&quot;p4&quot;,&quot;h4&quot;);
$arParagraphs[] = new HelperP(&quot;h5. Bootstrap heading&quot;,&quot;p5&quot;,&quot;h5&quot;);
$arParagraphs[] = new HelperP(&quot;h6. Bootstrap heading&quot;,&quot;p6&quot;,&quot;h6&quot;);

foreach($arParagraphs as $oP)
    $oP-&gt;show();
?&gt;
</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&lt;p id=&quot;p1&quot; class=&quot;h1&quot;&gt;
h1. Bootstrap heading&lt;/p&gt;
&lt;p id=&quot;p2&quot; class=&quot;h2&quot;&gt;
h2. Bootstrap heading&lt;/p&gt;
&lt;p id=&quot;p3&quot; class=&quot;h3&quot;&gt;
h3. Bootstrap heading&lt;/p&gt;
&lt;p id=&quot;p4&quot; class=&quot;h4&quot;&gt;
h4. Bootstrap heading&lt;/p&gt;
&lt;p id=&quot;p5&quot; class=&quot;h5&quot;&gt;
h5. Bootstrap heading&lt;/p&gt;
&lt;p id=&quot;p6&quot; class=&quot;h6&quot;&gt;
h6. Bootstrap heading&lt;/p&gt;
</pre>
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
$oP = new HelperP();
$oP->add_class("h6");
$oP->add_style("border:1px dashed blue");
$oP->add_style("padding:10px");
$oP->set_innerhtml("
    Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, <br/>
    totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. <br/> 
    Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, 
    qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur 
    adipisci[ng] velit, sed quia non-numquam [do] eius modi tempora inci[di]dunt, ut labore et dolore magnam aliquam 
    quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, 
    nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, 
    quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur?");
$oP->show();
?>            
        </div><!--/example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&lt;?php
use TheFramework\Helpers\HelperP;
$oP = new HelperP();
$oP-&gt;add_class(&quot;h6&quot;);
$oP-&gt;add_style(&quot;border:1px dashed blue&quot;);
$oP-&gt;add_style(&quot;padding:10px&quot;);
$oP-&gt;set_innerhtml(&quot;
    Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, &lt;br/&gt;
    totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. &lt;br/&gt; 
    Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, 
    qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur 
    adipisci[ng] velit, sed quia non-numquam [do] eius modi tempora inci[di]dunt, ut labore et dolore magnam aliquam 
    quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, 
    nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, 
    quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur?&quot;);
$oP-&gt;show();
?&gt;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&lt;p class=&quot;h6&quot; style=&quot;border:1px dashed blue;padding:10px&quot;&gt;

    Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, &lt;br&gt;
    totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. &lt;br&gt; 
    Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, 
    qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur 
    adipisci[ng] velit, sed quia non-numquam [do] eius modi tempora inci[di]dunt, ut labore et dolore magnam aliquam 
    quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, 
    nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, 
    quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur?&lt;/p&gt;</pre>
    </div>  
</div>
<!--/view_p-->  