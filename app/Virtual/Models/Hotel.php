<?php


namespace App\Virtual\Models;

use DateTime;

/**
 * @OA\Schema(
 *     title="Hotel",
 *     description="Hotel model",
 *     @OA\Xml(
 *         name="Hotel"
 *     )
 * )
 */
class Hotel
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
     *      title="Name",
     *      description="Name of the new hotel",
     *      example="A nice hotel"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Rating",
     *      description="Rating of the new hotel",
     *      example="This is new hotel's description"
     * )
     *
     * @var integer
     */
    public $rating;

    /**
     * @OA\Property(
     *      title="Category",
     *      description="Category of the new hotel",
     *      example="This is new hotel's description"
     * )
     *
     * @var string
     */
    public $category;


    /**
     * @OA\Property(
     *      title="Reputation",
     *      description="Reputation of the new hotel",
     *      example="700"
     * )
     *
     * @var integer
     */
    public $reputation;

    /**
     * @OA\Property(
     *      title="Price",
     *      description="Price of the new hotel",
     *      example="This is new hotel's description"
     * )
     *
     * @var integer
     */
    public $price;

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
