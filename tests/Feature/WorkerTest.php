<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Worker;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function testItListsAllWorkers()
    {
        Worker::factory()->count(5)->create();

        $response = $this->json('GET', route('workers.index'));
        $response
            ->assertOk()
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data'
            ]);
    }

    /**
     * @test
     */
    public function testItCreatesAWorker()
    {
        $input = ['name' => $this->faker->name];

        $response = $this->json('POST', route('workers.store'), $input);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => $input['name']
            ]);
    }
}
