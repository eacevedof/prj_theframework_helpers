<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Html\Table\Basic
 */
namespace TheFramework\Helpers\Html\Table;

use TheFramework\Helpers\Form\Fieldset;
use TheFramework\Helpers\Form\Form;
use TheFramework\Helpers\Form\Select;
use TheFramework\Helpers\Form\Input\Hidden;
use TheFramework\Helpers\Form\Input\Checkbox;
use TheFramework\Helpers\Html\Anchor;
use TheFramework\Helpers\Html\Button;

class Basic extends Table
{
    protected ?array $objFields = null;
    protected ?array $keyFields = null;
    protected ?array $columns = null;
    protected ?array $dataRows = null;
    protected ?array $orderBy = null;
    protected string $formId = "";
    protected string $urlNoview = "";
    protected string $urlDelete = "";
    protected string $urlUpdate = "";
    protected string $urlQuarantine = "";
    protected string $urlPickSingle = "";
    protected string $urlPickMultiple = "";
    protected string $urlPaginate = "";
    protected string $module = "";

    protected ?array $orderWay = null;
    protected bool $isOrdenable = false;
    protected bool $isToDetail = false;

    protected bool $isPickMultiple = false;
    protected bool $isPickSingle = false;
    protected bool $doMergePkeys = false;
    protected bool $isMergeKeyfields = false;
    protected string $mergeGlue = ",";
    protected ?array $assignSingle = null;
    protected ?array $assignMulti = null;
    protected ?array $multiAdd = null;
    protected ?array $singleAdd = null;
    protected ?array $extraColumns = null;
    protected ?array $hiddenColumns = null;
    protected ?array $extraHidden = null;

    protected ?array $configColTypes = null;
    protected bool $isDeleteSingle = false;
    protected bool $isQuarantineSingle = false;

    protected int $infoNumRegs = 0;
    protected int $infoCurrentPage = 0;
    protected int $infoNumPages = 0;
    protected int $infoNextPage = 0;
    protected int $infoPreviousPage = 0;
    protected int $infoFirstPage = 0;
    protected int $infoLastPage = 0;
    protected int $itemsPerPage = 0;

    protected bool $isCheckOnRowclick = false;
    protected bool $isPaginateBar = true;

    protected array $tmpJs = [];
    protected array $columnLength = [];

