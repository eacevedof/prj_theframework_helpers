<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Form\Input\Date
 */
namespace TheFramework\Helpers\Form\Input;

use TheFramework\Helpers\AbstractHelper;
use TheFramework\Helpers\Form\Label;

final class Date extends AbstractHelper
{
    private bool $useClearButton = true;
    private bool $convertDateBeforeShow = true;
    private bool $isIpadIphone = false;
    private string $separator = "/";

    public function __construct(
        string $id = "",
        string $name = "",
        string $value = "",
        array $extras = [],
        string $maxLength = "",
        string $class = "",
        ?Label $label = null
    ) {
        $this->idPrefix = "";
        $this->id = $id;
        $this->value = $value;
        $this->maxLength = $maxLength;
        $this->name = $name;
        if ($class) {
            $this->classes[] = $class;
        }
        $this->extras = $extras;
        $this->label = $label;
    }

    private function getDateArranged(array $dateParts): array
    {
        $result = ["y" => "", "m" => "", "d" => ""];
        $date0 = $dateParts[0] ?? "";
        $date2 = $dateParts[2] ?? "";
        $result["m"] = $dateParts[1] ?? "";
        if (strlen($date0) === 4) {
            $result["y"] = $date0;
            $result["d"] = $date2;
        }
        else {
            $result["d"] = $date0;
            $result["y"] = $date2;
        }
        return $result;
    }

    private function getConverted(string $anyDate): string
    {
        $inputDate = "";
        $anyDate = trim($anyDate);
        if (!$anyDate) {
            return $inputDate;
        }

        $anyDate = str_replace(" ", "", $anyDate);
        $sep = $this->separator;

        if (strstr($anyDate, "/")) {
            $sep = "/";
        }
        elseif (strstr($anyDate, "-")) {
            $sep = "-";
        }

        if ($sep) {
            $dateParts = explode($sep, $anyDate);
            $dateParts = $this->getDateArranged($dateParts);
            $inputDate = "{$dateParts["y"]}-{$dateParts["m"]}-{$dateParts["d"]}";
        }
        else {
            $inputDate = $anyDate;
        }

        return $inputDate;
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
        $htmlParts[] = "<input";
        $htmlParts[] = " type=\"date\"";
        if ($this->id) {
            $htmlParts[] = " id=\"{$this->idPrefix}{$this->id}\"";
        }
        if ($this->name) {
            $htmlParts[] = " name=\"{$this->idPrefix}{$this->name}\"";
        }
        if ($this->value) {
            $htmlParts[] = " value=\"" . $this->getConverted((string) $this->value) . "\"";
        }
        if ($this->maxLength) {
            $htmlParts[] = " maxlength=\"{$this->maxLength}\"";
        }
        if ($this->disabled) {
            $htmlParts[] = " disabled";
        }
        if ($this->readonly) {
            $htmlParts[] = " readonly";
        }
        if ($this->isRequired) {
            $htmlParts[] = " required";
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
        if ($this->placeholder) {
            $htmlParts[] = " placeholder=\"{$this->placeholder}\"";
        }
        if ($this->isPrimaryKey) {
            $htmlParts[] = " pk=\"pk\"";
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
        $htmlParts[] = ">";
        return implode("", $htmlParts);
    }

    public function getOpenTag(): string
    {
        return $this->getHtml();
    }

    public function setName(string $value): self
    {
        $this->name = $value;
        return $this;
    }

    public function setValue(mixed $value, bool $asEntity = false): self
    {
        $this->value = $asEntity ? htmlentities((string) $value) : $value;
        return $this;
    }

    public function setToday(): void
    {
        $this->convertDateBeforeShow = false;
        $this->value = date("d/m/Y");
    }

    public function setUseClearButton(bool $isOn = true): void
    {
        $this->useClearButton = $isOn;
    }

    public function setIsIpadIphone(bool $isOn = true): void
    {
        $this->isIpadIphone = $isOn;
    }

    public function setSeparator(string $value): void
    {
        $this->separator = $value;
    }

    public function setRequired(bool $isRequired = true): self
    {
        $this->isRequired = $isRequired;
        return $this;
    }

    public function setReadonly(bool $readonly = true): self
    {
        $this->readonly = $readonly;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(bool $asEntity = false): mixed
    {
        return $asEntity ? htmlentities((string) $this->value) : $this->value;
    }
}
