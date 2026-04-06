<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Html\Image
 */
namespace TheFramework\Helpers\Html;

use TheFramework\Helpers\AbstractHelper;

final class Image extends AbstractHelper
{
    private string $src = "";
    private string $alt = "";
    private string $title = "";

    public function __construct(
        string $src = "",
        string $id = "",
        string $class = "",
        string $style = "",
        array $extras = []
    ) {
        $this->type = "img";
        $this->idPrefix = "";
        $this->id = $id;
        $this->src = $src;
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
        $htmlParts[] = "<{$this->type}";
        if ($this->src) {
            $htmlParts[] = " src=\"{$this->src}\"";
        }
        if ($this->alt) {
            $htmlParts[] = " alt=\"{$this->getEscapedQuot($this->alt)}\"";
        }
        if ($this->title) {
            $htmlParts[] = " title=\"{$this->getEscapedQuot($this->title)}\"";
        }
        if ($this->id) {
            $htmlParts[] = " id=\"{$this->idPrefix}{$this->id}\"";
        }
        if ($this->jsOnBlur) {
            $htmlParts[] = " onblur=\"{$this->jsOnBlur}\"";
        }
        if ($this->jsOnChange) {
            $htmlParts[] = " onchange=\"{$this->jsOnChange}\"";
        }
        if ($this->jsOnClick) {
            $htmlParts[] = " onclick=\"{$this->jsOnClick}\"";
        }
        if ($this->jsOnKeypress) {
            $htmlParts[] = " onkeypress=\"{$this->jsOnKeypress}\"";
        }
        if ($this->jsOnFocus) {
            $htmlParts[] = " onfocus=\"{$this->jsOnFocus}\"";
        }
        if ($this->jsOnMouseover) {
            $htmlParts[] = " onmouseover=\"{$this->jsOnMouseover}\"";
        }
        if ($this->jsOnMouseout) {
            $htmlParts[] = " onmouseout=\"{$this->jsOnMouseout}\"";
        }
        $this->loadCssClass();
        if ($this->class) {
            $htmlParts[] = " class=\"{$this->class}\"";
        }
        $this->loadStyle();
        if ($this->style) {
            $htmlParts[] = " style=\"{$this->style}\"";
        }
        if ($this->attrDbfield) {
            $htmlParts[] = " dbfield=\"{$this->attrDbfield}\"";
        }
        if ($this->attrDbtype) {
            $htmlParts[] = " dbtype=\"{$this->attrDbtype}\"";
        }
        if ($this->extras) {
            $htmlParts[] = " " . $this->getExtras();
        }
        $htmlParts[] = ">";
        return implode("", $htmlParts);
    }

    public function getOpenTag(): string
    {
        return $this->getHtml();
    }

    public function setSrc(string $url): void
    {
        $this->src = $url;
    }

    public function setAlt(string $value): void
    {
        $this->alt = $value;
    }

    public function setTitle(string $value): void
    {
        $this->title = $value;
    }

    public function showOpenTag(): void
    {
        parent::showOpenTag();
    }

    public function showCloseTag(): void
    {
        parent::showCloseTag();
    }
}
