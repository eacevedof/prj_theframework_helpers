<!--elem_gettingstarted 1.0.0-->
<div class="row">
    <div id="accordion" role="tablist" aria-multiselectable="true" class="col-lg-12">
        <div class="card">
            <div class="card-header" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Getting started is very easy. Click here!
                    </a>
                </h5>
            </div>
            <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="card-block">
                    <ol>
                        <li>Download Helpers (zip file)</li>
                        <li>Unzip it in your vendors folder (e.g)</li>
                        <li>
                            Include <b>autoload.php</b> in your bootstrap file
<pre class="prettyprint">
&#x3C;?php
/*
lets suposse you have this folder tree
    yourproject/
        vendors/
            lib_1/
            lib_n/
            theframework/   --&#x3E;uncompressed zip
                helpers/
        index.php
*/
//this file is: yourproject/index.php
<b>include_once(&#x22;vendors/theframework/helpers/autoload.php&#x22;);</b>

use TheFramework\Helpers\HelperInputText;
$oInput = new HelperInputText();
$oInput-&#x3E;set_value(&#x22;Hello World&#x22;);
$oInput-&#x3E;add_class(&#x22;form-control&#x22;);
$oInput-&#x3E;show();</pre>
                        </li>
                        <li>
                            Result:
                            <img src="/images/example-input-text.png" alt="Example of HelperInputText">
                        </li>
                    </ol>            
                </div>
            </div>
        </div><!--/card-->
    </div><!--/acordion-->
    <br/><br/><br/>
</div>
<!--/elem_gettingstarted-->
