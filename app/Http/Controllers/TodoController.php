<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\TodoStoreRequest;
use Illuminate\Http\TodoUpdateRequest;
use Illuminate\Http\TodoDoneRequest;
use App\Models\Todo;
use App\Http\Resources\TodoResource;

class TodoController extends Controller
{
    public function index(Request $request)
    {
         $todo = Todo::with('TodoType')->get();
         return $todo;
    }
    public function store(TodoStoreRequest $request)
    {
        $todo = Todo::create($request->only('note', 'todo_type_id', 'user_id'));
    
        return response()->json($todo);
    }

    public function show($id)
    {
        $todo = Todo::findOrFail($id);
        return response()->json($todo);
    }

    public function update(TodoUpdateRequest $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update([
            'note'=>$request->note,
            'user_id'=>$request->user_id,
            'todo_type_id'=>$request->todo_type_id,
            'is_done'=>true,
            'date_done'=>now(),
        ]);
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
        $request->filled('todo_type') ? $filters []= ['todo_type_id', 'like', $request->todo_type]: 0;
        $request->filled('user_id') ? $filters[] = ['user_id', '=', $request->user_id] : 0;

        $todos = Todo::with(['todoType','user'])->orderBy('id', 'desc')
        ->when($request->todo_type_id != [], function($q) use( $request) {
            return $q->whereIn('todo_type_id', $request->todo_type_id);
        })
        ->where($filters)
        ->get();

        // return $todos;
        return TodoResource::collection($todos);
    }

    public function done(TodoDoneRequest $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update([
            'is_done'=>true,
            'date_done' => $request->date_done ?? now(),
        ]);
        return response()->json($todo);
    }

    function report(Request $request)
    {
        $filters = [];
        $request->filled('is_done') ? $filters []= ['is_done', '=', $request->is_done]: 0;

        $doneReport = Todo::selectRaw('GROUP_CONCAT(DISTINCT is_done) as is_done, count(*) as total')
        ->where($filters)
        ->groupBy('is_done')
        ->orderBy('total','desc')
        ->get();

        $typeReport = Todo::selectRaw('GROUP_CONCAT(DISTINCT todo_types.name) as name, count(*) as total, sum(is_done=1) as done, sum(is_done=0) as not_done')
        ->where($filters)
        ->leftJoin('todo_types','todo_type_id','=','todo_types.id')
        ->groupBy('todo_type_id')
        ->orderBy('total','desc')
        ->get();

        $everyUserReport = Todo::selectRaw('GROUP_CONCAT(DISTINCT users.name) as name, count(*) as total, sum(is_done=1) as done, sum(is_done=0) as not_done')
        ->where($filters)
        ->leftJoin('users','user_id','=','users.id')
        ->groupBy('user_id')
        ->orderBy('total','desc')
        ->get();

        $sumAllTodos = $typeReport->sum('total');

        return [
            'sumAllTodos' => $sumAllTodos,
            'doneReport' => $doneReport,
            'typeReport' => $typeReport,
            'everyUserReport' => $everyUserReport,
        ];
    }

    function myTodo()
    {
        $todo = Todo::where('user_id', Auth::id())
        ->orderBy('is_done')
        ->get();
        
        return TodoResource::collection($todo);
    }
}
