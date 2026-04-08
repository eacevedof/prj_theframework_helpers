<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Form\Input;

use EduardoAf\Helpers\AbstractHelper;
use EduardoAf\Helpers\Form\Label;

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
        $htmlParts = array_merge($htmlParts, $this->getJsEventAttributes());
        $htmlParts = array_merge($htmlParts, $this->getStyleAttributes());
        if ($this->placeholder) {
            $htmlParts[] = " placeholder=\"{$this->placeholder}\"";
        }
        $htmlParts = array_merge($htmlParts, $this->getDataAttributes());
        $htmlParts = array_merge($htmlParts, $this->getExtraAttributes());
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

    public static function getInstance(): self
    {
        return new self();
    }
}
