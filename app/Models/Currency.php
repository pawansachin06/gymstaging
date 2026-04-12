<?php

namespace App\Models;

use App\Traits\UuidTrait;
use App\Traits\StaticTableName;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;

class Currency extends Model
{
    use UuidTrait, StaticTableName, SoftDeletes;

    protected $fillable = [
        'code', 'name', 'rate', 'default', 'sequence',
    ];

    protected $casts = [
        'code' => 'string',
        'name' => 'string',
        'rate' => 'float',
        'default' => 'boolean',
        'sequence' => 'float',
    ];

    public static function createTable()
    {
        $messages = [];
        $tableName = self::getTableName();
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('code', 3)->unique();
                $table->string('name', 32);
                $table->decimal('rate');
                $table->boolean('default');
                $table->unsignedBigInteger('sequence')->default(0);
                $table->dateTime('deleted_at')->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        }
        return $messages;
    }
}
