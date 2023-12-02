<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomHours = [0, 8, 16];
        $randomKeys = array_rand($randomHours);

        $randomDays = rand(0, 30);
        $today = Carbon::today();

        $randomDate = $today->addDays($randomDays)->format('Y-m-d');
        $startTime = Carbon::parse($randomDate)->addHours($randomHours[$randomKeys]);
        $endTime = Carbon::parse($startTime)->addHours(8);

        return [
            "worker_id" => Worker::factory(),
            "start_time" => $startTime,
            'end_time' => $endTime
        ];
    }
}
