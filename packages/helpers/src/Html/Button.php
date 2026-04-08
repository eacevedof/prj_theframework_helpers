<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Html;

use EduardoAf\Helpers\AbstractHelper;
use EduardoAf\Helpers\Enums\ButtonTypeEnum;
use EduardoAf\Helpers\Enums\HtmlTypeEnum;

final class Button extends AbstractHelper
{
    private string $icon = "";

    public function __construct(
        string $innerHtml = "",
        string $type = ButtonTypeEnum::BUTTON,
        string $id = ""
    ) {
        $this->type = $type;
        $this->idPrefix = "";
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
        if ($this->icon) {
            $htmlParts[] = "<span class=\"{$this->icon}\"> </span> ";
        }
        $htmlParts[] = $this->innerHtml;
        $htmlParts[] = $this->getCloseTag();
        return implode("", $htmlParts);
    }

    public function getOpenTag(): string
    {
        $openTagParts = [];
        $openTagParts[] = "<" . HtmlTypeEnum::BUTTON;
        if ($this->type) {
            $openTagParts[] = " type=\"{$this->type}\"";
        }
        if ($this->id) {
            $openTagParts[] = " id=\"{$this->idPrefix}{$this->id}\"";
        }
        if ($this->disabled) {
            $openTagParts[] = " disabled";
        }
        $openTagParts = array_merge($openTagParts, $this->getCommonAttributes());
        $openTagParts[] = ">\n";
        return implode("", $openTagParts);
    }

    public function getCloseTag(): string
    {
        return "</" . HtmlTypeEnum::BUTTON . ">";
    }

    public function setIcon(string $iconClass): void
    {
        $this->icon = $iconClass;
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
