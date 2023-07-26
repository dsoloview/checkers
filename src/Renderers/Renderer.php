<?php

namespace Dsoloview\Checkers\Renderers;

use Dsoloview\Checkers\Entities\Board;
use Dsoloview\Checkers\Entities\Coordinates;
use Dsoloview\Checkers\Enums\Column;
use Dsoloview\Checkers\Enums\Row;

class Renderer
{
    public function renderBoard(Board $board): void
    {
        $this->renderTopRow();
        $this->renderRows($board);
    }

    private function renderTopRow(): void
    {
        echo '  ';
        foreach (Column::cases() as $col) {
            echo $col->value;
            echo ' ';
        }
        echo PHP_EOL;
    }

    private function renderRows(Board $board): void
    {
        foreach (Row::reversedCases() as $row) {
            $line = [];
            $line[] = $row->value;
            foreach (Column::cases() as $col) {
                $checker = $board->getChecker(new Coordinates($row, $col));
                if ($checker) {
                    $line[] = $checker->getColor()->getShape();
                } else {
                    $line[] = '.';
                }

            }
            echo implode(' ', $line);
            echo PHP_EOL;
        }
    }

}