<?php

namespace App\Http\Controllers\Admin\Yasin;

use App\Http\Controllers\Controller;
use App\Models\Airports;
use App\Models\Yasin\YasinRoutes;
use Illuminate\Http\Request;

class RoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort_search = null;

        $query = YasinRoutes::query();

        if ($request->has('search')) {
            $sort_search = $request->search;
            $query->where('to', $sort_search)
                ->orWhere('from', $sort_search)
                ->orWhere('route', $sort_search);
        }

        $routes = $query->paginate(15);

        return view('admin.yasin.routes.index', compact('routes', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.yasin.routes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'from_airport' => 'required',
            'to_airport' => 'required',
            'from_airport' => 'different:to_airport'
        ], [
            'from_airport.different' => "Orgin and destination cannot be same",
            'from_airport.required' => "Please select an orgin airport",
            'to_airport.required' => "Please select a destination airport",
        ]);

        $route = YasinRoutes::create([
            'route' => $request->from_airport . $request->to_airport,
            'from' => $request->from_airport,
            'to' => $request->to_airport,
            'status' => $request->status
        ]);

        return redirect()->back()->with('status', 'Route created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(YasinRoutes $route)
    {
        $route->load([
            'fromAirport',
            'toAirport'
        ]);
        return view('admin.yasin.routes.edit', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, YasinRoutes $route)
    {
        // dd($request);
        $request->validate([
            'from_airport' => 'required',
            'to_airport' => 'required',
            'from_airport' => 'different:to_airport'
        ], [
            'from_airport.different' => "Orgin and destination cannot be same",
            'from_airport.required' => "Please select an orgin airport",
            'to_airport.required' => "Please select a destination airport",
        ]);

        $route->from = $request->from_airport;
        $route->to = $request->to_airport;
        $route->route = $request->from_airport . $request->to_airport;
        $route->status = $request->status;
        $route->save();
        return redirect()->back()->with('status', 'Route updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return YasinRoutes::destroy($id);
    }

    public function autocompleteAirports(Request $request)
    {
        $search = $request->term;
        $response = array();

        if ($search) {
            $query = Airports::select("AirportCode", "AirportName");
            if ($search) {
                $query->Where(function ($query) use ($search) {
                    $query->orWhere('AirportCode', 'LIKE', "%$search%")
                        ->orWhere('AirportName', 'LIKE', "$search%");
                });
            }
            $airports = $query->orderBy('AirportCode', 'ASC')
                ->get();

            foreach ($airports as $air) {
                $response[] = array(
                    "id" => $air->AirportCode,
                    "text" => $air->AirportCode . ' - ' . $air->AirportName
                );
            }
        }



        $result['items'] = $response;

        return response()->json($result);
    }

    public function changeStatus(Request $request)
    {
        YasinRoutes::where('id', $request->id)
            ->update([
                'status' => ($request->status) == 1 ? false : true
            ]);

        return json_encode([
            'status' => true
        ]);
    }
}
