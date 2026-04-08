<?php

namespace application\modules\Shared\Components;

use Exception;

final class TplReader
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function getFileContent(string $filename, array $vars): string
    {
        if (!file_exists($filename))
            throw new Exception("TplReader: file not found: $filename");

        ob_start();

        extract($vars);
        include $filename;

        return ob_get_clean();
    }
}