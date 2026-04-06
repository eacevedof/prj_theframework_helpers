<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Form\Input\File
 */
namespace TheFramework\Helpers\Form\Input;

use TheFramework\Helpers\AbstractHelper;
use TheFramework\Helpers\Form\Label;

final class File extends AbstractHelper
{
    private string $maxSize = "";
    private string $accept = "";

    public function __construct(
        string $id = "",
        string $name = "",
        string $class = "",
        ?Label $label = null
    ) {
        $this->label = $label;
        $this->idPrefix = "";
        $this->type = "file";
        $this->id = $id;
        $this->name = $name;
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
            $htmlParts[] = " value=\"{$this->value}\"";
        }
        if ($this->accept) {
            $htmlParts[] = " accept=\"{$this->accept}\"";
        }
        if ($this->maxSize) {
            $htmlParts[] = " maxsize=\"{$this->maxSize}\"";
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

    public function setValue(mixed $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function setMaxSize(int $numBytes): void
    {
        $this->maxSize = (string) $numBytes;
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

    public function setAccept(string $accept): void
    {
        $this->accept = $accept;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxSize(): string
    {
        return $this->maxSize;
    }

    public function isReadonly(): bool
    {
        return $this->readonly;
    }

    public function getAccept(): string
    {
        return $this->accept;
    }
}
