<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $locations = Location::orderBy("id", "DESC")->paginate(10);
        return response()->json(["success", $locations], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LocationRequest $request
     * @return Response
     */
    public function store(LocationRequest $request)
    {
        $validated = $request->validated();
        $validated["create_user_id"] = auth()->user()->id;
        $location = Location::create($validated);
        return $location ? response()->json(["success", $location], 200) : response()->json(["error"], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param Location $location
     * @return Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Location $location
     * @return Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Location $location
     * @return Response
     */
    public function update(LocationRequest $request, Location $location)
    {
        $validated = $request->validated();
        $validated["update_user_id"] = auth()->user()->id;
        $location->update($validated);
        return $location ? response()->json(["success", $location], 200) : response()->json(["error"], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Location $location
     * @return Response
     * @throws Exception
     */
    public function destroy(Location $location)
    {
        $location->delete();
        return response()->json(["success"], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function location()
    {
        return view("layouts.cms");
    }

    /**
     * Display a listing of the resource.
     *
     * @param $searchKeword
     * @return Response
     */
    public function getSearched($searchKeword) {
        $locations = Location::
            where("city", "LIKE", "%$searchKeword%")
            ->orWhere("state", "LIKE", "%$searchKeword%")
            ->orWhere("country", "LIKE", "%$searchKeword%")
            ->orWhere("zip_code", "LIKE", "%$searchKeword%")
            ->orWhere("address", "LIKE", "%$searchKeword%")
            ->orderBy("id", "DESC")
            ->paginate(10);
        return $locations ? response()->json(["success", $locations], 200) : response()->json(["error"], 500);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function allLocations()
    {
        $locations = Location::all();
        return response()->json(["success", $locations], 200);
    }
}
