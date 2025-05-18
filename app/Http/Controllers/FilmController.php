<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use App\Models\Comment;


class FilmController extends Controller
{
    public function index(Request $request)
    {
        // Ambil daftar genre unik untuk dropdown filter
        $genres = Film::select('genre')
                      ->distinct()
                      ->orderBy('genre')
                      ->pluck('genre');

        // Mulai query
        $query = Film::query();

        // Filter berdasarkan genre jika ada
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        // Sorting berdasarkan rating jika ada
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

        // Paginate dan sertakan query string supaya filter & sort tetap di URL
        $films = $query->paginate(9)->withQueryString();

        return view('films.index', compact('films', 'genres'));
    }


    public function show($id)
{
    $film = Film::findOrFail($id);
    $comments = $film->comments()->latest()->get();
    return view('films.show', compact('film', 'comments'));
}

public function storeComment(Request $request, $id)
{
    $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email',
        'comment' => 'required',
    ]);

    Comment::create([
        'film_id' => $id,
        'name' => $request->name,
        'email' => $request->email,
        'comment' => $request->comment,
    ]);

    return redirect()->route('films.show', $id)->with('success', 'Komentar berhasil ditambahkan!');
}
}
