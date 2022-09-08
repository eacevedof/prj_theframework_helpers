<?php

namespace App\Shared\Infrastructure\Components\Translation;

use \BOOT;
use App\Shared\Infrastructure\Services\AppService;

final class TranslationComponent extends AppService
{
    private const FIND_TR_PATTERNS = [
        "\_\_\(\"(.*?)\"",
    ];

    private const PATH_SRC = BOOT::PATH_SRC;
    private const PATH_TR_ES = BOOT::PATH_ROOT."/locale/es/default.po";

    private array $arfiles;
    private array $skipfolders;
    private array $trs;

    public function __construct(array $input)
    {
        $this->input = $input;
        $this->arfiles = [];
        $this->skipfolders = [];
        $this->trs = [];
    }

    public static function get_self(array $body=[]): self
    {
        return new self($body["input"] ?? []);
    }

    public function _get_files(string $pathdir): array
    {
        $files = scandir($pathdir);
        if(count($files)<3) return [];
        unset($files[0]); unset($files[1]);
        return array_map(
            function ($file) use ($pathdir) {
                return "$pathdir/$file";
            },
            array_values($files)
        );
    }

    private function _load_files(string $path): void
    {
        $files = $this->_get_files($path);
        foreach ($files as $file) {
            if(in_array($file, $this->skipfolders)) continue;
            if (is_file($file)) $this->arfiles[] = $file;
            if (is_dir($file)) $this->_load_files($file);
        }
    }

    private function _get_trs(string $content, string $pattern): array
    {
        $pattern = "/$pattern/m";
        $matches = [];
        preg_match_all($pattern, $content, $matches);
        $result = $matches[1] ?? [];
        return array_unique($result);
    }

    private function _add_trs(array $trs): void
    {
        foreach ($trs as $tr) $this->trs[] = $tr;
    }

    private function _get_missing_es(): array
    {
        $estrs = file_get_contents(self::PATH_TR_ES);
        $missing = [];
        foreach ($this->trs as $tr) {
            if (strstr($estrs, $tr) || trim($tr)==="") continue;
            $missing[] = "msgid \"$tr\"";
            $missing[] = "msgstr \"$tr\"";
        }
        return $missing;
    }

    private function _get_not_used_es(): array
    {
        $estrs = file_get_contents(self::PATH_TR_ES);
        $lines = explode("\n", $estrs);
        $lines = array_filter($lines, function ($line){
           return strstr($line, "msgid \"");
        });

        $lines = array_map(function ($line){
            $line = substr($line, 0, -1);
            return str_replace("msgid \"", "", $line);
        }, $lines);

        $missing = [];
        foreach ($lines as $i => $line) {
            if (!in_array($line, $this->trs))
                $missing[] = "$line ({$i})";
        }

        return $missing;
    }

    private function _get_repeated(): array
    {
        $estrs = file_get_contents(self::PATH_TR_ES);
        $lines = explode("\n", $estrs);
        $lines = array_filter($lines, function ($line){
            return strstr($line, "msgid \"");
        });

        $lines = array_map(function ($line){
            $line = substr($line, 0, -1);
            return str_replace("msgid \"", "", $line);
        }, $lines);

        $count = array_count_values($lines);
        $count = array_filter($count, function ($num){
            return $num>1;
        });
        $count = array_keys($count);

        $found = [];
        foreach ($lines as $i=>$line)
            if (in_array($line, $count))
                $found[] = "$line ({$i})";

        return $found;
    }

    private function _load_all_inoked_translations(): void
    {
        foreach ($this->arfiles as $path) {
            $content = file_get_contents($path);
            if (!strstr($content, "__(\"")) continue;
            foreach (self::FIND_TR_PATTERNS as $pattern) {
                $trs = $this->_get_trs($content, $pattern);
                $this->_add_trs($trs);
            }
        }
        $trs = array_values(array_unique($this->trs));
        $this->trs = $trs;
    }

    public function run(): void
    {
        $this->_load_files(self::PATH_SRC);
        $this->_load_all_inoked_translations();

        $parameter = trim($this->input[0] ?? "");
        switch ($parameter) {
            case "--not-used":
                $found = $this->_get_not_used_es();
            break;
            case "--repeated":
                $found = $this->_get_repeated();
            break;
            default:
                $found = $this->_get_missing_es();
            break;
        }

        foreach ($found as $tr)
            print_r($tr."\n");
    }
}