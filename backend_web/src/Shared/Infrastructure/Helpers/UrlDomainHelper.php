<?php
namespace App\Shared\Infrastructure\Helpers;

final class UrlDomainHelper extends AppHelper implements IHelper
{
    private string $env;
    private string $domain;

    public function __construct()
    {
        $this->env = getenv("APP_ENV");
        $this->domain = getenv("APP_DOMAIN");
    }

    public static function get_self(): self
    {
        return new self();
    }

    private function _get_full_url(): string
    {
        return match ($this->env) {
            "local" => "http://$this->domain",
            default => "https://$this->domain",
        };
    }

    public function get_full_url(?string $append=null): string
    {
        $url = $this->_get_full_url();
        if (is_null($append)) return $url;
        return str_starts_with($append, "/") ? "$url$append" : "$url/$append";
    }
}
