<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Html\Link
 */
namespace TheFramework\Helpers\Html;

use TheFramework\Helpers\AbstractHelper;

final class Link extends AbstractHelper
{
    private string $mediaType = "text/css";
    private string $rel = "stylesheet";
    private array $hrefs = [];

    public function __construct(
        array $hrefs = [],
        string $type = "text/css",
        string $rel = "stylesheet"
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
                $htmlParts[] = "<link type=\"{$this->mediaType}\" rel=\"{$this->rel}\" href=\"{$hrefPath}\">\n";
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
}
