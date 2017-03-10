<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\AddingBookmarkRequest;
use App\Models\Article;
use App\Models\Garage;
use App\Repositories\Contracts\BookmarkRepositoryInterface;
use App\Repositories\Contracts\GarageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{

    private $repository;

    public function __construct(BookmarkRepositoryInterface $repo)
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
        $garageBookmarks = $this->repository->findWhere([
            'bookmarkable_type' => get_class(new Garage()), 'user_id' => Auth::user()->id
        ]);

        $articleBookmarks = $this->repository->findWhere([
            'bookmarkable_type' => get_class(new Article()), 'user_id' => Auth::user()->id
        ]);

        $bookmarksList = ['garage' => $garageBookmarks, 'article' => $articleBookmarks];
        return view('homes.bookmark.index', ['bookmarksList' => $bookmarksList]);
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
    public function store(AddingBookmarkRequest $request)
    {
        $bmData = $request->all();
        $bmData['user_id'] = Auth::user()->id;
        $newBm = $this->repository->create($bmData);

        return \Response::json(['status' => 1, 'data' => $newBm]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bookmark = $this->repository->find($id);
        if ($bookmark->bookmarkable_type === get_class(new Garage())) {
            $garageRepo = App::make(GarageRepositoryInterface::class);
            $garage = $garageRepo->find($bookmark->bookmarkable_id);
            
            return view('homes.garage.showGarageOnMap', ['garage' => $garage]);
        }

        if ($bookmark->bookmarkable_type === get_class(new Article())) {

            return $bookmark->bookmarkable->title;
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
