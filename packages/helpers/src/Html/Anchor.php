<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Html\Anchor
 */
namespace TheFramework\Helpers\Html;

use TheFramework\Helpers\AbstractHelper;

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
}
