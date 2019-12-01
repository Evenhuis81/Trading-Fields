<?php

namespace App\Http\ViewComposers;

use App\Advert;
use Illuminate\View\View;

class AdvertComposer
{
    // protected $adverts;
    /**
     * Create an advert composer.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->adverts = Advert::all();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $adverts = Advert::all();
        $view->with('adverts', compact('adverts'));
    }

    public function lastzip(AdvertRepository $adverts, View $view)
    {
        dd($lastzip);
        $view->with('lastzip', $this->lastzip);
    }
}