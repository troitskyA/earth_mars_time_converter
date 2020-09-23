<?php

use App\Domain\CalculationResult;

class CalculationResultTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testResultReturnCorrectValues()
    {
        $random1 = base64_encode(random_bytes(10));
        $random2 = base64_encode(random_bytes(10));
        $calculationResult = new CalculationResult($random1, $random2);

        $this->assertEquals($random1, $calculationResult->getMarsSolDate());
        $this->assertEquals($random2, $calculationResult->getCoordinatedMarsTime());
    }
}
