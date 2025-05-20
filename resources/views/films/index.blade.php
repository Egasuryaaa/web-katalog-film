
@extends('layouts.app')

@section('content')
  <h1 class="mb-4 text-center">Katalog Film</h1>

  <!-- RUNNING TEXT -->
  <div class="mb-4">
    <marquee behavior="scroll" direction="left" scrollamount="7" class="fw-bold text-primary fs-5">
      Selamat datang di Web Katalog Film! Temukan film favoritmu.
    </marquee>
  </div>

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

  <div class="row g-4">
    @forelse($films as $film)
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
        <a href="{{ route('films.show', $film) }}" class="text-decoration-none text-dark w-100">
          <div class="card h-100 shadow-sm border-0">
            <div class="ratio ratio-2x3" style="min-height: 330px;">
              <img
                src="{{ $film->poster_url }}"
                class="card-img-top object-fit-cover"
                alt="Poster {{ $film->title }}"
                style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px 10px 0 0;"
              >
            </div>
            <div class="card-body text-center d-flex flex-column justify-content-between">
              <h5 class="card-title mb-2 text-primary text-capitalize" style="min-height: 48px;">{{ $film->title }}</h5>
              <p class="mb-1"><span class="badge bg-warning text-dark fs-6"><strong>Rating:</strong> {{ $film->rating }}/10</span></p>
              <span class="badge bg-secondary mb-2">{{ $film->genre }}</span>
              <span class="text-muted small">{{ \Carbon\Carbon::parse($film->release_date)->format('d M Y') }}</span>
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

  <div class="d-flex justify-content-center mt-4">
    {{ $films->links() }}
  </div>

  <style>
    .ratio-2x3 {
      aspect-ratio: 2/3;
      background: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }
    .object-fit-cover {
      object-fit: cover;
      width: 100%;
      height: 100%;
    }
    .card {
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
      transform: translateY(-8px) scale(1.03);
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }
    marquee {
      background: #e9ecef;
      border-radius: 8px;
      padding: 8px 0;
    }
  </style>
@endsection