<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Shift;
use App\Models\Worker;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShiftTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function testItListsAllShifts()
    {
        Shift::factory()->count(5)->create();

        $response = $this->json('GET', route('shifts.index'));
        $response->assertOk()
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data'
            ]);
    }

    /**
     * @test
     */
    public function testItCreatesShiftForWorker()
    {
        $worker = Worker::factory()->create();

        $input = [
            'worker_id' => $worker->id,
            'start_time' => '2023-04-04 16:00:00',
            'end_time' => '2023-04-04 24:00:00'
        ];

        $response = $this->json('POST', route('shifts.store'), $input);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'worker_id' => $input['worker_id']
            ]);
    }

    /**
     * @test
     */
    public function testAShiftCannotHaveAnInvalidStartTime()
    {
        $worker = Worker::factory()->create();

        $input = [
            'worker_id' => $worker->id,
            'start_time' => '2023-04-04 12:00:00',
            'end_time' => '2023-04-04 24:00:00'
        ];

        $response = $this->json('POST', route('shifts.store'), $input);
        $response->assertStatus(400)
            ->assertJsonFragment([
                'error' => 'The selected start time is invalid'
            ]);
    }
}
