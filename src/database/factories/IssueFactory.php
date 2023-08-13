<?php

namespace Database\Factories;

use App\Enums\IssueStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Task;
use App\Models\Bug;
use App\Models\Issue;
use App\Models\User;

use function Ramsey\Uuid\v1;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Issue>
 */
class IssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = (new Issue)->getChildTypes();
        $statuses = IssueStatusEnum::cases();
        return [
            'title' => fake()->sentence(),
            'description' => fake()->sentences(3, true),
            'type' => array_rand($types),
            'status' => $statuses[array_rand($statuses)],
        ];
    }

    public function task(): static
    {
        return $this->state(fn (array $attributes) => ['type' => Task::class]);
    }

    public function bug(): static
    {
        return $this->state(fn (array $attributes) => ['type' => Bug::class]);
    }
}
