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
     * A basic feature test example.
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
}
