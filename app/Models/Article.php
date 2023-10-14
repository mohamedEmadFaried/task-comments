<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'type_user',
    ];
    public function user()
    {
        if ($this->type_user === 'user') {
            return $this->belongsTo(User::class);
        } elseif ($this->type_user === 'admin') {
            return $this->belongsTo(Admin::class);
        }
    }
}
