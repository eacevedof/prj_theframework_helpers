<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Form;

use EduardoAf\Helpers\AbstractHelper;

final class Label extends AbstractHelper
{
    private string $for = "";

    public function __construct(
        string $for = "",
        string $innerHtml = "",
        string $id = "",
        string $class = "",
        string $style = "",
        array $extras = []
    ) {
        $this->type = "label";
        $this->idPrefix = "";
        $this->id = $id;
        $this->innerHtml = $innerHtml;
        $this->for = $for;
        if ($class) {
            $this->classes[] = $class;
        }
        if ($style) {
            $this->styles[] = $style;
        }
        $this->extras = $extras;
    }

    public function getHtml(): string
    {
        $htmlParts = [];
        if ($this->comment) {
            $htmlParts[] = "<!-- {$this->comment} -->\n";
        }
        $htmlParts[] = $this->getOpenTag();
        $this->loadInnerObjects();
        $htmlParts[] = $this->innerHtml;
        $htmlParts[] = $this->getCloseTag();
        return implode("", $htmlParts);
    }

    public function getOpenTag(): string
    {
        $openTagParts = [];
        $openTagParts[] = "<{$this->type}";
        if ($this->id) {
            $openTagParts[] = " id=\"{$this->idPrefix}{$this->id}\"";
        }
        if ($this->for) {
            $openTagParts[] = " for=\"{$this->for}\"";
        }
        $openTagParts = array_merge($openTagParts, $this->getCommonAttributes());
        $openTagParts[] = ">";
        return implode("", $openTagParts);
    }

    public function setFor(string $value): void
    {
        $this->for = $value;
    }

    public function getFor(): string
    {
        return $this->for;
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
