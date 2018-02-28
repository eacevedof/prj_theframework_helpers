<!--view_input_file 1.0.1-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
        It helps to create html element "input type file":<br/>
        <b>&lt;input type=&quot;file&quot; id=&quot;fileUpload&quot; name=&quot;fileUpload&quot;&gt;</b>
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
if(isset($_FILES["fileUpload"]["name"]))
    pr("File uploaded! :) {$_FILES["fileUpload"]["name"]}");
    
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperInputFile;
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperDiv;
use TheFramework\Helpers\HelperRaw;
use TheFramework\Helpers\HelperButtonBasic;

//<label for="exampleInputFile">File input</label>
$oLabel = new HelperLabel();
$oLabel->set_for("exampleInputFile");
$oLabel->set_innerhtml("Attach your file here:");

//<input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
$oFile = new HelperInputFile("exampleInputFile");
$oFile->set_name("fileUpload");
$oFile->add_class("form-control-file");
$oFile->add_extras("aria-describedby","fileHelp");
$oFile->add_extras("autofocus","autofocus");

//there is no such a "HelperSmall" that is why I use HelperRaw in place.
$oRaw = new HelperRaw("<small id=\"fileHelp\" class=\"form-text text-muted\">"
        . "This is some placeholder block-level help text for the above input. "
        . "It's a bit lighter and easily wraps to a new line."
        . "</small>");

//<button type="submit" class="btn btn-primary">Submit</button>
$oButton = new HelperButtonBasic();
$oButton->set_type("submit");
$oButton->add_class("btn btn-primary");
$oButton->set_innerhtml("Submit");

//<div class="form-group">
$oDiv = new HelperDiv();
$oDiv->set_comments("div for label and input");
$oDiv->add_class("form-group");

$oDiv->add_inner_object($oLabel);
$oDiv->add_inner_object($oFile);
$oDiv->add_inner_object($oRaw);

$oForm = new HelperForm();
$oForm->set_action("/helper-input-file/examples/");
$oForm->set_id("myForm");
$oForm->set_comments("This is a comment");
$oForm->set_method("post");
$oForm->set_enctype("multipart/form-data");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->add_inner_object($oDiv);
$oForm->add_inner_object($oButton);
$oForm->show();
?>
        </div><!--example-->
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperInputFile;
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperDiv;
use TheFramework\Helpers\HelperRaw;
use TheFramework\Helpers\HelperButtonBasic;

//&lt;label for=&quot;exampleInputFile&quot;&gt;File input&lt;/label&gt;
$oLabel = new HelperLabel();
$oLabel-&gt;set_for(&quot;exampleInputFile&quot;);
$oLabel-&gt;set_innerhtml(&quot;Attach your file here:&quot;);

//&lt;input type=&quot;file&quot; class=&quot;form-control-file&quot; id=&quot;exampleInputFile&quot; aria-describedby=&quot;fileHelp&quot;&gt;
$oFile = new HelperInputFile(&quot;exampleInputFile&quot;);
$oFile-&gt;set_name(&quot;fileUpload&quot;);
$oFile-&gt;add_class(&quot;form-control-file&quot;);
$oFile-&gt;add_extras(&quot;aria-describedby&quot;,&quot;fileHelp&quot;);
$oFile-&gt;add_extras(&quot;autofocus&quot;,&quot;autofocus&quot;);

//there is no such a &quot;HelperSmall&quot; that is why I use HelperRaw in place.
$oRaw = new HelperRaw(&quot;&lt;small id=\&quot;fileHelp\&quot; class=\&quot;form-text text-muted\&quot;&gt;&quot;
        . &quot;This is some placeholder block-level help text for the above input. &quot;
        . &quot;It&#39;s a bit lighter and easily wraps to a new line.&quot;
        . &quot;&lt;/small&gt;&quot;);

//&lt;button type=&quot;submit&quot; class=&quot;btn btn-primary&quot;&gt;Submit&lt;/button&gt;
$oButton = new HelperButtonBasic();
$oButton-&gt;set_type(&quot;submit&quot;);
$oButton-&gt;add_class(&quot;btn btn-primary&quot;);
$oButton-&gt;set_innerhtml(&quot;Submit&quot;);

//&lt;div class=&quot;form-group&quot;&gt;
$oDiv = new HelperDiv();
$oDiv-&gt;set_comments(&quot;div for label and input&quot;);
$oDiv-&gt;add_class(&quot;form-group&quot;);

$oDiv-&gt;add_inner_object($oLabel);
$oDiv-&gt;add_inner_object($oFile);
$oDiv-&gt;add_inner_object($oRaw);

$oForm = new HelperForm();
$oForm-&gt;set_action(&quot;/helper-input-file/examples/&quot;);
$oForm-&gt;set_id(&quot;myForm&quot;);
$oForm-&gt;set_comments(&quot;This is a comment&quot;);
$oForm-&gt;set_method(&quot;post&quot;);
$oForm-&gt;set_enctype(&quot;multipart/form-data&quot;);
$oForm-&gt;add_style(&quot;border:1px dashed #4f9fcf;&quot;);
$oForm-&gt;add_style(&quot;padding:5px;&quot;);
$oForm-&gt;add_inner_object($oDiv);
$oForm-&gt;add_inner_object($oButton);
$oForm-&gt;show();</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&lt;!-- This is a comment --&gt;
&lt;form id=&quot;myForm&quot; method=&quot;post&quot; action=&quot;/helper-input-file/examples/&quot; enctype=&quot;multipart/form-data&quot; style=&quot;border:1px dashed #4f9fcf;;padding:5px;&quot;&gt;
&lt;div class=&quot;form-group&quot;&gt;
&lt;label for=&quot;exampleInputFile&quot;&gt;Attach your file here:&lt;/label&gt;
&lt;input type=&quot;file&quot; id=&quot;exampleInputFile&quot; name=&quot;fileUpload&quot; class=&quot;form-control-file&quot; aria-describedby=&quot;fileHelp&quot; autofocus=&quot;autofocus&quot;&gt;
&lt;small id=&quot;fileHelp&quot; class=&quot;form-text text-muted&quot;&gt;This is some placeholder block-level help text for the above input. It&#39;s a bit lighter and easily wraps to a new line.&lt;/small&gt;&lt;/div&gt;
&lt;button type=&quot;submit&quot; class=&quot;btn btn-primary&quot;&gt;
Submit&lt;/button&gt;
&lt;/form&gt;</pre>
    </div>
</div>
<!--/view_input_file-->  