<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Form\Input\Password
 */
namespace TheFramework\Helpers\Form\Input;

use TheFramework\Helpers\AbsHelper;
use TheFramework\Helpers\Form\Label;

final class Password extends AbsHelper
{
    public function __construct(
        string $id = "",
        string $name = "",
        string $value = "",
        int $length = 50,
        string $class = "",
        ?Label $label = null
    ) {
        $this->label = $label;
        $this->idPrefix = "";
        $this->type = "password";
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->maxLength = (string) $length;
        if ($class) {
            $this->classes[] = $class;
        }
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
        if ($this->type) {
            $htmlParts[] = " type=\"{$this->type}\"";
        }
        if ($this->id) {
            $htmlParts[] = " id=\"{$this->idPrefix}{$this->id}\"";
        }
        if ($this->name) {
            $htmlParts[] = " name=\"{$this->idPrefix}{$this->name}\"";
        }
        if ($this->value || $this->value === "0") {
            $htmlParts[] = " value=\"{$this->getEscapedQuot($this->value)}\"";
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
        $htmlParts[] = ">\n";
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

    public function setMaxLength(int $numChars): void
    {
        $this->maxLength = (string) $numChars;
    }

    public function setReadonly(bool $readonly = true): self
    {
        $this->readonly = $readonly;
        return $this;
    }

    public function setDisabled(bool $disabled = true): self
    {
        $this->disabled = $disabled;
        return $this;
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

    public function getValue(bool $asEntity = false): mixed
    {
        return $asEntity ? htmlentities((string) $this->value) : $this->value;
    }

    public function getMaxLength(): string
    {
        return $this->maxLength;
    }

    public function isReadonly(): bool
    {
        return $this->readonly;
    }
}
