<?php

namespace App\Http\Controllers\Providers\Yasin;

use App\Http\Controllers\Controller;
use App\Services\YasinService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class YasinBookingController extends Controller
{
    private $flightBookingService;

    public function __construct()
    {
        $this->flightBookingService = new YasinService();
    }

    public function search(Request $request)
    {

        // dd($request);

        if ($request->search_type == 'OneWay') {
            $date = Carbon::parse($request->oDate);
            $startDate = $date->copy()->format("Y/m/d");

            $adultCount = $request->oAdult;
            $childCount = $request->oChild;
            $infantCount = $request->oInfant;

            $route = $request->oFrom . $request->oTo;
        }

        $search_id = Str::random(10);

        $flights = [];
        $one_stop = $two_stop = $three_stop = $non_stop = $three_plus_stop = $refund = $no_refund = 0;
        $airlines = [];

        $result = $this->flightBookingService->get('Flight/GetFlightAvail', array(
            'Dates' => $startDate,
            'AdultCount' => $adultCount,
            'ChildCount' => $childCount,
            'InfantCount' => $infantCount,
            'Routes' => $route,
        ));

        if ($result['Error'] == '' && isset($result['Items']) && count($result['Items']) > 0) {

            if (Cache::has('yas_search_result_' . $search_id)) {
                Cache::delete('yas_search_result_' . $search_id);
            }

            foreach ($result['Items'] as $flight) {
                if ($flight['Avail']) {

                    $flight['api_provider'] = "yasin";
                    $flight['flightTime'] = getYasinFlightTime($flight);

                    switch ($flight['Stop']) {
                        case 0:
                            $non_stop++;
                            break;
                        case 1:
                            $one_stop++;
                            break;
                        case 2:
                            $two_stop++;
                            break;
                        case 3:
                            $three_stop++;
                            break;
                        default:
                            $three_plus_stop++;
                            break;
                    }

                    if ($flight['Refundable']) {
                        $refund++;
                    } else {
                        $no_refund++;
                    }

                    $flights[] = $flight;
                }
            }

            $airlines = getYasinAirLines($flights);
        }

        dd($flights);
    }
}
