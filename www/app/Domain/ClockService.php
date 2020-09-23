<?php

namespace App\Domain;

/**
 * Class ClockService
 *
 * @package App\Domain
 */
class ClockService
{
    const UTC_FORMAT = 'Y-m-d H:i:s';
    const UNIX_EPOCH_JULIAN_DATE = 2440587.5;
    const SECONDS_PER_DAY = 86400;
    const LEAP_SECONDS = 37;
    const ATOMIC_CORRECTION = 32.184;
    const J2000_EPOCH = 2451545.0;
    const MARS_MIDNIGHT_ON_6_JAN_2000 = 4.5;
    const MARS_TO_EARTH_DAY_LENGTH_COEFFICIENT = 1.027491252;
    const ADDITION_BY_CONVENTION = 44796.0;
    const ADJUSTMENT = 0.00096;
    const MCT_FORMAT = 'H:i:s';

    /**
     * @param string $dateTime
     * @return CalculationResult
     * @throws WrongDateTimeFormatException
     */
    public function calculate(string $dateTime): CalculationResult
    {
        if (!$this->isValid($dateTime)) {
            throw new WrongDateTimeFormatException();
        }

        $millsUnixEpoch = $this->convertToMillis($dateTime);
        $julianDate = $this->calculateJulianDate($millsUnixEpoch);
        $terrestrialTime = $this->calculateTerrestrialTime($julianDate);
        $marsSolDate = $this->calculateMarsSolDate($terrestrialTime);
        $coordinatedMarsTime = $this->calculateCoordinatedMarsTime($marsSolDate);

        return new CalculationResult((string)$marsSolDate, $coordinatedMarsTime);
    }

    /**
     * @param string $dateTime
     * @return bool
     */
    private function isValid(string $dateTime)
    {
        $utcDateTime = \DateTime::createFromFormat(self::UTC_FORMAT, $dateTime);
        if (!$utcDateTime || $utcDateTime->format(self::UTC_FORMAT) !== $dateTime) {
            return false;
        }

        return true;
    }

    /**
     * @param string $dateTime
     * @return false|int
     * @throws \Exception
     */
    private function convertToMillis(string $dateTime): int
    {
        return strtotime((new \DateTime($dateTime))->format('Y-m-d H:i:sP'));
    }

    private function calculateJulianDate(int $millsUnixEpoch): float
    {
        return (float)self::UNIX_EPOCH_JULIAN_DATE + ($millsUnixEpoch / self::SECONDS_PER_DAY);
    }

    private function calculateTerrestrialTime(float $julianDate): float
    {
        return $julianDate + (self::LEAP_SECONDS + self::ATOMIC_CORRECTION) / self::SECONDS_PER_DAY;
    }

    private function calculateMarsSolDate(float $terrestrialTime): float
    {
        return ((($terrestrialTime - self::J2000_EPOCH) - self::MARS_MIDNIGHT_ON_6_JAN_2000) / self::MARS_TO_EARTH_DAY_LENGTH_COEFFICIENT) + self::ADDITION_BY_CONVENTION - self::ADJUSTMENT;
    }

    private function calculateCoordinatedMarsTime(float $marsSolDate): string
    {
        return \gmdate(
            self::MCT_FORMAT,
            (int)(round(fmod($marsSolDate, 1) * self::SECONDS_PER_DAY, 0, PHP_ROUND_HALF_UP))
        );
    }
}
