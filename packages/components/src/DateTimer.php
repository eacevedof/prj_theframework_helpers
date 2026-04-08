<?php

namespace EduardoAf\Components;

use DateTime;

final class DateTimer
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function getDateTimeAsYmd(string $strDateTime): string
    {
        if (!$strDateTime) {
            return "";
        }
        $date = new DateTime($strDateTime);
        return $date->format('Y-m-d');
    }

}
