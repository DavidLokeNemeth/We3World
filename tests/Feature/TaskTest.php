<?php

namespace Tests\Feature;


use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskTest extends TestCase
{
    protected int $userId;
    protected int $taskId;

    protected function setUp(): void
    {
        parent::setUp();

        //Need create a user for Authentication
        $user = User::factory()->create();
        $this->userId = $user->id;

        //Forgot need 1 task also (In case have none)
        $task = Task::factory()->create();
        $this->taskId = $task->id;
    }

    public function test_auth_requirement_task_list()
    {
        //Call without Authentication
        $response = $this->json('get', '/api/tasks');

        //Check answer
        $response->assertStatus(401)
            ->assertJsonPath('message', 'Unauthenticated.');
    }

    public function test_auth_requirement_new_task()
    {
        //Call without Authentication
        $response = $this->json('post', '/api/tasks', [
            'title' => 'Test',
            'description' => 'Test description',
            'due_date' => '2023-12-20'
        ]);

        //Check answer
        $response->assertStatus(401)
            ->assertJsonPath('message', 'Unauthenticated.');
    }

    public function test_auth_requirement_ask_task()
    {
        //Call without Authentication
        $response = $this->json('get', '/api/tasks/' . $this->taskId);

        //Check answer
        $response->assertStatus(401)
            ->assertJsonPath('message', 'Unauthenticated.');
    }

    public function test_auth_requirement_update_task()
    {
        //Call without Authentication
        $response = $this->json('put', '/api/tasks/' . $this->taskId, [
            'description' => 'Test description22',
        ]);

        //Check answer
        $response->assertStatus(401)
            ->assertJsonPath('message', 'Unauthenticated.');
    }

    public function test_auth_requirement_delete_task()
    {
        //Call without Authentication
        $response = $this->json('delete', '/api/tasks/' . $this->taskId, [
            'description' => 'Test description22',
        ]);

        //Check answer
        $response->assertStatus(401)
            ->assertJsonPath('message', 'Unauthenticated.');
    }

    public function test_check_task_list()
    {
        //Need Authentication
        $user = User::find($this->userId);
        Sanctum::actingAs($user);

        $response = $this->json('get', '/api/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    "id",
                    "title",
                    "description",
                    "due_date",
                    "status",
                ]
            ]);
    }

    public function test_new_task()
    {
        //Need Authentication
        $user = User::find($this->userId);
        Sanctum::actingAs($user);

        //Call without Authentication
        $response = $this->json('post', '/api/tasks', [
            'title' => 'Test',
            'description' => 'Test description',
            'due_date' => '2023-12-20'
        ]);

        //Check answer
        $response->assertStatus(201)
            ->assertJsonStructure([
                "id",
                "title",
                "description",
                "due_date",
            ]);
    }

    public function test_ask_task()
    {
        //Need Authentication
        $user = User::find($this->userId);
        Sanctum::actingAs($user);

        //Call without Authentication
        $response = $this->json('get', '/api/tasks/' . $this->taskId);

        //Check answer
        $response->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "title",
                "description",
                "due_date",
                "status",
            ]);
    }

    public function test_update_task()
    {
        //Need Authentication
        $user = User::find($this->userId);
        Sanctum::actingAs($user);

        //Call without Authentication
        $response = $this->json('put', '/api/tasks/' . $this->taskId, [
            'description' => 'Test description22',
        ]);

        //Check answer
        $response->assertStatus(200)
            ->assertJsonStructure([
                "id",
                "title",
                "description",
                "due_date",
                "status",
            ])
            ->assertJsonPath('description', 'Test description22');
    }

    public function test_delete_task()
    {
        //Need Authentication
        $user = User::find($this->userId);
        Sanctum::actingAs($user);

        //Call without Authentication
        $response = $this->json('delete', '/api/tasks/' . $this->taskId, [
            'description' => 'Test description22',
        ]);

        //Check answer
        $response->assertStatus(200)
            ->assertJsonPath('message', 'Deleted successfully');
    }

    protected function tearDown(): void
    {
        //Need remove User and Task from db
        User::destroy($this->userId);
        //We already delete in delete task
//        Task::destroy($this->taskId);
        parent::tearDown();
    }
}
