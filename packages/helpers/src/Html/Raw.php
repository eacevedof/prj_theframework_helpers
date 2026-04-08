<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Html;

use EduardoAf\Helpers\AbstractHelper;

final class Raw extends AbstractHelper
{
    public function __construct(string $rawHtml = "")
    {
        $this->innerHtml = $rawHtml;
    }

    public function getHtml(): string
    {
        $this->loadInnerObjects();
        return $this->innerHtml;
    }

    public function getOpenTag(): string
    {
        return $this->getHtml();
    }

    public function setRawHtml(string $rawHtml, bool $asEntity = false): void
    {
        $this->setInnerHtml($rawHtml, !$asEntity);
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
