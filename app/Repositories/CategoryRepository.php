<?php

namespace App\Repositories;

use App\Category;

class PostRepository implements PostRepositoryInterface
{
    /**
     * Get's a category by it's ID
     *
     * @param int
     * @return collection
     */
    public function get($category_id)
    {
        return Category::find($category_id);
    }

    /**
     * Get's all categories.
     *
     * @return mixed
     */
    public function all()
    {
        return Category::all();
    }
}