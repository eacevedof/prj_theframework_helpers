<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name TheFramework\Helpers\IHelper
 */
namespace TheFramework\Helpers;

interface IHelper
{
    public function getHtml(): string;

    public function show(): void;
}
