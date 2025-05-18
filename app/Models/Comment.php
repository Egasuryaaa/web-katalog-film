<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['film_id', 'name', 'email', 'comment'];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}