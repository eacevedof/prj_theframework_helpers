<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Html;

use EduardoAf\Helpers\AbstractHelper;
use EduardoAf\Helpers\Enums\HtmlTypeEnum;
use EduardoAf\Helpers\Enums\LinkRelEnum;
use EduardoAf\Helpers\Enums\MediaTypeEnum;

final class Link extends AbstractHelper
{
    private string $mediaType = MediaTypeEnum::TEXT_CSS;
    private string $rel = LinkRelEnum::STYLESHEET;
    private array $hrefs = [];

    public function __construct(
        array $hrefs = [],
        string $type = MediaTypeEnum::TEXT_CSS,
        string $rel = LinkRelEnum::STYLESHEET
    ) {
        $this->mediaType = $type;
        $this->rel = $rel;
        $this->hrefs = $hrefs;
    }

    public function getHtml(): string
    {
        $htmlParts = [];
        foreach ($this->hrefs as $hrefPath) {
            if ($hrefPath) {
                $htmlParts[] = "<" . HtmlTypeEnum::LINK . " type=\"{$this->mediaType}\" rel=\"{$this->rel}\" href=\"{$hrefPath}\">\n";
            }
        }
        return implode("", $htmlParts);
    }

    public function getOpenTag(): string
    {
        return $this->getHtml();
    }

    public function show(): void
    {
        echo $this->getHtml();
    }

    public function addHref(string $filePath): void
    {
        $this->hrefs[] = $filePath;
    }

    public function setHrefs(array|string $hrefs): void
    {
        $this->hrefs = [];
        if (is_array($hrefs)) {
            $this->hrefs = $hrefs;
        }
        else {
            $this->hrefs[] = $hrefs;
        }
    }

    public function getHrefs(): array
    {
        return $this->hrefs;
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
