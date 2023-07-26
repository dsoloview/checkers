<?php

namespace Dsoloview\Checkers\Enums;

enum Error: string
{
    case NO_MOVES = 'No moves available for this checker';
    case INVALID_INPUT = 'Invalid input. Please try again.';
    case INVALID_COLUMN = 'Invalid column. Please try again.';
    case INVALID_ROW = 'Invalid row. Please try again.';
    case INVALID_MOVE = 'Invalid move. Please try again.';
    case NO_CHECKER = 'There is no checker at this coordinates. Please try again.';
    case WRONG_CHECKER = 'This checker is not yours. Please try again.';
}
