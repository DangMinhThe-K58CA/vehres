<?php

namespace App\Http\Controllers\Home;

use App\Repositories\Contracts\ArticleRepositoryInterface;
use App\Repositories\Contracts\GarageRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Repositories\Criteria\WhereConditionCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $articleRepo;
    private $garageRepo;

    public function __construct(ArticleRepositoryInterface $articleRepo, GarageRepositoryInterface $garageRepo)
    {
        $activatedCriteria = new WhereConditionCriteria('status', '=', 1);

        $this->articleRepo = $articleRepo;
        $this->articleRepo->pushCriteria($activatedCriteria);

        $this->garageRepo = $garageRepo;
        $this->garageRepo->pushCriteria($activatedCriteria);
    }

    public function getGaragesListView()
    {
        return view('homes.components.garagesListView');
    }
    
    public function welcome(Request $request)
    {
        $data = [];
        $allArticles = $this->articleRepo->paginate(config('common.article.paginate'));
        $topRateGarages = $this->garageRepo->getTopRated(config('common.garage.top_rated_number'));
        $data['allArticles'] = $allArticles;
        $data['topRateGarages'] = $topRateGarages;

        if (Auth::check()) {
            $recentViewedArticles = $this->articleRepo->getRecentViewedBy(Auth::user()->id, config('common.article.recent_viewed_number'));
            $data['recentViewedArticles'] = $recentViewedArticles;
        } else {
            $mostViewedArticles = $this->articleRepo->getMostViewed(config('common.article.recent_viewed_number'));
            $data['mostViewedArticles'] = $mostViewedArticles;
        }

        return view('homes.welcome', $data);
    }

    public function index()
    {
        return view('homes.index');
    }

    public function myWorld()
    {
        return view('homes.myWorld');
    }
}
