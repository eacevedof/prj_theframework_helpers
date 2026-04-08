<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Form\Input;

use EduardoAf\Helpers\AbstractHelper;

final class Hidden extends AbstractHelper
{
    public function __construct(
        string $id = "",
        string $name = "",
        string $value = "",
        array $extras = []
    ) {
        $this->type = "hidden";
        $this->idPrefix = "";
        $this->id = $id;
        $this->value = $value;
        $this->name = $name;
        $this->extras = $extras;
    }

    public function getHtml(): string
    {
        $htmlParts = [];
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

    public function setValue(mixed $value, bool $asEntity = false): self
    {
        $this->value = $asEntity ? htmlentities((string) $value) : $value;
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

    public static function getInstance(): self
    {
        return new self();
    }
}
