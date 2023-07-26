<?php

namespace Dsoloview\Checkers\Entities;

use Dsoloview\Checkers\Enums\Column;
use Dsoloview\Checkers\Enums\Row;

class Coordinates implements \JsonSerializable
{
    private Row $row;
    private Column $column;

    public function __construct(Row $row, Column $column)
    {
        $this->row = $row;
        $this->column = $column;
    }

    public function getColumn(): Column
    {
        return $this->column;
    }

    public function getRow(): Row
    {
        return $this->row;
    }


    public function jsonSerialize(): array
    {
        return [
            'row' => $this->row,
            'column' => $this->column
        ];
    }

    public function toString(): string
    {
        return $this->column->value . $this->row->value;
    }

    public function __toString(): string
    {
        return  $this->column->value . $this->row->value;
    }
}