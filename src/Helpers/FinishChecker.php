<?php

namespace Dsoloview\Checkers\Helpers;

use Dsoloview\Checkers\Entities\Board;
use Dsoloview\Checkers\Entities\Checker;
use Dsoloview\Checkers\Enums\Color;

class FinishChecker
{
    private ?Color $winner = null;
    private Board $board;
    /**
     * @var Checker[] $whiteCheckers
     */
    private array $whiteCheckers;
    /**
     * @var Checker[] $blackCheckers
     */
    private array $blackCheckers;

    public function __construct(Board $board)
    {
        $this->board = $board;
        $this->whiteCheckers = $board->getCheckersByColor(Color::White);
        $this->blackCheckers = $board->getCheckersByColor(Color::Black);
    }

    public function getWinner(): ?Color
    {
        return $this->winner;
    }

    public function checkIsFinished(): bool
    {
        if ($this->checkColorIsEmpty() || $this->checkColorDoesntHaveMoves()) {
            return true;
        }

        return false;
    }

    private function checkColorIsEmpty(): bool
    {
        if (empty($this->whiteCheckers)) {
            $this->winner = Color::Black;
            return true;
        } elseif (empty($this->blackCheckers)) {
            $this->winner = Color::White;
            return true;
        }

        return false;
    }

    private function checkColorDoesntHaveMoves(): bool
    {
        $whiteHasMoves = false;
        foreach ($this->whiteCheckers as $whiteChecker) {
            $movesChecker = new MovesChecker($this->board, $whiteChecker);
            if ($movesChecker->hasMoves()) {
                $whiteHasMoves = true;
                break;
            }
        }

        if (!$whiteHasMoves) {
            $this->winner = Color::Black;
            return true;
        }

        $blackHasMoves = false;
        foreach ($this->blackCheckers as $blackChecker) {
            $movesChecker = new MovesChecker($this->board, $blackChecker);
            if ($movesChecker->hasMoves()) {
                $blackHasMoves = true;
                break;
            }
        }

        if (!$blackHasMoves) {
            $this->winner = Color::White;
            return true;
        }

        return false;
    }


}