<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Hash;
use Lab404\Impersonate\Models\Impersonate;
use App\Events\UserRegistered;
use Artisan;

/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $remember_token
*/
class Faq extends Authenticatable
{
    use Notifiable, Impersonate;
    
    protected $fillable = ['question', 'answer', 'status'];
    
    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

}
