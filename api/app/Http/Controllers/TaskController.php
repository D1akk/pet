<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('user')->latest()->get();
        return response()->json($tasks, 200); 
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $request->user()->tasks()->create($request->validated());
        return response()->json(['task' => $task, 'user' => $task->user], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json(['task' => $task, 'user' => $task->user], 200); // Статус 200
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTaskRequest $request, Task $task)
    {
        Gate::authorize('modify', $task);
    
        $task->update($request->validated());
    
        return response()->json(['task' => $task, 'user' => $task->user], 200);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('modify', $task);
    
        $task->delete();
    
        return response()->json(['message' => 'The Task was deleted'], 204); 
    }
    
}
