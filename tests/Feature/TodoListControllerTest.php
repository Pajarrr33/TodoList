<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListControllerTest extends TestCase
{
    public function testTodoList()
    {
        $this->withSession([
            "user" => "Fajar",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "test",
                ],
                [
                    "id" => "2",
                    "todo" => "test2",
                ]
            ]
        ])->get('/todoList')
            ->assertSeeText("1")
            ->assertSeeText("test")
            ->assertSeeText("2")
            ->assertSeeText("test2");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "Fajar",
        ])->post("/todoList",[])
        ->assertSeeText("Todo is missing");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "Fajar",
        ])->post("/todoList",[
            "todo" => "test"
        ])->assertRedirect("/todoList");
    }

    public function testRemoveTodoList()
    {
        $this->withSession([
            "user" => "Fajar",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "test",
                ],
                [
                    "id" => "2",
                    "todo" => "test2",
                ]
            ]
        ])->post("/todoList/1/delete")
        ->assertRedirect("/todoList");
    }
}
