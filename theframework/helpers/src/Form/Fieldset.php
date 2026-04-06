<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Form\Fieldset
 */
namespace TheFramework\Helpers\Form;

use TheFramework\Helpers\AbstractHelper;

final class Fieldset extends AbstractHelper
{
    private const TYPE = "fieldset";

    public function __construct(
        string $innerHtml = "",
        string $id = "",
        string $class = "",
        string $style = "",
        array $extras = []
    ) {
        $this
            ->setType(self::TYPE)
            ->setId($id)
            ->setInnerHtml($innerHtml)
            ->setClass($class)
            ->setStyle($style)
            ->setExtras($extras)
        ;
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
        if ($this->extras) {
            $openTagParts[] = " " . $this->getExtras();
        }
        $openTagParts[] = ">";
        return implode("", $openTagParts);
    }
}