    public function __construct(array $rows = [], array $columns = [], string $formId = "frmList", string $module = "")
    {
        parent::__construct();
        $this->isPaginateBar = true;
        $this->lowerFieldnames($rows);
        $this->dataRows = $rows;
        $this->numRows = count($rows);
        $this->columns = $columns;
        $this->numCols = count($columns);
        $this->formId = $formId;
        $this->idPrefix = "tbl";
        $this->id = $module;
        $this->module = $module;
        $this->loadGetUrls();
        $this->mergeGlue = ",";
        $this->orderBy = [];
        $this->orderWay = [];
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

    protected function getFieldsAsString(): string
    {
        $htmlString = "";
        if ($this->objFields) {
            foreach ($this->objFields as $objField) {
                if (is_object($objField) && method_exists($objField, "getHtml")) {
                    $htmlString .= $objField->getHtml();
                }
            }
        }
        return $htmlString;
    }

    protected function buildPaginateBar(): string
    {
        $pages = [];
        for ($i = 1; $i <= $this->infoNumPages; $i++) {
            $pages[$i] = "pag {$i}";
        }

        $selPages = new Select($pages, "selPage");
        $selPages->setValueToSelect($this->infoCurrentPage);
        $selPages->setStyle("margin:0;padding:0;width:85px;");
        $selPages->setName("selPage");
        $selPages->setJsOnChange("table_frmsubmit();");

        $htmlSelect = $selPages->getHtml();
        $htmlNavPages = "
        <table id=\"tblNavPages\" style=\"width:100%; padding:0; margin-bottom:3px; margin-top:3px;\">
        <tr>
        <td style=\"background:#fff; padding:0; color:#003399;\">
        <div class=\"pagination pagination-left\" style=\"padding:0;margin:0; margin-left:3px;\">";
        $htmlNavPages .= $this->buildNavigationButtons($htmlSelect);
        $htmlNavPages .= "</div>
        </td>
        </tr>
        </table>
        ";
        return $htmlNavPages;
    }

    protected function getReturnSingle(): string
    {
        $jsParts = [];
        $idReturnKey = $this->getGet("returnkey");
        $idReturnDesc = $this->getGet("returndesc");
        $doClose = (int)$this->getGet("close");
        $jsParts[] = "var sIdReturnKey=\"{$idReturnKey}\";";
        $jsParts[] = "var sIdReturnDesc=\"{$idReturnDesc}\";";
        $jsParts[] = "var doClose={$doClose};";
        return implode("\n", $jsParts);
    }

    protected function convertToUrlparams(array $forParams): string
    {
        $urlParts = [];
        $glue = "&";
        if ($this->isPermaLink) {
            $glue = "/";
            foreach ($forParams as $params) {
                foreach ($params as $fieldName => $value) {
                    $urlParts[] = $value;
                }
            }
        } else {
            foreach ($forParams as $params) {
                foreach ($params as $fieldName => $value) {
                    $urlParts[] = "{$fieldName}={$value}";
                }
            }
        }
        return implode($glue, $urlParts);
    }

    protected function jsFnMultiassignWindow(): string
    {
        return "
        function multiassign_window(sUrlAction,iW,iH,doClose)
        {
            var iW = iW || 800;
            var iH = iH || 600;
            var sUrlAction = sUrlAction || window.location.search;
            window.open(sUrlAction,\"multipick\",\"width=\"+iW+\",height=\"+iH,status=0,scrollbars=0,resizable=0,left=0,top=0);
        }
        ";
    }

    protected function jsFnSingleassignWindow(): string
    {
        $this->setTmpJs();
        if ($this->isPermaLink) {
            $this->addTmpJs("window.open(\"/\"+sUrlAction,\"singlepick\",\"width=\"+iW+\",height=\"+iH,status=0,scrollbars=0,resizable=0,left=0,top=0);");
        } else {
            $this->addTmpJs("window.open(\"index.php?\"+sUrlAction,\"singlepick\",\"width=\"+iW+\",height=\"+iH,status=0,scrollbars=0,resizable=0,left=0,top=0);");
        }

        $tmpJs = $this->getTmpJs();
        return "
        function singleassign_window(sUrlAction,sIdNameKey,sIdNameDesc,iW,iH)
        {
            var iW = iW||800;
            var iH = iH||600;
            var sUrlAction = sUrlAction || window.location.search;
            {$tmpJs}
        }
        ";
    }

    protected function jsFnMultiadd(): string
    {
        return "
        //helper_table_basic
        function multiadd(sUrlAction,sIdForm)
        {
            var sIdForm = sIdForm || \"{$this->formId}\";
            var sUrlAction = sUrlAction || window.location.search;
            var oForm = document.getElementById(sIdForm);
            if(oForm)
            {
                if(is_checked(\"pkeys[]\"))
                {
                    if(confirm(oTfwtr.confirm))
                    {
                        oForm.action=sUrlAction;
                        oForm.submit();
                    }
                }
                else
                    alert(oTfwtr.norows);
            }
        }
        ";
    }

    protected function jsFnSingleadd(): string
    {
        return "
        //helper_table_basic
        function singleadd(iRow,sIdReturnKey,sIdReturnDesc,doClose)
        {
            var sHidKey = \"hidKeySingle_\"+iRow;
            var sHidDesc = \"hidDescSingle_\"+iRow;
            var oWindowParent = top.opener;
            if(oWindowParent)
            {
                var sKeyValue = document.getElementById(sHidKey).value;
                var sDescValue = document.getElementById(sHidDesc).value;
                var eInput = oWindowParent.document.getElementById(sIdReturnKey);
                if(!eInput) eInput = oWindowParent.document.getElementsByName(sIdReturnKey)[0];
                if(eInput) eInput.value = sKeyValue;
                eInput = oWindowParent.document.getElementById(sIdReturnDesc);
                if(!eInput) eInput = oWindowParent.document.getElementsByName(sIdReturnDesc)[0];
                if(eInput) eInput.value = sDescValue;
                if(doClose) self.close();
            }
        }
        ";
    }

    protected function jsFnFormSubmit(): string
    {
        $tmpJs = "";
        if ($this->isPermaLink) {
            $this->setTmpJs();
            $this->addTmpJs("var iPage = TfwControl.getvalue_byid(\"selPage\");");
            $this->addTmpJs("iPage = iPage || 1;");
            $this->addTmpJs("sUrlAction += iPage + \"/\";");
            $tmpJs = $this->getTmpJs();
        }

        return "
        //helper_table_basic
        function table_frmsubmit(sUrlAction,sIdForm)
        {
            var sIdForm = sIdForm || \"{$this->formId}\";
            var sUrlAction = sUrlAction || document.getElementById(\"hidUrlPaginate\").value;
            var oForm = document.getElementById(sIdForm);
            if(oForm)
            {
                {$tmpJs}
                oForm.action=sUrlAction;
                oForm.submit();
            }
         }
        ";
    }

    protected function jsFnRowcheck(): string
    {
        return "
        //helper_table_basic
        function rowcheck(iRow,id)
        {
            var id = id||\"pkeys\";
            id = id+\"_\"+iRow;
            var eCheckBox = document.getElementById(id);
            if(eCheckBox)
            {
                if(TfwControl.is_checkbox_checked(eCheckBox))
                    TfwControl.set_checkbox_check(eCheckBox,0);
                else
                    TfwControl.set_checkbox_check(eCheckBox,1);
                rowchange(iRow);
            }
        }
        ";
    }

    protected function jsFnCheckAll(): string
    {
        return "
        //helper_table_basic
        function check_all(id,name)
        {
            var id = id||\"pkeys_all\";
            var name = name||\"pkeys[]\";
            var eCheckBox = document.getElementById(id);
            if(TfwControl.is_checkbox_checked(eCheckBox))
                TfwControl.set_checked_byname(name,true);
            else
                TfwControl.set_checked_byname(name,false);
        }
        ";
    }

    protected function jsFnNavClick(): string
    {
        $this->setTmpJs();
        if ($this->isPermaLink) {
            $this->addTmpJs("sUrlAction += iPage+\"/\";");
        } else {
            $this->addTmpJs("sUrlAction += \"&page=\"+iPage;");
        }

        $tmpJs = $this->getTmpJs();

        return "
        //helper_table_basic
        function nav_click(iPage)
        {
            var iPage = iPage || 1;
            var sUrlAction = TfwControl.getvalue_byid(\"hidUrlPaginate\");
            {$tmpJs}
            TfwControl.sel_option_byid(\"selPage\",iPage);
            TfwControl.form_submit(\"{$this->formId}\",sUrlAction);
        }
        ";
    }

    protected function jsFnMultiDelete(): string
    {
        $checkPostKey = $this->buildPostkey();
        return "
        //helper_table_basic
        function multi_delete()
        {
            if(is_checked(\"{$checkPostKey}[]\"))
            {
                if(confirm(\"" . (defined('tr_main_confirm_before_delete') ? tr_main_confirm_before_delete : 'Confirm delete?') . "\"))
                {
                    var sUrlAction = document.getElementById(\"hidUrlNoview\").value;
                    sUrlAction = sUrlAction.replace(\"%replaceview%\",\"delete\");
                    var oHidAction = document.getElementById(\"hidAction\");
                    oHidAction.value = \"multidelete\";
                    TfwControl.form_submit(\"{$this->formId}\",sUrlAction);
                }
            }
            else
                alert(\"" . (defined('tr_main_table_selection') ? tr_main_table_selection : 'Select rows') . "\");
        }
        ";
    }

    protected function jsFnMultiQuarantine(): string
    {
        $checkPostKey = $this->buildPostkey();

        return "
        //helper_table_basic
        function multi_quarantine()
        {
            if(is_checked(\"{$checkPostKey}[]\"))
            {
                if(confirm(\"" . (defined('tr_main_confirm_before_quarantine') ? tr_main_confirm_before_quarantine : 'Confirm quarantine?') . "\"))
                {
                    var sUrlAction = document.getElementById(\"hidUrlNoview\").value;
                    sUrlAction = sUrlAction.replace(\"%replaceview%\",\"quarantine\");
                    var oHidAction = document.getElementById(\"hidAction\");
                    oHidAction.value = \"multiquarantine\";
                    TfwControl.form_submit(\"{$this->formId}\",sUrlAction);
                }
            }
            else
                alert(\"" . (defined('tr_main_table_selection') ? tr_main_table_selection : 'Select rows') . "\");
        }
        ";
    }

    protected function jsFnIsChecked(): string
    {
        return "
        //helper_table_basic
        function is_checked(sCheckName)
        {
            var arObjChecks = document.getElementsByName(sCheckName);
            if(arObjChecks.length!=undefined)
            {
                for(var i=0; i<arObjChecks.length; i++)
                    if(arObjChecks[i].checked==1)
                        return true;
            }
            return false;
        }
        ";
    }

    protected function jsFnRowchange(): string
    {
        return "
        //helper_table_basic
        function rowchange(iRow)
        {
            var sId = \"hidRowChanged_\"+iRow+\"_0\";
            var oHidRowChanged = document.getElementById(sId);
            if(oHidRowChanged) oHidRowChanged.value=1;
        }
        ";
    }

    protected function jsFnHrefgo(): string
    {
        return "
        //helper_table_basic
        function hrefgo(sUrl,sConfirm)
        {
            var sConfirm = sConfirm || \"\";
            var sUrl = sUrl || \"\";
            if(sUrl!=\"\")
            {
                if(sConfirm!=\"\")
                {
                    if(confirm(sConfirm))
                        window.location = sUrl;
                }
                else
                {
                    window.location = sUrl;
                }
            }
        }
        ";
    }

    protected function buildJs(): string
    {
        $htmlJs = "<script helper=\"Basic.buildJs\" type=\"text/javascript\">\n";
        $htmlJs .= $this->jsFnRowchange();
        $htmlJs .= $this->jsFnFormSubmit();
        $htmlJs .= $this->jsFnCheckAll();
        $htmlJs .= $this->jsFnNavClick();
        $htmlJs .= $this->jsFnMultiDelete();
        $htmlJs .= $this->jsFnMultiQuarantine();
        $htmlJs .= $this->jsFnIsChecked();
        $htmlJs .= $this->jsFnHrefgo();

        if ($this->isCheckOnRowclick) {
            $htmlJs .= $this->jsFnRowcheck();
        }

        if ($this->isOrdenable) {
            $htmlJs .= "var sThBackground=\"\";
         var sThColor=\"\";

         function order_by(eTh)
         {
            var sFieldName = eTh.getAttribute(\"dbfield\");
            var oHidOrderBy = document.getElementById(\"hidOrderBy\");
            var oHidOrderType = document.getElementById(\"hidOrderType\");

            var sOrderBy = oHidOrderBy.value;
            var sOrderType = oHidOrderType.value;

            if(sOrderBy)
            {
                if(sFieldName==sOrderBy)
                {
                    if(sOrderType.toUpperCase()==\"ASC\")
                        oHidOrderType.value=\"DESC\";
                    else oHidOrderType.value=\"ASC\";
                }
                else
                {
                    oHidOrderBy.value = sFieldName;
                    oHidOrderType.value = \"ASC\";
                }
            }
            else
            {
                oHidOrderBy.value = sFieldName;
                oHidOrderType.value = \"ASC\";
            }
            table_frmsubmit();
         }

         function on_thover(eTh,sColor,sBackColor)
         {
            sThBackground = eTh.style.backgroundColor;
            sThColor = eTh.style.color;
            eTh.style.color=sColor;
            eTh.style.backgroundColor=sBackColor;
         }

         function on_thout(eTh){eTh.style.backgroundColor=sThBackground;eTh.style.color=sThColor;}
        ";
        }

        if ($this->assignMulti) {
            $htmlJs .= $this->jsFnMultiassignWindow();
        }
        if ($this->multiAdd) {
            $htmlJs .= $this->jsFnMultiadd();
        }
        if ($this->assignSingle) {
            $htmlJs .= $this->jsFnSingleassignWindow();
        }
        if ($this->singleAdd) {
            $htmlJs .= $this->jsFnSingleadd();
        }
        $htmlJs .= "</script>\n";
        return $htmlJs;
    }

    protected function buildJsFieldids(): string
    {
        $ids = array_keys($this->columns);
        $fieldIds = implode("\",\"", $ids);
        return "\"{$fieldIds}\"";
    }

    protected function buildHiddenFields(): string
    {
        $htmlHidden = "";
        $hidden = new Hidden();

        $hidden->setId("hidOrderBy");
        $hidden->setName("hidOrderBy");
        if ($this->orderBy) {
            $hidden->setValue(implode(",", $this->orderBy));
        }
        $htmlHidden .= $hidden->getHtml();

        $hidden->setId("hidOrderType");
        $hidden->setName("hidOrderType");
        if ($this->orderWay) {
            $hidden->setValue(implode(",", $this->orderWay));
        }
        $htmlHidden .= $hidden->getHtml();

        $hidden->setId("hidKeyFields");
        $hidden->setName("hidKeyFields");
        if ($this->keyFields) {
            $hidden->setValue(implode(",", $this->keyFields));
        }
        $htmlHidden .= $hidden->getHtml();

        $hidden->setName("hidUrlCurrent");
        $hidden->setId("hidUrlCurrent");
        $hidden->setValue($this->getRequestUri());
        $htmlHidden .= $hidden->getHtml();

        $hidden->setName(null);
        $hidden->setId("hidUrlNoview");
        $hidden->setValue($this->urlNoview);
        $htmlHidden .= $hidden->getHtml();

        $hidden->setId("hidUrlPaginate");
        $hidden->setValue($this->urlPaginate);
        $htmlHidden .= $hidden->getHtml();

        $hidden->setId("hidAuxiliar");
        $hidden->setName("hidAuxiliar");
        $hidden->setValue("");
        $htmlHidden .= $hidden->getHtml();

        $hidden->setId("hidAction");
        $hidden->setName("hidAction");
        $hidden->setValue("");
        $htmlHidden .= $hidden->getHtml();

        $hidden->setId("hidPostback");
        $hidden->setName("hidPostback");
        $hidden->setValue("");
        $htmlHidden .= $hidden->getHtml();

        $hidden->setId("selItemsPerPage");
        $hidden->setName("selItemsPerPage");
        $hidden->setValue($this->itemsPerPage);
        $htmlHidden .= $hidden->getHtml();

        if ($this->assignSingle) {
            $hidden->setId("hidAssignSingle");
            $hidden->setName("hidAssignSingle");
            $hidden->setValue("");
            $htmlHidden .= $hidden->getHtml();
        }
        if ($this->assignMulti) {
            $hidden->setId("hidAssignMulti");
            $hidden->setName("hidAssignMulti");
            $hidden->setValue("");
            $htmlHidden .= $hidden->getHtml();
        }
        return $htmlHidden;
    }

    protected function buildHiddenRow(int $numRow): string
    {
        $hidden = new Hidden();
        $idName = "hidRow_{$numRow}_0";
        $hidden->setId($idName);
        $hidden->setName($idName);
        $hidden->setValue($numRow);
        return $hidden->getHtml();
    }

    protected function buildHiddenRowchange(int $numRow): string
    {
        $hidden = new Hidden();
        $idName = "hidRowChanged_{$numRow}_0";
        $hidden->setId($idName);
        $hidden->setName($idName);
        $hidden->setValue("0");
        return $hidden->getHtml();
    }

    protected function buildHiddenKeys(array $row, int $numRow): string
    {
        $htmlHidden = "";
        $hidden = new Hidden();
        if ($this->keyFields) {
            foreach ($this->keyFields as $fieldName) {
                $idName = "hid{$fieldName}_{$numRow}";
                $hidden->setId($idName);
                $hidden->setName($idName);
                $hidden->setValue($this->getFieldvalueByname($row, $fieldName));
                $htmlHidden .= $hidden->getHtml();
            }
        }
        return $htmlHidden;
    }

    protected function buildHiddenColumns(array $row, int $numRow): string
    {
        $htmlHidden = "";
        $hidden = new Hidden();
        if ($this->hiddenColumns) {
            foreach ($this->hiddenColumns as $fieldName) {
                $idName = "hid{$fieldName}_{$numRow}_0";
                $hidden->setId($idName);
                $hidden->setName($idName);
                $hidden->addExtras("cellpos", "{$numRow}_0");
                $hidden->setValue($this->getFieldvalueByname($row, $fieldName));
                $htmlHidden .= $hidden->getHtml();
            }
        }
        return $htmlHidden;
    }

    protected function buildExtraHidden(int $numRow): string
    {
        $htmlHidden = "";
        $hidden = new Hidden();
        if ($this->extraHidden) {
            foreach ($this->extraHidden as $fieldName => $value) {
                $idName = "hid{$fieldName}_{$numRow}_0";
                $hidden->setId($idName);
                $hidden->setName($idName);
                $hidden->addExtras("cellpos", "{$numRow}_0");

                if (is_array($value)) {
                    $value = implode(",", $value);
                }
                $hidden->setValue($value);
                $htmlHidden .= $hidden->getHtml();
            }
        }
        return $htmlHidden;
    }

    protected function loadArrayObjectTr(): void
    {
        $columns = $this->getOperationColumns();
        $this->loadHeadRow($columns, $this->objTrs);
        $this->loadBodyRows($columns, $this->objTrs);
    }

    protected function getOperationColumns(): array
    {
        $columns = [];
        if ($this->isToDetail) {
            $columns["detail"] = "Upd";
        }
        if ($this->isPickMultiple) {
            $columns["multipick"] = "Multi";
        }
        if ($this->isPickSingle) {
            $columns["singlepick"] = "Single";
        }

        if (!empty($columns)) {
            $columns = array_merge($columns, $this->columns);
        } else {
            $columns = $this->columns;
        }

        if ($this->isDeleteSingle) {
            $columns["delete"] = "Del";
        }
        if ($this->isQuarantineSingle) {
            $columns["quarantine"] = "Del";
        }
        if ($this->extraColumns) {
            $columns = $this->reorderColumns($columns, $this->extraColumns);
        }
        return $columns;
    }

    protected function reorderColumns(array $columns, array $virtualColumns): array
    {
        $colsReordered = [];
        $occupied = [];
        $temp = [];

        foreach ($columns as $fieldName => $label) {
            $position = $this->arrayKeyPosition($fieldName, $columns);
            $occupied[] = ["fieldname" => $fieldName, "label" => $label, "position" => $position];
        }

        foreach ($occupied as $i => $columnOccupied) {
            $fieldName = $columnOccupied["fieldname"];
            $label = $columnOccupied["label"];
            $position = $columnOccupied["position"];

            $newInPosition = $this->getColumnsByPosition($position, $virtualColumns);
            foreach ($newInPosition as $newCol) {
                $temp[] = $newCol;
            }

            $temp[] = $columnOccupied;
            $this->unsetByPosition($position, $virtualColumns);
        }

        foreach ($virtualColumns as $i => $data) {
            $data["fieldname"] = "virtual_{$i}";
            $temp[] = $data;
        }

        foreach ($temp as $data) {
            $colsReordered[$data["fieldname"]] = $data["label"];
        }
        return $colsReordered;
    }

    protected function getColumnsByPosition(int $position, array $columns): array
    {
        $colsInPosition = [];
        foreach ($columns as $i => $colData) {
            if ($colData["position"] === $position) {
                $colData["fieldname"] = "virtual_{$i}";
                $colsInPosition[] = $colData;
            }
        }
        return $colsInPosition;
    }

    protected function unsetByPosition(int $position, array &$columns): void
    {
        foreach ($columns as $key => $colData) {
            if ($colData["position"] === $position) {
                unset($columns[$key]);
            }
        }
    }

    protected function loadHeadRow(array $columns, ?array &$objRows): void
    {
        if ($objRows === null) {
            $objRows = [];
        }
        $trHead = new Tr();
        $trHead->setAsRowHead();
        $trHead->setAttrRowNumber("-1");

        $objThs = [];
        foreach ($columns as $fieldName => $label) {
            $columnPosition = $this->arrayKeyPosition($fieldName, $columns);
            $th = new Td();
            $th->setAsHeader();
            $th->setAttrDbfield($fieldName);
            $th->setAttrColNumber((string)$columnPosition);
            $th->setAttrRowNumber("-1");

            if ($fieldName === "multipick") {
                $th->setInnerHtml($this->buildMultipleButtonHead());
            } else {
                $colLabel = $this->buildColumnLabel($fieldName, $label);
                $th->setInnerHtml($colLabel);
                $noOrder = ["delete", "detail", "singlepick", "quarantine"];
                if ($this->isOrdenable && !(in_array($fieldName, $noOrder) || strstr($fieldName, "virtual_"))) {
                    $th->setJsOnClick("order_by(this);");
                    $th->setJsOnMouseover("on_thover(this,'#000','#B2B2B2');");
                    $th->setJsOnMouseout("on_thout(this);");
                }
            }
            $objThs[] = $th;
        }
        $trHead->setObjTds($objThs);
        $objRows[] = $trHead;
    }

    protected function buildColumnLabel(string $fieldName, string $label): string
    {
        $columnHeader = $label;
        if ($this->isOrdenable && $this->orderBy) {
            $position = array_search($fieldName, array_values($this->orderBy));
            $orderWay = "";
            if ($position !== false) {
                $orderWay = $this->orderWay[$position] ?? "";
            }
            if ($orderWay === "ASC") {
                $columnHeader = "{$columnHeader} <span class=\"awe-caret-up\"></span>";
            } elseif ($orderWay === "DESC") {
                $columnHeader = "{$columnHeader} <span class=\"awe-caret-down\"></span>";
            }
        }
        return $columnHeader;
    }

    protected function loadBodyRows(array $columns, ?array &$objRows): void
    {
        if ($objRows === null) {
            $objRows = [];
        }
        if (!$this->dataRows) {
            return;
        }
        foreach ($this->dataRows as $numRow => $row) {
            $objTds = [];
            $tr = new Tr();

            if ($this->isCheckOnRowclick) {
                $postKey = $this->buildPostkey();
                $tr->setJsOnClick("rowcheck('{$numRow}','{$postKey}');");
            }

            $tr->setAttrRowNumber((string)$numRow);

            foreach ($columns as $fieldName => $label) {
                $numColumn = (int)$this->arrayKeyPosition($fieldName, $columns);
                $td = new Td();
                $td->setAttrDbfield($fieldName);
                $td->setAttrColNumber((string)$numColumn);
                $td->setAttrRowNumber((string)$numRow);
                $td->setAttrPosition($numRow, $numColumn);

                $tdInner = $this->buildCellContent($row, $fieldName, $numRow, $numColumn);
                $td->setInnerHtml($tdInner);
                $objTds[] = $td;
            }
            $tr->setObjTds($objTds);
            $objRows[] = $tr;
        }
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
            case "multipick":
                $tdInner .= $this->buildMultipleButton($row, $numRow);
                break;
            case "singlepick":
                $tdInner .= $this->buildSingleButton($row, $numRow);
                break;
            default:
                $tdInner .= $this->getFieldvalueByname($row, $fieldName) ?? "";
                break;
        }
        return $tdInner;
    }

    protected function buildUrlButton(string $urlMethod, array $row, ?string $exclude = null): string
    {
        $returnUrl = $urlMethod;
        $keys = $this->getKeysAsUrl($row, $exclude);

        if ($this->isPermaLink) {
            if (!$this->isLastcharSlash($returnUrl)) {
                $returnUrl = $urlMethod . "/";
            }
            if ($keys) {
                $returnUrl .= $keys . "/";
            }
        } elseif ($keys) {
            $returnUrl .= "&" . $keys;
        }

        return $returnUrl;
    }

    protected function buildDeleteButton(array $row): string
    {
        $anchor = new Anchor();
        $anchor->addClass("btn btn-danger");
        $deleteLabel = defined('tr_main_list_delete') ? tr_main_list_delete : 'Delete';
        $anchor->setInnerHtml("\n<span class=\"awe-remove-sign\"></span> {$deleteLabel}");
        $anchor->setTarget("self");
        $urlButton = $this->buildUrlButton($this->urlDelete, $row);
        $confirmMsg = defined('tr_main_confirm_before_delete') ? tr_main_confirm_before_delete : 'Confirm delete?';
        $anchor->setHref("javascript:hrefgo('{$urlButton}','{$confirmMsg}');");
        return $anchor->getHtml();
    }

    protected function buildQuarantineButton(array $row): string
    {
        $anchor = new Anchor();
        $anchor->addClass("btn btn-danger");
        $quarantineLabel = defined('tr_main_list_quarantine') ? tr_main_list_quarantine : 'Quarantine';
        $anchor->setInnerHtml("\n<span class=\"awe-remove-sign\"></span> {$quarantineLabel}");
        $anchor->setTarget("self");
        $urlButton = $this->buildUrlButton($this->urlQuarantine, $row);
        $confirmMsg = defined('tr_main_confirm_before_quarantine') ? tr_main_confirm_before_quarantine : 'Confirm quarantine?';
        $anchor->setHref("javascript:hrefgo('{$urlButton}','{$confirmMsg}');");
        return $anchor->getHtml();
    }

    protected function buildDetailButton(array $row): string
    {
        $anchor = new Anchor();
        $anchor->addClass("btn btn-info");
        $anchor->setInnerHtml("\n<span class=\"awe-info-sign\"></span> info");
        $anchor->setTarget("self");
        $urlButton = $this->buildUrlButton($this->urlUpdate, $row, "page");
        $anchor->setHref($urlButton);
        return $anchor->getHtml();
    }

    protected function buildMultipleButton(array $row, int $numRow): string
    {
        $checkbox = new Checkbox();
        $checkbox->setUnlabeled();
        $htmlCheck = "";

        if ($this->doMergePkeys) {
            $values = [];
            if ($this->keyFields) {
                foreach ($this->keyFields as $fldKeyName) {
                    $values[] = "{$fldKeyName}=" . $this->getFieldvalueByname($row, $fldKeyName);
                }
            }
            $merged = implode($this->mergeGlue, $values);
            $checkbox->setOptions([$merged => null]);
            $checkbox->setId("pkeys_{$numRow}");
            $checkbox->setName("pkeys");
            $checkbox->setAttrDbfield("pkeys");
            $htmlCheck .= $checkbox->getHtml();
        } elseif ($this->keyFields) {
            foreach ($this->keyFields as $fldKeyName) {
                $fieldValue = $this->getFieldvalueByname($row, $fldKeyName);
                $checkbox->setOptions([$fieldValue => ""]);
                $id = $fldKeyName . "_{$numRow}";
                $checkbox->setId($id);
                $checkbox->setName($fldKeyName);
                $checkbox->setAttrDbfield($fldKeyName);
                $htmlCheck .= $checkbox->getHtml();
            }
        }
        return $htmlCheck;
    }

    protected function buildSingleButton(array $row, int $numRow): string
    {
        $idDestKey = $this->singleAdd["destkey"] ?? "";
        $idDestDesc = $this->singleAdd["destdesc"] ?? "";
        $columnsKeys = explode(",", $this->singleAdd["colkeys"] ?? "");
        $columnsDesc = explode(",", $this->singleAdd["coldescs"] ?? "");
        $doClose = (int)($this->singleAdd["close"] ?? 0);

        $button = new Button();
        $button->addClass("btn btn-success");
        $button->setInnerHtml("Pick");
        $hidKey = new Hidden("hidKeySingle_{$numRow}");
        $hidDesc = new Hidden("hidDescSingle_{$numRow}");

        $button->setJsOnClick("singleadd({$numRow},'{$idDestKey}','{$idDestDesc}',{$doClose});");

        $htmlButton = "";

        $values = [];
        $numFields = count($columnsKeys);
        foreach ($columnsKeys as $fieldName) {
            if ($numFields > 1) {
                $values[] = "{$fieldName}=" . $this->getFieldvalueByname($row, $fieldName);
            } else {
                $values[] = $this->getFieldvalueByname($row, $fieldName);
            }
        }

        $merged = implode($this->mergeGlue, $values);
        $hidKey->setValue($merged);

        $values = [];
        foreach ($columnsDesc as $fieldName) {
            $values[] = $this->getFieldvalueByname($row, $fieldName);
        }

        $merged = implode($this->mergeGlue, $values);
        $hidDesc->setValue($merged);

        $htmlButton .= $button->getHtml();
        $htmlButton .= $hidKey->getHtml();
        $htmlButton .= $hidDesc->getHtml();
        return $htmlButton;
    }

    protected function buildMultipleButtonHead(): string
    {
        $checkbox = new Checkbox();
        $checkbox->setUnlabeled();
        $htmlCheck = "";
        if ($this->doMergePkeys) {
            $fldKeyNames = implode($this->mergeGlue, array_values($this->keyFields ?? []));
            $checkbox->setOptions([$fldKeyNames => null]);
            $checkbox->setId("pkeys_all");
            $checkbox->setName("pkeys_all");
            $checkbox->setJsOnClick("check_all();");
            $htmlCheck .= $checkbox->getHtml();
        } elseif ($this->keyFields) {
            foreach ($this->keyFields as $fldKeyName) {
                $checkbox->setOptions([$fldKeyName => null]);
                $checkbox->setId("{$fldKeyName}_all");
                $checkbox->setName("{$fldKeyName}_all");
                $checkbox->setJsOnClick("check_all('{$fldKeyName}_all','{$fldKeyName}[]');");
                $htmlCheck .= $checkbox->getHtml();
            }
        }
        return $htmlCheck;
    }

    protected function getKeysAsUrl(array $row, mixed $exclude = null): string
    {
        $excludeArray = $this->mixedToArray($exclude);
        $rowKeys = [];
        $glue = "&";

        if ($this->isPermaLink) {
            if ($this->keyFields) {
                foreach ($this->keyFields as $fldKeyName) {
                    if (in_array($fldKeyName, $excludeArray)) {
                        continue;
                    }
                    $fieldValue = $this->getFieldvalueByname($row, $fldKeyName);
                    if ($fieldValue) {
                        $rowKeys[] = $fieldValue;
                    }
                }
            }
        } elseif ($this->keyFields) {
            foreach ($this->keyFields as $fldKeyName) {
                if (in_array($fldKeyName, $excludeArray)) {
                    continue;
                }
                $fieldValue = $this->getFieldvalueByname($row, $fldKeyName);
                if ($fieldValue) {
                    $rowKeys[] = "{$fldKeyName}={$fieldValue}";
                }
            }
        }
        return implode($glue, $rowKeys);
    }

    protected function getKeysAsString(array $row, mixed $exclude = null, bool $isWithName = false): string
    {
        $rowKeys = [];
        $glue = ",";
        $excludeArray = $this->mixedToArray($exclude);
        if ($this->keyFields) {
            foreach ($this->keyFields as $fldKeyName) {
                if (in_array($fldKeyName, $excludeArray)) {
                    continue;
                }
                $fieldValue = $this->getFieldvalueByname($row, $fldKeyName);
                if ($isWithName) {
                    $rowKeys[] = "{$fldKeyName}:{$fieldValue}";
                } else {
                    $rowKeys[] = $fieldValue;
                }
            }
        }
        return implode($glue, $rowKeys);
    }

    protected function getFieldvalueByname(array $row, string $name): ?string
    {
        foreach ($row as $fieldName => $fieldValue) {
            if ($fieldName === $name) {
                return $this->getFormatedvalue($fieldName, $fieldValue);
            }
        }
        return null;
    }

    protected function getColformat(string $fieldName): ?string
    {
        if ($this->configColTypes) {
            foreach ($this->configColTypes as $field => $format) {
                if ($fieldName === $field) {
                    return $format;
                }
            }
        }
        return null;
    }

    protected function getFormatedvalue(string $fieldName, mixed $fieldValue): string
    {
        $value = "";
        $format = $this->getColformat($fieldName);
        switch ($format) {
            case "date":
                $value = function_exists('dbbo_date') ? dbbo_date($fieldValue) : (string)$fieldValue;
                break;
            case "datetime4":
                $value = function_exists('dbbo_datetime4') ? dbbo_datetime4($fieldValue) : (string)$fieldValue;
                break;
            case "datetime6":
                $value = function_exists('dbbo_datetime6') ? dbbo_datetime6($fieldValue) : (string)$fieldValue;
                break;
            case "time4":
                $value = function_exists('dbbo_time4') ? dbbo_time4($fieldValue) : (string)$fieldValue;
                break;
            case "time6":
                $value = function_exists('dbbo_time6') ? dbbo_time6($fieldValue) : (string)$fieldValue;
                break;
            case "int":
                $value = function_exists('dbbo_int') ? dbbo_int($fieldValue) : (string)$fieldValue;
                break;
            case "numeric2":
                $value = function_exists('dbbo_numeric2') ? dbbo_numeric2($fieldValue) : (string)$fieldValue;
                break;
            default:
                $value = (string)$fieldValue;
                break;
        }
        return $value;
    }

    protected function buildNavigationButtons(string $htmlSelect): string
    {
        $htmlUlButtons = "";
        $htmlUlButtons .= "<ul style=\"margin:0\">";
        if ($this->infoCurrentPage > 1) {
            $htmlUlButtons .= "<li><a href=\"javascript:nav_click({$this->infoFirstPage});\">&nbsp;&nbsp;<span class=\"awe-arrow-left\"></span>&nbsp;&nbsp;</a></li>";
            $htmlUlButtons .= "<li><a href=\"javascript:nav_click({$this->infoPreviousPage});\">&nbsp;&nbsp;«&nbsp;&nbsp;</a></li>";
        }
        $htmlUlButtons .= "<li>&nbsp;Total: {$this->infoNumRegs} - ({$this->infoCurrentPage}/{$this->infoNumPages})&nbsp;</li>";
        if ($this->infoCurrentPage < $this->infoLastPage) {
            $htmlUlButtons .= "<li><a href=\"javascript:nav_click({$this->infoNextPage});\">&nbsp;&nbsp;»&nbsp;&nbsp;</a></li>";
            $htmlUlButtons .= "<li><a href=\"javascript:nav_click({$this->infoLastPage});\">&nbsp;&nbsp;<span class=\"awe-arrow-right\"></span>&nbsp;&nbsp;</a></li>";
        }

        if ($this->infoNumPages > 1) {
            $htmlUlButtons .= "<li>&nbsp;&nbsp;Go to:&nbsp;&nbsp;{$htmlSelect}</li>";
        }
        $htmlUlButtons .= "</ul>";
        return $htmlUlButtons;
    }

    private function buildUrlNomethod(bool $isByMvc = false): string
    {
        $urlNoMethod = [];
        if ($this->isPermaLink) {
            if (isset($_GET["tfw_iso_language"])) {
                $urlNoMethod[0] = $_GET["tfw_iso_language"];
            }

            if ($isByMvc) {
                if (isset($_GET["tfw_package"])) {
                    $urlNoMethod[1] = $_GET["tfw_package"];
                }
                if (isset($_GET["tfw_controller"])) {
                    $urlNoMethod[2] = $_GET["tfw_controller"];
                }
                if (isset($_GET["tfw_partial"])) {
                    $urlNoMethod[3] = $_GET["tfw_partial"];
                }
            } else {
                if (isset($_GET["tfw_group"])) {
                    $urlNoMethod[1] = $_GET["tfw_group"];
                }
                if (isset($_GET["tfw_module"])) {
                    $urlNoMethod[2] = $_GET["tfw_module"];
                }
                if (isset($_GET["tfw_section"])) {
                    $urlNoMethod[3] = $_GET["tfw_section"];
                }
            }
            return implode("/", $urlNoMethod);
        }

        if (isset($_GET["tfw_iso_language"])) {
            $urlNoMethod[1] = "lang=" . $_GET["tfw_iso_language"];
        }

        if ($isByMvc) {
            if (!empty($_GET["tfw_package"])) {
                $urlNoMethod[1] = "package=" . $_GET["tfw_package"];
            }
            if (!empty($_GET["tfw_controller"])) {
                $urlNoMethod[2] = "controller=" . $_GET["tfw_controller"];
            }
            if (!empty($_GET["tfw_partial"])) {
                $urlNoMethod[3] = "partial=" . $_GET["tfw_partial"];
            }
        } else {
            if (!empty($_GET["tfw_group"])) {
                $urlNoMethod[1] = "group=" . $_GET["tfw_group"];
            }
            if (!empty($_GET["tfw_module"])) {
                $urlNoMethod[2] = "module=" . $_GET["tfw_module"];
            }
            if (!empty($_GET["tfw_section"])) {
                $urlNoMethod[3] = "section=" . $_GET["tfw_section"];
            }
        }
        return implode("&", $urlNoMethod);
    }

    private function buildUrlExtras(): string
    {
        $get = $_GET;
        $remove = [
            "tfw_iso_language", "tfw_group", "tfw_module", "tfw_section", "tfw_view",
            "tfw_package", "tfw_controller", "tfw_partial", "tfw_method",
            "page", "selPage"
        ];

        foreach ($get as $param => $value) {
            if (in_array($param, $remove)) {
                unset($get[$param]);
            }
        }

        if ($this->isPermaLink) {
            return implode("/", $get);
        }

        $urlParts = [];
        foreach ($get as $param => $value) {
            $urlParts[] = "{$param}={$value}";
        }
        return implode("&", $urlParts);
    }

    private function getPaginateView(): string
    {
        $view = $_GET["tfw_view"] ?? "";
        if (!$view) {
            $view = $_GET["tfw_method"] ?? "";
        }
        return $view ?: "get_list";
    }

    protected function loadGetUrls(bool $isByMvc = false): void
    {
        $urlNoMethod = $this->buildUrlNomethod($isByMvc);
        $urlExtras = $this->buildUrlExtras();

        if ($this->isPermaLink) {
            $this->urlNoview = "/{$urlNoMethod}/%replaceview%/";
            $this->urlDelete = "/{$urlNoMethod}/delete/";
            $this->urlUpdate = "/{$urlNoMethod}/update/";
            $this->urlQuarantine = "/{$urlNoMethod}/quarantine/";
            $this->urlPaginate = "/{$urlNoMethod}/";

            if (in_array($_GET["tfw_view"] ?? "", ["multiassign", "singleassign"])) {
                $this->urlPaginate .= "{$_GET["tfw_view"]}/";
            }

            if ($urlExtras) {
                $this->urlNoview .= "{$urlExtras}/";
                $this->urlDelete .= "{$urlExtras}/";
                $this->urlUpdate .= "{$urlExtras}/";
                $this->urlQuarantine .= "{$urlExtras}/";
                $this->urlPaginate .= "{$urlExtras}/";
            }
        } else {
            $this->urlNoview = "?{$urlNoMethod}&view=%replaceview%";
            $this->urlDelete = "?{$urlNoMethod}&view=delete";
            $this->urlUpdate = "?{$urlNoMethod}&view=update";
            $this->urlQuarantine = "?{$urlNoMethod}&view=quarantine";
            $this->urlPaginate = "?{$urlNoMethod}";
            $this->urlPaginate .= "&view=" . $this->getPaginateView();

            if ($urlExtras) {
                $this->urlNoview .= "&{$urlExtras}";
                $this->urlDelete .= "&{$urlExtras}";
                $this->urlUpdate .= "&{$urlExtras}";
                $this->urlQuarantine .= "&{$urlExtras}";
                $this->urlPaginate .= "&{$urlExtras}";
            }
        }
    }

    protected function buildPostkey(): string
    {
        $checkName = "";
        if ($this->doMergePkeys) {
            $checkName = "pkeys";
        } elseif ($this->keyFields) {
            foreach ($this->keyFields as $fldKeyName) {
                $checkName .= $fldKeyName;
            }
        }
        return $checkName;
    }

    protected function lowerFieldnames(array &$rows): void
    {
        $lowered = [];
        if (is_array($rows)) {
            foreach ($rows as $i => $row) {
                $tmpRow = [];
                foreach ($row as $fieldName => $value) {
                    $fieldName = strtolower($fieldName);
                    $tmpRow[$fieldName] = $value;
                }
                $lowered[$i] = $tmpRow;
            }
        }
        $rows = $lowered;
    }

    protected function fixLength(array &$row, string $fieldName): void
    {
        if ($this->hasColumnLength($fieldName)) {
            $value = $row[$fieldName] ?? "";
            $lenVal = strlen($value);
            $lenConf = $this->getColumnLength($fieldName);
            if ($lenVal > $lenConf) {
                $value = substr($value, 0, $lenConf) . "...";
                $row[$fieldName] = $value;
            }
        }
    }

    protected function arrayKeyPosition(string $key, array $array): int
    {
        $keys = array_keys($array);
        $position = array_search($key, $keys);
        return $position !== false ? (int)$position : -1;
    }

    protected function setTmpJs(mixed $values = null): void
    {
        $this->tmpJs = [];
        if (is_array($values)) {
            $this->tmpJs = $values;
        } elseif ($values) {
            $this->tmpJs[] = $values;
        }
    }

    protected function addTmpJs(string $jsString): void
    {
        if ($jsString !== null) {
            $this->tmpJs[] = $jsString;
        }
    }

    public function setColumnDetail(bool $isOn = true): void
    {
        $this->isToDetail = $isOn;
    }

    public function setColumnDelete(bool $isOn = true): void
    {
        $this->isDeleteSingle = $isOn;
    }

    public function setColumnQuarantine(bool $isOn = true): void
    {
        $this->isQuarantineSingle = $isOn;
    }

    public function setColumnPickmultiple(bool $isOn = true): void
    {
        $this->isPickMultiple = $isOn;
    }

    public function mergePks(bool $isOn = true, string $glue = ","): void
    {
        $this->doMergePkeys = $isOn;
        $this->mergeGlue = $glue;
    }

    public function setColumnPicksingle(bool $isOn = true): void
    {
        $this->isPickSingle = $isOn;
    }

    public function setKeyfields(array $keyFields): void
    {
        $this->keyFields = $keyFields;
    }

    public function setOrderby(array $fieldNames): void
    {
        $this->orderBy = $fieldNames;
    }

    public function setOrderbytype(array $orderWay): void
    {
        $this->orderWay = $orderWay;
    }

    public function setUrlDelete(string $url): void
    {
        $this->urlDelete = $url;
    }

    public function setUrlQuarantine(string $url): void
    {
        $this->urlQuarantine = $url;
    }

    public function setUrlUpdate(string $url): void
    {
        $this->urlUpdate = $url;
    }

    public function setUrlPaginate(string $url): void
    {
        $this->urlPaginate = $url;
    }

    public function setUrlPicksingle(string $url): void
    {
        $this->urlPickSingle = $url;
    }

    public function setModule(string $module): void
    {
        $this->module = $module;
    }

    public function setCurrentPage(int $numPage): void
    {
        $this->infoCurrentPage = $numPage;
    }

    public function setNextPage(int $numPage): void
    {
        $this->infoNextPage = $numPage;
    }

    public function setPreviousPage(int $numPage): void
    {
        $this->infoPreviousPage = $numPage;
    }

    public function setTotalRegs(int $numRegs): void
    {
        $this->infoNumRegs = $numRegs;
    }

    public function setTotalPages(int $numPages): void
    {
        $this->infoNumPages = $numPages;
    }

    public function setFirstPage(int $numFirstPage): void
    {
        $this->infoFirstPage = $numFirstPage;
    }

    public function setLastPage(int $numLastPage): void
    {
        $this->infoLastPage = $numLastPage;
    }

    public function setFields(array $objFields): void
    {
        $this->objFields = $objFields;
    }

    public function setOrdenable(bool $isOn = true): void
    {
        $this->isOrdenable = $isOn;
    }

    public function setCheckOnRowclick(bool $isOn = true): void
    {
        $this->isCheckOnRowclick = $isOn;
    }

    public function setMultiassign(array $data): void
    {
        $this->assignMulti = $data;
    }

    public function setSingleassign(array $data): void
    {
        $this->assignSingle = $data;
    }

    public function setMultiadd(array $data): void
    {
        $this->multiAdd = $data;
    }

    public function setSingleadd(array $data): void
    {
        $this->singleAdd = $data;
    }

    public function setFormatColumns(array $format): void
    {
        $this->configColTypes = $format;
    }

    public function addExtraColums(array $data): void
    {
        $this->extraColumns = $data;
    }

    public function setColumnHidden(array $columns): void
    {
        $this->hiddenColumns = $columns;
    }

    public function setExtraHidden(array $columns): void
    {
        $this->extraHidden = $columns;
    }

    public function setItemsPerPage(int $itemsPerPage): void
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    public function setNoPaginatebar(bool $isOn = false): void
    {
        $this->isPaginateBar = $isOn;
    }

    public function setColumnLength(array $columnLength): void
    {
        $this->columnLength = [];
        if ($columnLength) {
            $this->columnLength = $columnLength;
        }
    }

    public function addColumnLength(string $fieldName, int $length): void
    {
        $this->columnLength[$fieldName] = $length;
    }

    protected function getTmpJs(string $glue = "\n"): string
    {
        return implode($glue, $this->tmpJs);
    }

    protected function hasColumnLength(string $fieldName): bool
    {
        $fieldNames = array_keys($this->columnLength);
        return in_array($fieldName, $fieldNames);
    }

    protected function getColumnLength(string $fieldName): int
    {
        return $this->columnLength[$fieldName] ?? 0;
    }
}
