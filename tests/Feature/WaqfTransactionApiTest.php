<?php

namespace Tests\Feature;

use App\Models\WaqfTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WaqfTransactionApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_transactions(): void
    {
        WaqfTransaction::factory()->create([
            'donor_name' => 'Test Donor',
            'amount' => 100000,
            'transaction_type' => 'wakaf',
        ]);

        $response = $this->getJson('/api/waqf-transactions');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'data' => [
                        '*' => ['id', 'donor_name', 'amount', 'transaction_type', 'payment_status', 'transaction_code']
                    ]
                ]
            ]);
    }

    public function test_can_create_transaction(): void
    {
        $transactionData = [
            'donor_name' => 'Ahmad Fauzi',
            'donor_email' => 'ahmad@example.com',
            'donor_phone' => '081234567890',
            'amount' => 500000,
            'transaction_type' => 'wakaf',
            'purpose' => 'Pembangunan asrama santri',
            'payment_method' => 'transfer_bank',
        ];

        $response = $this->postJson('/api/waqf-transactions', $transactionData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Transaksi wakaf berhasil dibuat',
            ]);

        $this->assertDatabaseHas('waqf_transactions', [
            'donor_name' => 'Ahmad Fauzi',
            'amount' => '500000.00',
        ]);
    }

    public function test_can_get_single_transaction(): void
    {
        $transaction = WaqfTransaction::factory()->create();

        $response = $this->getJson("/api/waqf-transactions/{$transaction->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $transaction->id,
                    'donor_name' => $transaction->donor_name,
                ]
            ]);
    }

    public function test_can_update_transaction(): void
    {
        $transaction = WaqfTransaction::factory()->create([
            'payment_status' => 'pending',
        ]);

        $updateData = [
            'payment_status' => 'completed',
            'paid_at' => now()->toISOString(),
        ];

        $response = $this->putJson("/api/waqf-transactions/{$transaction->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Transaksi wakaf berhasil diperbarui',
            ]);

        $this->assertDatabaseHas('waqf_transactions', [
            'id' => $transaction->id,
            'payment_status' => 'completed',
        ]);
    }

    public function test_can_delete_transaction(): void
    {
        $transaction = WaqfTransaction::factory()->create();

        $response = $this->deleteJson("/api/waqf-transactions/{$transaction->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Transaksi wakaf berhasil dihapus',
            ]);

        $this->assertDatabaseMissing('waqf_transactions', [
            'id' => $transaction->id,
        ]);
    }

    public function test_transaction_code_is_auto_generated(): void
    {
        $transactionData = [
            'donor_name' => 'Test Donor',
            'amount' => 100000,
            'transaction_type' => 'wakaf',
        ];

        $response = $this->postJson('/api/waqf-transactions', $transactionData);

        $response->assertStatus(201);
        
        $transaction = WaqfTransaction::where('donor_name', 'Test Donor')->first();
        
        $this->assertNotNull($transaction->transaction_code);
        $this->assertStringStartsWith('WQF-', $transaction->transaction_code);
    }
}
