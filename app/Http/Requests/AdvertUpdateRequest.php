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
        return $this->user()->can('update', $advert);
    }

    protected function prepareForValidation()
    {
        if (!is_int($this->input(['condition_id']))) {
            $this->merge([
                'condition_id' => null,
            ]);
        }
        if ($this->input(['bids'])) {
            $bid = $this->input(['startbid']);
            } else {
                $bid = null;
            };
        $this->merge([
            // merge owner_id?? (like with create) or useless (cause doublecheck)  >> I think no
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
        if ($this->input('unchanged')) {
            return [
            'title' => 'required|string|min:3|max:50',
            'description' => 'required|string|min:3|max:500',
            'condition_id' => 'nullable|integer',
            'price' => 'required|integer|min:0|max:10000',
            'category' => 'required|integer',
            'startbid' => ['nullable', 'integer', 'min:0', 'max:'.$this->input(['price'])],
            'delivery_id' => 'required|integer',
            'name' => 'required|string|min:3|max:50',
            'phonenr' => 'nullable|string|min:10|max:10',
            'zipcode' => 'required|string|min:6|max:6',
            ];
        } elseif ($this->hasFile('images')) {
            return [
                'title' => 'required|string|min:3|max:50',
                'description' => 'required|string|min:3|max:500',
                'condition_id' => 'nullable|integer',
                'price' => 'required|integer|min:0|max:10000',
                'category' => 'required|integer',
                'startbid' => ['nullable', 'integer', 'min:0', 'max:'.$this->input(['price'])],
                'delivery_id' => 'required|integer',
                'name' => 'required|string|min:3|max:50',
                'phonenr' => 'nullable|string|min:10|max:10',
                'zipcode' => 'required|string|min:6|max:6',
                'images' => 'required|array|min:1',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'imagename' => 'required',
                ];
        } elseif ($this->input(['base64key'])) {
            return [
                'title' => 'required|string|min:3|max:50',
                'description' => 'required|string|min:3|max:500',
                'condition_id' => 'nullable|integer',
                'price' => 'required|integer|min:0|max:10000',
                'category' => 'required|integer',
                'startbid' => ['integer', 'min:0', 'max:'.$this->input(['price'])],
                'delivery_id' => 'required|integer',
                'name' => 'required|string|min:3|max:50',
                'phonenr' => 'nullable|string|min:10|max:10',
                'zipcode' => 'required|string|min:6|max:6',
                'base64key' => 'required',
                'imagename' => 'required',
                ];
        }
    }

    public function withValidator($validator)
    {
        // dd($validator);
        $advert = $this->route('advert');
        $picturename = "";
        $base64Img=[];
        $redirect = redirect()->route('adverts.edit', ['advert' => $advert->id])
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
                    return $redirect->with('images', $base64Img)
                    ->with('imagename', $picturename)
                    ->with('imagekey', 'base64key')
                    ->with('bidcheckoff', 'a');
                } else {
                    return $redirect->with('images', $base64Img)
                    ->with('imagename', $picturename)
                    ->with('imagekey', 'base64key')
                    ->with('bidcheckon', 'a');
                }
        } elseif ($this->input(['base64key'])) {
            $picturename = $this->input('imagename');
            array_push($base64Img, $this->input(['base64key']));
            if(is_null($this->input(['bids']))) {
                return $redirect->with('images', $base64Img)
                ->with('imagename', $picturename)
                ->with('imagekey', 'base64key')
                ->with('bidcheckoff', 'a');
            } else {
                return $redirect->with('images', $base64Img)
                ->with('imagename', $picturename)
                ->with('imagekey', 'base64key')
                ->with('bidcheckon', 'a');
            }
        }
         else {
            if(is_null($this->input(['bids']))) {
                return $redirect->with('bidcheckoff', 'a');
            } else {
                return $redirect->with('bidcheckon', 'a');
            }
        }
    }
}