<?php

namespace App\Repositories\Interfaces;



interface AdvertRepositoryInterface
{
    public function all();

    public function getByUser();
}