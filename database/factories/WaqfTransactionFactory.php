<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WaqfTransaction>
 */
class WaqfTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $transactionTypes = ['wakaf', 'sadaqah', 'infaq'];
        $paymentStatuses = ['pending', 'completed', 'failed'];
        $paymentMethods = ['transfer_bank', 'cash', 'e-wallet'];
        
        return [
            'donor_name' => fake()->name(),
            'donor_email' => fake()->email(),
            'donor_phone' => fake()->phoneNumber(),
            'amount' => fake()->randomFloat(2, 10000, 10000000),
            'transaction_type' => fake()->randomElement($transactionTypes),
            'purpose' => fake()->sentence(),
            'payment_method' => fake()->randomElement($paymentMethods),
            'payment_status' => fake()->randomElement($paymentStatuses),
            'paid_at' => fake()->boolean(70) ? fake()->dateTimeBetween('-1 month', 'now') : null,
        ];
    }
}
