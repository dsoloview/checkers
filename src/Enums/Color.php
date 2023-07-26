<?php

namespace Dsoloview\Checkers\Enums;

enum Color
{
    case White;
    case Black;

    public function getShape(): string
    {
        return match ($this) {
            self::White => '⚫',
            self::Black => '⚪',
        };
    }
}
