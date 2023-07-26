<?php

namespace Dsoloview\Checkers\Enums;

trait ExtendedEnumTrait
{
    public static function getValues(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}