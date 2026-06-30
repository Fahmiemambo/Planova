<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'icon'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blocks()
    {
        return $this->morphMany(Block::class, 'blockable')->orderBy('order');
    }
}
