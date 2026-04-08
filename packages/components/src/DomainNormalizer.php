<?php

namespace application\modules\Shared\Components;

use application\modules\Shared\Components\Traits\LogTrait;

/**
Los servidores DNS solo entienden ASCII: Los sistemas DNS tradicionales solo pueden trabajar con caracteres ASCII básicos (a-z, 0-9, guiones).
No pueden procesar directamente caracteres especiales como "ñ", "á", "ü", etc.
Punycode es el estándar internacional: Para permitir dominios en otros idiomas (chino, árabe, español, etc.),
se creó el estándar Punycode que convierte caracteres Unicode a ASCII.

El prefijo xn--:
    Indica que es un dominio internacionalizado codificado en Punycode.

Ejemplos reales:
    españá.com → xn--espa-rta.com
    müller.de → xn--mller-kva.de
    日本.jp → xn--wgv71a.jp (Japón)
    москва.рф → xn--80adxhks.xn--p1ai (Moscú)
 */
final class DomainNormalizer
{
    use LogTrait;

    public static function getInstance(): self
    {
        return new self();
    }

    public function getDomainSanitizedAsPunycode(string $domain): string
    {
        $domain = trim($domain);
        if ($this->isValidIpAddress($domain)) return $domain;

        if ($this->isAsciiOnly($domain)) {
            return $domain;
        }

        return $this->convertToAsciiWithIdn2($domain);
    }

    private function isValidIpAddress(string $domain): bool
    {
        return filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ||
            filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }

    private function isAsciiOnly(string $domain): bool
    {
        // @note: HAY QUE USAR COMILLAS SIMPLES 
        return preg_match('/^[\x00-\x7F]+$/', $domain) === 1;
    }

    private function convertToAsciiWithIdn2(string $domain): string
    {
        $cmd = "LC_ALL=C.UTF-8 LANG=C.UTF-8 idn2 {$domain} 2>&1";
        $out = trim(shell_exec($cmd));

        if (!$out) {
            $this->logError("idn2 no devolvió salida para: {$domain} (cmd: {$cmd})", __METHOD__);
            return $domain;
        }

        if (stripos($out, "error") !== false || stripos($out, "failed") !== false) {
            $this->logError("Error ejecutando idn2 para {$domain}: {$out}", __METHOD__);
            return $domain;
        }

        return $out;
    }
}
