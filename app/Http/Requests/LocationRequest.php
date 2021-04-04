<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store Location request",
 *      description="Store Location request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class LocationRequest extends FormRequest
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
            "city"      => "required|max:20",
            "state"     => "required|max:20",
            "country"   => "required|max:20",
            "zip_code"  => "required|size:5",
            "address"   => "required|max:50",
        ];
    }

    /**
     * Validation messages if validation fails
     *
     * @return array
     */
    public function messages() {
        return [];
    }

}
