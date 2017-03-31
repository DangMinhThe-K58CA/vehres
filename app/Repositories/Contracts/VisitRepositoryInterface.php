<?php

namespace App\Repositories\Contracts;

/**
 * Interface RepositoryInterface
 */
interface VisitRepositoryInterface extends RepositoryInterface
{
    public function searchOnInstance($key, $visitableType);
}
