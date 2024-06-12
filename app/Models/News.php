<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    public $table = 'news';
    protected $fillable = [
        'user_id',
        'image',
        'title',
        'upload',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
