<?php

namespace EduardoAf\Helpers\Enums;

final class InputTypeEnum
{
    public const TEXT = "text";
    public const PASSWORD = "password";
    public const EMAIL = "email";
    public const NUMBER = "number";
    public const TEL = "tel";
    public const URL = "url";
    public const HIDDEN = "hidden";
    public const CHECKBOX = "checkbox";
    public const RADIO = "radio";
    public const FILE = "file";
    public const SUBMIT = "submit";
    public const RESET = "reset";
    public const BUTTON = "button";
    public const DATE = "date";
    public const DATETIME_LOCAL = "datetime-local";
    public const TIME = "time";
    public const MONTH = "month";
    public const WEEK = "week";
    public const COLOR = "color";
    public const RANGE = "range";
    public const SEARCH = "search";

    private function __construct()
    {
    }
}
