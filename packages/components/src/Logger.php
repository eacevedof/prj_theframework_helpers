<?php

namespace application\modules\Shared\Components;

final class Logger
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function writeLog(string $filePath, string $content): void
    {
        $htmlPath = realpath(FCPATH);
        $logsFolderPath = realpath( "$htmlPath/../logs");
        $today = date("Y-m-d");
        $logFilePath =  "$logsFolderPath/$filePath";

        $pathInfo = pathinfo($logFilePath);
        $finalDir = $pathInfo["dirname"];
        if (!is_dir($finalDir))
            mkdir($finalDir, 0777, true);

        $fileName = $pathInfo["filename"];
        $ext = $pathInfo["extension"] ?? "log";
        if (strstr($filePath, "sql")) $ext = "sql";
        $fileName = "$today-$fileName";

        $now = date("Y-m-d H:i:s");
        $logFilePath = "{$finalDir}/{$fileName}.{$ext}";
        $content = trim($content);

        if ($ext === "sql") $content = $this->getNormalizedMarginForSql($content);

        file_put_contents($logFilePath, "\n[$now]\n$content", FILE_APPEND);
    }

    private function getNormalizedMarginForSql(string $content): string
    {
        $content = "$content\n";
        return preg_replace("/^ {8}/m", "", $content);
    }

}