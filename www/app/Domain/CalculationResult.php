<?php

namespace App\Domain;

/**
 * Class CalculationResult
 *
 * @package App\Domain
 */
class CalculationResult
{
    private string $marsSolDate;
    private string $coordinatedMarsTime;

    public function __construct(string $marsSolDate, string $coordinatedMarsTime)
    {
        $this->marsSolDate = $marsSolDate;
        $this->coordinatedMarsTime = $coordinatedMarsTime;
    }

    /**
     * @return string
     */
    public function getMarsSolDate(): string
    {
        return $this->marsSolDate;
    }

    /**
     * @return string
     */
    public function getCoordinatedMarsTime(): string
    {
        return $this->coordinatedMarsTime;
    }
}
