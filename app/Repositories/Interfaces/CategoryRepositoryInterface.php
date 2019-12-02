<?php

namespace App\Repositories;

interface CategoryRepositoryInterface
{
    /**
     * Get's a category by it's ID
     *
     * @param int
     */
    public function get($category_id);

    /**
     * Get's all categories.
     *
     * @return mixed
     */
    public function all();
}