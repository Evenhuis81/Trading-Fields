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
    public function withValidator($validator)
    {
    // $validator->after(function ($validator) {
        // $req = 1;
        // $req = $this->validated();
        // dd($this->input['startbid']);
        if(is_null($this->input(['bids']))) {
        // $validator->after(function ($validator){
                redirect('/adverts/create')
                ->withErrors($validator)
                ->withInput()
                ->with('bidcheck', 'a');
            } else {
                redirect('/adverts/create')
                ->withErrors($validator)
                ->withInput();
            } 
        // });
    }
}