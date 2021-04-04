<?php


namespace App\Virtual\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="HotelResource",
 *     description="Hotel resource",
 *     @OA\Xml(
 *         name="HotelResource"
 *     )
 * )
 */
class HotelResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
