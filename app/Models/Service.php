<?php

namespace App\Models;

use App\Enums\ServiceVariantEnum;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class Service extends Model
{
    use SoftDeletes, UuidTrait;

    protected $fillable = [
        'name',
        'slug',
        'label',
        'icon',
        'image',
        'type',
        'variant',
    ];

    protected $casts = [
        'variant' => ServiceVariantEnum::class,
    ];

    public static function createTable()
    {
        $messages = [];
        $tableName = 'services';
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name', 255);
                $table->string('slug', 100);
                $table->string('label', 100);
                $table->string('type', '25'); // professional | organization
                $table->string('variant', 25)->nullable();
                $table->string('image', 100)->nullable();
                $table->string('icon', 100)->nullable();

                $table->foreignUuid('parent_id')->nullable();
                $table->json('meta')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('created_at')->nullable();
            });
            $messages[] = "$tableName created";
        }
        return $messages;
    }
}
