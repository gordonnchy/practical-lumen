<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();

        return response()->json(['todos' => $todos, 'status' => 'success'], 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required | string | max:255'
        ]);

        if($validator->fails()) return response()->json(['errors' => $validator->errors(), 'status' => 'fail'], 400);

        $todo = Todo::create($request->all());

        return response()->json(['todo' => $todo, 'status' => 'success'], 201);
    }

    public function show($id)
    {
        $todo = Todo::find($id);

        if(!$todo) {
            return response()->json(['error' => 'todo not found', 'status' => 'fail'], 404);
        }

        return response()->json(['todo' => $todo, 'status' => 'success'], 200);
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);

        if(!$todo) {
            return response()->json(['error' => 'todo not found', 'status' => 'fail'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required | string | max:255'
        ]);

        if($validator->fails()) return response()->json(['errors' => $validator->errors(), 'status' => 'fail'], 400);

        $todo->update($request->all());

        return response()->json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);

        if(!$todo) {
            return response()->json(['error' => 'todo not found', 'status' => 'fail'], 404);
        }
        
        $todo->delete();

        return response()->json(['status' => 'success'], 200);        
    }
}
