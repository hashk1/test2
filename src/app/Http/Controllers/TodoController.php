<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    // 一覧表示
    public function index()
    {
        $todos = Todo::orderBy('created_at', 'desc')->get();
        return view('todos.index', compact('todos'));
    }

    // 新規作成
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => false,
        ]);

        return redirect()->route('todos.index')->with('success', 'Todoを追加しました');
    }

    // 完了/未完了の切り替え
    public function toggle(Todo $todo)
    {
        $todo->update([
            'completed' => !$todo->completed,
        ]);

        return redirect()->route('todos.index');
    }

    // 削除
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()->route('todos.index')->with('success', 'Todoを削除しました');
    }
}
