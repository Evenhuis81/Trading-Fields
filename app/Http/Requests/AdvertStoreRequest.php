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
        // controleren of gebruiker is ingelogd?
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->input(['bids'])) {
            $bid = $this->input(['startbid']);
            } else {
                $bid = null;
            };
        $this->merge([
            'owner_id' => auth()->id(),
            'startbid' => $bid,
        ]);
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
            return [
            'owner_id' => 'required|integer|min:0',
            'title' => 'required|string|min:3|max:50',
            'description' => 'required|string|min:3|max:500',
            'price' => 'required|integer|min:0|max:10000',
            'category' => 'required|integer',
            'startbid' => ['nullable', 'integer', 'min:0', 'max:10000'],
            // how to validate base64 as file? (convert + validate?)
            'base64key' => 'required',
            'imagename' => 'required',
            ];
        } else {
            return [
                'owner_id' => 'required|integer|min:0',
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
    public function withValidator($validator)
    {
        $picturename = "";
        $base64Img=[];
        $redirect = redirect('/adverts/create')
        ->withErrors($validator)
        ->withInput();
        if ($this->hasFile('images')) {
            $picturename = $this->file('images')[0]->getClientOriginalName();
            foreach ($this->file('images') as $picture) {
                $imageData = base64_encode(file_get_contents($picture));
                $src = 'data: '.mime_content_type($picture->path()).';base64,'.$imageData;
                array_push($base64Img, $src);
                $picturename = $this->file('images')[0]->getClientOriginalName();
            }
                if(is_null($this->input(['bids']))) {
                    $redirect->with('images', $base64Img)
                    ->with('imagename', $picturename)
                    ->with('imagekey', 'base64key')
                    ->with('bidcheckoff', 'a');
                } else {
                    $redirect->with('images', $base64Img)
                    ->with('imagename', $picturename)
                    ->with('imagekey', 'base64key')
                    ->with('bidcheckon', 'a');
                }
        } elseif ($this->input(['base64key'])) {
            $picturename = $this->input('imagename');
            array_push($base64Img, $this->input(['base64key']));
            if(is_null($this->input(['bids']))) {
                $redirect->with('images', $base64Img)
                ->with('imagename', $picturename)
                ->with('imagekey', 'base64key')
                ->with('bidcheckoff', 'a');
            } else {
                $redirect->with('images', $base64Img)
                ->with('imagename', $picturename)
                ->with('imagekey', 'base64key')
                ->with('bidcheckon', 'a');
            }
        } else {
            if(is_null($this->input(['bids']))) {
                $redirect->with('bidcheckoff', 'a');
            } else {
                $redirect->with('bidcheckon', 'a');
            }
        }
    }
}