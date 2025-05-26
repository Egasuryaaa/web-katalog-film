<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',  // Kolom name untuk menyimpan nama genre
    ];

    /**
     * Relasi many-to-many dengan Film.
     * Setiap genre bisa dimiliki oleh banyak film, dan setiap film bisa memiliki banyak genre.
     */
    public function films()
    {
        return $this->belongsToMany(Film::class, 'film_genre', 'genre_id', 'film_id');
    }
}
