<?php

namespace App\Repositories\Contracts;

/**
 * Interface RepositoryInterface
 */
interface ArticleRepositoryInterface extends RepositoryInterface
{
    public function getRecentViewedBy($userId, $number);

    public function getMostViewed($number);
}
