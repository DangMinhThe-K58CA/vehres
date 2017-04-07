<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\AddingBookmarkRequest;
use App\Models\Article;
use App\Models\Bookmark;
use App\Models\Garage;
use App\Repositories\Contracts\ArticleRepositoryInterface;
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

        $searchOptions = [
            'Garage' => get_class(new Garage()),
            'Article' => get_class(new Article()),
        ];
        $bookmarksList = ['garage' => $garageBookmarks, 'article' => $articleBookmarks];
        $searchParamters = [
            'url' => action('Home\BookmarkController@search'),
        ];

        return view('homes.bookmark.index', [
            'bookmarksList' => $bookmarksList,
            'searchOptions' => $searchOptions,
            'searchParamters' => $searchParamters,
        ]);
    }

    /**
     * @param BookmarkRepositoryInterface $repo
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(BookmarkRepositoryInterface $repo, Request $request)
    {
        $bookmarkableType = $request->input('option');
        $searchKey = $request->input('searchKey');

        $results = $repo->searchOnInstance($searchKey, $bookmarkableType);

        return view('homes.bookmark.bookmarks', ['bookmarks' => $results]);
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
     * @param AddingBookmarkRequest $request
     * @return mixed
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

            return redirect()->to(action('Home\GarageController@show', ['id' => $garage->id]));
        }

        if ($bookmark->bookmarkable_type === get_class(new Article())) {
            $articleRepo = App::make(ArticleRepositoryInterface::class);
            $article = $articleRepo->find($bookmark->bookmarkable_id);

            return redirect()->to(action('Home\ArticleController@getSpecificArticle', ['id' => $article->id]));
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
//        $deletedBm = $this->repository->find($id);
        $this->repository->delete($id);

        $deletedBm = Bookmark::withTrashed()->where('id', $id)->first();
//        $deletedBm->delete();
//        dd($deletedBm);
//        $this->repository->delete($id);

        return \Response::json(['status' => 1, 'data' => $deletedBm]);
    }
}
