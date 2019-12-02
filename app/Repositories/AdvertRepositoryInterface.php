<?php

namespace App\Repositories;

interface advertRepositoryInterface
{
    /**
     * Get's an advert by it's ID
     *
     * @param int
     */
    public function get($advert_id);

    /**
     * Get's all adverts.
     *
     * @return mixed
     */
    public function all();
    public function admanAdverts();
}