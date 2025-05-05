@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-4">
      <img src="{{ $film->image_url }}" class="img-fluid rounded shadow-sm" alt="{{ $film->name }}">
      @if($film->trailer_url)
        <div class="mt-3">
          <a href="{{ $film->trailer_url }}" target="_blank" class="btn btn-outline-primary w-100">
            Watch Trailer
          </a>
        </div>
      @endif
    </div>
    <div class="col-md-8">
      <h1>{{ $film->name }}</h1>
      <p><strong>Rating:</strong> {{ $film->rating }}</p>
      <p><strong>Release Date:</strong> {{ \Carbon\Carbon::parse($film->release_date)->format('d M Y') }}</p>
      <p><strong>Duration:</strong> {{ $film->duration }} minutes</p>
      <p><strong>Genre:</strong> {{ $film->genre }}</p>
      <hr>
      <h4>Description</h4>
      <p>{{ $film->description }}</p>
      <a href="{{ route('films.index') }}" class="btn btn-secondary mt-3">Back to Catalog</a>
    </div>
  </div>
@endsection
