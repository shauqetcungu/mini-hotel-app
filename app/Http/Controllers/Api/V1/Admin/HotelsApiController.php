<?php


namespace App\Http\Controllers\Api\V1\Admin;


use App\Http\Requests\HotelRequest;
use App\Models\Hotel;
use App\Virtual\Resources\HotelResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class HotelsApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/hotels",
     *      operationId="getHotelsList",
     *      tags={"Hotels"},
     *      summary="Get list of hotels",
     *      description="Returns list of hotels",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/HotelResource")
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
        return new HotelResource(Hotel::get());
    }

    /**
     * @OA\Post(
     *      path="/api/v1/hotels",
     *      operationId="storeHotel",
     *      tags={"Hotels"},
     *      summary="Store new hotel",
     *      description="Returns hotel data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/HotelRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Hotel")
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
     * @param HotelRequest $request
     * @return JsonResponse|object
     */
    public function store(HotelRequest $request)
    {
        $validated = $request->validated();
        $validated["create_user_id"] = 1;
        $hotel = Hotel::create($validated);
        return (new HotelResource($hotel))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }


    /**
     * @OA\Get(
     *      path="/api/v1/hotels/{id}",
     *      operationId="getHotelById",
     *      tags={"Hotels"},
     *      summary="Get hotel information",
     *      description="Returns hotel data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Hotel id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Hotel")
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
     * @param Hotel $hotel
     * @return HotelResource
     */
    public function show(Hotel $hotel)
    {
        return new HotelResource($hotel);
    }


    /**
     * @OA\Put(
     *      path="/api/v1/hotels/{id}",
     *      operationId="updateHotel",
     *      tags={"Hotels"},
     *      summary="Update existing hotel",
     *      description="Returns updated hotel data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Hotel id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/HotelRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Hotel")
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
    public function update(HotelRequest $request, Hotel $hotel)
    {
        $hotel->update($request->all());

        return (new HotelResource($hotel))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }


    /**
     * @OA\Delete(
     *      path="/api/v1/hotels/{id}",
     *      operationId="deleteHotel",
     *      tags={"Hotels"},
     *      summary="Delete existing hotel",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Hotel id",
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
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }


    /**
     * @OA\Get(
     *      path="/api/v1/hotels/{searchKeword}/search",
     *      operationId="getSearchedHotel",
     *      tags={"Hotels"},
     *      summary="Get searched hotel",
     *      description="Returns hotel data",
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
     *          @OA\JsonContent(ref="#/components/schemas/Hotel")
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
     * @return HotelResource
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
        return new HotelResource($hotels);
    }
}
