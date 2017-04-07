<?php

namespace App\Repositories\Eloquent;

use App\Models\Article;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use App\Repositories\Contracts\VisitRepositoryInterface;
use App\Repositories\Criteria\WhereConditionCriteria;
use App\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ArticleRepository extends Repository implements ArticleRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Article::class;
    }

    public function getRecentViewedBy($userId, $number)
    {
        $visitRepo = App::make(VisitRepositoryInterface::class);
        $whereConditions = [
            new WhereConditionCriteria('user_id', '=', $userId),
            new WhereConditionCriteria('visitable_type', '=', get_class(new Article())),
            new WhereConditionCriteria('is_latest', '=', 1),
        ];

        foreach ($whereConditions as $condition) {
            $visitRepo->pushCriteria($condition);
        }
        $visitRepo->applyCriteria();
        $visits = $visitRepo->model->orderBy('created_at', 'asc')->limit($number)->get();

        $articles = [];
        foreach ($visits as $visit) {
            array_push($articles, $visit->visitable);
        }

        return $articles;
    }

    public function getMostViewed($number)
    {
        $visitRepo = App::make(VisitRepositoryInterface::class);
        $whereConditions = [
            new WhereConditionCriteria('visitable_type', '=', get_class(new Article())),
            new WhereConditionCriteria('is_latest', '=', 1),
        ];

        foreach ($whereConditions as $condition) {
            $visitRepo->pushCriteria($condition);
        }
        $visitRepo->applyCriteria();
        $visited = $visitRepo->model->select('visitable_id', DB::raw('COUNT(id) as total'))
                ->groupBy('visitable_id')
                ->orderBy('total', 'desc')
                ->take($number)
                ->get();

        $mostVisitedArticles = [];
        $articleRepo = App::make(ArticleRepositoryInterface::class);
        foreach ($visited as $visit) {
            array_push($mostVisitedArticles, $articleRepo->find($visit->visitable_id));
        }

        return $mostVisitedArticles;
    }
}
