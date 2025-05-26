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
  <form method="GET" action="{{ route('films.index') }}" class="row mb-4 g-3 align-items-end" id="filterForm">
    <div class="col-md-3">
        <label for="genre" class="form-label">Filter Genre</label>
        <select name="genre" id="genre" class="form-select auto-submit">
            <option value="">— Semua Genre —</option>
            @foreach($genres as $id => $name)
                <option value="{{ $id }}" {{ request('genre') == $id ? 'selected' : '' }}>
                    {{ ucfirst($name) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label for="age_restriction" class="form-label">Restriksi Usia</label>
        <select name="age_restriction" id="age_restriction" class="form-select auto-submit">
            <option value="">— Semua Usia —</option>
            <option value="Semua Umur" {{ request('age_restriction') === 'Semua Umur' ? 'selected' : '' }}>
                Semua Umur
            </option>
            <option value="Anak-anak" {{ request('age_restriction') === 'Anak-anak' ? 'selected' : '' }}>
                Anak-anak
            </option>
            <option value="Remaja" {{ request('age_restriction') === 'Remaja' ? 'selected' : '' }}>
                Remaja
            </option>
            <option value="Dewasa" {{ request('age_restriction') === 'Dewasa' ? 'selected' : '' }}>
                Dewasa
            </option>
        </select>
    </div>

    <div class="col-md-3">
        <label for="release_year" class="form-label">Tahun Rilis</label>
        <select name="release_year" id="release_year" class="form-select auto-submit">
            <option value="">— Semua Tahun —</option>
            @for($year = date('Y'); $year >= 1900; $year--)
                <option value="{{ $year }}" {{ request('release_year') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endfor
        </select>
    </div>

    <div class="col-md-3">
        <label for="sort" class="form-label">Urutkan Rating</label>
        <select name="sort" id="sort" class="form-select auto-submit">
            <option value="">— Default —</option>
            <option value="rating_asc" {{ request('sort') === 'rating_asc' ? 'selected' : '' }}>
                Terendah ke Tertinggi
            </option>
            <option value="rating_desc" {{ request('sort') === 'rating_desc' ? 'selected' : '' }}>
                Tertinggi ke Terendah
            </option>
        </select>
    </div>
</form>

<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('films.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-x-circle"></i> Reset Filter
    </a>
</div>
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
              <span class="badge bg-secondary mb-2">
                @foreach($film->genres as $genre)
                  {{ $genre->name }}@if(!$loop->last), @endif
                @endforeach
              </span>
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

  <!-- PAGINATION -->
  <div class="d-flex justify-content-center mt-4">
    <nav>
      <ul class="pagination pagination-sm">
        <li class="page-item">
          <a class="page-link" href="{{ $films->previousPageUrl() }}" aria-label="Previous">
            <span aria-hidden="true">&laquo; Previous</span>
          </a>
        </li>
        @for ($i = 1; $i <= $films->lastPage(); $i++)
          <li class="page-item {{ $films->currentPage() == $i ? 'active' : '' }}">
            <a class="page-link" href="{{ $films->url($i) }}">{{ $i }}</a>
          </li>
        @endfor
        <li class="page-item">
          <a class="page-link" href="{{ $films->nextPageUrl() }}" aria-label="Next">
            <span aria-hidden="true">Next &raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
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

    /* Pagination styling */
    .pagination {
      justify-content: center;
      align-items: center;
    }
    .page-item {
      margin: 0 5px;
    }
    .page-link {
      padding: 8px 16px;
      border-radius: 5px;
      transition: background-color 0.2s, color 0.2s;
      font-size: 1rem;
    }
    .page-link:hover {
      background-color: #007bff;
      color: #fff;
    }
    .page-item.active .page-link {
      background-color: #007bff;
      color: #fff;
    }
    .page-item.disabled .page-link {
      background-color: #f8f9fa;
      color: #6c757d;
    }
  </style>

  <script>
    // Auto submit form when any filter changes
    document.querySelectorAll('.auto-submit').forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    // Add loading state
    document.getElementById('filterForm').addEventListener('submit', function() {
        document.querySelectorAll('.auto-submit').forEach(select => {
            select.disabled = true;
        });
    });
  </script>
@endsection
