<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Html\Table\Tr
 */
namespace TheFramework\Helpers\Html\Table;

use TheFramework\Helpers\AbstractHelper;

final class Tr extends AbstractHelper
{
    private bool $isRowHead = false;
    private bool $isRowFoot = false;
    private string $colSpan = "";
    private string $rowSpan = "";
    private int $numCols = 0;
    private string $attrRowNumber = "";

    public function __construct(
        array $innerHelpers = [],
        string $id = "",
        string $class = "",
        string $style = "",
        string $colSpan = "",
        string $rowSpan = "",
        array $extras = []
    ) {
        $this->type = "tr";
        $this->innerHtml = "";
        $this->idPrefix = "tr";
        $this->id = $id;
        $this->innerHelpers = $innerHelpers;
        $this->numCols = count($this->innerHelpers);
        $this->colSpan = $colSpan;
        $this->rowSpan = $rowSpan;
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
        $htmlParts[] = $this->getOpenTag();
        $this->loadInnerObjects();
        if ($this->innerHtml) {
            $htmlParts[] = $this->innerHtml;
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
        if ($this->rowSpan) {
            $openTagParts[] = " rowspan=\"{$this->rowSpan}\"";
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
        if ($this->isPrimaryKey) {
            $openTagParts[] = " pk=\"pk\"";
        }
        if ($this->attrDbtype) {
            $openTagParts[] = " dbtype=\"{$this->attrDbtype}\"";
        }
        if ($this->attrRowNumber !== "") {
            $openTagParts[] = " rownumber=\"{$this->attrRowNumber}\"";
        }
        $openTagParts[] = ">\n";
        return implode("", $openTagParts);
    }

    public function getCloseTag(): string
    {
        return parent::getCloseTag();
    }

    public function setColSpan(string $value): void
    {
        $this->colSpan = $value;
    }

    public function setObjTds(array $innerHelpers = []): void
    {
        $this->innerHelpers = $innerHelpers;
        $this->numCols = count($this->innerHelpers);
    }

    public function setAsRowHead(bool $isOn = true): void
    {
        $this->isRowHead = $isOn;
    }

    public function setAsRowFoot(bool $isOn = true): void
    {
        $this->isRowFoot = $isOn;
    }

    public function setAttrRowNumber(string $value): void
    {
        $this->attrRowNumber = $value;
    }

    public function addInnerHelper(mixed $value): self
    {
        $this->innerHelpers[] = $value;
        $this->numCols = count($this->innerHelpers);
        return $this;
    }

    public function addTd(Td $td): void
    {
        $this->innerHelpers[] = $td;
        $this->numCols = count($this->innerHelpers);
    }

    public function getColSpan(): string
    {
        return $this->colSpan;
    }

    public function getObjTds(): array
    {
        return $this->innerHelpers;
    }

    public function isRowHead(): bool
    {
        return $this->isRowHead;
    }

    public function isRowFoot(): bool
    {
        return $this->isRowFoot;
    }

    public function getNumColumns(): int
    {
        return $this->numCols;
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
