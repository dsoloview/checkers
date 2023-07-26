<?php

namespace Dsoloview\Checkers\Entities;

class Move
{
    private Coordinates $from;
    private Coordinates $to;
    private ?Checker $capturedChecker;
    private bool $isAvailableForColor;

    public function __construct(Coordinates $from, Coordinates $to, bool $isAvailableForColor, ?Checker $capturedChecker = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->capturedChecker = $capturedChecker;
        $this->isAvailableForColor = $isAvailableForColor;
    }

    public function getFrom(): Coordinates
    {
        return $this->from;
    }

    public function setFrom(Coordinates $from): void
    {
        $this->from = $from;
    }

    public function isAvailableForColor(): bool
    {
        return $this->isAvailableForColor;
    }

    public function getTo(): Coordinates
    {
        return $this->to;
    }

    public function setTo(Coordinates $to): void
    {
        $this->to = $to;
    }

    public function getCapturedChecker(): ?Checker
    {
        return $this->capturedChecker;
    }

    public function setCapturedChecker(?Checker $capturedChecker): void
    {
        $this->capturedChecker = $capturedChecker;
    }

    public function isCapturing(): bool
    {
        return $this->capturedChecker !== null;
    }

}