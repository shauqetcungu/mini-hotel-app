<?php


namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="Location",
 *     description="Location model",
 *     @OA\Xml(
 *         name="Location"
 *     )
 * )
 */

class Location
{

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="City",
     *      description="City of the new location",
     *      example="A nice location"
     * )
     *
     * @var string
     */
    public $city;

    /**
     * @OA\Property(
     *      title="Country",
     *      description="Country of the new location",
     *      example="This is new location's description"
     * )
     *
     * @var string
     */
    public $country;

    /**
     * @OA\Property(
     *      title="state",
     *      description="state of the new location",
     *      example="This is new location's description"
     * )
     *
     * @var string
     */
    public $state;


    /**
     * @OA\Property(
     *      title="address",
     *      description="address of the new location",
     *      example="This is new location's description"
     * )
     *
     * @var string
     */
    public $address;

    /**
     * @OA\Property(
     *      title="zip_code",
     *      description="zip_code of the new location",
     *      example="This is new location's description"
     * )
     *
     * @var string
     */
    public $zip_code;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var DateTime
     */
    private $updated_at;

    /**
     * @OA\Property(
     *     title="Deleted at",
     *     description="Deleted at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var DateTime
     */
    private $deleted_at;
}
