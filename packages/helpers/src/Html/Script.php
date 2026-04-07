<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Html\Script
 */
namespace TheFramework\Helpers\Html;

use TheFramework\Helpers\AbstractHelper;
use TheFramework\Helpers\Enums\HtmlTypeEnum;

final class Script extends AbstractHelper
{
    private string $tag = HtmlTypeEnum::SCRIPT;
    private array $sources = [];
    private array $publicFiles = [];

    public function __construct(string $type = "")
    {
        $this->idPrefix = "";
        $this->type = $type;
    }

    public function getOpenTag(): string
    {
        $openTagParts = [];
        $openTagParts[] = "<{$this->tag}";
        if ($this->id) {
            $openTagParts[] = " id=\"{$this->idPrefix}{$this->id}\"";
        }
        if ($this->extras) {
            $openTagParts[] = " " . $this->getExtras();
        }
        $openTagParts[] = ">\n";
        return implode("", $openTagParts);
    }

    public function getCloseTag(): string
    {
        return "\n</{$this->tag}>";
    }

    public function getHtml(): string
    {
        $htmlParts = [];
        $htmlParts[] = $this->getOpenTag();
        $this->loadInnerObjectsWithSeparator("\n");
        $htmlParts[] = $this->innerHtml;
        $htmlParts[] = $this->getCloseTag();
        return implode("", $htmlParts);
    }

    private function loadInnerObjectsWithSeparator(string $separator): void
    {
        $innerParts = [];
        foreach ($this->innerHelpers as $innerValue) {
            if (is_object($innerValue) && method_exists($innerValue, "getHtml")) {
                $innerParts[] = $innerValue->getHtml();
            }
            elseif (is_string($innerValue)) {
                $innerParts[] = $innerValue;
            }
        }
        if ($innerParts) {
            $this->innerHtml .= implode($separator, $innerParts);
        }
    }

    public function getHtmlSrc(): string
    {
        $htmlParts = [];
        foreach ($this->sources as $source) {
            $tmpParts = [];
            if ($this->type) {
                $tmpParts[] = "type=\"{$this->type}\"";
            }

            if (is_string($source)) {
                $tmpParts[] = "src=\"{$source}\"";
                $htmlParts[] = "<" . HtmlTypeEnum::SCRIPT . " " . implode(" ", $tmpParts) . "></" . HtmlTypeEnum::SCRIPT . ">";
            }
            elseif (is_array($source)) {
                foreach ($source as $key => $value) {
                    $tmpParts[] = "{$key}=\"{$value}\"";
                }
                $htmlParts[] = "<" . HtmlTypeEnum::SCRIPT . " " . implode(" ", $tmpParts) . "></" . HtmlTypeEnum::SCRIPT . ">";
            }
        }
        return implode("\n", $htmlParts);
    }

    private function moveFile(string $from, string $to, string $mode): void
    {
        switch ($mode) {
            case "c":
                if (is_file($from) && !is_file($to)) {
                    copy($from, $to);
                }
                break;

            case "rw":
                if (is_file($from) && is_file($to)) {
                    unlink($to);
                    copy($from, $to);
                }
                break;
        }
    }

    public function moveToPublic(): void
    {
        foreach ($this->publicFiles as $publicFile) {
            $from = $publicFile["from"];
            $to = $publicFile["to"];
            $mode = $publicFile["mode"];
            $this->moveFile($from, $to, $mode);
        }
    }

    public function setSrc(array $sources = []): void
    {
        $this->sources = $sources;
    }

    public function addSrc(string $src): void
    {
        $this->sources[] = $src;
    }

    public function addSrcExt(string $src, array $extra = []): void
    {
        $this->sources[] = array_merge(["src" => $src], $extra);
    }

    public function addPublic(string $pathFrom, string $pathTo, string $mode = "c"): void
    {
        if ($pathFrom && $pathTo) {
            $this->publicFiles[] = ["from" => $pathFrom, "to" => $pathTo, "mode" => $mode];
        }
    }

    public function showOpenTag(): void
    {
        echo $this->getOpenTag();
    }

    public function showCloseTag(): void
    {
        echo $this->getCloseTag();
    }

    public function showHtmlSrc(): void
    {
        echo $this->getHtmlSrc();
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
