<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Html\Button
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/button
 */
namespace TheFramework\Helpers\Html;

use TheFramework\Helpers\AbstractHelper;

final class Button extends AbstractHelper
{
    private string $icon = "";

    public function __construct(
        string $innerHtml = "",
        string $type = "button",
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
        $openTagParts[] = "<button";
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
        return "</button>";
    }

    public function setIcon(string $iconClass): void
    {
        $this->icon = $iconClass;
    }
}
