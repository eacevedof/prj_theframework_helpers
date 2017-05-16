<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.2
 * @name HelperTableRaw
 * @date 02-10-2014 07:19 (SPAIN)
 * @file helper_table_raw.php
 * @requires 
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;
class HelperTableRaw extends TheFrameworkHelper
{
    protected $arLabels;
    protected $arRows;

    public function __construct($arRows,$arLabels=array()) 
    {
        $this->arRows = $arRows;
        $this->arLabels = $arLabels;
    }
    
    public function get_html() 
    {
        $sHtmlToReturn = "<table>\n";
        //si no se hay pasado etiquetas se intentan recuperar desde la primera fila
        if(!$this->arLabels)
            if(is_array($this->arRows[0]))
                $this->arLabels = array_keys($this->arRows[0]);
        
        //LABELS EN COLUMNAS
        if($this->arLabels)
        {
            $sHtmlToReturn .= "<tr>";
            foreach($this->arLabels as $sLabel)
                $sHtmlToReturn .= "<th>$sLabel</th>";
            $sHtmlToReturn .= "</tr>\n";
        }       
        
        //DATOS
        if($this->arRows)
        {
            foreach($this->arRows as $arRows)
            {
                $sHtmlToReturn .= "<tr>";
                foreach($arRows as $sValue)
                    $sHtmlToReturn .= "<td>$sValue</td>";    
                $sHtmlToReturn .= "</tr>\n";
            }
        }

        $sHtmlToReturn .= "</table>";
        return $sHtmlToReturn;
    }
    
    public function set_data($arRows){$this->arRows = $arRows;}
    public function set_labels($arLabels){$this->arLabels=$arLabels;}
}