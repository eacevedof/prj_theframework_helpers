<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Form\Input;

use EduardoAf\Helpers\AbstractHelper;

final class Generic extends AbstractHelper
{
    public function __construct(
        mixed $value,
        array $extras = []
    ) {
        $this->value = $value;
        $this->extras = $extras;
    }

    public function getHtml(): string
    {
        $htmlParts = [];
        if ($this->comment) {
            $htmlParts[] = "<!-- {$this->comment} -->\n";
        }
        $htmlParts[] = "<input";
        if ($this->value || $this->value === "0") {
            $htmlParts[] = " value=\"{$this->getEscapedQuot($this->value)}\"";
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

    public function setValue(mixed $value, bool $asEntity = false): self
    {
        $this->value = $asEntity ? htmlentities((string) $value) : $value;
        return $this;
    }

    public function getValue(bool $asEntity = false): mixed
    {
        return $asEntity ? htmlentities((string) $this->value) : $this->value;
    }
}
