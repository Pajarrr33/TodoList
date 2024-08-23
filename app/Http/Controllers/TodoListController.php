<?php

namespace App\Http\Controllers;

use App\Services\TodoListService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoListController extends Controller
{

    private TodoListService $todoListService;

    public function __construct(TodoListService $todoListService) {
        $this->todoListService = $todoListService;
    }


    public function viewTodo(Request $request)
    {
        return response()->view("todolist.todolist", [
            "title" => "todolist",
            "todolist" => $this->todoListService->getTodo()
        ]);
    }

    public function addTodo(Request $request): Response|RedirectResponse
    {
        $todo = $request->input("todo");

        if(empty($todo)) {
            return response()->view("todolist.todolist", [
                "title" => "todolist",
                "todolist" => $this->todoListService->getTodo(),
                "error" => "Todo is missing"
            ]);
        }

        $this->todoListService->saveTodo(uniqid(), $todo);

        return redirect('/todoList');
    }

    public function removeTodo(Request $request,string $id): RedirectResponse
    {
        $this->todoListService->removeTodo($id);

        return redirect("/todoList");
    }
}
