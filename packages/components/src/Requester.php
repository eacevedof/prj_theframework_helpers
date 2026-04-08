<?php

namespace EduardoAf\Components;

final class Requester
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function getRealIpAddress(): string
    {
        $remoteIp = $_SERVER["REMOTE_ADDR"] ?? "IP unknown";
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $forwardedIps = explode(",", $_SERVER["HTTP_X_FORWARDED_FOR"]);
            $remoteIp = trim($forwardedIps[0]);
        }

        if (strpos($remoteIp, ":") !== false) {
            $ipParts = explode(":", $remoteIp);
            return $ipParts[0];
        }
        return $remoteIp;
    }

}