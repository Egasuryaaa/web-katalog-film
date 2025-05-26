<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['film_id', 'name', 'email', 'comment', 'parent_id'];

    // Relasi ke film
    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    // Relasi ke komentar induk (parent)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Relasi ke balasan (reply)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies'); // Mengambil balasan dan balasan dari balasan
    }
}



