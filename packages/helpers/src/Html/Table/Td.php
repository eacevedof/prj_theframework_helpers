<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Html\Table;

use EduardoAf\Helpers\AbstractHelper;

final class Td extends AbstractHelper
{
    private string $colSpan = "";
    private bool $isHeader = false;
    private string $attrRowNumber = "";
    private string $attrColNumber = "";
    private string $attrPosition = "";

    public function __construct(
        string $innerHtml = "",
        string $id = "",
        string $class = "",
        string $style = "",
        string $colSpan = "",
        array $extras = []
    ) {
        $this->type = "td";
        $this->idPrefix = "td";
        $this->id = $id;
        $this->innerHtml = $innerHtml;
        $this->colSpan = $colSpan;
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
        if ($this->innerHtml !== "") {
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
        if ($this->colSpan) {
            $openTagParts[] = " colspan=\"{$this->colSpan}\"";
        }
        $openTagParts = array_merge($openTagParts, $this->getJsEventAttributes());
        $openTagParts = array_merge($openTagParts, $this->getStyleAttributes());
        $openTagParts = array_merge($openTagParts, $this->getDataAttributes());
        if ($this->attrRowNumber !== "") {
            $openTagParts[] = " rownumber=\"{$this->attrRowNumber}\"";
        }
        if ($this->attrColNumber !== "") {
            $openTagParts[] = " colnumber=\"{$this->attrColNumber}\"";
        }
        if ($this->attrPosition) {
            $openTagParts[] = " cellpos=\"{$this->attrPosition}\"";
        }
        if ($this->extras) {
            $openTagParts[] = " " . $this->getExtras();
        }
        $openTagParts[] = ">";
        return implode("", $openTagParts);
    }

    public function getCloseTag(): string
    {
        return parent::getCloseTag();
    }

    public function setAttrRowNumber(string $value): void
    {
        $this->attrRowNumber = $value;
    }

    public function setAttrColNumber(string $value): void
    {
        $this->attrColNumber = $value;
    }

    public function setColSpan(string $value): void
    {
        $this->colSpan = $value;
    }

    public function setAsHeader(bool $isOn = true): void
    {
        $this->isHeader = $isOn;
        $this->type = $this->isHeader ? "th" : "td";
    }

    public function setInnerObject(mixed $htmlObject): void
    {
        if (is_array($htmlObject)) {
            foreach ($htmlObject as $obj) {
                if (method_exists($obj, "getHtml")) {
                    $this->innerHtml .= $obj->getHtml();
                }
            }
        }
        elseif (method_exists($htmlObject, "getHtml")) {
            $this->innerHtml .= $htmlObject->getHtml();
        }
        else {
            $this->innerHtml .= $htmlObject;
        }
    }

    public function setAttrPosition(int $numRow, int $numColumn): void
    {
        $this->attrPosition = "{$numRow}_{$numColumn}";
    }

    public function getColSpan(): string
    {
        return $this->colSpan;
    }

    public function isHeader(): bool
    {
        return $this->isHeader;
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
