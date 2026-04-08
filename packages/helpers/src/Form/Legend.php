<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Form;

use EduardoAf\Helpers\AbstractHelper;

final class Legend extends AbstractHelper
{
    public function __construct(
        string $innerHtml = "",
        string $id = "",
        string $class = "",
        string $style = "",
        array $extras = []
    ) {
        $this->type = "legend";
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
        $this->style = $style;
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
        $openTagParts = array_merge($openTagParts, $this->getCommonAttributes());
        $openTagParts[] = ">";
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
