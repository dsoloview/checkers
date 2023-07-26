<?php

namespace Dsoloview\Checkers\Enums;

enum Column: string
{
    use ExtendedEnumTrait;
    case A = 'A';
    case B = 'B';
    case C = 'C';
    case D = 'D';
    case E = 'E';
    case F = 'F';
    case G = 'G';
    case H = 'H';

    public function next(): ?Column
    {
        return match ($this) {
            self::A => self::B,
            self::B => self::C,
            self::C => self::D,
            self::D => self::E,
            self::E => self::F,
            self::F => self::G,
            self::G => self::H,
            self::H => null,
        };
    }

    public function previous(): ?Column
    {
        return match ($this) {
            self::A => null,
            self::B => self::A,
            self::C => self::B,
            self::D => self::C,
            self::E => self::D,
            self::F => self::E,
            self::G => self::F,
            self::H => self::G,
        };
    }
}
