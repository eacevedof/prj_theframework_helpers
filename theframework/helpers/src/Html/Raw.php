<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Html\Raw
 */
namespace TheFramework\Helpers\Html;

use TheFramework\Helpers\AbsHelper;

final class Raw extends AbsHelper
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
}
