<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Category;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    //ビューの表示
    public function index()
    {
        $todos = Todo::with('category')->get();
        $categories = Category::all();

        return view('index', compact('todos', 'categories'));
    }

    //検索アクションの定義(category_idとkeywordで検索)
    public function search(Request $request)
    {
        $todos = Todo::with('category')->CategorySearch($request->category_id)->KeywordSearch($request->keyword)->get();
        $categories = Category::all();

        return view('index', compact('todos', 'categories'));
    }

    //Todoの新規作成
    public function store(TodoRequest $request)
    {
        $todo = $request->only(['content', 'category_id']);
        Todo::create($todo);

        return redirect('/')->with('message', 'Todoを作成しました');
    }

    //Todoの更新
    public function update(TodoRequest $request)
    {
        $todo = $request->only(['content']);
        Todo::find($request->id)->update($todo);

        return redirect('/')->with('message', 'Todoを更新しました');
    }

    //Todoの削除
    public function destroy(Request $request)
    {
        Todo::find($request->id)->delete();

        return redirect('/')->with('message', 'Todoを削除しました');
    }
}
