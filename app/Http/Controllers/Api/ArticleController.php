<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Request\Article\StoreRequest;

class ArticleController extends Controller
{
    public function store(StoreRequest $request, Article $article)
    {
        $article->create([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);
    }
}
