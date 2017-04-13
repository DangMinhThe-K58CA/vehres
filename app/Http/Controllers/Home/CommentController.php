<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\CreatingCommentRequest;
use App\Http\Requests\GettingCommentsRequest;
use App\Http\Requests\UpdatingCommentRequest;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Garage;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use App\Repositories\Contracts\CommentRepositoryInterface;
use App\Repositories\Contracts\GarageRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param $commentableType
     * @param $id
     * @return mixed
     */
    private function getSpecificInstance($commentableType, $commentable_id)
    {
        if ($commentableType === 'App\Models\Garage') {
            $garageRepo = App::make(GarageRepositoryInterface::class);
            $garage = $garageRepo->find($commentable_id);

            return $garage;
        }

        if ($commentableType === 'App\Models\Article') {
            $repo = App::make(ArticleRepositoryInterface::class);
            $article = $repo->find($commentable_id);

            return $article;
        }
    }

    /**
     * @param GettingCommentsRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(GettingCommentsRequest $request)
    {
        $commentableType = $request->input('commentable_type');
        $commentable_id = $request->input('commentable_id');
        $instance = $this->getSpecificInstance($commentableType, $commentable_id);
        if ($instance instanceof Garage) {
            $comments = $instance->comments()->orderBy('created_at', 'desc')->paginate(config('common.garage.comment.paginate'));

            return view('homes.comment.comments', ['instance' => $instance, 'comments' => $comments]);
        }

        if ($instance instanceof Article) {
            $comments = $instance->comments()->orderBy('created_at', 'desc')->paginate(config('common.article.comment.paginate'));

            return view('homes.comment.comments', ['instance' => $instance, 'comments' => $comments]);
        }
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
     * @param CreatingCommentRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(CreatingCommentRequest $request)
    {
        $commentableType = $request->input('commentable_type');
        $commentable_id = $request->input('commentable_id');
        $instance = $this->getSpecificInstance($commentableType, $commentable_id);

        if ($instance instanceof Garage) {
            $newCmtData = $request->all();
            $newCmtData['user_id'] = Auth::user()->id;
            $newCmt = $this->commentRepository->create($newCmtData);

            return view('homes.comment.comment', ['instance' => $instance, 'comment' => $newCmt]);
        }

        if ($instance instanceof Article) {
            $newCmtData = $request->all();
            $newCmtData['user_id'] = Auth::user()->id;
            $newCmt = $this->commentRepository->create($newCmtData);

            return view('homes.comment.comment', ['instance' => $instance, 'comment' => $newCmt]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param UpdatingCommentRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatingCommentRequest $request, $id)
    {
        $curCmt = $this->commentRepository->find($id);
        if(Auth::user()->can('update', $curCmt)) {
            $curCmt->update($request->all());

            return 1;
        } else {
            return $this->unauthorizedActionException();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $curCmt = $this->commentRepository->find($id);
        if(Auth::user()->can('delete', $curCmt)) {
            $this->commentRepository->delete($id);
            return 1;
        } else {
            return $this->unauthorizedActionException();
        }
    }

    /**
     * Result if unauthorized user.
     * @return mixed
     */
    private function unauthorizedActionException() {
        $failedResult = [
            'status' => -1,
            'data' => [[
                "error" => "unauthorized",
                "message" => "Action not allowed."
            ]]
        ];

        return \Response::json($failedResult);
    }
}
