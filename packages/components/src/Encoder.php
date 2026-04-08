<?php

namespace application\modules\Shared\Components;

final class Encoder
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function getArrayAsBase64Encoded(array $array): string
    {
        $jsonString = json_encode($array);
        return $this->getBase64Encoded($jsonString);
    }

    public function getDecodedArrayFromBase64(string $base64Encoded): array
    {
        if (!$this->isBase64String($base64Encoded))
            return [];

        $decodedString = $this->getBase64Decoded($base64Encoded);
        if ($decodedString) {
            $array = json_decode($decodedString, true);
            if (json_last_error() === JSON_ERROR_NONE) return $array;
        }
        return [];
    }

    public function getBase64Encoded(string $string): string
    {
        return base64_encode($string);
    }

    public function getBase64Decoded(string $base64Encoded): string
    {
        $decoded = base64_decode($base64Encoded, true);
        if ($decoded) return $decoded;
        return $base64Encoded;
    }

    public function isBase64String(string $string): bool
    {
        return (base64_encode(base64_decode($string, true)) === $string);
    }

}