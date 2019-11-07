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
        // base64img = key?
        if ($this->input(['base64key'])) {
        // if ($this->hasFile('images')) {
            return [
            'title' => 'required|string|min:3|max:50',
            'description' => 'required|string|min:3|max:500',
            'price' => 'required|integer|min:0|max:10000',
            'category' => 'required|integer',
            'startbid' => ['nullable', 'integer', 'min:0', 'max:10000'],
            'base64key' => 'required',
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
            $redirect=redirect('/adverts/create')
            ->withErrors($validator)
            ->withInput();
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
                    ->with('imagekey', 'base64key')
                    ->with('bidcheckoff', 'a');
                } else {
                    redirect('/adverts/create')
                    ->withErrors($validator)
                    ->withInput()
                    ->with('imagekey', 'base64key')
                    ->with('images', $base64Img)
                    ->with('bidcheckon', 'a');
                }
            }
        } elseif ($this->input(['base64key'])) {
            $base64Img=[];
            array_push($base64Img, $this->input(['base64key']));
            if(is_null($this->input(['bids']))) {
                redirect('/adverts/create')
                ->withErrors($validator)
                ->withInput()
                ->with('imagekey', 'base64key')
                ->with('images', $base64Img)
                ->with('bidcheckoff', 'a');
            } else {
                redirect('/adverts/create')
                ->withErrors($validator)
                ->withInput()
                ->with('imagekey', 'base64key')
                ->with('images', $base64Img)
                ->with('bidcheckon', 'a');
            }
        } else {
            if(is_null($this->input(['bids']))) {
                redirect('/adverts/create')
                ->withErrors($validator)
                ->withInput()
                ->with('bidcheckoff', 'a');
            } else {
                redirect('/adverts/create')
                ->withErrors($validator)
                ->withInput()
                ->with('bidcheckon', 'a');
            }
        }
    }
}