<?php

use App\Domain\ClockService;
use App\Domain\CalculationResult;
use App\Domain\WrongDateTimeFormatException;

class ClockServiceTest extends TestCase
{
    public function testItReturnsCorrectObject()
    {
        $service = new ClockService();

        $this->assertEquals(
            new CalculationResult('52160.135914819', '03:15:43'),
            $service->calculate('2020-09-23 14:03:00')
        );
    }

    public function testItDoesNotAcceptURIFormat()
    {
        $service = new ClockService();
        $this->expectException(WrongDateTimeFormatException::class);

        $service->calculate('2020-09-23%2014:03:00');
    }

    /**
     * @throws Exception
     */
    public function testItThrowsExceptionWithEmptyDate()
    {
        $service = new ClockService();
        $this->expectException(WrongDateTimeFormatException::class);

        $service->calculate('');
    }

    /**
     * @throws Exception
     */
    public function testItThrowsExceptionWithSimpleString()
    {
        $service = new ClockService();
        $this->expectException(WrongDateTimeFormatException::class);

        $service->calculate('Y-m-d H:i:s');
    }

    /**
     * @throws Exception
     */
    public function testItThrowsExceptionWithNoSecondsSet()
    {
        $service = new ClockService();
        $this->expectException(WrongDateTimeFormatException::class);

        $service->calculate('2020-09-23 23:30');
    }

    /**
     * @throws Exception
     */
    public function testItThrowsExceptionWithWrongDateSet()
    {
        $service = new ClockService();
        $this->expectException(WrongDateTimeFormatException::class);

        $service->calculate('2020-0923 23:30:20');
    }

    /**
     * @throws Exception
     */
    public function testItThrowsExceptionWithWrongYearSet()
    {
        $service = new ClockService();
        $this->expectException(WrongDateTimeFormatException::class);

        $service->calculate('2020 09-23 23:30:20');
    }
}
