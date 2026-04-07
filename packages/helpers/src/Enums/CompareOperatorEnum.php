<?php

namespace TheFramework\Helpers\Enums;

final class CompareOperatorEnum
{
    public const EQUAL = "=";
    public const NOT_EQUAL = "!=";
    public const LESS_THAN = "<";
    public const GREATER_THAN = ">";
    public const LESS_OR_EQUAL = "<=";
    public const GREATER_OR_EQUAL = ">=";

    private function __construct()
    {
    }
}
