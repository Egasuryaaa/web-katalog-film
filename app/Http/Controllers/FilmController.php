<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Comment;
use App\Models\Genre;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $query = Film::query();

        // Filter by genre
        if ($request->filled('genre')) {
            $query->whereHas('genres', function($q) use ($request) {
                $q->where('genres.id', $request->genre);
            });
        }

        // Filter by age restriction
        if ($request->filled('age_restriction')) {
            $query->where('age_restriction', $request->age_restriction);
        }

        // Filter by release year
        if ($request->filled('release_year')) {
            $query->whereYear('release_date', $request->release_year);
        }

        // Sort by rating
        if ($request->filled('sort')) {
            if ($request->sort === 'rating_asc') {
                $query->orderBy('rating', 'asc');
            } elseif ($request->sort === 'rating_desc') {
                $query->orderBy('rating', 'desc');
            }
        } else {
            // Default: terbaru dulu
            $query->orderBy('created_at', 'desc');
        }

        $films = $query->paginate(12);
        $genres = Genre::pluck('name', 'id');

        return view('films.index', compact('films', 'genres'));
    }

    public function show($id)
    {
        $film = Film::findOrFail($id);

        // Menampilkan komentar utama dan komentar berbalasan (nested replies)
        $comments = $film->comments()->whereNull('parent_id')->with('replies')->latest()->get();

        // Menambahkan depth untuk setiap komentar dan balasan
        foreach ($comments as $comment) {
            $this->setCommentDepth($comment);
        }

        return view('films.show', compact('film', 'comments'));
    }

    public function store(Request $request)
    {
        // Validasi input, termasuk genre dan age_restriction
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'release_date' => 'required|date',
            'duration' => 'required|integer',
            'age_restriction' => 'required|max:255',
            'poster' => 'required|url',
            'trailer_url' => 'required|url',
            'rating' => 'required|integer',
            'genre' => 'required|array',  // Validasi agar GENRE berupa array
        ]);

        // Menyimpan film baru
        $film = Film::create([
            'title' => $request->title,
            'description' => $request->description,
            'release_date' => $request->release_date,
            'duration' => $request->duration,
            'age_restriction' => $request->age_restriction,
            'poster' => $request->poster,
            'trailer_url' => $request->trailer_url,
            'rating' => $request->rating,
        ]);

        // Menyambungkan film dengan genre yang dipilih (relasi many-to-many)
        $film->genres()->attach($request->genre);  // Menghubungkan film dengan genre yang dipilih

        return redirect()->route('films.index')->with('success', 'Film berhasil ditambahkan!');
    }

    public function storeComment(Request $request, $id)
    {
        // Validasi input untuk komentar
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'comment' => 'required',
            'parent_id' => 'nullable|exists:comments,id', // Pastikan parent_id valid jika ada
        ]);

        // Menyimpan komentar atau balasan
        Comment::create([
            'film_id' => $id,
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'parent_id' => $request->parent_id, // Simpan parent_id jika ada
        ]);

        return redirect()->route('films.show', $id)->with('success', 'Komentar berhasil ditambahkan!');
    }

    // Fungsi rekursif untuk menambahkan depth pada komentar dan balasan
    private function setCommentDepth($comment, $currentDepth = 0)
    {
        $comment->depth = $currentDepth; // Menetapkan depth untuk komentar saat ini

        // Menambahkan depth untuk setiap balasan secara rekursif
        foreach ($comment->replies as $reply) {
            $this->setCommentDepth($reply, $currentDepth + 1); // Menambah depth untuk balasan
        }
    }
}
