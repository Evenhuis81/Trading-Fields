<?php

namespace App\Http\ViewComposers;

use App\Category;
use Illuminate\View\View;

class CategoryComposer
{
    protected $categories;
    /**
     * Create a category composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categories = Category::all();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('categories', $this->categories);
    }
}