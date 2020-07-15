<?php

namespace App\Http\Controllers;

use App\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function myAction()
    {
        return 'my action';
    }

    public function myAction2()
    {
        return 'my action 2';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Flight::all();
    }

//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//        //
//    }
    /**
     * Create a new flight instance.
     *
     * @param  Request  $request
     * // @return Flight
     */
    public function store(Request $request)
    {
        // Validate the request...

        $flight = new Flight;
        $flight->name = $request->name;
        $flight->save();

        $flight->fill(['name' => $flight->name . ' Flight 22']);

        $flightCopy = Flight::create([
            'name' => 'COPY ' . $request->name
        ]);

//        return $flight;
        return [$flight, $flightCopy];
    }

    // function in route
//    /**
//     * Display the specified resource.
//     *
//     * @param  \App\Flight  $flight
//     * @return \Illuminate\Http\Response
//     */
    public function show(Flight $flight)
    {
        return $flight;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Flight $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flight $flight)
    {
//        $flight = Flight::updateOrCreate([
////            'id' => $flight->id,
//            'name' => $request->name
//        ]);

        $flight->update([
            'name' => $request->name
        ]);

        return $flight;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Flight $flight
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Flight $flight)
    {
        $flight->delete();

        return 'it is done)';
    }
}
