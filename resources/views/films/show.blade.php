
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

      <hr>

      <h4>Komentar</h4>
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formKomentar" aria-expanded="false" aria-controls="formKomentar">
        Tambahkan Komentar
      </button>
      <div class="collapse" id="formKomentar">
        <form action="{{ route('films.comments.store', $film->id) }}" method="POST" class="mb-4 mt-3">
          @csrf
          <div class="mb-2">
            <label for="name" class="form-label">Nama:</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name') }}">
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-2">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}">
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-2">
            <label for="comment" class="form-label">Komentar:</label>
            <textarea name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror" rows="3" required>{{ old('comment') }}</textarea>
            @error('comment')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <button type="submit" class="btn btn-success">Kirim Komentar</button>
        </form>
      </div>

      <ul class="list-group mb-3">
        @forelse($comments as $comment)
          <li class="list-group-item">
            <strong>{{ $comment->name }}</strong>
            (
              {{
                substr($comment->email, 0, 3)
                . str_repeat('*', max(0, strpos($comment->email, '@') - 3))
                . substr($comment->email, strpos($comment->email, '@'))
              }}
            )<br>
            {{ $comment->comment }}<br>
            <small class="text-muted">{{ $comment->created_at->format('d-m-Y H:i') }}</small>
          </li>
        @empty
          <li class="list-group-item text-muted">Belum ada komentar.</li>
        @endforelse
      </ul>

      <a href="{{ route('films.index') }}" class="btn btn-secondary mt-3">
        ← Back to Catalog
      </a>
    </div>
  </div>
@endsection