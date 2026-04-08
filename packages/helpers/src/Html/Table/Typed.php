<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Html\Table;

use EduardoAf\Helpers\Form\Fieldset;
use EduardoAf\Helpers\Form\Form;
use EduardoAf\Helpers\Form\Select;
use EduardoAf\Helpers\Form\Input\Checkbox;
use EduardoAf\Helpers\Form\Input\Text;
use EduardoAf\Helpers\Html\Anchor;
use EduardoAf\Helpers\Html\Button;

final class Typed extends Basic
{
    protected array $columnsAnchor = [];
    protected array $columnsInputText = [];
    protected array $columnsRadio = [];
    protected array $columnsCheckbox = [];
    protected array $columnsSelect = [];
    protected array $columnsRaw = [];
    protected bool $isColumnButtonUpdate = false;
    protected bool $isColumnButtonInsert = false;

    public function __construct(array $rows = [], array $columns = [], string $formId = "frmList", string $module = "")
    {
        parent::__construct();
        $this->lowerFieldnames($rows);
        $this->dataRows = $rows;
        $this->numRows = count($rows);
        $this->columns = $columns;
        $this->numCols = count($columns);
        $this->formId = $formId;
        $this->idPrefix = "tbl";
        $this->id = $module;
        $this->mergeGlue = ",";

        $this->columnsAnchor = [];
        $this->columnsInputText = [];
        $this->columnsRadio = [];
        $this->columnsSelect = [];
        $this->columnsCheckbox = [];
    }

    public function getHtml(): string
    {
        $this->useThead = true;
        $this->useTfoot = true;

        $htmlParts = [];
        $fieldset = new Fieldset();
        $form = new Form($this->formId);
        $form->addClass("form-horizontal");
        $form->setStyle("margin:0;padding:0;border:0;");

        $htmlParts[] = $form->getOpenTag();
        $htmlParts[] = $fieldset->getOpenTag();
        $htmlParts[] = $this->getFieldsAsString();
        $htmlParts[] = $fieldset->getCloseTag();

        if ($this->isPaginateBar) {
            $htmlParts[] = $this->buildPaginateBar();
        }

        $htmlParts[] = $this->getOpenTag();
        $this->loadArrayObjectTr();
        $htmlParts[] = $this->getHtmlRows();
        $htmlParts[] = $this->getCloseTag();
        $htmlParts[] = $this->buildHiddenFields();
        $htmlParts[] = $form->getCloseTag();
        $htmlParts[] = $this->buildJs();
        return implode("", $htmlParts);
    }

    protected function buildCellContent(array $row, string $fieldName, int $numRow, int $numColumn): string
    {
        $tdInner = "";
        if ($numColumn === 0) {
            $tdInner .= $this->buildHiddenRowchange($numRow);
            $tdInner .= $this->buildHiddenRow($numRow);
            $tdInner .= $this->buildHiddenKeys($row, $numRow);
            $tdInner .= $this->buildHiddenColumns($row, $numRow);
            if ($this->hiddenColumns) {
                $tdInner .= $this->buildExtraHidden($numRow);
            }
        }

        $this->fixLength($row, $fieldName);

        if (isset($row[$fieldName])) {
            $row[$fieldName] = htmlentities($row[$fieldName]);
        }

        switch ($fieldName) {
            case "delete":
                $tdInner .= $this->buildDeleteButton($row);
                break;
            case "quarantine":
                $tdInner .= $this->buildQuarantineButton($row);
                break;
            case "detail":
                $tdInner .= $this->buildDetailButton($row);
                break;
            case "butinsert":
                $tdInner .= $this->buildNewButton($numRow, $numColumn);
                break;
            case "butupdate":
                $tdInner .= $this->buildEditButton($numRow, $numColumn);
                break;
            case "multipick":
                $tdInner .= $this->buildMultipleButton($row, $numRow);
                break;
            case "singlepick":
                $tdInner .= $this->buildSingleButton($row, $numRow);
                break;
            default:
                if (in_array($fieldName, array_keys($this->columnsAnchor))) {
                    $tdInner .= $this->buildAnchorCellContent($row, $fieldName, $numRow, $numColumn);
                } elseif (in_array($fieldName, array_keys($this->columnsInputText))) {
                    $tdInner .= $this->buildInputtextCellContent($row, $fieldName, $numRow, $numColumn);
                } elseif (in_array($fieldName, array_keys($this->columnsSelect))) {
                    $tdInner .= $this->buildSelectCellContent($row, $fieldName, $numRow, $numColumn);
                } elseif (in_array($fieldName, array_keys($this->columnsCheckbox))) {
                    $tdInner .= $this->buildCheckboxCellContent($row, $fieldName, $numRow, $numColumn);
                } elseif (in_array($fieldName, array_keys($this->columnsRaw))) {
                    $tdInner .= $this->buildRawCellContent($row, $fieldName, $numRow, $numColumn);
                } else {
                    $tdInner .= $this->getFieldvalueByname($row, $fieldName) ?? "";
                }
                break;
        }
        return $tdInner;
    }

