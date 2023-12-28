<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user_id = Auth::user()->id;

        $tasks = Task::where('user_id', $user_id)->get();

        return response(['tasks' => $tasks]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'titulo' => 'required',
        ]);

        $titulo = $fields['titulo'];
        $user = Auth::user()->id;

        Task::create([
            'titulo' => $titulo,
            'user_id' => $user
        ]);

        $data = ['message' => 'Task criada com sucesso!'];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        $task = Task::find($id);
        $status = $task->status;

        $status_atualizado;
        if($status == false) {
            $status_atualizado = true;
        } else {
            $status_atualizado = false;
        }

        $task->status = $status_atualizado;
        $task->update();

        return response()->json(['message' => 'Task atualizada'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        $task->delete();

        return response()->json(null, 204);
    }
}
