<?php

namespace Dsoloview\Checkers\Helpers;

use Dsoloview\Checkers\Entities\Board;
use Dsoloview\Checkers\Entities\Checker;
use Dsoloview\Checkers\Entities\Coordinates;
use Dsoloview\Checkers\Entities\Move;
use Dsoloview\Checkers\Enums\Color;
use Dsoloview\Checkers\Enums\Column;
use Dsoloview\Checkers\Enums\Row;

class MovesChecker
{
    private Board $board;
    private Checker $checker;
    private array $availableMoves = [];

    public function __construct(Board $board, Checker $checker)
    {
        $this->board = $board;
        $this->checker = $checker;
    }

    /**
     * @return Move[]
     */
    public function getAvailableMoves(): array
    {
        $this->availableMoves = [];
        $this->getAllMoves();
        $this->filterMovesByAnotherChecker();
        $this->filterMovesByAvailabilityForColor();

        return $this->availableMoves;
    }

    private function getAllMoves(): void
    {
        if ($this->checker->getCoordinates()->getRow()->next()) {
            if ($this->checker->getCoordinates()->getColumn()->previous()) {
                $this->availableMoves[] = new Move(
                    $this->checker->getCoordinates(),
                    new Coordinates(
                        $this->checker->getCoordinates()->getRow()->next(),
                        $this->checker->getCoordinates()->getColumn()->previous()
                    ),
                    $this->checker->getColor() === Color::White
                );
            }

            if ($this->checker->getCoordinates()->getColumn()->next()) {
                $this->availableMoves[] = new Move(
                    $this->checker->getCoordinates(),
                    new Coordinates(
                        $this->checker->getCoordinates()->getRow()->next(),
                        $this->checker->getCoordinates()->getColumn()->next()
                    ),
                    $this->checker->getColor() === Color::White
                );
            }
        }

        if ($this->checker->getCoordinates()->getRow()->previous()) {
            if ($this->checker->getCoordinates()->getColumn()->previous()) {
                $this->availableMoves[] = new Move(
                    $this->checker->getCoordinates(),
                    new Coordinates(
                        $this->checker->getCoordinates()->getRow()->previous(),
                        $this->checker->getCoordinates()->getColumn()->previous()
                    ),
                    $this->checker->getColor() === Color::Black
                );
            }

            if ($this->checker->getCoordinates()->getColumn()->next()) {
                $this->availableMoves[] = new Move(
                    $this->checker->getCoordinates(),
                    new Coordinates(
                        $this->checker->getCoordinates()->getRow()->previous(),
                        $this->checker->getCoordinates()->getColumn()->next()
                    ),
                    $this->checker->getColor() === Color::Black
                );
            }
        }
    }

    private function filterMovesByAnotherChecker(): void
    {
        foreach ($this->availableMoves as $key => &$move) {
            $checker = $this->board->getChecker($move->getTo());
            if ($checker !== null && $checker->getColor() === $this->checker->getColor()) {
                unset($this->availableMoves[$key]);
            }

            if ($checker !== null && $checker->getColor() !== $this->checker->getColor()) {
                $move->setCapturedChecker($checker);
                $result = $this->checkForCapturing($move);
                if (!$result) {
                    unset($this->availableMoves[$key]);
                }
            }
        }
    }

    private function filterMovesByAvailabilityForColor(): void
    {
        foreach ($this->availableMoves as $key => &$move) {
            if (!$move->isAvailableForColor() && !$move->isCapturing()) {
                unset($this->availableMoves[$key]);
            }
        }
    }

    private function checkForCapturing(Move &$move): bool
    {
        $currentRow = $move->getFrom()->getRow();
        $currentColumn = $move->getFrom()->getColumn();
        $moveRow = $move->getTo()->getRow();
        $moveColumn = $move->getTo()->getColumn();

        if ($currentRow->next() === $moveRow) {
            if ($currentColumn->next() === $moveColumn) {
                if ($moveRow->next() && $moveColumn->next()) {
                    return $this->checkNextFieldAvailable($moveRow->next(), $moveColumn->next(), $move);
                }
            } elseif ($currentColumn->previous() === $moveColumn) {
                if ($moveRow->next() && $moveColumn->previous()) {
                    return $this->checkNextFieldAvailable($moveRow->next(), $moveColumn->previous(), $move);
                }
            }

        } elseif ($currentRow->previous() === $moveRow) {
            if ($currentColumn->next() === $moveColumn) {
                if ($moveRow->previous() && $moveColumn->next()) {
                   return $this->checkNextFieldAvailable($moveRow->previous(), $moveColumn->next(), $move);
                }
            } elseif ($currentColumn->previous() === $moveColumn) {
                if ($moveRow->previous() && $moveColumn->previous()) {
                    return $this->checkNextFieldAvailable($moveRow->previous(), $moveColumn->previous(), $move);
                }
            }
        }

        return false;
    }

    private function checkNextFieldAvailable(Row $row, Column $column, Move &$move): bool
    {
        $coordinates = new Coordinates($row, $column);
        $checker = $this->board->getChecker($coordinates);
        if (!$checker) {
            $move->setTo($coordinates);
            return true;
        }

        return false;
    }

    public function hasMoves(): bool
    {
        return count($this->getAvailableMoves()) > 0;
    }
}