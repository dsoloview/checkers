<?php

namespace Dsoloview\Checkers;

use Dsoloview\Checkers\Entities\Board;
use Dsoloview\Checkers\Entities\Checker;
use Dsoloview\Checkers\Entities\Move;
use Dsoloview\Checkers\Enums\Color;
use Dsoloview\Checkers\Enums\Error;
use Dsoloview\Checkers\Helpers\FinishChecker;
use Dsoloview\Checkers\Helpers\MovesChecker;
use Dsoloview\Checkers\Parsers\InputParser;
use Dsoloview\Checkers\Renderers\MessageRenderer;

class App
{
    private Board $board;
    private InputParser $inputParser;
    private Color $currentPlayer;
    private bool $isFinished = false;

    public function __construct()
    {
        $this->board = new Board();
        $this->inputParser = new InputParser();
        $this->currentPlayer = Color::White;
    }

    public function run(): void
    {
        while (true) {
            $this->board->draw();

            $this->checkIsFinished();
            if ($this->isFinished) {
                break;
            }

            $this->inputParser->setBoard($this->board);
            $this->inputParser->setCurrentPlayer($this->currentPlayer);
            $checkerCoordinates = $this->inputParser->parseCheckerCoordinate();


            $checker = $this->board->getChecker($checkerCoordinates);
            $movesChecker = new MovesChecker($this->board, $checker);

            if (!$movesChecker->hasMoves()) {
                MessageRenderer::renderError(Error::NO_MOVES);
                continue;
            }

            $availableMoves = $movesChecker->getAvailableMoves();

            MessageRenderer::availableMovesMessage($availableMoves);

            $move = $this->inputParser->parseMoveCoordinate($availableMoves);

            $this->board->move($checker, $move);

            $this->capturingCycle($checker, $move);

            $this->changePlayer();
        }
    }

    private function capturingCycle(Checker $checker, Move $move): void
    {
        while ($move->isCapturing()) {
            $movesChecker = new MovesChecker($this->board, $checker);
            $availableMoves = $movesChecker->getAvailableMoves();

            if (empty($availableMoves)) {
                break;
            } else {
                $isCapturing = false;
                foreach ($availableMoves as $move) {
                    if ($move->isCapturing()) {
                        $isCapturing = true;
                        break;
                    }
                }

                if (!$isCapturing) {
                    break;
                }
            }

            $this->board->draw();

            MessageRenderer::availableMovesMessage($availableMoves);

            $move = $this->inputParser->parseMoveCoordinate($availableMoves);

            $this->board->move($checker, $move);
        }
    }

    private function checkIsFinished(): void
    {
        $finishChecker = new FinishChecker($this->board);
        $this->isFinished = $finishChecker->checkIsFinished();

        if ($this->isFinished) {
            MessageRenderer::renderWinnerMessage($finishChecker->getWinner());
        }
    }

    private function changePlayer(): void
    {
        $this->currentPlayer = $this->currentPlayer === Color::White ? Color::Black : Color::White;
    }
}