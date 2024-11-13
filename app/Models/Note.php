<?php
namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    // Engedélyezett mezők tömeges hozzárendeléshez
    protected $fillable = ['title', 'text', 'user_id'];
    
    // Alternatíva: Minden mező tömegesen hozzárendelhető (nem ajánlott)
    protected $guarded = [];
    public function getRouteKeyName(){
        return 'uuid';
    }

    // Automatikusan generál UUID-t az 'uuid' mezőhöz, ha új rekord jön létre
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
