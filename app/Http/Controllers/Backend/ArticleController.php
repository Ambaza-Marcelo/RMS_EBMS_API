<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Article;
use App\Models\Category;
use App\Exports\ArticleExport;
use App\Models\Stock;
use App\Imports\ArticlesImport;
use Excel;
class ArticleController extends Controller
{
    //
     public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('article.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any article !');
        }

        $articles = Article::all();
        return view('backend.pages.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('article.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any article !');
        }
        $categories = Category::all();
        return view('backend.pages.article.create', compact(
            'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('article.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any article !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'unit' => 'required|max:20',
            'unit_price' => 'required',
            'quantity' => 'required',
            'category_id' => 'required'
        ]);

        // Create New Article
        $article = new Article();
        $article->name = $request->name;
        $artCode = strtoupper(substr($request->name, 0, 3));
        $article->code = $artCode.date("y").substr(number_format(time() * mt_rand(), 0, '', ''), 0, 6);
        $article->unit = $request->unit;
        $article->unit_price = $request->unit_price;
        $article->quantity = $request->quantity;
        $article->status = $request->status;
        $article->specification = $request->specification;
        $article->expiration_date = $request->expiration_date;
        $article->threshold_quantity = $request->threshold_quantity;
        $article->category_id = $request->category_id;
        $article->created_by = $this->user->name;
        $article->save();

        $stock = new Stock();

        $article_id = Article::latest()->first()->id;

        $unit = Article::where('id',$article_id)->value('unit');
        $quantity = Article::where('id',$article_id)->value('quantity');
        $threshold_quantity = Article::where('id',$article_id)->value('threshold_quantity');

        $stock->article_id = $article_id;
        $stock->quantity = $quantity;
        $stock->threshold_quantity = $threshold_quantity;
        $stock->total_value = $quantity * $article->unit_price;
        $stock->unit = $unit;
        $stock->created_by = $this->user->name;
        $stock->save();

        session()->flash('success', 'Article has been created !!');
        return redirect()->route('admin.articles.index');
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


    public function uploadArticle(Request $request)
    {
        Excel::import(new ArticlesImport, $request->file('file')->store('temp'));
        return redirect()->back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('article.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any article !');
        }

        $article = Article::find($id);
        $categories = Category::all();
        return view('backend.pages.article.edit', compact(
            'article', 
            'categories'));
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
        if (is_null($this->user) || !$this->user->can('article.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any article !');
        }

        // Create New Article
        $article = Article::find($id);

        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'unit_price' => 'required',
            'quantity' => 'required',
            'category_id' => 'required'
        ]);


        $article->name = $request->name;
        $article->unit = $request->unit;
        $article->unit_price = $request->unit_price;
        $article->quantity = $request->quantity;
        $article->status = $request->status;
        $article->specification = $request->specification;
        $article->expiration_date = $request->expiration_date;
        $article->threshold_quantity = $request->threshold_quantity;
        $article->category_id = $request->category_id;
        $article->created_by = $this->user->name;
        $article->save();


        //$article_id = Article::latest()->first()->id;

        $unit = Article::where('id',$id)->value('unit');
        $quantity = Article::where('id',$id)->value('quantity');
        $threshold_quantity = Article::where('id',$id)->value('threshold_quantity');

        $stock = Stock::where('article_id',$id)->first();
        $stock->article_id = $id;
        $stock->total_value = $quantity * $article->unit_price;
        $stock->unit = $unit;
        $stock->quantity = $quantity;
        $stock->threshold_quantity = $threshold_quantity;
        $stock->created_by = $this->user->name;
        $stock->save();

        session()->flash('success', 'Article has been updated !!');
        return redirect()->route('admin.articles.index');
    }

    public function get_article_data()
    {
        return Excel::download(new ArticleExport, 'articles.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('article.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any article !');
        }

        $article = Article::find($id);
        if (!is_null($article)) {
            $article->delete();
        }

        session()->flash('success', 'Article has been deleted !!');
        return back();
    }
}
