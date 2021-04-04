<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelRequest;
use App\Models\Hotel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HotelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $hotels = Hotel::orderBy("id", "DESC")->paginate(10);
        return response()->json(["success", $hotels], 200);
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
     * @param HotelRequest $request
     * @return Response
     */
    public function store(HotelRequest $request)
    {
        $validated = $request->validated();
        $destinationPath = "/images/hotels";
        $validated["image"] = $this->uploadImage($validated["image"], $destinationPath  . "/");
        $validated["create_user_id"] = auth()->user()->id;
        $hotel = Hotel::create($validated);
        return $hotel ? response()->json(["success", $hotel], 200) : response()->json(["error"], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param Hotel $hotel
     * @return Response
     */
    public function show(Hotel $hotel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Hotel $hotel
     * @return Response
     */
    public function edit(Hotel $hotel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param HotelRequest $request
     * @param Hotel $hotel
     * @return Response
     */
    public function update(HotelRequest $request, Hotel $hotel)
    {
        $validated = $request->validated();
        $validated["update_user_id"] = auth()->user()->id;
        if(!empty($validated["image"])) {
            $destinationPath = "/images/hotels";
            $this->deletePhoto($hotel->image);
            $validated["image"] = $this->uploadImage($validated["image"], $destinationPath  . "/");
        }

        $hotel->update($validated);
        return $hotel ? response()->json(["success", $hotel], 200) : response()->json(["error"], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Hotel $hotel
     * @return Response
     * @throws Exception
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return response()->json(["success"], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function hotel()
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
        $hotels = Hotel::
        where("name", "LIKE", "%$searchKeword%")
            ->orWhere("rating", "LIKE", "%$searchKeword%")
            ->orWhere("category", "LIKE", "%$searchKeword%")
            ->orWhere("reputation", "LIKE", "%$searchKeword%")
            ->orWhere("price", "LIKE", "%$searchKeword%")
            ->orWhere("availability", "LIKE", "%$searchKeword%")
            ->orderBy("id", "DESC")
            ->paginate(10);
        return $hotels ? response()->json(["success", $hotels], 200) : response()->json(["error"], 500);
    }

    public static function uploadImage($image, $destinationPath) {
        $filename = Str::random(4) . '-' . str_replace(' ', '-', $image->getClientOriginalName());
        $image->move(public_path() . $destinationPath, $filename);
        return $destinationPath . $filename;
    }

    public static function deletePhoto($image) {
        $image_path = substr($image, 1);
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
    }
}
