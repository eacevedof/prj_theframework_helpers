<?php

namespace App\Shared\Infrastructure\Components\Request;

final class RequestComponent
{
    public function get_post($sKey=null, $default=null)
    {
        if(!$sKey) return $_POST ?? [];
        return $_POST[$sKey] ?? $default;
    }

    public function get_get($sKey=null, $default=null)
    {
        if(!$sKey) return $_GET ?? [];
        return $_GET[$sKey] ?? $default;
    }

    public function get_request($sKey=null, $default=null)
    {
        if(!$sKey) return $_REQUEST ?? [];
        return $_REQUEST[$sKey] ?? $default;
    }

    public function get_files($sKey=null)
    {
        if(!$sKey) return $_FILES ?? [];
        return $_FILES[$sKey] ?? null;
    }

    public function get_remote_ip(): string
    {
        if ($ip = ($_SERVER["HTTP_CLIENT_IP"] ?? "")) return $ip;
        if ($ip = ($_SERVER["HTTP_X_FORWARDED_FOR"] ?? "")) return $ip;
        if ($ip = $_SERVER["REMOTE_ADDR"]) return $ip;
        return "127.0.0.1";
    }

    public function get_lang(): string
    {
        return $_REQUEST["lang"] ?? "en";
    }

    public function set_lang(string $lang="en"): void
    {
        $_REQUEST["lang"] = $lang;
    }

    public function is_post($sKey=null): bool { return $sKey ? isset($_POST[$sKey]) : count($_POST)>0;}

    public function is_get($sKey=null): bool { return $sKey ? isset($_GET[$sKey]) : count($_GET)>0;}

    public function is_file($sKey=null): bool { return $sKey ? isset($_FILES[$sKey]) : count($_FILES)>0;}

    public function get_method(){ return strtolower($_SERVER["REQUEST_METHOD"]) ?? "";}

    public function is_put(): bool { return $this->get_method()==="put";}

    public function is_patch(): bool { return $this->get_method()==="patch";}

    public function is_delete(): bool { return $this->get_method()==="delete";}

    public function is_postm(): bool { return $this->get_method()==="post";}

    public function get_header($key=null): ?string
    {
        $all = getallheaders();
        if(!$key) return $all;
        foreach ($all as $k=>$v)
            if(strtolower($k) === strtolower($key))
                return $v;
        return null;
    }

    public function get_referer(): ?string
    {
        return $_SERVER["HTTP_REFERER"] ?? null;
    }

    public function get_request_uri(): ?string
    {
        return $_SERVER["REQUEST_URI"] ?? null;
    }

    public function get_redirect(): ?string
    {
        return $this->get_get("redirect");
    }

    public function is_accept_json(): bool
    {
        $accept = $this->get_header("accept");
        $accept = strtolower($accept);
        return strstr($accept,"application/json");
    }

}