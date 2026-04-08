<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Form;

use EduardoAf\Helpers\AbstractHelper;

final class Fieldset extends AbstractHelper
{
    private const TYPE = "fieldset";

    public function __construct(
        string $innerHtml = "",
        string $id = "",
        string $class = "",
        string $style = "",
        array $extras = []
    ) {
        $this
            ->setType(self::TYPE)
            ->setId($id)
            ->setInnerHtml($innerHtml)
            ->setClass($class)
            ->setStyle($style)
            ->setExtras($extras)
        ;
    }

    public function getHtml(): string
    {
        $htmlParts = [];
        if ($this->comment) {
            $htmlParts[] = "<!-- {$this->comment} -->\n";
        }
        $htmlParts[] = $this->getOpenTag();
        $this->loadInnerObjects();
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
        $openTagParts = array_merge($openTagParts, $this->getJsEventAttributes());
        $openTagParts = array_merge($openTagParts, $this->getStyleAttributes());
        $openTagParts = array_merge($openTagParts, $this->getExtraAttributes());
        $openTagParts[] = ">";
        return implode("", $openTagParts);
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
