<?php

namespace Dsoloview\Checkers\Parsers;

use Dsoloview\Checkers\Entities\Board;
use Dsoloview\Checkers\Entities\Coordinates;
use Dsoloview\Checkers\Entities\Move;
use Dsoloview\Checkers\Enums\Color;
use Dsoloview\Checkers\Enums\Column;
use Dsoloview\Checkers\Enums\Error;
use Dsoloview\Checkers\Enums\Row;
use Dsoloview\Checkers\Renderers\MessageRenderer;

class InputParser
{
    private Board $board;
    private Color $currentPlayer;

    public function setBoard(Board $board): void
    {
        $this->board = $board;
    }

    public function setCurrentPlayer(Color $currentPlayer): void
    {
        $this->currentPlayer = $currentPlayer;
    }

    public function parseCheckerCoordinate(): Coordinates
    {
        MessageRenderer::renderMessage('Current player: ' . $this->currentPlayer->name);
        while (true) {
            $input = readline('Enter coordinates of checker: ');
            if ($this->validateCheckerInput($input)) {
                return new Coordinates(Row::from($input[1]), Column::from($input[0]));
            }
        }
    }

    /**
     * @param array<Move> $availableMoves
     * @return Move
     */
    public function parseMoveCoordinate(array $availableMoves): Move
    {
        while (true) {
            $input = readline('Enter coordinates of move: ');
            if ($this->validateMoveInput($input, $availableMoves)) {
                foreach ($availableMoves as $availableMove) {
                    if ($availableMove->getTo()->toString() === trim($input)) {
                        return $availableMove;
                    }
                }
            }
        }
    }

    /**
     * @param array<Move> $availableMoves
     * @return bool
     */
    private function validateMoveInput(string $input, array $availableMoves): bool
    {
        $input = trim($input);
        foreach ($availableMoves as $availableMove) {
            if ($availableMove->getTo()->toString() === $input) {
                return true;
            }
        }

        MessageRenderer::renderError(Error::INVALID_MOVE);
        return false;
    }

    private function validateCheckerInput(string $input): bool
    {
        $input = trim($input);
        $inputParts = str_split($input);

        if (count($inputParts) !== 2) {
            MessageRenderer::renderError(Error::INVALID_INPUT);
            return false;
        }

        $col = $inputParts[0];
        $row = $inputParts[1];

        if (!in_array($col, Column::getValues())) {
            MessageRenderer::renderError(Error::INVALID_COLUMN);
            return false;
        }

        if (!in_array($row, Row::getValues())) {
            MessageRenderer::renderError(Error::INVALID_ROW);
            return false;
        }

        $coordinates = new Coordinates(Row::from($row), Column::from($col));

        $checker = $this->board->getChecker($coordinates);

        if (!$checker) {
            MessageRenderer::renderError(Error::NO_CHECKER);
            return false;
        }

        if ($checker->getColor() !== $this->currentPlayer) {
            MessageRenderer::renderError(Error::WRONG_CHECKER);
            return false;
        }

        return true;
    }

}