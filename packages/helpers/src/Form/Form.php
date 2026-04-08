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
        $openTagParts = array_merge($openTagParts, $this->getJsEventAttributes());
        if ($this->jsOnSubmit) {
            $openTagParts[] = " onsubmit=\"{$this->jsOnSubmit}\"";
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
        $openTagParts = array_merge($openTagParts, $this->getStyleAttributes());
        $openTagParts = array_merge($openTagParts, $this->getDataAttributes());
        $openTagParts = array_merge($openTagParts, $this->getExtraAttributes());
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
