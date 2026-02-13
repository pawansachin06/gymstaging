<?php

namespace App\Models;

use App\Models\Traits\StorageurlTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @package App
 * @property string $title
 */
class FileVerification extends Model
{
    use StorageurlTrait;

    protected $table = 'files_verifications';
    protected $fillable = ['verification_id','file_path'];
    public $timestamps = false;
    public $incrementing = false;

    public function verification()
    {
        return $this->belongsTo(Verification::class);
    }
}
