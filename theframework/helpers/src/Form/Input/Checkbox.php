<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Form\Input\Checkbox
 */
namespace TheFramework\Helpers\Form\Input;

use TheFramework\Helpers\AbstractHelper;
use TheFramework\Helpers\Form\Label;
use TheFramework\Helpers\Form\Legend;
use TheFramework\Helpers\Form\Fieldset;

final class Checkbox extends AbstractHelper
{
    private array $options = [];
    private array $valuesToCheck = [];
    private array $valuesDisabled = [];
    private bool $isGrouped = true;
    private int $checksPerLine = 6;

    private ?Legend $legend = null;
    private ?Fieldset $fieldset = null;
    private bool $isLabeled = false;

    public function __construct(
        array|string $options = [],
        string $name = "",
        array|string $valuesToCheck = [],
        array|string $valuesDisabled = [],
        string $class = "",
        array|string $extras = [],
        bool $isGrouped = true,
        ?Legend $legend = null,
        ?Fieldset $fieldset = null
    ) {
        $this->convertStringToArray($options, true);
        $this->convertStringToArray($valuesToCheck);
        $this->convertStringToArray($valuesDisabled);

        $this->type = "checkbox";
        $this->idPrefix = "";
        $this->name = $name;
        $this->id = $name;
        $this->options = $options;
        $this->valuesToCheck = $valuesToCheck;
        $this->valuesDisabled = $valuesDisabled;
        $this->isGrouped = $isGrouped;
        if ($class) {
            $this->classes[] = $class;
        }
        $this->extras = is_array($extras) ? $extras : [];
        $this->legend = $legend;
        $this->fieldset = $fieldset;
    }

    public function getHtml(): string
    {
        $htmlParts = [];
        if ($this->comment) {
            $htmlParts[] = "<!-- {$this->comment} -->\n";
        }
        if ($this->fieldset) {
            $htmlParts[] = $this->fieldset->getOpenTag();
        }
        if ($this->legend) {
            $htmlParts[] = $this->legend->getHtml();
        }

        $optionIndex = 0;
        $numOptions = count($this->options);
        foreach ($this->options as $value => $outText) {
            $checkId = "";
            $isChecked = in_array($value, $this->valuesToCheck);
            $isDisabled = in_array($value, $this->valuesDisabled);
            if ($this->id) {
                $checkId = "{$this->idPrefix}{$this->id}";
            }
            if ($numOptions > 1) {
                $checkId .= "_{$optionIndex}";
            }
            if (($optionIndex % $this->checksPerLine) === 0 && $optionIndex > 0) {
                $htmlParts[] = "<br/>";
            }
            $htmlParts[] = $this->buildCheck($checkId, (string) $value, $outText, $isChecked, $isDisabled);
            $optionIndex++;
        }

        if ($this->fieldset) {
            $htmlParts[] = $this->fieldset->getCloseTag();
        }

        return implode("", $htmlParts);
    }

    public function getOpenTag(): string
    {
        return $this->getHtml();
    }

    private function buildCheck(
        string $id,
        string $value,
        string $outText,
        bool $isChecked = false,
        bool $isDisabled = false
    ): string {
        $htmlParts = [];
        $name = $this->name ?: "noname";

        $htmlParts[] = "<input";
        $htmlParts[] = " type=\"{$this->type}\" ";
        if ($id) {
            $htmlParts[] = " id=\"{$id}\"";
        }
        $htmlParts[] = " name=\"{$this->idPrefix}{$name}";
        if ($this->isGrouped) {
            $htmlParts[] = "[]";
        }
        $htmlParts[] = "\"";
        $htmlParts[] = " value=\"{$value}\"";

        if ($this->jsOnBlur) {
            $htmlParts[] = " onblur=\"{$this->jsOnBlur}\"";
        }
        if ($this->jsOnChange) {
            $htmlParts[] = " onchange=\"{$this->jsOnChange};\"";
        }
        if ($this->jsOnClick) {
            $htmlParts[] = " onclick=\"{$this->jsOnClick}\"";
        }
        if ($this->jsOnKeypress) {
            $htmlParts[] = " onkeypress=\"{$this->jsOnKeypress};\"";
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
        if ($this->extras) {
            $htmlParts[] = " " . $this->getExtras();
        }
        if ($isChecked) {
            $htmlParts[] = " checked";
        }
        if ($isDisabled) {
            $htmlParts[] = " disabled";
        }
        $htmlParts[] = ">";

        if ($this->isLabeled) {
            $label = new Label($id, $outText);
            $htmlParts[] = $label->getHtml();
        }
        elseif ($outText) {
            $htmlParts[] = $outText;
        }

        return implode("", $htmlParts);
    }

    private function convertStringToArray(array|string &$mixedValue, bool $isValIndex = false): void
    {
        if (!$mixedValue) {
            $mixedValue = [];
            return;
        }

        if (is_string($mixedValue)) {
            $mixedValue = explode("|", $mixedValue);
            if ($isValIndex) {
                $indexed = [];
                foreach ($mixedValue as $v) {
                    $indexed[$v] = "";
                }
                $mixedValue = $indexed;
            }
        }
    }

    public function setFieldset(Fieldset $fieldset): void
    {
        $this->fieldset = $fieldset;
    }

    public function setLegend(Legend $legend): void
    {
        $this->legend = $legend;
    }

    public function setValuesToCheck(array|string $values): void
    {
        $this->convertStringToArray($values);
        $this->valuesToCheck = $values;
    }

    public function setNotGroupedName(bool $isOn = false): void
    {
        $this->isGrouped = $isOn;
    }

    public function setChecksPerLine(int $numChecks): void
    {
        $this->checksPerLine = $numChecks;
    }

    public function setOptions(array|string $options): void
    {
        $this->convertStringToArray($options, true);
        $this->options = $options;
    }

    public function setUnlabeled(bool $isOn = true): void
    {
        $this->isLabeled = !$isOn;
    }

    public function setName(string $value): self
    {
        $this->name = $value;
        return $this;
    }
}
