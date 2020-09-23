<?php

namespace App\Http\Controllers;

use App\Domain\ClockService;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function index(Request $request)
    {
        $dateTime = $request->get('dateTime');

        if (is_null($dateTime)) {
            $dateTime = (new \DateTime(\urldecode($dateTime)))->format(ClockService::UTC_FORMAT);
        }

        try {
            $calculationResult = (new ClockService())->calculate(
                (new \DateTime(\urldecode($dateTime)))->format(ClockService::UTC_FORMAT)
            );

            return response(
                'Mars Sol Date: ' . $calculationResult->getMarsSolDate(
                ) . '<br/>' . 'Coordinated Mars Time: ' . $calculationResult->getCoordinatedMarsTime()
            );
        } catch (\Exception $exeption) {
            return response('Wrong Date Time', 422);
        }
    }
}
