<?php

namespace Dsoloview\Checkers\Entities;

use Dsoloview\Checkers\Enums\Color;
use Dsoloview\Checkers\Enums\Column;
use Dsoloview\Checkers\Enums\Row;
use Dsoloview\Checkers\Renderers\Renderer;

class Board
{
    private array $checkers = [];
    private Renderer $renderer;

    public function __construct()
    {
        $this->setDefaultBoard();
        $this->renderer = new Renderer();
    }

    public function draw(): void
    {
        $this->renderer->renderBoard($this);
    }

    private function setChecker(Checker $checker): void
    {
        $this->checkers[json_encode($checker->getCoordinates())] = $checker;
    }

    public function move(Checker $checker, Move $move): void
    {
        $this->removeChecker($checker);
        if ($move->isCapturing()) {
            $this->removeChecker($move->getCapturedChecker());
        }
        $checker->setCoordinates($move->getTo());
        $this->setChecker($checker);
    }

    public function removeChecker(Checker $checker): void
    {
        unset($this->checkers[json_encode($checker->getCoordinates())]);
    }
    public function getChecker(Coordinates $coordinates): ?Checker
    {
        return $this->checkers[json_encode($coordinates)] ?? null;
    }

    /**
     * @return Checker[]
     */
    public function getCheckersByColor(Color $color): array
    {
        $checkers = [];
        foreach ($this->checkers as $checker) {
            if ($checker->getColor() === $color) {
                $checkers[] = $checker;
            }
        }
        return $checkers;
    }

    private function setDefaultBoard(): void
    {
        $this->setChecker(new Checker(Color::White, new Coordinates(Row::One, Column::A)));
        $this->setChecker(new Checker(Color::White, new Coordinates(Row::One, Column::C)));
        $this->setChecker(new Checker(Color::White, new Coordinates(Row::One, Column::E)));
        $this->setChecker(new Checker(Color::White, new Coordinates(Row::One, Column::G)));

        $this->setChecker(new Checker(Color::White, new Coordinates(Row::Two, Column::B)));
        $this->setChecker(new Checker(Color::White, new Coordinates(Row::Two, Column::D)));
        $this->setChecker(new Checker(Color::White, new Coordinates(Row::Two, Column::F)));
        $this->setChecker(new Checker(Color::White, new Coordinates(Row::Two, Column::H)));

        $this->setChecker(new Checker(Color::White, new Coordinates(Row::Three, Column::A)));
        $this->setChecker(new Checker(Color::White, new Coordinates(Row::Three, Column::C)));
        $this->setChecker(new Checker(Color::White, new Coordinates(Row::Three, Column::E)));
        $this->setChecker(new Checker(Color::White, new Coordinates(Row::Three, Column::G)));

        $this->setChecker(new Checker(Color::Black, new Coordinates(Row::Six, Column::B)));
        $this->setChecker(new Checker(Color::Black, new Coordinates(Row::Six, Column::D)));
        $this->setChecker(new Checker(Color::Black, new Coordinates(Row::Six, Column::F)));
        $this->setChecker(new Checker(Color::Black, new Coordinates(Row::Six, Column::H)));

        $this->setChecker(new Checker(Color::Black, new Coordinates(Row::Seven, Column::A)));
        $this->setChecker(new Checker(Color::Black, new Coordinates(Row::Seven, Column::C)));
        $this->setChecker(new Checker(Color::Black, new Coordinates(Row::Seven, Column::E)));
        $this->setChecker(new Checker(Color::Black, new Coordinates(Row::Seven, Column::G)));

        $this->setChecker(new Checker(Color::Black, new Coordinates(Row::Eight, Column::B)));
        $this->setChecker(new Checker(Color::Black, new Coordinates(Row::Eight, Column::D)));
        $this->setChecker(new Checker(Color::Black, new Coordinates(Row::Eight, Column::F)));
        $this->setChecker(new Checker(Color::Black, new Coordinates(Row::Eight, Column::H)));
    }

}