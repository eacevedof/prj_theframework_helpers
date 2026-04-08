<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Html\Xl;

use EduardoAf\Helpers\AbstractHelper;

final class Xl extends AbstractHelper
{
    protected array $objLi = [];

    public function __construct(string $innerHtml = "", string $id = "", array $objLi = [])
    {
        $this->idPrefix = "";
        $this->type = "ul";
        $this->id = $id;
        $this->innerHtml = $innerHtml;
        $this->objLi = $objLi;
    }

    public function getHtml(): string
    {
        $htmlParts = [];
        if (!$this->innerHtml) {
            $this->innerHtml = $this->getArrayLiAsString();
        }
        if ($this->comment) {
            $htmlParts[] = "<!-- {$this->comment} -->\n";
        }
        $htmlParts[] = $this->getOpenTag();
        $htmlParts[] = $this->innerHtml;
        $htmlParts[] = $this->getCloseTag();
        return implode("", $htmlParts);
    }

    private function getArrayLiAsString(): string
    {
        $liString = "";
        foreach ($this->objLi as $li) {
            if (is_object($li) && method_exists($li, "getHtml")) {
                $liString .= $li->getHtml();
            } elseif (is_string($li)) {
                $liString .= $li;
            }
        }
        return $liString;
    }

    public function getOpenTag(): string
    {
        $openTagParts = [];
        $openTagParts[] = "<{$this->type}";
        if ($this->id) {
            $openTagParts[] = " id=\"{$this->idPrefix}{$this->id}\"";
        }
        if ($this->disabled) {
            $openTagParts[] = " disabled";
        }
        if ($this->readonly) {
            $openTagParts[] = " readonly";
        }
        if ($this->isRequired) {
            $openTagParts[] = " required";
        }
        $openTagParts = array_merge($openTagParts, $this->getJsEventAttributes());
        $openTagParts = array_merge($openTagParts, $this->getStyleAttributes());
        $openTagParts = array_merge($openTagParts, $this->getExtraAttributes());
        $openTagParts[] = ">\n";
        return implode("", $openTagParts);
    }

    public function setArrayLi(array $objLi): void
    {
        $this->objLi = $objLi;
    }

    public function addLi(mixed $li): void
    {
        $this->objLi[] = $li;
    }

    public function getArrayLi(): array
    {
        return $this->objLi;
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
