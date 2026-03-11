<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Exception;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'amount',
        'currency_code',
        'type',
        'status',
        'environment',
        'user_id',
        'stripe_intent_id',
        'stripe_customer_id',
        'meta',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'float',
        'meta' => 'array',
    ];

    public function process()
    {
        $payment = $this;
        $id = $payment->id;
        $payload = $payment->meta['payload'] ?? [];
        try {
            $type = $payload['metadata']['type'] ?? '';
            $draftIds = $payload['metadata']['draft_ids'] ?? '';
            $userId = $payload['metadata']['user_id'] ?? null;
            if (!empty($draftIds)) {
                $draftIds = explode(',', $draftIds);
            }
            if (!empty($payment->processed_at)) {
                Log::error('PAYMENT', ['msg' => 'Already processed', 'id' => $id]);
                return;
            }
            if (empty($userId)) {
                Log::error('PAYMENT', ['msg' => 'UserId empty', 'id' => $id]);
                return;
            }
            if ($type == 'location_boost') {
                DB::transaction(function () use ($payment, $draftIds, $userId) {
                    $items = LocationBoostCity::query()
                        ->where('status', 'draft')
                        ->where('user_id', $userId)
                        ->whereIn('id', $draftIds)->get(['id']);
                    foreach ($items as $item) {
                        $item->update([
                            'status' => 'active',
                            'amount' => $payment->amount,
                            'currency_code' => $payment->currency_code,
                        ]);
                    }
                    $payment->update(['processed_at' => now()]);
                });
            }
        } catch (Exception $e) {
            Log::error('PAYMENT', ['msg' => $e->getMessage(), ['id' => $id]]);
        }
    }

    public static function createTable()
    {
        $messages = [];
        $tableName = 'payments';
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->decimal('amount', 10, 2);
                $table->string('currency_code', 5);
                $table->string('type', 100)->nullable();
                $table->string('status');
                $table->string('environment', 10);
                $table->foreignId('user_id')->nullable();
                $table->string('stripe_intent_id');
                $table->string('stripe_customer_id')->nullable();
                $table->json('meta')->nullable();
                $table->dateTime('processed_at')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('created_at')->nullable();
            });
            $messages[] = "$tableName created";
        }
        return $messages;
    }
}
