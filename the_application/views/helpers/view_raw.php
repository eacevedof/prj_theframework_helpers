<!--view_raw 1.0.0-->
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
use TheFramework\Helpers\HelperRaw;
$oHelperRaw = new HelperRaw("
    <div onclick=\"alert('hello')\" >This is a div - clickme </div>
    <p>
        Al contrario del pensamiento popular, el texto de Lorem Ipsum no es simplemente texto aleatorio. 
        Tiene sus raices en una pieza cl´sica de la literatura del Latin, que data del año 45 antes de 
        Cristo, haciendo que este adquiera mas de 2000 años de antiguedad. Richard McClintock, 
        un profesor de Latin de la Universidad de Hampden-Sydney en Virginia, encontró una de 
        las palabras más oscuras de la lengua del latín...
    </p>
");
$oHelperRaw->show();
?>
        </pre>    
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
use TheFramework\Helpers\HelperRaw;
$oHelperRaw = new HelperRaw(
    &#x22;
    &#x3C;div onclick=\&#x22;alert(&#x27;hello&#x27;)\&#x22; &#x3E;This is a div - clickme &#x3C;/div&#x3E;
    &#x3C;p&#x3E;
        Al contrario del pensamiento popular, el texto de Lorem Ipsum no es simplemente texto aleatorio. 
        Tiene sus raices en una pieza cl&#xB4;sica de la literatura del Latin, que data del a&#xF1;o 45 antes de 
        Cristo, haciendo que este adquiera mas de 2000 a&#xF1;os de antiguedad. Richard McClintock, 
        un profesor de Latin de la Universidad de Hampden-Sydney en Virginia, encontr&#xF3; una de 
        las palabras m&#xE1;s oscuras de la lengua del lat&#xED;n...
    &#x3C;/p&#x3E;
    &#x22;
);
$oHelperRaw-&#x3E;show();
?&#x3E;
        </pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
    &#x3C;div onclick=&#x22;alert(&#x27;hello&#x27;)&#x22;&#x3E;This is a div - clickme &#x3C;/div&#x3E;
    &#x3C;p&#x3E;
        Al contrario del pensamiento popular, el texto de Lorem Ipsum no es simplemente texto aleatorio. 
        Tiene sus raices en una pieza cl&#xB4;sica de la literatura del Latin, que data del a&#xF1;o 45 antes de 
        Cristo, haciendo que este adquiera mas de 2000 a&#xF1;os de antiguedad. Richard McClintock, 
        un profesor de Latin de la Universidad de Hampden-Sydney en Virginia, encontr&#xF3; una de 
        las palabras m&#xE1;s oscuras de la lengua del lat&#xED;n...
    &#x3C;/p&#x3E;

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
        <pre>
<?php
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperInputText;
$oHelperRaw = new HelperRaw("<label><b>Some label</b></label>");
$oHelperRaw->add_inner_object(new HelperInputText("txtSome","txtSome","Some value"));

$oForm = new HelperForm("frmRawExample","frmRawExample");
$oForm->set_style("border:1px dashed blue");
$oForm->add_control($oHelperRaw);
$oForm->show();

//another print form
//$sHtml = $oForm->get_html();
//echo $sHtml;
?>
        </pre>   
        <br/>         
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
use TheFramework\Helpers\HelperRaw;
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperInputText;
$oHelperRaw = new HelperRaw(&#x22;&#x3C;label&#x3E;&#x3C;b&#x3E;Some label&#x3C;/b&#x3E;&#x3C;/label&#x3E;&#x22;);
$oHelperRaw-&#x3E;add_inner_object(new HelperInputText(&#x22;txtSome&#x22;,&#x22;txtSome&#x22;,&#x22;Some value&#x22;));

$oForm = new HelperForm(&#x22;frmRawExample&#x22;,&#x22;frmRawExample&#x22;);
$oForm-&#x3E;set_style(&#x22;border:1px dashed blue&#x22;);
$oForm-&#x3E;add_control($oHelperRaw);
$oForm-&#x3E;show();

//another print form
//$sHtml = $oForm-&#x3E;get_html();
//echo $sHtml;
?&#x3E;
        </pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;form id=&#x22;frmRawExample&#x22; method=&#x22;post&#x22; style=&#x22;border:1px dashed blue&#x22;&#x3E;
&#x3C;label&#x3E;&#x3C;b&#x3E;Some label&#x3C;/b&#x3E;&#x3C;/label&#x3E;&#x3C;input type=&#x22;text&#x22; id=&#x22;txtSome&#x22; name=&#x22;txtSome&#x22; value=&#x22;Some value&#x22; maxlength=&#x22;50&#x22;&#x3E;

&#x3C;/form&#x3E;
        </pre>
    </div>          
</div>
<!--/view_raw-->  