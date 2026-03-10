<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
