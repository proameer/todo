<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        // $todo = Todo::create($request->all());
        return Todo::all();
    }
    public function store(Request $request)
    {
        $todo = Todo::create([
            'note'=>$request->note,
            ]);
        return response()->json($todo);
    }

    public function show($id)
    {
        $todo = Todo::findOrFail($id);
        return response()->json($todo);
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update($request->all());
        return response()->json($todo);
    }

    public function delete($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return response()->json(['message' => 'Todo deleted successfully']);
    }

    function search(Request $request)
    {
        $filters = [];
        $request->filled('note') ? $filters []= ['note', 'like', "%{$request->note}%"]: 0;
        $request->filled('is_done') ? $filters []= ['is_done', '=', $request->is_done]: 0;
        $request->filled('date_done') ? $filters []= ['date_done', '=', $request->date_done]: 0;
        $request->filled('start_date') ? $filters []= ['date_done', '>=', $request->start_date] : 0;
        $request->filled('end_date') ? $filters []= ['date_done', '<=', $request->end_date] : 0;
        $request->filled('start_date1') ? $filters []= ['created_at', '>=', $request->start_date1] : 0;
        $request->filled('end_date1') ? $filters []= ['created_at', '<=', $request->end_date1] : 0;

        $todos = Todo::orderBy('id', 'desc')
        ->where($filters)
        ->get();

        return $todos;
    }
}
