<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Form;

use EduardoAf\Helpers\AbstractHelper;
use EduardoAf\Helpers\InterfaceHelper;

final class Form extends AbstractHelper
{
    private const string TYPE = "form";
    public const string METHOD_POST = "post";
    public const string METHOD_GET = "get";
    public const string ENCTYPE_MULTIPART = "multipart/form-data";

    private string $method = "";
    private string $enctype = "";
    private string $action = "";
    protected string $jsOnSubmit = "";

    private ?Fieldset $fieldset = null;
    private ?Legend $legend = null;

    public function __construct(
        string $id = "",
        string $name = "",
        string $method = self::METHOD_POST,
        string $innerHtml = "",
        string $action = "",
        string $class = "",
        string $style = "",
        array $extras = [],
        string $enctype = "",
        string $onSubmit = ""
    ) {
        $this
            ->setType(self::TYPE)
            ->setId($id)
            ->setName($name)
            ->setMethod($method)
            ->setInnerHtml($innerHtml)
            ->setAction($action)
            ->setClass($class)
            ->setStyle($style)
            ->setExtras($extras)
            ->setEnctype($enctype)
            ->setOnSubmit($onSubmit)
        ;
    }

    public function getHtml(): string
    {
        $htmlParts = [];
        if ($this->comment) {
            $htmlParts[] = "<!-- {$this->comment} -->\n";
        }
        $htmlParts[] = $this->getOpenTag();
        if ($this->fieldset) {
            $htmlParts[] = $this->fieldset->getOpenTag();
        }
        if ($this->legend) {
            $htmlParts[] = $this->legend->getOpenTag();
        }
        $this->loadInnerObjects();
        if ($this->innerHtml) {
            $htmlParts[] = "{$this->innerHtml}\n";
        }
        if ($this->legend) {
            $htmlParts[] = $this->legend->getCloseTag();
        }
        if ($this->fieldset) {
            $htmlParts[] = $this->fieldset->getCloseTag();
        }
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
        if ($this->jsOnSubmit) {
            $openTagParts[] = " onsubmit=\"{$this->jsOnSubmit}\"";
        }
        if ($this->jsOnMouseover) {
            $openTagParts[] = " onmouseover=\"{$this->jsOnMouseover}\"";
        }
        if ($this->jsOnMouseout) {
            $openTagParts[] = " onmouseout=\"{$this->jsOnMouseout}\"";
        }
        if ($this->method) {
            $openTagParts[] = " method=\"{$this->method}\"";
        }
        if ($this->action) {
            $openTagParts[] = " action=\"{$this->action}\"";
        }
        if ($this->enctype) {
            $openTagParts[] = " enctype=\"{$this->enctype}\"";
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

    public function setLegend(?Legend $legend): self
    {
        $this->legend = $legend;
        return $this;
    }

    public function setFieldset(Fieldset $fieldset): self
    {
        $this->fieldset = $fieldset;
        return $this;
    }

    public function setMethod(string $value): self
    {
        $this->method = $value;
        return $this;
    }

    public function setAction(string $value): self
    {
        $this->action = $value;
        return $this;
    }

    public function setEnctype(string $value): self
    {
        $this->enctype = $value;
        return $this;
    }

    public function setOnSubmit(string $jsCode): self
    {
        $this->jsOnSubmit = $jsCode;
        return $this;
    }

    public function addFirstInner(InterfaceHelper $helper): self
    {
        array_unshift($this->innerHelpers, $helper);
        return $this;
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
