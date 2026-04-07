<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Form\Textarea
 */
namespace TheFramework\Helpers\Form;

use TheFramework\Helpers\AbstractHelper;
use TheFramework\Helpers\Enums\HtmlTypeEnum;

final class Textarea extends AbstractHelper
{
    private int $cols = 40;
    private int $rows = 8;
    private bool $isCounterSpan = false;
    private bool $isCounterJs = false;

    public function __construct(
        string $id = "",
        string $name = "",
        string $innerHtml = "",
        array $extras = [],
        int $maxLength = -1,
        int $cols = 40,
        int $rows = 8,
        string $class = "",
        string $style = "",
        ?Label $label = null
    ) {
        $this->type = HtmlTypeEnum::TEXTAREA;
        $this->idPrefix = "";
        $this->id = $id;
        $this->innerHtml = $innerHtml;
        $this->name = $name;
        $this->cols = $cols;
        $this->rows = $rows;
        if ($class) {
            $this->classes[] = $class;
        }
        if ($style) {
            $this->styles[] = $style;
        }
        $this->maxLength = (string) $maxLength;
        $this->extras = $extras;
        $this->label = $label;
    }

    private function printJsCounter(): void
    {
?>

<script type="text/javascript" helper="textarea.js_counter">
    var fn_txaspan = function(oTextarea,sValue)
    {
        var sNameSpan = "sp"+oTextarea.id;
        var oSpan = document.getElementById(sNameSpan);
        if(oSpan)
            oSpan.innerHTML = sValue;
    };

    var fn_txamaxlength = function(oTextarea, oEvent)
    {
        var sInnerHtml = "";
        var isEvent = true;
        if(oTextarea)
        {
            var iMaxLen = oTextarea.getAttribute("maxlength") || 1000;
            sInnerHtml = oTextarea.value;
            var iLen = sInnerHtml.length;
            if(iLen>iMaxLen)
            {
                isEvent = false;
                iLen = iMaxLen;
                oTextarea.value = sInnerHtml;
            }
            var sLenText = iLen+"/"+iMaxLen;
            fn_txaspan(oTextarea,sLenText);
        }
        return isEvent;
    };
</script>
<?php
    }

    public function getHtml(): string
    {
        $htmlParts = [];
        if ($this->label) {
            $htmlParts[] = $this->label->getHtml();
        }
        if ($this->comment) {
            $htmlParts[] = "<!-- {$this->comment} -->\n";
        }
        if ((int) $this->maxLength > -1 && $this->isCounterJs && $this->isCounterSpan) {
            $this->jsOnKeyup .= " return fn_txamaxlength(this,event);";
        }
        $htmlParts[] = $this->getOpenTag();
        $htmlParts[] = htmlentities($this->innerHtml);
        $htmlParts[] = $this->getCloseTag();

        if ($this->isCounterSpan) {
            $htmlParts[] = "\n<" . HtmlTypeEnum::SPAN . " id=\"sp{$this->idPrefix}{$this->id}\"></" . HtmlTypeEnum::SPAN . ">";
            if ($this->isCounterJs) {
                $this->printJsCounter();
            }
        }

        return implode("", $htmlParts);
    }

    public function getOpenTag(): string
    {
        $openTagParts = [];
        $openTagParts[] = "<{$this->type} ";
        if ($this->id) {
            $openTagParts[] = "id=\"{$this->idPrefix}{$this->id}\" ";
        }
        if ($this->name) {
            $openTagParts[] = "name=\"{$this->idPrefix}{$this->name}\" ";
        }
        if ($this->rows) {
            $openTagParts[] = "rows=\"{$this->rows}\" ";
        }
        if ($this->cols) {
            $openTagParts[] = "cols=\"{$this->cols}\" ";
        }
        if ($this->disabled) {
            $openTagParts[] = "disabled ";
        }
        if ($this->readonly) {
            $openTagParts[] = "readonly ";
        }
        if ($this->isRequired) {
            $openTagParts[] = "required ";
        }
        if ($this->jsOnFocus) {
            $openTagParts[] = "onfocus=\"{$this->jsOnFocus}\" ";
        }
        if ($this->jsOnBlur) {
            $openTagParts[] = "onblur=\"{$this->jsOnBlur}\" ";
        }
        if ($this->jsOnChange) {
            $openTagParts[] = "onchange=\"{$this->jsOnChange}\" ";
        }
        if ($this->jsOnClick) {
            $openTagParts[] = "onclick=\"{$this->jsOnClick}\" ";
        }
        if ($this->jsOnKeypress) {
            $openTagParts[] = "onkeypress=\"{$this->jsOnKeypress}\" ";
        }
        if ($this->jsOnKeydown) {
            $openTagParts[] = "onkeydown=\"{$this->jsOnKeydown}\" ";
        }
        if ($this->jsOnKeyup) {
            $openTagParts[] = "onkeyup=\"{$this->jsOnKeyup}\" ";
        }
        if ($this->jsOnMouseover) {
            $openTagParts[] = "onmouseover=\"{$this->jsOnMouseover}\" ";
        }
        if ($this->jsOnMouseout) {
            $openTagParts[] = "onmouseout=\"{$this->jsOnMouseout}\" ";
        }
        $this->loadCssClass();
        if ($this->class) {
            $openTagParts[] = "class=\"{$this->class}\" ";
        }
        $this->loadStyle();
        if ($this->style) {
            $openTagParts[] = "style=\"{$this->style}\" ";
        }
        if ($this->maxLength) {
            $openTagParts[] = "maxlength=\"{$this->maxLength}\" ";
        }
        if ($this->extras) {
            $openTagParts[] = " " . $this->getExtras();
        }
        if ($this->isPrimaryKey) {
            $openTagParts[] = "pk=\"pk\" ";
        }
        if ($this->attrDbtype) {
            $openTagParts[] = "dbtype=\"{$this->attrDbtype}\" ";
        }
        $openTagParts[] = ">\n";
        return implode("", $openTagParts);
    }

    public function setMaxLength(int $value): void
    {
        $this->maxLength = (string) $value;
    }

    public function setRows(int $value): void
    {
        $this->rows = $value;
    }

    public function setCols(int $value): void
    {
        $this->cols = $value;
    }

    public function setCounterSpan(bool $isOn = true): void
    {
        $this->isCounterSpan = $isOn;
    }

    public function setCounterJs(bool $isOn = true): void
    {
        $this->isCounterJs = $isOn;
    }

    public function getMaxLength(): string
    {
        return $this->maxLength;
    }

    public function setReadonly(bool $readonly = true): self
    {
        $this->readonly = $readonly;
        return $this;
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
