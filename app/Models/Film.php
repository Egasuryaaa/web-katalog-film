<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Film extends Model
{
    use HasFactory;

    // Menambahkan kolom-kolom yang perlu diisi dalam fillable
    protected $fillable = [
        'title',
        'description',
        'release_date',
        'duration',
        'poster',  // Kolom di DB yang menyimpan path
        'trailer_url',
        'rating',
        'age_restriction', // Menambahkan 'age_restriction' ke dalam fillable
    ];

    /**
     * Relasi ke komentar film.
     */
    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class, 'film_id');
    }

    /**
     * Relasi many-to-many dengan Genre.
     * Setiap film bisa memiliki banyak genre, dan genre bisa dimiliki oleh banyak film.
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'film_genre', 'film_id', 'genre_id');
    }

    /**
     * Accessor untuk generate URL publik poster.
     * Jadi di Blade bisa dipanggil: $film->poster_url
     */
    public function getPosterUrlAttribute()
    {
        if ($this->poster) {
            return Storage::url($this->poster); // Mendapatkan URL untuk file poster
        }
        return asset('images/default-poster.png'); // Gambar default jika poster tidak ada
    }

    /**
     * Mengatur pengisian genre saat menyimpan film.
     * Karena menggunakan relasi many-to-many, kita tidak perlu kolom 'genre' di `films`.
     */
    public static function boot()
    {
        parent::boot();

        // Sebelum menyimpan data, kita pastikan genre dipilih melalui relasi
        static::saving(function ($film) {
            if ($film->genres->isEmpty()) {
                // Jika tidak ada genre yang dipilih, kita bisa menetapkan genre default
                // Atau bisa kita biarkan kosong jika ingin validasi lebih lanjut
            }
        });
    }
}
