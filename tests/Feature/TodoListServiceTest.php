<?php

namespace Tests\Feature;

use App\Services\TodoListService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodoListServiceTest extends TestCase
{
    private TodoListService $todoListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todoListService = $this->app->make(TodoListService::class);
    }

    public function testTodoNotNull()
    {
        self::assertNotNull($this->todoListService);
    }

    public function testSaveTodo()
    {
        $this->todoListService->saveTodo("1","Fajar");

        $todolist = Session::get("todolist");

        foreach ($todolist as $t) {
            self::assertEquals("1", $t['id']);
            self::assertEquals("Fajar",$t['todo']);
        }
    }

    public function testGetTodoEmpty()
    {
        self::assertEquals([], $this->todoListService->getTodo());
    }

    public function testGetTodoNotEmpty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "test",
            ],
            [
                "id" => 2,
                "todo" => "test2",
            ]
        ];

        $this->todoListService->saveTodo("1","test");
        $this->todoListService->saveTodo("2","test2");

        self::assertEquals($expected,$this->todoListService->getTodo());
    }

    public function testRemoveTodo()
    {
        $this->todoListService->saveTodo("1","test");
        $this->todoListService->saveTodo("2","test2");

        self::assertEquals(2,sizeof($this->todoListService->getTodo()));

        $this->todoListService->removeTodo("3");

        self::assertEquals(2,sizeof($this->todoListService->getTodo()));

        $this->todoListService->removeTodo("2");

        self::assertEquals(1,sizeof($this->todoListService->getTodo()));

        $this->todoListService->removeTodo("1");

        self::assertEquals(0,sizeof($this->todoListService->getTodo()));
    }
}
