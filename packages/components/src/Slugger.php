<?php

namespace EduardoAf\Components;

final class Slugger
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function getSluggedText(string $text): string
    {
        $slug = strtolower(trim($text));
        $slug = strtr($slug, [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u',
            'ü' => 'u', 'Ü' => 'u', 'ñ' => 'n', 'Ñ' => 'n'
        ]);
        $slug = preg_replace("/[^a-z0-9]+/", "-", $slug);
        $slug = preg_replace("/^-+|-+$/", "", $slug);
        return $slug;
    }
}