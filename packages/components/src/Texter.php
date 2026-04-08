<?php

namespace EduardoAf\Components;

final class Texter
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function getSanitizedPrimitives(array $primitives): array
    {
        return array_map(function ($value) {
            $value = $this->getSanitizedText($value);
            if (empty($value)) {
                return null;
            }
            return $value;
        }, $primitives);
    }

    public function getSanitizedText(?string $text): ?string
    {
        if (is_null($text)) return null;
        if (!trim($text)) return "";

        $text = strip_tags($text);//remove html tags
        $text = preg_replace("/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ@.,_\- \n#|+\/:]/", " ", $text);
        $text = preg_replace("/[^\S\r\n]+/", " ", $text);
        return trim($text);
    }

    public function getTextAsUtf8FromHtml(string $htmlText): string
    {
        $utf8Text = html_entity_decode($htmlText, ENT_QUOTES | ENT_HTML5, "UTF-8");
        return $this->getHardReplace($utf8Text);
    }

    public function getHmtDecode(?string $htmlText): ?string
    {
        if (is_null($htmlText)) return null;
        if (!$htmlText = trim($htmlText)) return "";
        return htmlspecialchars_decode(html_entity_decode($htmlText));
    }

    private function getHardReplace(string $htmlText): string
    {
        $vocals = [
            "&aacute;" => "á",
            "&eacute;" => "é",
            "&iacute;" => "í",
            "&oacute;" => "ó",
            "&uacute;" => "ú",
            "&amp;" => "&",
            "&quot;" => "\"",
        ];
        return str_replace(
            array_keys($vocals),
            array_values($vocals),
            $htmlText
        );
    }

}