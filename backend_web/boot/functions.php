<?php

//functions.php 20200721
function dd($var,$title=""){
    $sContent= var_export($var,1);
    if($title) echo "<b style=\"font-size: small; font-family: 'Roboto', 'sans-serif'\">$title</b>";
    echo "<pre style=\"background:greenyellow;border:1px solid;\">"
        .$sContent
        ."</pre>";
    exit;
}

function lgerr($var, $title=null)
{
    $dlog = date("Ymd");
    $sNow = date("Y-m-d_H:i:s");
    if($title) $title = "<<  $title >>";
    $ip = $_SERVER["REMOTE_ADDR"] ?? "";
    $title = PHP_EOL."$sNow - $ip: (lgerr) $title";
    if(!is_string($var)) $var = var_export($var,1);
    if($var) $var = PHP_EOL.$var.PHP_EOL;
    $var = $title.$var;
    $sPathFile = BOOT::PATH_LOGS."/error/";
    if (!is_dir($sPathFile)) mkdir($sPathFile, 0775, 1);
    $sPathFile .= "app_$dlog.log";
    $oCursor=fopen($sPathFile,"ab");
    fwrite($oCursor,$var);
    fclose($oCursor);
}

function appboot_loadenv(): void
{
    $arpaths = [
        "%PATH_PUBLIC%" => BOOT::PATH_PUBLIC, "%PATH_ROOT%" => BOOT::PATH_ROOT,
        "%PATH_SRC%" => BOOT::PATH_SRC, "%PATH_SRC_CONFIG%" => BOOT::PATH_SRC_CONFIG
    ];
    
    $arEnvs = [
        ENV::LOCAL => ".env.".ENV::LOCAL,
        ENV::DEV => ".env.".ENV::DEV,
        ENV::TEST => ".env.".ENV::TEST,
        ENV::PROD => ".env",
    ];

    foreach ($arEnvs as $envtype => $envfile) {
        $pathenv = BOOT::PATH_ROOT."/$envfile";
        if (is_file($pathenv)) {
            $content = file_get_contents($pathenv);
            $lines = explode(PHP_EOL, $content);

            foreach ($lines as $strline) {
                if (strstr($strline, "=")) {
                    $keyval = explode("=", $strline);
                    $key = trim($keyval[0]);
                    if ($key) {
                        $value = trim($keyval[1] ?? "");
                        $value = str_replace(array_keys($arpaths), array_values($arpaths), $value);
                        putenv(sprintf("%s=%s", $key, $value));
                        $_ENV[$key] = $value;
                    }
                }//if line has =
            }//foreach lines
            return;
        }//if is file
    }//foreach envs

    $_SERVER += $_ENV;
}

function __(string $msgid): string
{
    if (!$msgid = trim($msgid)) return "";
    $args = func_get_args();
    array_shift($args);
    $msgchanged = $msgid;
    foreach ($args as $i => $str) {
        $rep = "{".$i."}";
        $msgchanged = str_replace($rep, $str, $msgchanged);
    }

    $lang = strtolower(trim($_REQUEST["lang"] ?? "en"));
    if ($lang === "en") return $msgchanged;

    $pathpo = PATH_ROOT."/locale/$lang/default.po";
    if(!is_file($pathpo)) return $msgchanged;

    if(!($_REQUEST["APP_TRANSLATIONS"][$lang] ?? [])) {
        $content = file_get_contents($pathpo);
        $content = trim($content);
        if (!$content) return $msgchanged;

        $lines = explode(PHP_EOL, $content);

        $trs = [];
        foreach ($lines as $i => $line) {

            if (!$line = trim($line)) continue;
            if (str_starts_with($line, "#")) continue;
            if (strstr($line, "msgstr \"")) continue;

            $id = str_replace("msgid \"","", $line);
            $id = substr($id, 0, -1);
            $id = str_replace("\\\"","\"", $id);

            $tr = trim($lines[$i+1] ?? "");
            $tr = str_replace("msgstr \"","", $tr);
            $tr = substr($tr, 0, -1);
            $tr = str_replace("\\\"","\"", $tr);

            $trs[$id] = $tr;
        }
        $_REQUEST["APP_TRANSLATIONS"][$lang] = $trs;
        unset($lines, $trs);
    }

    $msgchanged = ($_REQUEST["APP_TRANSLATIONS"][$lang][$msgid] ?? "") ?: $msgid;

    foreach ($args as $i => $str) {
        $rep = "{".$i."}";
        $msgchanged = str_replace($rep, $str, $msgchanged);
    }

    return $msgchanged;
}