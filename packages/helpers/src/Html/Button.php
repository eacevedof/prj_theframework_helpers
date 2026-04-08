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
        if ($this->jsOnBlur) {
            $openTagParts[] = " onblur=\"{$this->jsOnBlur}\"";
        }
        if ($this->jsOnChange) {
            $openTagParts[] = " onchange=\"{$this->jsOnChange}\"";
        }
        if ($this->jsOnClick) {
            $openTagParts[] = " onclick=\"{$this->jsOnClick}\"";
        }
        if ($this->jsOnKeypress) {
            $openTagParts[] = " onkeypress=\"{$this->jsOnKeypress}\"";
        }
        if ($this->jsOnFocus) {
            $openTagParts[] = " onfocus=\"{$this->jsOnFocus}\"";
        }
        if ($this->jsOnMouseover) {
            $openTagParts[] = " onmouseover=\"{$this->jsOnMouseover}\"";
        }
        if ($this->jsOnMouseout) {
            $openTagParts[] = " onmouseout=\"{$this->jsOnMouseout}\"";
        }
        $this->loadCssClass();
        if ($this->class) {
            $openTagParts[] = " class=\"{$this->class}\"";
        }
        $this->loadStyle();
        if ($this->style) {
            $openTagParts[] = " style=\"{$this->style}\"";
        }
        if ($this->attrDbfield) {
            $openTagParts[] = " dbfield=\"{$this->attrDbfield}\"";
        }
        if ($this->attrDbtype) {
            $openTagParts[] = " dbtype=\"{$this->attrDbtype}\"";
        }
        if ($this->extras) {
            $openTagParts[] = " " . $this->getExtras();
        }
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
