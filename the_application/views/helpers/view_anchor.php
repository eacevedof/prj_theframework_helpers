<!--view_anchor 1.0.0-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
        It allows you to create &#x3C;a&#x3E;...&#x3C;/a&#x3E; html element
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
<?php
use TheFramework\Helpers\HelperAnchor;
use TheFramework\Helpers\HelperRaw;

$arHtml = [];
$arHtml[] = new HelperRaw("<ul class=\"nav nav-pills\">");
$arHtml[] = new HelperRaw("<li class=\"nav-item\">");
$arHtml["anchor_1"] = new HelperAnchor("Eduardoaf.com");
$arHtml["anchor_1"]->add_class("nav-link active");
$arHtml["anchor_1"]->set_href("http://eduardoaf.com");
$arHtml["anchor_1"]->set_target("blank");
$arHtml[] = new HelperRaw("</li>");
$arHtml[] = new HelperRaw("<li class=\"nav-item\">");
$arHtml["anchor_2"] = new HelperAnchor("Simple link");
$arHtml["anchor_2"]->add_class("nav-link");
$arHtml["anchor_2"]->set_href("#");
$arHtml[] = new HelperRaw("</li>");
$arHtml[] = new HelperRaw("</ul>");

foreach ($arHtml as $oHtml)
    $oHtml->show();
?>
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">&#x3C;?php
use TheFramework\Helpers\HelperAnchor;
use TheFramework\Helpers\HelperRaw;

$arHtml = [];
$arHtml[] = new HelperRaw(&#x22;&#x3C;ul class=\&#x22;nav nav-pills\&#x22;&#x3E;&#x22;);
$arHtml[] = new HelperRaw(&#x22;&#x3C;li class=\&#x22;nav-item\&#x22;&#x3E;&#x22;);
$arHtml[&#x22;anchor_1&#x22;] = new HelperAnchor(&#x22;Eduardoaf.com&#x22;);
$arHtml[&#x22;anchor_1&#x22;]-&#x3E;add_class(&#x22;nav-link active&#x22;);
$arHtml[&#x22;anchor_1&#x22;]-&#x3E;set_href(&#x22;http://eduardoaf.com&#x22;);
$arHtml[&#x22;anchor_1&#x22;]-&#x3E;set_target(&#x22;blank&#x22;);
$arHtml[] = new HelperRaw(&#x22;&#x3C;/li&#x3E;&#x22;);
$arHtml[] = new HelperRaw(&#x22;&#x3C;li class=\&#x22;nav-item\&#x22;&#x3E;&#x22;);
$arHtml[&#x22;anchor_2&#x22;] = new HelperAnchor(&#x22;Simple link&#x22;);
$arHtml[&#x22;anchor_2&#x22;]-&#x3E;add_class(&#x22;nav-link&#x22;);
$arHtml[&#x22;anchor_2&#x22;]-&#x3E;set_href(&#x22;#&#x22;);
$arHtml[] = new HelperRaw(&#x22;&#x3C;/li&#x3E;&#x22;);
$arHtml[] = new HelperRaw(&#x22;&#x3C;/ul&#x3E;&#x22;);

foreach ($arHtml as $oHtml)
    $oHtml-&#x3E;show();
?&#x3E;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;ul class=&#x22;nav nav-pills&#x22;&#x3E;&#x3C;li class=&#x22;nav-item&#x22;&#x3E;&#x3C;a href=&#x22;http://eduardoaf.com&#x22; target=&#x22;_blank&#x22; class=&#x22;nav-link active&#x22;&#x3E;Eduardoaf.com&#x3C;/a&#x3E;
&#x3C;/li&#x3E;&#x3C;li class=&#x22;nav-item&#x22;&#x3E;&#x3C;a href=&#x22;#&#x22; class=&#x22;nav-link&#x22;&#x3E;Simple link&#x3C;/a&#x3E;
&#x3C;/li&#x3E;&#x3C;/ul&#x3E;</pre>
    </div>
<!-------------------------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------------------------->
    <h3>
        <span>Example 2</span>
    </h3>
    <br/>
    <div>
        <h4>Live Html</h4>
<?php
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperP;

$oForm = new HelperForm();
$oForm->add_class("");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->set_id("myForm");
$oForm->add_control(new HelperP("<b>Links in a form</b>"));
for($i=0; $i<3; $i++)
    $oForm->add_control(new HelperAnchor("Anchor $i","anchor_$i","#link"));

$oForm->show();
?>
        <br/> 
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperP;

$oForm = new HelperForm();
$oForm-&#x3E;add_class(&#x22;&#x22;);
$oForm-&#x3E;add_style(&#x22;border:1px dashed #4f9fcf;&#x22;);
$oForm-&#x3E;add_style(&#x22;padding:5px;&#x22;);
$oForm-&#x3E;set_id(&#x22;myForm&#x22;);
$oForm-&#x3E;add_control(new HelperP(&#x22;&#x3C;b&#x3E;Links in a form&#x3C;/b&#x3E;&#x22;));
for($i=0; $i&#x3C;3; $i++)
    $oForm-&#x3E;add_control(new HelperAnchor(&#x22;Anchor $i&#x22;,&#x22;anchor_$i&#x22;,&#x22;#link&#x22;));

$oForm-&#x3E;show();
?&#x3E;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;form id=&#x22;myForm&#x22; method=&#x22;post&#x22; style=&#x22;border:1px dashed #4f9fcf;;padding:5px;&#x22;&#x3E;
&#x3C;p&#x3E;
&#x3C;b&#x3E;Links in a form&#x3C;/b&#x3E;&#x3C;/p&#x3E;
&#x3C;a id=&#x22;anchor_0&#x22; href=&#x22;#link&#x22;&#x3E;Anchor 0&#x3C;/a&#x3E;
&#x3C;a id=&#x22;anchor_1&#x22; href=&#x22;#link&#x22;&#x3E;Anchor 1&#x3C;/a&#x3E;
&#x3C;a id=&#x22;anchor_2&#x22; href=&#x22;#link&#x22;&#x3E;Anchor 2&#x3C;/a&#x3E;
&#x3C;/form&#x3E;</pre>
    </div>    
</div>
<!--/view_anchor-->  