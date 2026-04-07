<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Html\Table\Raw
 */
namespace TheFramework\Helpers\Html\Table;

use TheFramework\Helpers\AbstractHelper;

final class Raw extends AbstractHelper
{
    protected array $labels = [];
    protected array $rows = [];

    public function __construct(array $rows = [], array $labels = [])
    {
        $this->idPrefix = "";
        $this->type = "table";
        $this->rows = $rows;
        $this->labels = $labels;
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

    public function getHtml(): string
    {
        $htmlParts = [];
        $htmlParts[] = $this->getOpenTag() . "\n";

        if (!$this->labels && isset($this->rows[0]) && is_array($this->rows[0])) {
            $this->labels = array_keys($this->rows[0]);
        }

        if ($this->labels) {
            $htmlParts[] = "<tr>";
            foreach ($this->labels as $label) {
                $htmlParts[] = "<th>{$label}</th>";
            }
            $htmlParts[] = "</tr>\n";
        }

        if ($this->rows) {
            foreach ($this->rows as $row) {
                $htmlParts[] = "<tr>";
                foreach ($row as $value) {
                    $htmlParts[] = "<td>{$value}</td>";
                }
                $htmlParts[] = "</tr>\n";
            }
        }

        $htmlParts[] = "</table>";
        return implode("", $htmlParts);
    }

    public function setData(array $rows): void
    {
        $this->rows = $rows;
    }

    public function setLabels(array $labels): void
    {
        $this->labels = $labels;
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
