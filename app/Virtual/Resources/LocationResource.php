<?php

namespace App\Virtual\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="LocationResource",
 *     description="Location resource",
 *     @OA\Xml(
 *         name="LocationResource"
 *     )
 * )
 */
class LocationResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
