<?php

namespace Dsoloview\Checkers\Entities;

use Dsoloview\Checkers\Enums\Color;

class Checker implements \JsonSerializable
{
    private Color $color;
    private Coordinates $coordinates;

    public function __construct(Color $color, Coordinates $coordinates)
    {
        $this->color = $color;
        $this->coordinates = $coordinates;
    }

    public function getColor(): Color
    {
        return $this->color;
    }

    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    public function setCoordinates(Coordinates $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

    public function jsonSerialize(): array
    {
        return [
            'color' => $this->color,
            'coordinates' => $this->coordinates
        ];
    }
}