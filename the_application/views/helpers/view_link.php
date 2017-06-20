<!--view_link 1.1.0-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
        It allows to create &#x3C;link rel=&#x22;...&#x22; href=&#x22;...&#x22; type=&#x22;...&#x22;&#x3E; for css files among other things
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
use TheFramework\Helpers\HelperLink;
use TheFramework\Helpers\HelperTableRaw;
$arHrefs = [
    "https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/css/foundation.min.css",
    "https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"
];
$oLink = new HelperLink($arHrefs);
$oLink->add_href("https://code.jquery.com/ui/1.7.2/themes/smoothness/jquery-ui.css");
$oLink->show();

$arTable = [
    ["col1"=>"Airi Satou","col2"=>"Accountant","col3"=>"Tokyo","col4"=>"2008/11/28","col5"=>"$162,700"],
    ["col1"=>"Angelica Ramos","col2"=>"Chief Executive Officer (CEO)","col3"=>"London","col4"=>"2009/10/09","col5"=>"$1,200,000"],
    ["col1"=>"Ashton Cox","col2"=>"Junior Technical Author","col3"=>"San Francisco","col4"=>"2009/01/12","col5"=>"$86,000"]
];
$oTable = new HelperTableRaw($arTable);
$oTable->add_extras("cellspacing","0");
$oTable->add_extras("width","100%");
$oTable->set_id("idExample");
$oTable->add_class("display");
$oTable->add_class("responsive");
$oTable->show();
?>
        </div>
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
use TheFramework\Helpers\HelperLink;
use TheFramework\Helpers\HelperTableRaw;
$arHrefs = [
    &#x22;https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/css/foundation.min.css&#x22;,
    &#x22;https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css&#x22;
];
$oLink = new HelperLink($arHrefs);
$oLink-&#x3E;add_href(&#x22;https://code.jquery.com/ui/1.7.2/themes/smoothness/jquery-ui.css&#x22;);
$oLink-&#x3E;show();

$arTable = [
    [&#x22;col1&#x22;=&#x3E;&#x22;Airi Satou&#x22;,&#x22;col2&#x22;=&#x3E;&#x22;Accountant&#x22;,&#x22;col3&#x22;=&#x3E;&#x22;Tokyo&#x22;,&#x22;col4&#x22;=&#x3E;&#x22;2008/11/28&#x22;,&#x22;col5&#x22;=&#x3E;&#x22;$162,700&#x22;],
    [&#x22;col1&#x22;=&#x3E;&#x22;Angelica Ramos&#x22;,&#x22;col2&#x22;=&#x3E;&#x22;Chief Executive Officer (CEO)&#x22;,&#x22;col3&#x22;=&#x3E;&#x22;London&#x22;,&#x22;col4&#x22;=&#x3E;&#x22;2009/10/09&#x22;,&#x22;col5&#x22;=&#x3E;&#x22;$1,200,000&#x22;],
    [&#x22;col1&#x22;=&#x3E;&#x22;Ashton Cox&#x22;,&#x22;col2&#x22;=&#x3E;&#x22;Junior Technical Author&#x22;,&#x22;col3&#x22;=&#x3E;&#x22;San Francisco&#x22;,&#x22;col4&#x22;=&#x3E;&#x22;2009/01/12&#x22;,&#x22;col5&#x22;=&#x3E;&#x22;$86,000&#x22;]
];
$oTable = new HelperTableRaw($arTable);
$oTable-&#x3E;add_extras(&#x22;cellspacing&#x22;,&#x22;0&#x22;);
$oTable-&#x3E;add_extras(&#x22;width&#x22;,&#x22;100%&#x22;);
$oTable-&#x3E;set_id(&#x22;idExample&#x22;);
$oTable-&#x3E;add_class(&#x22;display&#x22;);
$oTable-&#x3E;add_class(&#x22;responsive&#x22;);
$oTable-&#x3E;show();
?&#x3E;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;link type=&#x22;text/css&#x22; rel=&#x22;stylesheet&#x22; href=&#x22;https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/css/foundation.min.css&#x22;&#x3E;
&#x3C;link type=&#x22;text/css&#x22; rel=&#x22;stylesheet&#x22; href=&#x22;https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css&#x22;&#x3E;
&#x3C;link type=&#x22;text/css&#x22; rel=&#x22;stylesheet&#x22; href=&#x22;https://code.jquery.com/ui/1.7.2/themes/smoothness/jquery-ui.css&#x22;&#x3E;
&#x3C;table id=&#x22;idExample&#x22; class=&#x22;display responsive&#x22; cellspacing=&#x22;0&#x22; width=&#x22;100%&#x22;&#x3E;
&#x3C;tr&#x3E;&#x3C;th&#x3E;col1&#x3C;/th&#x3E;&#x3C;th&#x3E;col2&#x3C;/th&#x3E;&#x3C;th&#x3E;col3&#x3C;/th&#x3E;&#x3C;th&#x3E;col4&#x3C;/th&#x3E;&#x3C;th&#x3E;col5&#x3C;/th&#x3E;&#x3C;/tr&#x3E;
&#x3C;tr&#x3E;&#x3C;td&#x3E;Airi Satou&#x3C;/td&#x3E;&#x3C;td&#x3E;Accountant&#x3C;/td&#x3E;&#x3C;td&#x3E;Tokyo&#x3C;/td&#x3E;&#x3C;td&#x3E;2008/11/28&#x3C;/td&#x3E;&#x3C;td&#x3E;$162,700&#x3C;/td&#x3E;&#x3C;/tr&#x3E;
&#x3C;tr&#x3E;&#x3C;td&#x3E;Angelica Ramos&#x3C;/td&#x3E;&#x3C;td&#x3E;Chief Executive Officer (CEO)&#x3C;/td&#x3E;&#x3C;td&#x3E;London&#x3C;/td&#x3E;&#x3C;td&#x3E;2009/10/09&#x3C;/td&#x3E;&#x3C;td&#x3E;$1,200,000&#x3C;/td&#x3E;&#x3C;/tr&#x3E;
&#x3C;tr&#x3E;&#x3C;td&#x3E;Ashton Cox&#x3C;/td&#x3E;&#x3C;td&#x3E;Junior Technical Author&#x3C;/td&#x3E;&#x3C;td&#x3E;San Francisco&#x3C;/td&#x3E;&#x3C;td&#x3E;2009/01/12&#x3C;/td&#x3E;&#x3C;td&#x3E;$86,000&#x3C;/td&#x3E;&#x3C;/tr&#x3E;
&#x3C;/table&#x3E;</pre>
    </div>
</div>
<!--/view_link-->  