    protected function getOperationColumns(): array
    {
        $columns = parent::getOperationColumns();
        if ($this->isColumnButtonUpdate) {
            $columns["butupdate"] = "Save";
        }
        if ($this->isColumnButtonInsert) {
            $columns["butinsert"] = "New";
        }
        return $columns;
    }

    protected function buildAnchorCellContent(array $row, string $fieldName, int $numRow, int $numColumn): string
    {
        $cellPos = "{$numRow}_{$numColumn}";
        $anchorData = $this->getAnchorData($row, $fieldName);
        $href = $anchorData["href"];

        if ($href !== "%nohref%") {
            $anchor = new Anchor();
            $href = str_replace("%cellpos%", "'{$cellPos}'", $href);
            if (!($anchorData["external"] ?? false)) {
                if ($this->isPermaLink) {
                    $href = "/" . $href;
                } else {
                    $href = "index.php?" . $href;
                }
            }

            $anchor->setHref($href);

            $target = $anchorData["target"] ?? "self";
            $anchor->setTarget($target);
            $anchor->addExtras("cellpos", $cellPos);

            $class = $anchorData["class"] ?? "";
            if ($class) {
                $anchor->addClass($class);
            }

            $innerHtml = $anchorData["innerhtml"] ?? "";
            $classIcon = $anchorData["icon"] ?? "";
            if ($classIcon) {
                $innerHtml = "<span class=\"{$classIcon}\"></span> {$innerHtml}";
            }
            $anchor->setInnerHtml($innerHtml);
            return $anchor->getHtml();
        }
        return "-";
    }

    protected function buildInputtextCellContent(array $row, string $fieldName, int $numRow, int $numColumn): string
    {
        $inputText = new Text();
        $cellPos = "{$numRow}_{$numColumn}";
        $inputText->addExtras("cellpos", $cellPos);
        $cellPos = "{$fieldName}_{$numRow}_{$numColumn}";
        $inputText->setId("txt{$cellPos}");
        $inputText->setName("txt{$cellPos}");

        $properties = $this->columnsInputText[$fieldName] ?? [];
        if (!empty($properties["class"])) {
            $inputText->addClass($properties["class"]);
        } else {
            $inputText->addClass("input-small");
        }
        if (!empty($properties["onclick"])) {
            $inputText->setJsOnClick($properties["onclick"]);
        }
        if (!empty($properties["onfocus"])) {
            $inputText->setJsOnFocus($properties["onfocus"]);
        }
        if (!empty($properties["readonly"])) {
            $inputText->setReadonly();
        }
        $inputText->setValue($this->getFieldvalueByname($row, $fieldName) ?? "");
        return $inputText->getHtml();
    }

    protected function buildSelectCellContent(array $row, string $fieldName, int $numRow, int $numColumn): string
    {
        $select = new Select();
        $cellPos = "{$numRow}_{$numColumn}";
        $select->addExtras("cellpos", $cellPos);
        $cellPos = "{$fieldName}_{$numRow}_{$numColumn}";
        $select->setId("sel{$cellPos}");
        $select->setName("sel{$cellPos}");
        $select->setOptions($this->getSelectOptions($fieldName));
        $select->setValueToSelect($this->getFieldvalueByname($row, $fieldName) ?? "");
        return $select->getHtml();
    }

    protected function buildCheckboxCellContent(array $row, string $fieldName, int $numRow, int $numColumn): string
    {
        $checkbox = new Checkbox();
        $cellPos = "{$numRow}_{$numColumn}";
        $checkbox->addExtras("cellpos", $cellPos);
        $cellPos = "{$fieldName}_{$numRow}_{$numColumn}";
        $checkbox->setId("chk{$cellPos}");
        $checkbox->setName("chk{$fieldName}");
        $checkbox->setOptions([$this->getKeysAsString($row) => ""]);

        $fieldValue = $this->getFieldvalueByname($row, $fieldName);
        $properties = $this->columnsCheckbox[$fieldName] ?? [];
        if (is_array($properties) && array_key_exists("forchecked", $properties)) {
            if ($properties["forchecked"] == $fieldValue) {
                $checkbox->setValuesToCheck([$this->getKeysAsString($row)]);
            }
        } elseif ($fieldValue) {
            $checkbox->setValuesToCheck([$this->getKeysAsString($row)]);
        }

        return $checkbox->getHtml();
    }

