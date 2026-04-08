<?php

namespace EduardoAf\Components;

use Exception;

final class TplReplacer
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function getFileContent(string $absFilePath, array $replaces): string
    {
        $absFilePath = realpath($absFilePath);
        if (!file_exists($absFilePath))
            throw new Exception("TplReplacer: file not found: $absFilePath");

        $content = file_get_contents($absFilePath);
        foreach ($replaces as $tag => $replace) {
            if (is_array($replace)) {
                $replace = implode(", ", $replace);
            }
            $content = str_replace($tag, $replace, $content);
        }
        return $content;
    }
}