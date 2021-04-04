<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store Hotel request",
 *      description="Store Hotel request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class HotelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"          => "required|max:10|not_contains",
            "rating"        => "required|integer|between:1,5",
            "category"      => "required|in:hotel,alternative,hostel,lodge,resort,guest-house",
            "reputation"    => "required|integer|between:1,1000",
            "price"         => "required|integer",
            "availability"  => "required|integer",
            "location_id"   => "required",
            "image"         => "nullable",
        ];
    }

    /**
     * Validation messages if validation fails
     *
     * @return array
     */
    public function messages() {
        return [
            "name.not_contains" => "Name can not contain the following words: Free, Offer, Book, Website.",
            "category.in"       => "Category must be one of the following: hotel, alternative, hostel, lodge, resort, guest-house.",
        ];
    }
}
