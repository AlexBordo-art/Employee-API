<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'hours_worked' => $this->faker->numberBetween(1, 8),
            'is_paid' => false,
        ];
    }
}
