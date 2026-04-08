<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Html;

use EduardoAf\Helpers\AbstractHelper;

final class Anchor extends AbstractHelper
{
    private string $href = "";
    private string $target = "";

    public function __construct(
        string $innerHtml = "",
        string $id = "",
        string $href = "",
        string $target = "",
        string $class = "",
        string $style = "",
        array $extras = []
    ) {
        $this->type = "a";
        $this->idPrefix = "";
        $this->id = $id;
        $this->href = $href;
        $this->target = $target;
        $this->innerHtml = $innerHtml;
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
        if ($this->href) {
            $openTagParts[] = " href=\"{$this->href}\"";
        }
        if ($this->target) {
            $openTagParts[] = " target=\"{$this->target}\"";
        }
        $openTagParts = array_merge($openTagParts, $this->getCommonAttributes());
        $openTagParts[] = ">";
        return implode("", $openTagParts);
    }

    public function setHref(string $value): void
    {
        $this->href = $value;
    }

    public function setTarget(string $value): void
    {
        $this->target = "_{$value}";
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
