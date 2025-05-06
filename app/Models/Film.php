<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;  // <— jangan lupa import ini

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'release_date',
        'duration',
        'genre',
        'poster',        // ini kolom di DB yang menyimpan path
        'trailer_url',
        'rating',
    ];

    /**
     * Accessor untuk generate URL publik poster.
     * Jadi di Blade bisa dipanggil: $film->poster_url
     */
    public function getPosterUrlAttribute()
    {
        if ($this->poster) {
            // Pastikan sebelumnya kamu sudah menjalankan:
            // php artisan storage:link
            return Storage::url($this->poster);
        }
        // Fallback kalau belum ada poster
        return asset('images/default-poster.png');
    }
}
