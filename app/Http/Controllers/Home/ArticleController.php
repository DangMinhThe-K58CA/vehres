<?php

namespace App\Http\Controllers\Home;

use App\Repositories\Contracts\ArticleRepositoryInterface;
use App\Repositories\Contracts\GarageRepositoryInterface;
use App\Repositories\Criteria\WhereConditionCriteria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    private $repository;

    public function __construct(ArticleRepositoryInterface $articleRepo)
    {
        $this->repository = $articleRepo;
        $this->repository->pushCriteria(new WhereConditionCriteria('status', '=', 1));
    }

    public function getSpecificArticle(Request $request) {
        $article = $this->repository->find($request->input('id'));
        if ($article === null) {
            abort(404, 'The requested article\'s not found !');
        }
        $data = [];
        $comments = $article->comments;
        $data['article'] = $article;
        $data['comments'] = $comments;

        $garageRepo = App::make(GarageRepositoryInterface::class);
        $topRateGarages = $garageRepo->getTopRated(config('common.garage.top_rated_number'));
        $data['topRateGarages'] = $topRateGarages;

        $recentViewedArticles = $this->repository->getRecentViewedBy(Auth::user()->id, config('common.article.recent_viewed_number'));
        $data['recentViewedArticles'] = $recentViewedArticles;

        return view('homes.article.showArticle', $data);
    }
}
