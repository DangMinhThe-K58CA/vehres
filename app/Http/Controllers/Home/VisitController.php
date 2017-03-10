<?php

namespace App\Http\Controllers\Home;

use App\Models\Article;
use App\Models\Garage;
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

        $visitsList = ['garage' => $garageViews, 'article' => $articleViews];
        return view('homes.visit.index', ['visitsList' => $visitsList]);
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

            return $visit->visitable->title;
        }
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
        $deletedBm = $this->repository->find($id);
        $this->repository->delete($id);

        return \Response::json(['status' => 1, 'data' => $deletedBm]);
    }
}
