<!--view_theframework 1.0.1-->
<div class="col-lg-12">
    <h2>Resume</h2>
    <p>
        This is the Main parent Class.<br/>
        This class provides global html attributes and methods that help you to re-use
        them in your custom helpers.<br/>
        it allows to create your own helpers.
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
use TheFramework\Helpers\TheFrameworkHelper;
use TheFramework\Helpers\HelperSelect;

class AppHelperClock extends TheFrameworkHelper
{
    public function __construct($id)
    {
        $this->_id = $id;
    }//__construct
    
    private function get_select($sType="hours")
    {
        $oSelect = new HelperSelect([]);
        $oSelect->add_class("custom-select mb-2 mr-sm-2 mb-sm-0");
        $arOptions = [""=>"...pick"];
        if($sType=="min")
        {
            for($i=0;$i<60;$i++)
            {
                $sHour = sprintf("%02d",$i);
                $arOptions[$sHour] = $sHour;
            }
        }
        else 
        {
            for($i=0;$i<24;$i++)
            {
                $sHour = sprintf("%02d",$i);
                $arOptions[$sHour] = $sHour;
            }            
        }
        
        $oSelect->set_options($arOptions);
        return $oSelect;
    }//get_select
    
    //this method should be defined always
    public function get_html()
    {
        $sHtml = "<div id=\"$this->_id\" class=\"row\">";
        $sHtml .= "<div class=\"col-sm\">";
        $oSelect = $this->get_select();
        $oSelect->set_value_to_select(date("H"));
        $sHtml .= $oSelect->get_html();
        $sHtml .= "</div>";
        $sHtml .= "<div class=\"col-sm\">:</div>";
        $sHtml .= "<div class=\"col-sm\">";
        $oSelect = $this->get_select("min");
        $sHtml .= $oSelect->get_html();
        $sHtml .= "</div>";
        $sHtml .= "<div class=\"col-sm-9\"></div>";
        $sHtml .= "</div>";
        return $sHtml;
    }//get_html
    
}//AppHelperClock

$oMyClock = new AppHelperClock("divMyclock");
$oMyClock->show();
?>
        <br/>        
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
use TheFramework\Helpers\TheFrameworkHelper;
use TheFramework\Helpers\HelperSelect;

class AppHelperClock extends TheFrameworkHelper
{
    public function __construct($id)
    {
        $this-&#x3E;_id = $id;
    }//__construct
    
