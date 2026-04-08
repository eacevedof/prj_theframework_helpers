<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Html\Xl;

use EduardoAf\Helpers\AbstractHelper;

final class Li extends AbstractHelper
{
    public function __construct(string $innerHtml = "", string $id = "")
    {
        $this->idPrefix = "li";
        $this->type = "li";
        $this->id = $id;
        $this->innerHtml = $innerHtml;
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
        if ($this->disabled) {
            $openTagParts[] = " disabled";
        }
        if ($this->readonly) {
            $openTagParts[] = " readonly";
        }
        if ($this->isRequired) {
            $openTagParts[] = " required";
        }
        $openTagParts = array_merge($openTagParts, $this->getJsEventAttributes());
        $openTagParts = array_merge($openTagParts, $this->getStyleAttributes());
        $openTagParts = array_merge($openTagParts, $this->getExtraAttributes());
        $openTagParts[] = ">\n";
        return implode("", $openTagParts);
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
