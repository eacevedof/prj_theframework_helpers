<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Html;

use EduardoAf\Helpers\AbstractHelper;

final class Image extends AbstractHelper
{
    private string $src = "";
    private string $alt = "";
    private string $title = "";

    public function __construct(
        string $src = "",
        string $id = "",
        string $class = "",
        string $style = "",
        array $extras = []
    ) {
        $this->type = "img";
        $this->idPrefix = "";
        $this->id = $id;
        $this->src = $src;
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
        $htmlParts[] = "<{$this->type}";
        if ($this->src) {
            $htmlParts[] = " src=\"{$this->src}\"";
        }
        if ($this->alt) {
            $htmlParts[] = " alt=\"{$this->getEscapedQuot($this->alt)}\"";
        }
        if ($this->title) {
            $htmlParts[] = " title=\"{$this->getEscapedQuot($this->title)}\"";
        }
        if ($this->id) {
            $htmlParts[] = " id=\"{$this->idPrefix}{$this->id}\"";
        }
        $htmlParts = array_merge($htmlParts, $this->getCommonAttributes());
        $htmlParts[] = ">";
        return implode("", $htmlParts);
    }

    public function getOpenTag(): string
    {
        return $this->getHtml();
    }

    public function setSrc(string $url): void
    {
        $this->src = $url;
    }

    public function setAlt(string $value): void
    {
        $this->alt = $value;
    }

    public function setTitle(string $value): void
    {
        $this->title = $value;
    }

    public function showOpenTag(): void
    {
        parent::showOpenTag();
    }

    public function showCloseTag(): void
    {
        parent::showCloseTag();
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
