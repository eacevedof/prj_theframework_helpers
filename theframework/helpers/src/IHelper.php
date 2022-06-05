<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name TheFramework\Helpers\IHelper
 */
namespace TheFramework\Helpers;

interface IHelper
{
    public function get_html(): string;

    public function show(): void;

    public function add(IHelper $helper): void;
}