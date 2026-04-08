<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Traits;

trait HtmlAttributesTrait
{
    protected function getJsEventAttributes(): array
    {
        $attributes = [];
        if ($this->jsOnBlur) {
            $attributes[] = " onblur=\"{$this->jsOnBlur}\"";
        }
        if ($this->jsOnChange) {
            $attributes[] = " onchange=\"{$this->jsOnChange}\"";
        }
        if ($this->jsOnClick) {
            $attributes[] = " onclick=\"{$this->jsOnClick}\"";
        }
        if ($this->jsOnKeypress) {
            $attributes[] = " onkeypress=\"{$this->jsOnKeypress}\"";
        }
        if ($this->jsOnKeydown) {
            $attributes[] = " onkeydown=\"{$this->jsOnKeydown}\"";
        }
        if ($this->jsOnKeyup) {
            $attributes[] = " onkeyup=\"{$this->jsOnKeyup}\"";
        }
        if ($this->jsOnFocus) {
            $attributes[] = " onfocus=\"{$this->jsOnFocus}\"";
        }
        if ($this->jsOnMouseover) {
            $attributes[] = " onmouseover=\"{$this->jsOnMouseover}\"";
        }
        if ($this->jsOnMouseout) {
            $attributes[] = " onmouseout=\"{$this->jsOnMouseout}\"";
        }
        return $attributes;
    }

    protected function getStyleAttributes(): array
    {
        $attributes = [];
        $this->loadCssClass();
        if ($this->class) {
            $attributes[] = " class=\"{$this->class}\"";
        }
        $this->loadStyle();
        if ($this->style) {
            $attributes[] = " style=\"{$this->style}\"";
        }
        return $attributes;
    }

    protected function getDataAttributes(): array
    {
        $attributes = [];
        if ($this->attrDbfield) {
            $attributes[] = " dbfield=\"{$this->attrDbfield}\"";
        }
        if ($this->attrDbtype) {
            $attributes[] = " dbtype=\"{$this->attrDbtype}\"";
        }
        if ($this->isPrimaryKey) {
            $attributes[] = " pk=\"pk\"";
        }
        return $attributes;
    }

    protected function getExtraAttributes(): array
    {
        $attributes = [];
        if ($this->extras) {
            $attributes[] = " " . $this->getExtras();
        }
        return $attributes;
    }

    protected function getCommonAttributes(): array
    {
        return array_merge(
            $this->getJsEventAttributes(),
            $this->getStyleAttributes(),
            $this->getDataAttributes(),
            $this->getExtraAttributes()
        );
    }
}
