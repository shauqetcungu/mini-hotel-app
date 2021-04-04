<?php


namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use App\Virtual\Resources\LocationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class LocationsApiController extends Controller

{
    /**
     * @OA\Get(
     *      path="/api/v1/locations",
     *      operationId="getLocationsList",
     *      tags={"Locations"},
     *      summary="Get list of locations",
     *      description="Returns list of locations",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/LocationResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        return new LocationResource(Location::get());
    }

    /**
     * @OA\Post(
     *      path="/api/v1/locations",
     *      operationId="storeLocation",
     *      tags={"Locations"},
     *      summary="Store new location",
     *      description="Returns location data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LocationRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Location")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @param LocationRequest $request
     * @return JsonResponse|object
     */
    public function store(LocationRequest $request)
    {
        $validated = $request->validated();
        $validated["create_user_id"] = 1;
        $location = Location::create($validated);
        return (new LocationResource($location))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }


    /**
     * @OA\Get(
     *      path="/api/v1/locations/{id}",
     *      operationId="getLocationById",
     *      tags={"Locations"},
     *      summary="Get location information",
     *      description="Returns location data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Location id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Location")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @param Location $location
     * @return LocationResource
     */
    public function show(Location $location)
    {
        return new LocationResource($location);
    }


    /**
     * @OA\Put(
     *      path="/api/v1/locations/{id}",
     *      operationId="updateLocation",
     *      tags={"Locations"},
     *      summary="Update existing location",
     *      description="Returns updated location data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Location id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LocationRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Location")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(LocationRequest $request, Location $location)
    {
        $location->update($request->all());

        return (new LocationResource($location))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }


    /**
     * @OA\Delete(
     *      path="/api/v1/locations/{id}",
     *      operationId="deleteLocation",
     *      tags={"Locations"},
     *      summary="Delete existing location",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Location id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy(Location $location)
    {
        $location->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }


    /**
     * @OA\Get(
     *      path="/api/v1/locations/{searchKeword}/search",
     *      operationId="getSearchedLocation",
     *      tags={"Locations"},
     *      summary="Get searched location",
     *      description="Returns location data",
     *      @OA\Parameter(
     *          name="searchKeword",
     *          description="Keyword ",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Location")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @param $searchKeword
     * @return LocationResource
     */
    public function getSearched($searchKeword) {
        $locations = Location::
        where("city", "LIKE", "%$searchKeword%")
            ->orWhere("state", "LIKE", "%$searchKeword%")
            ->orWhere("country", "LIKE", "%$searchKeword%")
            ->orWhere("zip_code", "LIKE", "%$searchKeword%")
            ->orWhere("address", "LIKE", "%$searchKeword%")
            ->orderBy("id", "DESC")
            ->get();
        return new LocationResource($locations);
    }
}
