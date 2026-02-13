<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @package App
 * @property string $title
*/
class Notification extends Model
{
    protected $fillable = ['table_class','table_id' ,'sender_id', 'receiver_id' , 'message', 'mark_as_read'];    

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function related_model(){
        return $this->table_class::find($this->table_id);
    }

   
}
