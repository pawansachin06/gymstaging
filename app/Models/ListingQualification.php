<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ListingQualification extends Model {

    protected $fillable = [
        'name', 'status', 'file', 'reason', 'reviewed_by', 'listing_id', 'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    protected $appends = ['file_url'];

    public function getFileUrlAttribute()
    {
        if (!empty($this->file) && !empty($this->listing->folder)) {
            $folder = $this->listing->folder;
            $name = $this->file;
            return url("uploads/{$folder}/{$name}");
        }
        return null;
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public static function createTable()
    {
        $messages = [];
        $tableName = 'listing_qualifications';
        if (!Schema::hasColumn($tableName, 'status')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending')->after('name');
                $table->string('file', 100)->nullable()->after('status');
                $table->string('reason', 255)->nullable()->after('file');
                $table->foreignId('reviewed_by')->nullable()->after('reason');
                $table->dateTime('reviewed_at')->nullable()->after('listing_id');
            });
            $messages[] = "$tableName status added.";
        }
    }
}
