<?php

namespace Dsoloview\Checkers\Enums;

enum Row: int
{
    use ExtendedEnumTrait;
    case One = 1;
    case Two = 2;
    case Three = 3;
    case Four = 4;
    case Five = 5;
    case Six = 6;
    case Seven = 7;
    case Eight = 8;

    public static function reversedCases(): array
    {
        return array_reverse(self::cases());
    }

    public function next(): ?Row
    {
        return match ($this) {
            self::One => self::Two,
            self::Two => self::Three,
            self::Three => self::Four,
            self::Four => self::Five,
            self::Five => self::Six,
            self::Six => self::Seven,
            self::Seven => self::Eight,
            self::Eight => null,
        };
    }

    public function previous(): ?Row
    {
        return match ($this) {
            self::One => null,
            self::Two => self::One,
            self::Three => self::Two,
            self::Four => self::Three,
            self::Five => self::Four,
            self::Six => self::Five,
            self::Seven => self::Six,
            self::Eight => self::Seven,
        };
    }
}
