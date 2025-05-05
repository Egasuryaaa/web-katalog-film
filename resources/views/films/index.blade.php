@extends('layouts.app')

@section('content')
  <h1 class="mb-4">Katalog Film</h1>

  <!-- filter form (sesuai implementasi Anda) -->

  <div class="row">
    @forelse($films as $film)
      <div class="col-md-4 mb-4">
        <a href="{{ route('films.show', $film->id) }}" class="text-decoration-none text-dark">
          <div class="card h-100 shadow-sm">
            <img src="{{ $film->image_url }}" class="card-img-top" alt="{{ $film->name }}">
            <div class="card-body text-center">
              <h5 class="card-title">{{ $film->name }}</h5>
              <p class="mb-0"><strong>Rating:</strong> {{ $film->rating }}</p>
            </div>
          </div>
        </a>
      </div>
    @empty
      <p class="text-center">Belum ada film tersedia.</p>
    @endforelse
  </div>

  <div class="d-flex justify-content-center">
    {{ $films->withQueryString()->links() }}
  </div>
@endsection
