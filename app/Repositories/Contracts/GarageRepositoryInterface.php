<?php

namespace App\Repositories\Contracts;

/**
 * Interface RepositoryInterface
 */
interface  GarageRepositoryInterface extends RepositoryInterface
{
    public function getTopRated($numOfGarage);
}
