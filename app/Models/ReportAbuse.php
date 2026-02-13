<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @package App
 * @property string $title
*/
class ReportAbuse extends Model
{
    protected $fillable = ['table_class','table_id' ,'message'];  
    
    protected $table = 'report_abuse';

    public function review()
    {
        return $this->belongsTo(ListingReview::class , 'table_id' );
    }
}
