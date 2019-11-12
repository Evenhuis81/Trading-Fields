<?php

namespace App\Http\Requests;

// use App\Advert;
use Illuminate\Foundation\Http\FormRequest;

class AdvertUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $advert = $this->route('advert');
        return $advert && $this->user()->can('update', $advert);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $advert = $this->route('advert');
        if ($this->input('unchanged')) {
            return [
            'title' => 'required|string|min:3|max:50',
            'description' => 'required|string|min:3|max:500',
            'price' => 'required|integer|min:0|max:10000',
            'category' => 'required|integer',
            'startbid' => ['nullable', 'integer', 'min:0', 'max:10000'],
            ];
        } else {
            return [
            'title' => 'required|string|min:3|max:50',
            'description' => 'required|string|min:3|max:500',
            'price' => 'required|integer|min:0|max:10000',
            'category' => 'required|integer',
            'startbid' => ['nullable', 'integer', 'min:0', 'max:10000'],
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'imagename' => 'required',
            ];
        }
    }
}
