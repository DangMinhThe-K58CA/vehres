<?php

namespace App\Http\Controllers\Home;

use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function getSpecificArticle(ArticleRepositoryInterface $repo, Request $request) {
        $article = $repo->find($request->input('id'));
        $comments = $article->comments;

        return view('homes.article.showArticle', ['article' => $article, 'comments' => $comments]);
    }
}
