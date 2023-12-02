<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Shift;
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
}
