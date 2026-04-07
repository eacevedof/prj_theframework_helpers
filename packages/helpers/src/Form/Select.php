<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Form\Select
 */
namespace TheFramework\Helpers\Form;

use TheFramework\Helpers\AbstractHelper;
use TheFramework\Helpers\Enums\HtmlTypeEnum;

final class Select extends AbstractHelper
{
    private array $options = [];
    private mixed $valuesToSelect = null;
    private string $selectedAsHidden = "";
    private bool $isMultiple = false;
    private int $size = 1;

    public function __construct(
        array $options,
        string $id = "",
        string $name = "",
        ?Label $label = null,
        mixed $valueToSelect = "",
        int $size = 1,
        bool $isMultiple = false,
        array $extras = [],
        string $class = "",
        bool $readonly = false
    ) {
        $this->type = HtmlTypeEnum::SELECT;
        $this->valuesToSelect = $valueToSelect;
        $this->options = $options;
        $this->idPrefix = "";
        $this->id = $id;
        $this->name = $name;
        $this->isMultiple = $isMultiple;
        if ($this->size > 1) {
            $this->isMultiple = true;
        }
        $this->size = $size;
        $this->label = $label;
        $this->extras = $extras;
        if ($class) {
            $this->classes[] = $class;
        }
        $this->readonly = $readonly;
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
        $htmlParts[] = $this->getOpenTag();

        $valueToSelect = !is_array($this->valuesToSelect)
            ? (string) $this->valuesToSelect
            : $this->valuesToSelect;

        if (!$this->readonly) {
            if (!$this->isMultiple) {
                foreach ($this->options as $value => $innerText) {
                    $optionValue = (string) $value;
                    $isSelected = ($valueToSelect === $optionValue);
                    $htmlParts[] = $this->buildHtmlOption($value, $innerText, $isSelected);
                }
            }
            else {
                foreach ($this->options as $value => $innerText) {
                    $isSelected = is_array($valueToSelect)
                        ? in_array($value, $valueToSelect)
                        : ($valueToSelect === (string) $value);
                    $htmlParts[] = $this->buildHtmlOption($value, $innerText, $isSelected);
                }
            }
        }
        else {
            if (!$this->isMultiple) {
                if (count($this->options) <= 2 && array_key_exists("", $this->options)) {
                    unset($this->options[""]);
                    $itemReadonly = $this->options;
                }
                else {
                    $itemReadonly = $this->getItemReadonly($this->options, $valueToSelect);
                }
                foreach ($itemReadonly as $value => $text) {
                    $htmlParts[] = $this->buildHtmlOption($value, $text, true);
                }
            }
        }

        $htmlParts[] = $this->getCloseTag();
        $htmlParts[] = $this->selectedAsHidden;
        return implode("", $htmlParts);
    }

    public function getOpenTag(): string
    {
        $openTagParts = [];
        $openTagParts[] = "<{$this->type}";
        if ($this->id) {
            $openTagParts[] = " id=\"{$this->idPrefix}{$this->id}\"";
        }
        if ($this->isMultiple) {
            $openTagParts[] = " name=\"{$this->idPrefix}{$this->name}[]\"";
        }
        else {
            $openTagParts[] = " name=\"{$this->idPrefix}{$this->name}\"";
        }
        if ($this->size) {
            $openTagParts[] = " size=\"{$this->size}\"";
        }
        if ($this->isMultiple) {
            $openTagParts[] = " multiple";
        }
        if ($this->disabled) {
            $openTagParts[] = " disabled";
        }
        if ($this->isRequired) {
            $openTagParts[] = " required";
        }
        if ($this->jsOnBlur) {
            $openTagParts[] = " onblur=\"{$this->jsOnBlur}\"";
        }
        if ($this->jsOnChange) {
            $openTagParts[] = " onchange=\"{$this->jsOnChange}\"";
        }
        if ($this->jsOnClick) {
            $openTagParts[] = " onclick=\"{$this->jsOnClick}\"";
        }
        if ($this->jsOnKeypress) {
            $openTagParts[] = " onkeypress=\"{$this->jsOnKeypress}\"";
        }
        if ($this->jsOnFocus) {
            $openTagParts[] = " onfocus=\"{$this->jsOnFocus}\"";
        }
        if ($this->jsOnMouseover) {
            $openTagParts[] = " onmouseover=\"{$this->jsOnMouseover}\"";
        }
        if ($this->jsOnMouseout) {
            $openTagParts[] = " onmouseout=\"{$this->jsOnMouseout}\"";
        }
        $this->loadCssClass();
        if ($this->class) {
            $openTagParts[] = " class=\"{$this->class}\"";
        }
        $this->loadStyle();
        if ($this->style) {
            $openTagParts[] = " style=\"{$this->style}\"";
        }
        if ($this->attrDbfield) {
            $openTagParts[] = " dbfield=\"{$this->attrDbfield}\"";
        }
        if ($this->attrDbtype) {
            $openTagParts[] = " dbtype=\"{$this->attrDbtype}\"";
        }
        if ($this->isPrimaryKey) {
            $openTagParts[] = " pk=\"pk\"";
        }
        if ($this->extras) {
            $openTagParts[] = " " . $this->getExtras();
        }
        $openTagParts[] = ">\n";
        return implode("", $openTagParts);
    }

    private function getItemReadonly(array $options, mixed $valueToSelect): array
    {
        $itemReadOnly = ["" => ""];
        foreach ($options as $optValue => $optText) {
            if ($valueToSelect == (string) $optValue) {
                return [$optValue => $optText];
            }
        }
        return $itemReadOnly;
    }

    private function buildHtmlOption(mixed $value, string $innerText, bool $isSelected = false): string
    {
        $option = "\t<" . HtmlTypeEnum::OPTION;
        $value = $this->getEscapedQuot($value);
        $option .= " value=\"{$value}\"";
        if ($isSelected) {
            $option .= " selected";
        }
        $option .= ">";
        $option .= htmlentities($innerText);
        $option .= "</" . HtmlTypeEnum::OPTION . ">\n";
        return $option;
    }

    public function setReadonly(bool $readonly = true): self
    {
        $this->readonly = $readonly;
        return $this;
    }

    public function setName(string $value): self
    {
        $this->name = $value;
        return $this;
    }

    public function setValueToSelect(mixed $values): void
    {
        $this->valuesToSelect = $values;
    }

    public function setMultipleSize(int $value): void
    {
        $this->size = $value;
        if ($this->size > 1) {
            $this->isMultiple = true;
        }
    }

    public function setSelectedValueAsHiddenOn(): void
    {
        $this->selectedAsHidden = "
        <input type=\"hidden\" name=\"{$this->name}\" id=\"{$this->id}\" value=\"{$this->valuesToSelect}\"/>\n";
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function setRequired(bool $isRequired = true): self
    {
        $this->isRequired = $isRequired;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSelectedValue(): mixed
    {
        return $this->valuesToSelect;
    }

    public function getCloseTag(): string
    {
        return parent::getCloseTag();
    }
}
