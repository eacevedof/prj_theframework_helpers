<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Form\Input\Radio
 */
namespace TheFramework\Helpers\Form\Input;

use TheFramework\Helpers\AbstractHelper;
use TheFramework\Helpers\Enums\HtmlTypeEnum;
use TheFramework\Helpers\Enums\InputTypeEnum;
use TheFramework\Helpers\Form\Label;

final class Radio extends AbstractHelper
{
    private array $options = [];
    private string $valueToCheck = "";
    private string $legendText = "";

    public function __construct(
        array $options,
        string $groupName,
        string $legendText = "",
        string $valueToCheck = "",
        string $class = "",
        array $extras = []
    ) {
        $this->type = InputTypeEnum::RADIO;
        $this->idPrefix = "";
        $this->options = $options;
        $this->valueToCheck = $valueToCheck;
        $this->name = $groupName;
        $this->legendText = $legendText;
        if ($class) {
            $this->classes[] = $class;
        }
        $this->extras = $extras;
    }

    public function getHtml(): string
    {
        $htmlParts = [];
        if ($this->comment) {
            $htmlParts[] = "<!-- {$this->comment} -->\n";
        }
        if ($this->legendText) {
            $htmlParts[] = "<" . HtmlTypeEnum::LEGEND . ">{$this->legendText}</" . HtmlTypeEnum::LEGEND . ">\n";
        }

        $i = 0;
        foreach ($this->options as $value => $labelText) {
            $isChecked = ($this->valueToCheck == $value);
            $id = $this->idPrefix . $this->name . "_" . $i;
            $id = str_replace("[]", "", $id);
            $label = new Label($id, $labelText, "lbl{$id}");
            $htmlParts[] = $this->buildInputRadio($id, (string) $value, $label, $isChecked);
            $i++;
        }

        return implode("", $htmlParts);
    }

    public function getOpenTag(): string
    {
        return $this->getHtml();
    }

    private function buildInputRadio(
        string $id,
        string $value,
        ?Label $label = null,
        bool $isChecked = false
    ): string {
        $this->id = $id;
        $htmlParts = [];
        $htmlParts[] = "<" . HtmlTypeEnum::INPUT;
        if ($this->type) {
            $htmlParts[] = " type=\"{$this->type}\"";
        }
        if ($this->id) {
            $htmlParts[] = " id=\"{$id}\"";
        }
        if ($this->name) {
            $htmlParts[] = " name=\"{$this->idPrefix}{$this->name}\"";
        }
        if ($value) {
            $htmlParts[] = " value=\"{$value}\"";
        }
        if ($isChecked) {
            $htmlParts[] = " checked";
        }
        if ($this->disabled) {
            $htmlParts[] = " disabled";
        }
        if ($this->readonly) {
            $htmlParts[] = " readonly";
        }
        if ($this->jsOnBlur) {
            $htmlParts[] = " onblur=\"{$this->jsOnBlur}\"";
        }
        if ($this->jsOnChange) {
            $htmlParts[] = " onchange=\"{$this->jsOnChange}\"";
        }
        if ($this->jsOnClick) {
            $htmlParts[] = " onclick=\"{$this->jsOnClick}\"";
        }
        if ($this->jsOnKeypress) {
            $htmlParts[] = " onkeypress=\"{$this->jsOnKeypress}\"";
        }
        if ($this->jsOnFocus) {
            $htmlParts[] = " onfocus=\"{$this->jsOnFocus}\"";
        }
        if ($this->jsOnMouseover) {
            $htmlParts[] = " onmouseover=\"{$this->jsOnMouseover}\"";
        }
        if ($this->jsOnMouseout) {
            $htmlParts[] = " onmouseout=\"{$this->jsOnMouseout}\"";
        }
        $this->loadCssClass();
        if ($this->class) {
            $htmlParts[] = " class=\"{$this->class}\"";
        }
        $this->loadStyle();
        if ($this->style) {
            $htmlParts[] = " style=\"{$this->style}\"";
        }
        if ($this->attrDbfield) {
            $htmlParts[] = " dbfield=\"{$this->attrDbfield}\"";
        }
        if ($this->attrDbtype) {
            $htmlParts[] = " dbtype=\"{$this->attrDbtype}\"";
        }
        if ($this->isPrimaryKey) {
            $htmlParts[] = " pk=\"pk\"";
        }
        if ($this->extras) {
            $htmlParts[] = " " . $this->getExtras();
        }
        $htmlParts[] = " />\n";
        if ($label) {
            $htmlParts[] = $label->getHtml();
        }

        return implode("", $htmlParts);
    }

    public function setName(string $value): self
    {
        $this->name = $value;
        return $this;
    }

    public function setValueToCheck(string $value): void
    {
        $this->valueToCheck = $value;
    }

    public function setLegendText(string $value): void
    {
        $this->legendText = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValueChecked(): string
    {
        return $this->valueToCheck;
    }

    public function getLegendText(): string
    {
        return $this->legendText;
    }
}
