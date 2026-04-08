<?php

namespace application\modules\Shared\Components;

final class Curler
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function getCurlGet(string $url): array
    {
        $curlObj = curl_init();
        curl_setopt_array($curlObj, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 120
        ]);
        $jsonResponse = curl_exec($curlObj);
        $error = curl_error($curlObj);
        $statusCode = (int) curl_getinfo($curlObj, CURLINFO_HTTP_CODE);

        curl_close($curlObj);

        return [
            "url" => $url,
            "status_code" => $statusCode,
            "error" => $error,
            "response" => $jsonResponse,
        ];
    }

    public function getCurlByOptions(array $curlOptions): array
    {
        $curlObj = curl_init();
        curl_setopt_array($curlObj, $curlOptions);
        $jsonResponse = curl_exec($curlObj);
        $error = curl_error($curlObj);
        $statusCode = (int) curl_getinfo($curlObj, CURLINFO_HTTP_CODE);
        curl_close($curlObj);

        return [
            "url" => $curlOptions[CURLOPT_URL] ?? "",
            "status_code" => $statusCode,
            "error" => $error,
            "response" => $jsonResponse,
        ];
    }

    public function getCurlGetWithHeaders(string $url, array $headers): array
    {
        $curlObj = curl_init();
        curl_setopt_array($curlObj, [
            CURLOPT_URL            => $url,
            CURLOPT_HTTPAUTH       => CURLAUTH_ANY,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_HEADER         => false,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER     => $this->getHeadersAsTextLine($headers),
        ]);

        $jsonResponse = curl_exec($curlObj);
        $error = curl_error($curlObj);
        $statusCode = curl_getinfo($curlObj, CURLINFO_HTTP_CODE);
        curl_close($curlObj);

        return [
            "url" => $url,
            "status_code" => $statusCode,
            "error" => $error,
            "response" => $jsonResponse,
        ];
    }

    private function getHeadersAsTextLine(array $headers): array
    {
        $headerTexts = [];
        foreach ($headers as $key => $value) {
            $headerTexts[] = "$key: $value";
        }
        return $headerTexts;
    }

    public function getCurlStatus(string $url): array
    {
        $curlObj = curl_init();
        curl_setopt_array($curlObj, [
            CURLOPT_URL => $url,
            CURLOPT_NOBODY => true,
            CURLOPT_TIMEOUT => 30
        ]);
        $jsonResponse = curl_exec($curlObj);
        $error = curl_error($curlObj);
        $statusCode = (int) curl_getinfo($curlObj, CURLINFO_HTTP_CODE);
        curl_close($curlObj);

        return [
            "url" => $url,
            "status_code" => $statusCode,
            "error" => $error,
            "response" => $jsonResponse,
        ];
    }

}