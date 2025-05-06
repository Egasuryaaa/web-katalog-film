@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-4">
      <img
        src="{{ $film->poster_url }}"
        class="img-fluid rounded shadow-sm mb-3"
        alt="Poster {{ $film->title }}"
      >

      @if($film->trailer_url)
        <a
          href="{{ $film->trailer_url }}"
          target="_blank"
          class="btn btn-outline-primary w-100 mb-4"
        >
          Watch Trailer
        </a>
      @endif
    </div>

    <div class="col-md-8">
      <h1>{{ $film->title }}</h1>
      <p><strong>Rating:</strong> {{ $film->rating }}/10</p>
      <p>
        <strong>Release Date:</strong>
        {{ \Carbon\Carbon::parse($film->release_date)->format('d M Y') }}
      </p>
      <p><strong>Duration:</strong> {{ $film->duration }} minutes</p>
      <p><strong>Genre:</strong> {{ $film->genre }}</p>

      <hr>

      <h4>Description</h4>
      <p>{{ $film->description }}</p>

      <a href="{{ route('films.index') }}" class="btn btn-secondary mt-3">
        ← Back to Catalog
      </a>
    </div>
  </div>
@endsection
