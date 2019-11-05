<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertStoreRequest extends FormRequest
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
        if ($this->input(['base64img'])) {
        // if ($this->hasFile('images')) {
            return [
            'title' => 'required|string|min:3|max:50',
            'description' => 'required|string|min:3|max:500',
            'price' => 'required|integer|min:0|max:10000',
            'category' => 'required|integer',
            'startbid' => ['nullable', 'integer', 'min:0', 'max:10000'],
            // 'images' => 'required|array|min:1',
            // 'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
                ];
        }
    }
    public function withValidator($validator)
    {
        if ($this->hasFile('images')) {
            $base64Img=[];
            foreach ($this->file('images') as $picture) {
                $imageData = base64_encode(file_get_contents($picture));
                $src = 'data: '.mime_content_type($picture->path()).';base64,'.$imageData;
                array_push($base64Img, $src);
                if(is_null($this->input(['bids']))) {
                    redirect('/adverts/create')
                    ->withErrors($validator)
                    ->withInput()
                    ->with('images', $base64Img)
                    ->with('bidcheckoff', 'a');
                } else {
                    redirect('/adverts/create')
                    ->withErrors($validator)
                    ->withInput()
                    ->with('images', $base64Img)
                    ->with('bidcheckon', 'a');
                }
            }
        } elseif ($this->input(['base64img'])) {
            $base64Img=[];
            array_push($base64Img, $this->input(['base64img']));
            if(is_null($this->input(['bids']))) {
                redirect('/adverts/create')
                ->withErrors($validator)
                ->withInput()
                ->with('images', $base64Img)
                ->with('bidcheckoff', 'a');
            } else {
                redirect('/adverts/create')
                ->withErrors($validator)
                ->withInput()
                ->with('images', $base64Img)
                ->with('bidcheckon', 'a');
            }
        } else {
            if(is_null($this->input(['bids']))) {
                redirect('/adverts/create')
                ->withErrors($validator)
                ->withInput()
                // ->with('images', $base64Img)
                ->with('bidcheckoff', 'a');
            } else {
                redirect('/adverts/create')
                ->withErrors($validator)
                ->withInput()
                // ->with('images', $base64Img)
                ->with('bidcheckon', 'a');
            }
        }
    }
}