    private function get_select($sType=&#x22;hours&#x22;)
    {
        $oSelect = new HelperSelect([]);
        $oSelect-&#x3E;add_class(&#x22;custom-select mb-2 mr-sm-2 mb-sm-0&#x22;);
        $arOptions = [&#x22;&#x22;=&#x3E;&#x22;...pick&#x22;];
        if($sType==&#x22;min&#x22;)
        {
            for($i=0;$i&#x3C;60;$i++)
            {
                $sHour = sprintf(&#x22;%02d&#x22;,$i);
                $arOptions[$sHour] = $sHour;
            }
        }
        else 
        {
            for($i=0;$i&#x3C;24;$i++)
            {
                $sHour = sprintf(&#x22;%02d&#x22;,$i);
                $arOptions[$sHour] = $sHour;
            }            
        }
        
        $oSelect-&#x3E;set_options($arOptions);
        return $oSelect;
    }//get_select
    
    //this method should be defined always
    public function get_html()
    {
        $sHtml = &#x22;&#x3C;div id=\&#x22;$this-&#x3E;_id\&#x22; class=\&#x22;row\&#x22;&#x3E;&#x22;;
        $sHtml .= &#x22;&#x3C;div class=\&#x22;col-sm\&#x22;&#x3E;&#x22;;
        $oSelect = $this-&#x3E;get_select();
        $oSelect-&#x3E;set_value_to_select(date(&#x22;H&#x22;));
        $sHtml .= $oSelect-&#x3E;get_html();
        $sHtml .= &#x22;&#x3C;/div&#x3E;&#x22;;
        $sHtml .= &#x22;&#x3C;div class=\&#x22;col-sm\&#x22;&#x3E;:&#x3C;/div&#x3E;&#x22;;
        $sHtml .= &#x22;&#x3C;div class=\&#x22;col-sm\&#x22;&#x3E;&#x22;;
        $oSelect = $this-&#x3E;get_select(&#x22;min&#x22;);
        $sHtml .= $oSelect-&#x3E;get_html();
        $sHtml .= &#x22;&#x3C;/div&#x3E;&#x22;;
        $sHtml .= &#x22;&#x3C;div class=\&#x22;col-sm-9\&#x22;&#x3E;&#x3C;/div&#x3E;&#x22;;
        $sHtml .= &#x22;&#x3C;/div&#x3E;&#x22;;
        return $sHtml;
    }//get_html
    
}//AppHelperClock

$oMyClock = new AppHelperClock(&#x22;divMyclock&#x22;);
$oMyClock-&#x3E;show();
?&#x3E;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;div id=&#x22;divMyclock&#x22; class=&#x22;row&#x22;&#x3E;&#x3C;div class=&#x22;col-sm&#x22;&#x3E;&#x3C;select name=&#x22;&#x22; size=&#x22;1&#x22; class=&#x22;custom-select mb-2 mr-sm-2 mb-sm-0&#x22;&#x3E;
&#x9;&#x3C;option value=&#x22;&#x22;&#x3E;...pick&#x3C;/option&#x3E;
...
&#x9;&#x3C;option value=&#x22;07&#x22; selected=&#x22;&#x22;&#x3E;07&#x3C;/option&#x3E;
...
&#x9;&#x3C;option value=&#x22;23&#x22;&#x3E;23&#x3C;/option&#x3E;
&#x3C;/select&#x3E;
&#x3C;/div&#x3E;&#x3C;div class=&#x22;col-sm&#x22;&#x3E;:&#x3C;/div&#x3E;&#x3C;div class=&#x22;col-sm&#x22;&#x3E;&#x3C;select name=&#x22;&#x22; size=&#x22;1&#x22; class=&#x22;custom-select mb-2 mr-sm-2 mb-sm-0&#x22;&#x3E;
&#x9;&#x3C;option value=&#x22;&#x22; selected=&#x22;&#x22;&#x3E;...&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;00&#x22;&#x3E;00&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;01&#x22;&#x3E;01&#x3C;/option&#x3E;
...
&#x9;&#x3C;option value=&#x22;49&#x22;&#x3E;59&#x3C;/option&#x3E;
&#x3C;/select&#x3E;
&#x3C;/div&#x3E;&#x3C;div class=&#x22;col-sm-9&#x22;&#x3E;&#x3C;/div&#x3E;&#x3C;/div&#x3E;</pre>
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

$oForm = new HelperForm();
$oForm->add_class("form-inline");
$oForm->add_style("border:1px dashed blue;");
$oForm->add_style("padding:5px;");
$oForm->set_id("myForm");
$oForm->add_control($oMyClock);
$oForm->show();
?>
        <br/> 
        <h4>PHP Code:</h4>
        <pre class="prettyprint">
&#x3C;?php
use TheFramework\Helpers\HelperForm;

$oForm = new HelperForm();
$oForm-&#x3E;add_class(&#x22;form-inline&#x22;);
$oForm-&#x3E;add_style(&#x22;border:1px dashed blue;&#x22;);
$oForm-&#x3E;add_style(&#x22;padding:5px;&#x22;);
$oForm-&#x3E;set_id(&#x22;myForm&#x22;);
$oForm-&#x3E;add_control($oMyClock);
$oForm-&#x3E;show();
?&#x3E;</pre>
        <br/>
        <h4>HTML Result:</h4>
        <pre class="prettyprint">
&#x3C;form id=&#x22;myForm&#x22; method=&#x22;post&#x22; class=&#x22;form-inline&#x22; style=&#x22;border:1px dashed blue;;padding:5px;&#x22;&#x3E;
&#x3C;div id=&#x22;divMyclock&#x22; class=&#x22;row&#x22;&#x3E;&#x3C;div class=&#x22;col-sm&#x22;&#x3E;&#x3C;select name=&#x22;&#x22; size=&#x22;1&#x22; class=&#x22;custom-select mb-2 mr-sm-2 mb-sm-0&#x22;&#x3E;
&#x9;&#x3C;option value=&#x22;&#x22;&#x3E;...pick&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;00&#x22;&#x3E;00&#x3C;/option&#x3E;
...
&#x9;&#x3C;option value=&#x22;07&#x22; selected=&#x22;&#x22;&#x3E;07&#x3C;/option&#x3E;
...
&#x9;&#x3C;option value=&#x22;23&#x22;&#x3E;23&#x3C;/option&#x3E;
&#x3C;/select&#x3E;
&#x3C;/div&#x3E;&#x3C;div class=&#x22;col-sm&#x22;&#x3E;:&#x3C;/div&#x3E;&#x3C;div class=&#x22;col-sm&#x22;&#x3E;&#x3C;select name=&#x22;&#x22; size=&#x22;1&#x22; class=&#x22;custom-select mb-2 mr-sm-2 mb-sm-0&#x22;&#x3E;
&#x9;&#x3C;option value=&#x22;&#x22; selected=&#x22;&#x22;&#x3E;...pick&#x3C;/option&#x3E;
&#x9;&#x3C;option value=&#x22;00&#x22;&#x3E;00&#x3C;/option&#x3E;
...
&#x9;&#x3C;option value=&#x22;59&#x22;&#x3E;59&#x3C;/option&#x3E;
&#x3C;/select&#x3E;
&#x3C;/div&#x3E;&#x3C;div class=&#x22;col-sm-9&#x22;&#x3E;&#x3C;/div&#x3E;&#x3C;/div&#x3E;
&#x3C;/form&#x3E;</pre>
    </div>    
</div>
<!--/view_theframework-->  