    protected function buildRawCellContent(array $row, string $fieldName, int $numRow, int $numColumn): string
    {
        $column = $this->columnsRaw[$fieldName] ?? "";
        if (is_string($column)) {
            $this->replaceTagnames($column, $row);
        } elseif (is_object($column)) {
            if (method_exists($column, "getHtml")) {
                $column = $column->getHtml();
                $this->replaceTagnames($column, $row);
            }
        }
        $column = str_replace("%numrow%", (string)$numRow, $column);
        $column = str_replace("%numcolum%", (string)$numColumn, $column);
        return $column;
    }

    protected function buildNewButton(int $numRow, int $numColumn): string
    {
        $button = new Button();
        $cellPos = "{$numRow}_{$numColumn}";
        $button->setId("butInsert{$cellPos}");
        $button->setInnerHtml("Save");
        $button->setJsOnClick("alert('new');");
        $button->addClass("btn btn-alt btn-success");
        $button->addExtras("cellpos", $cellPos);
        return $button->getHtml();
    }

    protected function buildEditButton(int $numRow, int $numColumn): string
    {
        $button = new Button();
        $cellPos = "{$numRow}_{$numColumn}";
        $button->setId("butUpdate{$cellPos}");
        $button->setInnerHtml("Save");
        $button->addClass("btn btn-alt btn-success");
        $button->setJsOnClick("alert('TODO: Hi! I gonna save you');");
        $button->addExtras("cellpos", $cellPos);
        return $button->getHtml();
    }

    protected function getAnchorData(array $row, string $fieldName): array
    {
        $anchorData = ["href" => "#", "innerhtml" => ""];
        $configData = $this->columnsAnchor[$fieldName] ?? [];

        $anchorData["href"] = $this->getFieldvalueByname($row, $configData["href"] ?? "") ?? "";
        if (!$anchorData["href"]) {
            $anchorData["href"] = $configData["href"] ?? "#";
        }

        if (isset($_GET["tfw_iso_language"]) && !(strstr($anchorData["href"], "http") || strstr($anchorData["href"], "javascript:"))) {
            $anchorData["href"] = "{$_GET["tfw_iso_language"]}/{$anchorData["href"]}";
        }

        $anchorData["innerhtml"] = $this->getFieldvalueByname($row, $configData["innerhtml"] ?? "") ?? "";
        if (!$anchorData["innerhtml"]) {
            $anchorData["innerhtml"] = $configData["innerhtml"] ?? "";
        }

        if (!empty($configData["external"])) {
            $anchorData["external"] = $configData["external"];
        }
        if (!empty($configData["target"])) {
            $anchorData["target"] = $configData["target"];
        }
        if (!empty($configData["class"])) {
            $anchorData["class"] = $configData["class"];
        }
        if (!empty($configData["icon"])) {
            $anchorData["icon"] = $configData["icon"];
        }
        return $anchorData;
    }

    protected function replaceTagnames(string &$value, array $row): void
    {
        $tagNames = [];
        preg_match_all("/%[a-z,A-Z,\_]+%/", $value, $tagNames);
        $tagNames = $tagNames[0];
        foreach ($tagNames as $i => $tag) {
            $tagNames[$i] = str_replace("%", "", $tag);
        }

        foreach ($tagNames as $fieldName) {
            $tmpFind = "%{$fieldName}%";
            $fieldValue = $this->getFieldvalueByname($row, $fieldName);
            if ($fieldValue !== null) {
                $value = str_replace($tmpFind, $fieldValue, $value);
            }
        }
    }

    protected function getSelectOptions(string $fieldName): array
    {
        return $this->columnsSelect[$fieldName] ?? [];
    }

    public function setColumnAnchor(array $columns): void
    {
        $this->columnsAnchor = $columns;
    }

    public function setColumnText(array $columns): void
    {
        $this->columnsInputText = $columns;
    }

    public function setColumnSelect(array $columns): void
    {
        $this->columnsSelect = $columns;
    }

    public function setColumnCheckbox(array $columns): void
    {
        $this->columnsCheckbox = $columns;
    }

    public function setInsertButton(bool $isOn = true): void
    {
        $this->isColumnButtonInsert = $isOn;
    }

    public function setUpdateButton(bool $isOn = true): void
    {
        $this->isColumnButtonUpdate = $isOn;
    }

    public function setColumnRaw(array $columns): void
    {
        $this->columnsRaw = $columns;
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
