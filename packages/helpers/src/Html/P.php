<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Html;

use EduardoAf\Helpers\AbstractHelper;

final class P extends AbstractHelper
{
    public function __construct(
        string $innerHtml = "",
        string $id = "",
        string $class = "",
        string $style = "",
        array $extras = []
    ) {
        $this->type = "p";
        $this->idPrefix = "";
        $this->id = $id;
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
        $openTagParts = array_merge($openTagParts, $this->getCommonAttributes());
        $openTagParts[] = ">\n";
        return implode("", $openTagParts);
    }

    public function showOpenTag(): void
    {
        parent::showOpenTag();
    }

    public function showCloseTag(): void
    {
        parent::showCloseTag();
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
