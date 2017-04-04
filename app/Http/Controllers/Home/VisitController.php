<?php

namespace App\Http\Controllers\Home;

use App\Models\Article;
use App\Models\Garage;
use App\Models\Visit;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use App\Repositories\Contracts\GarageRepositoryInterface;
use App\Repositories\Contracts\VisitRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    private $repository;

    public function __construct(VisitRepositoryInterface $repo)
    {
        $this->repository = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $garageViews = $this->repository->findWhere([
            'is_latest' => 1,
            'visitable_type' => get_class(new Garage()),
            'user_id' => Auth::user()->id,
        ]);

        $articleViews = $this->repository->findWhere([
            'is_latest' => 1,
            'visitable_type' => get_class(new Article()),
            'user_id' => Auth::user()->id,
        ]);

        $searchOptions = [
            'Garage' => get_class(new Garage()),
            'Article' => get_class(new Article()),
        ];
        $searchParamters = [
            'url' => action('Home\VisitController@search'),
        ];
        $visitsList = ['garage' => $garageViews, 'article' => $articleViews];

        return view('homes.visit.index', [
            'visitsList' => $visitsList,
            'searchOptions' => $searchOptions,
            'searchParamters' => $searchParamters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visit = $this->repository->find($id);
        if ($visit->visitable_type === get_class(new Garage())) {
            $garageRepo = App::make(GarageRepositoryInterface::class);
            $garage = $garageRepo->find($visit->visitable_id);

            return view('homes.garage.showGarageOnMap', ['garage' => $garage]);
        }

        if ($visit->visitable_type === get_class(new Article())) {
            $articleRepo = App::make(ArticleRepositoryInterface::class);
            $article = $articleRepo->find($visit->visitable_id);

            return redirect()->to(action('Home\ArticleController@getSpecificArticle', ['id' => $article->id]));
        }
    }

    /**
     * @param VisitRepositoryInterface $repo
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(VisitRepositoryInterface $repo, Request $request)
    {
        $visitableType = $request->input('option');
        $searchKey = $request->input('searchKey');
        $results = $repo->searchOnInstance($searchKey, $visitableType);

        return view('homes.visit.visits', ['visits' => $results]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        $deletedVisit = Visit::withTrashed()->where('id', $id)->first();

        return \Response::json(['status' => 1, 'data' => $deletedVisit]);
    }
}
