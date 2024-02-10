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

    public function search(Request $request, $search_id)
    {
        $flights = [];
        $one_stop = $two_stop = $three_stop = $non_stop = $three_plus_stop = $refund = $no_refund = 0;
        $airlines = [];


        if ($request->search_type == 'OneWay') {
            $date = Carbon::parse($request->oDate);
            $startDate = $date->copy()->format("Y/m/d");

            $adultCount = $request->oAdult;
            $childCount = $request->oChild;
            $infantCount = $request->oInfant;

            $route = $request->oFrom . $request->oTo;

            $result = $this->flightBookingService->get('Flight/GetFlightAvail', array(
                'Dates' => $startDate,
                'AdultCount' => $adultCount,
                'ChildCount' => $childCount,
                'InfantCount' => $infantCount,
                'Routes' => $route,
            ));

            // dd($result);

            if ($result['Error'] == '' && isset($result['Items']) && count($result['Items']) > 0) {
                if (Cache::has('yas_search_result_' . $search_id)) {
                    Cache::delete('yas_search_result_' . $search_id);
                }

                foreach ($result['Items'] as $flight) {
                    if ($flight['Avail']) {

                        $flight['api_provider'] = "yasin";

                        $route = str_split($flight['Route'], 3);

                        $flight['origin'] = $route[0];
                        $flight['destination'] = $route[1];

                        $flight['rph'] = $flight['RPH'];
                        $flight['rbd'] = $flight['RBD'];
                        $flight['cabin'] = $flight['Cabin'];
                        $flight['route'] = $flight['Route'];
                        $flight['depature_date'] = $flight['FlightDate'] . ' ' . $flight['DepatureTime'];
                        $flight['arrival_time'] = $flight['ArrivalDate'] . ' ' . $flight['ArrivalTime'];
                        $flight['flight_duration'] = getYasinFlightTime($flight);
                        $flight['stops'] = $flight['Stop'];
                        $flight['airline'] = $flight['AirLine'];
                        $flight['flight_no'] = $flight['FlightNo'];
                        $flight['aircraft'] = $flight['Aircraft'];

                        $flight['adult_fare'] = $flight['FlightFare'];
                        $flight['child_fare'] = $flight['FlightChildFare'];
                        $flight['infant_fare'] = $flight['FlightInfantFare'];

                        $flight['total_price'] = 0;

                        for ($i = 0; $i < $adultCount; $i++) {
                            $flight['total_price'] += $flight['adult_fare'];
                        }
                        for ($i = 0; $i < $childCount; $i++) {
                            $flight['total_price'] += $flight['child_fare'];
                        }
                        for ($i = 0; $i < $infantCount; $i++) {
                            $flight['total_price'] += $flight['infant_fare'];
                        }

                        // dd($flight['total_price']);

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
        }

        return $result = [
            'currency' => "IRR",
            'one_stop' => $one_stop,
            'two_stop' => $two_stop,
            'three_stop' => $three_stop,
            'non_stop' => $non_stop,
            'three_plus_stop' => $three_plus_stop,
            'refund' => $refund,
            'no_refund' => $no_refund,
            'airlines' => $airlines,
            'flights' => $flights,
        ];

        // dd($result);
    }
}
