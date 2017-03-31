<?php

namespace App\Repositories\Contracts;

/**
 * Interface RepositoryInterface
 */
interface BookmarkRepositoryInterface extends RepositoryInterface
{
    public function searchOnInstance($key, $bookmarkableType);
}
