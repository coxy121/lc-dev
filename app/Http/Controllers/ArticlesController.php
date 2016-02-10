<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;
use App\Http\Requests\ArticleRequest;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UnauthorizedException;
use App\Http\AuthTraits\OwnsRecord;
use DB;
use App\User;
use Redirect;

class ArticlesController extends Controller
{
    use OwnsRecord;

    /**
     * create a new article controller instance
     * ArticlesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']] );
        //$this->middleware('admin',['only'=> 'index']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        if(Auth::user()->isAdmin()) {
            $articles = Article::latest('published_at')->published()->get();
        }else{
            $currentUser = Auth::id();
            $articles = Article::latest('published_at')->published()->where('user_id', '=', $currentUser)->get();
        }
        return view('articles.index', compact('articles'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.show', compact('article'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::lists('tag_name','id');
        return view('articles.create',compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $this->createArticle($request);
        return redirect('articles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $user = User::where('id', '=', $article->user_id)->first();
        if( ! $this->adminOrCurrentUserOwns($article)){
            throw new UnauthorizedException;
        }

        $tags = Tag::lists('tag_name','id');
        return view('articles.edit', compact('article','tags'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws UnauthorizedException
     */
    public function update(ArticleRequest $request, $id)
    {

        $article = Article::findOrFail($id);
        if ($this->userNotOwnerOf($article)) {
            throw new UnauthorizedException;
        }
        $input = $request->all();
        $input['user_id']=Auth::user()->id;

        $article->update($input);
        $this->syncTags($article,$request->input('tagList'));

        alert()->success('Congrats!', 'You updated your article');
        return redirect('articles');
    }


    /**
     * Sync up the list of tags in database
     * @param Article $article
     * @param array $tags
     */
    private function syncTags(Article $article, array $tags)
    {
        $article->tags()->sync($tags);
    }

    /**
     * Save a new article
     * @param ArticleRequest $request
     * @return mixed
     */
    private function createArticle(ArticleRequest $request)
    {
        $article = Auth::user()->articles()->create($request->all());
        $this->syncTags($article,$request->input('tagList'));
        return $article;
    }
}
