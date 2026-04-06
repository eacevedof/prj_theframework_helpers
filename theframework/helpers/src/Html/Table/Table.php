<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Html\Table\Table
 */
namespace TheFramework\Helpers\Html\Table;

use TheFramework\Helpers\AbstractHelper;
use TheFramework\Helpers\Enums\HtmlTypeEnum;

class Table extends AbstractHelper
{
    protected ?array $objTrs = null;
    protected bool $useThead = false;
    protected bool $useTfoot = false;
    protected int $numRows = 0;
    protected int $numCols = 0;

    public function __construct(
        array $mixedTrs = [],
        string $id = "",
        string $class = "",
        string $style = "",
        array $extras = []
    ) {
        $this->type = HtmlTypeEnum::TABLE;
        $this->idPrefix = "tbl";
        $this->id = $id;
        $this->innerHtml = "";
        $this->objTrs = $mixedTrs;
        $this->numRows = count($this->objTrs);
        $this->loadNumCols();
        if ($class) {
            $this->classes[] = $class;
        }
        if ($style) {
            $this->styles[] = $style;
        }
        $this->extras = $extras;
    }

    protected function loadNumCols(): void
    {
        $this->numCols = 0;
        if (!isset($this->objTrs[0])) {
            return;
        }

        $firstTr = $this->objTrs[0];
        if (is_object($firstTr) && ($firstTr instanceof Tr)) {
            $this->numCols = $firstTr->getNumColumns();
        }
        elseif (is_array($firstTr)) {
            $this->numCols = count($firstTr);
        }
        elseif (is_string($firstTr)) {
            $this->numCols = substr_count($firstTr, "</" . HtmlTypeEnum::TD . ">");
        }
        else {
            $this->numCols = -1;
        }
    }

    public function getHtml(): string
    {
        $htmlParts = [];
        if ($this->comment) {
            $htmlParts[] = "<!-- {$this->comment} -->\n";
        }
        $htmlParts[] = $this->getOpenTag();
        if (!$this->innerHtml) {
            $this->innerHtml = $this->getHtmlRows();
        }
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
        $openTagParts[] = ">\n";
        return implode("", $openTagParts);
    }

    protected function getHtmlRows(): string
    {
        $positionsHead = $this->getPositionsHead();
        $positionsFoot = $this->getPositionsFoot();
        $positionsBody = $this->getPositionsBody($positionsHead, $positionsFoot);

        $htmlRows = "";
        $htmlRows .= $this->buildThead($positionsHead);
        $htmlRows .= $this->buildTfoot($positionsFoot);
        $htmlRows .= $this->buildTbody($positionsBody);

        return $htmlRows;
    }

    protected function getMixedTrAsString(mixed $mixedTr): string
    {
        $trString = "";
        if (is_object($mixedTr) && method_exists($mixedTr, "getHtml")) {
            $trString .= "\t" . $mixedTr->getHtml();
        }
        elseif (is_array($mixedTr)) {
            $trString .= "\t<" . HtmlTypeEnum::TR . ">" . implode("\n", $mixedTr) . "</" . HtmlTypeEnum::TR . ">";
        }
        else {
            $trString .= "\t" . $mixedTr;
        }
        return $trString;
    }

    protected function buildThead(array $positionsHead = []): string
    {
        $trString = "";
        foreach ($positionsHead as $pos) {
            $mixedTr = $this->objTrs[$pos];
            $trString .= $this->getMixedTrAsString($mixedTr);
        }
        $thead = "";
        if ($trString !== "") {
            $thead = "<" . HtmlTypeEnum::THEAD . " id=\"tblh\">\n{$trString}</" . HtmlTypeEnum::THEAD . ">\n";
        }
        return $thead;
    }

    protected function buildTbody(array $positionsBody = []): string
    {
        $trString = "";
        foreach ($positionsBody as $pos) {
            $mixedTr = $this->objTrs[$pos];
            $trString .= $this->getMixedTrAsString($mixedTr);
        }
        $tbody = "";
        if ($trString !== "") {
            $tbody = "<" . HtmlTypeEnum::TBODY . " id=\"{$this->id}_tbody\">\n{$trString}</" . HtmlTypeEnum::TBODY . ">\n";
        }
        return $tbody;
    }

    protected function buildTfoot(array $positionsFoot = []): string
    {
        $trString = "";
        foreach ($positionsFoot as $pos) {
            $mixedTr = $this->objTrs[$pos];
            $trString .= $this->getMixedTrAsString($mixedTr);
        }
        $tfoot = "";
        if ($trString !== "") {
            $tfoot = "<" . HtmlTypeEnum::TFOOT . " id=\"{$this->id}_tfoot\">\n{$trString}</" . HtmlTypeEnum::TFOOT . ">\n";
        }
        return $tfoot;
    }

    protected function getPositionsHead(): array
    {
        $positions = [];
        if (!$this->useThead) {
            return $positions;
        }

        foreach ($this->objTrs as $i => $mixedRow) {
            if (is_object($mixedRow) && $mixedRow->isRowHead()) {
                $positions[] = $i;
            }
            elseif (is_array($mixedRow)) {
                $isHead = false;
                foreach ($mixedRow as $td) {
                    if (is_string($td) && strstr($td, "</" . HtmlTypeEnum::TH . ">")) {
                        $isHead = true;
                        break;
                    }
                }
                if ($isHead) {
                    $positions[] = $i;
                }
            }
            elseif (is_string($mixedRow) && strstr($mixedRow, "</" . HtmlTypeEnum::TH . ">")) {
                $positions[] = $i;
            }
        }
        return $positions;
    }

    protected function getPositionsBody(array $positionsHead = [], array $positionsFoot = []): array
    {
        $positions = [];
        $numRows = count($this->objTrs);
        for ($i = 0; $i < $numRows; $i++) {
            if (!in_array($i, $positionsHead) && !in_array($i, $positionsFoot)) {
                $positions[] = $i;
            }
        }
        return $positions;
    }

    protected function getPositionsFoot(): array
    {
        $positions = [];
        if (!$this->useTfoot) {
            return $positions;
        }

        foreach ($this->objTrs as $i => $row) {
            if (is_object($row) && $row->isRowFoot()) {
                $positions[] = $i;
            }
        }
        return $positions;
    }

    public function useHeader(bool $isOn = true): void
    {
        $this->useThead = $isOn;
    }

    public function useFooter(bool $isOn = true): void
    {
        $this->useTfoot = $isOn;
    }

    public function setObjRows(array $objArray = []): void
    {
        $this->objTrs = $objArray;
        $this->numRows = count($this->objTrs);
        $this->loadNumCols();
    }

    public function addObjRow(mixed $value): void
    {
        $this->objTrs[] = $value;
        $this->numRows = count($this->objTrs);
        $this->loadNumCols();
    }

    public function addTr(Tr $tr): void
    {
        $this->objTrs[] = $tr;
        $this->numRows = count($this->objTrs);
        $this->loadNumCols();
    }

    public function getObjRows(): ?array
    {
        return $this->objTrs;
    }
}
