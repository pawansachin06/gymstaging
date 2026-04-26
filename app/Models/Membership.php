<?php

namespace App\Models;

use App\Traits\UuidTrait;
use App\Traits\StaticTableName;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;

class Membership extends Model
{
    use UuidTrait, StaticTableName, SoftDeletes;
    
    protected $fillable = [
        'name', 'excerpt', 'currency_code', 'duration', 'is_popular',
        'overline', 'underline', 'sequence', 'features', 'capabilities', 'meta',
        'stripe_price_id', 'stripe_price_ids', 'stripe_product_id',
    ];

    protected $casts = [
        'name' => 'string',
        'excerpt' => 'string',
        'overline' => 'string',
        'underline' => 'string',
        'currency_code' => 'string',
        'duration' => 'string',
        'is_popular' => 'boolean',
        'sequence' => 'integer',
        'features' => 'array',
        'capabilities' => 'array',
        'meta' => 'array',
        'stripe_price_ids' => 'array',
    ];

    public function hasCapability($key)
    {
        return data_get($this->capabilities, $key, false);
    }

    public static function createTable()
    {
        $messages = [];
        $tableName = self::getTableName();
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name', 50);
                $table->string('excerpt', 255);
                $table->string('overline', 100)->nullable();
                $table->string('underline', 100)->nullable();
                $table->enum('duration', ['monthly','yearly']);
                $table->boolean('is_popular')->default(false);
                $table->unsignedBigInteger('sequence')->default(0);
                $table->string('stripe_product_id')->nullable();
                $table->json('stripe_price_ids')->nullable();
                $table->json('features')->nullable(); // ['title'=> '']
                $table->json('capabilities')->nullable();
                $table->json('meta')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
            $messages[] = "$tableName created";
        }
        if (!Schema::hasColumn($tableName, 'underline')) {
            Schema::table($tableName, function(Blueprint $table) {
                $table->string('overline', 100)->nullable()->after('excerpt');
                $table->string('underline', 100)->nullable()->after('overline');
            });
        }
        if (!Schema::hasColumn($tableName, 'stripe_price_ids')) {
            Schema::table($tableName, function(Blueprint $table) {
                $table->json('stripe_price_ids')->nullable()->after('stripe_product_id');
            });
        }
        return $messages;
    }

}
