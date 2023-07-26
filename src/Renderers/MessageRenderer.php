<?php

namespace Dsoloview\Checkers\Renderers;

use Dsoloview\Checkers\Entities\Coordinates;
use Dsoloview\Checkers\Entities\Move;
use Dsoloview\Checkers\Enums\Color;
use Dsoloview\Checkers\Enums\Error;

class MessageRenderer
{
    public static function renderError(Error $error): void
    {
        echo $error->value;
        echo PHP_EOL;
    }

    public static function renderMessage(string $message): void
    {
        echo $message;
        echo PHP_EOL;
    }

    /**
     * @param array<Move> $moves
     * @return void
     */
    public static function availableMovesMessage(array $moves): void
    {
        echo 'Available moves: ';
        echo PHP_EOL;
        $movesBuilder = [];
        foreach ($moves as $move) {
            $movesBuilder[] = $move->getTo()->toString();
        }
        echo implode(', ', $movesBuilder);
        echo PHP_EOL;
    }

    public static function renderWinnerMessage(Color $color): void
    {
        echo 'Winner is ' . $color->name . ' player';
        echo PHP_EOL;
    }

}