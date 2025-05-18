{{-- nambah --}}
{{-- modif --}}
{{-- modif neh --}}

@extends('layouts.app')

@section('content')
  <h1 class="mb-4">Katalog Film</h1>

  <!-- FILTER & SORT FORM -->
  <form method="GET" action="{{ route('films.index') }}" class="row mb-4 g-2 align-items-end">
    <div class="col-md-4">
      <label for="genre" class="form-label">Filter by Genre</label>
      <select name="genre" id="genre" class="form-select">
        <option value="">— Semua Genre —</option>
        @foreach($genres as $g)
          <option value="{{ $g }}" {{ request('genre') === $g ? 'selected' : '' }}>
            {{ ucfirst($g) }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-md-4">
      <label for="sort" class="form-label">Urutkan Rating</label>
      <select name="sort" id="sort" class="form-select">
        <option value="">— Default —</option>
        <option value="rating_asc" {{ request('sort') === 'rating_asc' ? 'selected' : '' }}>
          Terendah ke Tertinggi
        </option>
        <option value="rating_desc" {{ request('sort') === 'rating_desc' ? 'selected' : '' }}>
          Tertinggi ke Terendah
        </option>
      </select>
    </div>

    <div class="col-md-4">
      <button type="submit" class="btn btn-primary w-100">Terapkan</button>
    </div>
  </form>
  <!-- /FILTER & SORT FORM -->

  <div class="row">
    @forelse($films as $film)
      <div class="col-md-4 mb-4">
        <a href="{{ route('films.show', $film) }}" class="text-decoration-none text-dark">
          <div class="card h-100 shadow-sm">
            <img
              src="{{ $film->poster_url }}"
              class="card-img-top"
              alt="Poster {{ $film->title }}"
            >
            <div class="card-body text-center">
              <h5 class="card-title">{{ $film->title }}</h5>
              <p class="mb-0"><strong>Rating:</strong> {{ $film->rating }}/10</p>
            </div>
          </div>
        </a>
      </div>
    @empty
      <div class="col-12">
        <p class="text-center">Belum ada film tersedia.</p>
      </div>
    @endforelse
  </div>

  <div class="d-flex justify-content-center">
    {{ $films->links() }}
  </div>
@endsection
