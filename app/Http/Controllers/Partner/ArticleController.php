<?php

namespace App\Http\Controllers\Partner;

use App\Http\Requests\CreatingArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use MyHelper;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    private $repository;

    public function __construct(ArticleRepositoryInterface $repo)
    {
        $this->repository = $repo;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $status = $request->input('status');

        $articles = Auth::user()->articles()->where('status', $status)->paginate(config('common.paging_number'));

        return view('partners.articles.index', [
            'status' => $status,
            'articles' => $articles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('partners.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatingArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatingArticleRequest $request)
    {
        $data = $request->except('avatar');
        $data['user_id'] = Auth::user()->id;
        if ($request->hasFile('avatar')) {
            $filePath = $this->uploadFile($request->file('avatar'));
            $data['avatar'] = $filePath;
        }

        $article = $this->repository->create($data);

        return redirect()->to(action('Partner\ArticleController@show', ['article' => $article->id]))
            ->with('success', 'Your article has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = $this->repository->find($id);
        if (! Auth::user()->can('view', $article)) {
            abort(403);
        }
        if ($article === null) {
            abort(404, 'Article\'s not found !');
        }

        return view('partners.articles.showArticle', ['article' => $article]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = $this->repository->find($id);
        if ($article === null) {
            abort(404, 'Article\'s not found !');
        }

        return view('partners.articles.edit', ['article' => $article]);
    }


    public function uploadFile(UploadedFile $file)
    {
        return MyHelper::uploadFile($file);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, $id)
    {
        $data = $request->except(['_method', '_token']);
        $article = $this->repository->find($id);

        if (! Auth::user()->can('update', $article)) {
            abort(403);
        }

        if ($request->hasFile('avatar')) {
            $filePath = $this->uploadFile($request->file('avatar'));

            $data['avatar'] = $filePath;
        }

        $article->update($data);

        return redirect()->to(action('Partner\ArticleController@show', ['article' => $id]))->with('success', 'Article updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
