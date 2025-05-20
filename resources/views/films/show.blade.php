
@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-4">
      <div class="mb-3">
        <img
          src="{{ $film->poster_url }}"
          class="img-fluid rounded shadow-sm poster-custom"
          alt="Poster {{ $film->title }}"
          style="object-fit:cover; aspect-ratio:2/3; width:100%; background:#f8f9fa"
        >
      </div>

      @if($film->trailer_url)
        <button
          class="btn btn-outline-primary w-100 mb-4"
          data-bs-toggle="modal"
          data-bs-target="#trailerModal"
        >
          Watch Trailer
        </button>
        <!-- Modal -->
        <div class="modal fade" id="trailerModal" tabindex="-1" aria-labelledby="trailerModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="trailerModalLabel">Trailer: {{ $film->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="stopTrailer()"></button>
              </div>
              <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                  <iframe id="trailerFrame" src="" allowfullscreen allow="autoplay"></iframe>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script>
          // Ambil ID video dari URL YouTube
          function getYoutubeEmbed(url) {
            let regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            let match = url.match(regExp);
            if (match && match[2].length == 11) {
              return 'https://www.youtube.com/embed/' + match[2] + '?autoplay=1';
            }
            return '';
          }
          // Saat modal dibuka, set src iframe
          document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('trailerModal');
            var btn = document.querySelector('[data-bs-target="#trailerModal"]');
            var iframe = document.getElementById('trailerFrame');
            var trailerUrl = @json($film->trailer_url);

            modal.addEventListener('show.bs.modal', function () {
              iframe.src = getYoutubeEmbed(trailerUrl);
            });
            modal.addEventListener('hide.bs.modal', function () {
              iframe.src = '';
            });
          });
          // Untuk tombol close manual
          function stopTrailer() {
            document.getElementById('trailerFrame').src = '';
          }
        </script>
      @endif
    </div>

    <div class="col-md-8">
      <h1 class="mb-2 text-primary">{{ $film->title }}</h1>
      <p><strong>Rating:</strong> <span class="badge bg-warning text-dark fs-6">{{ $film->rating }}/10</span></p>
      <p>
        <strong>Release Date:</strong>
        <span class="text-muted">{{ \Carbon\Carbon::parse($film->release_date)->format('d M Y') }}</span>
      </p>
      <p><strong>Duration:</strong> <span class="text-muted">{{ $film->duration }} minutes</span></p>
      <p><strong>Genre:</strong> <span class="badge bg-secondary">{{ $film->genre }}</span></p>

      <hr>

      <h4>Description</h4>
      <p class="fst-italic">{{ $film->description }}</p>

      <hr>

      <!-- RUNNING TEXT untuk informasi film -->
      <div class="mb-2">
        <marquee behavior="scroll" direction="left" scrollamount="7" class="fs-6 text-info">
          Selamat datang di detail film {{ $film->title }} — Tinggalkan komentar dan gunakan fitur diskusi dengan sopan.
        </marquee>
      </div>

      <h4>Komentar</h4>
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formKomentar" aria-expanded="false" aria-controls="formKomentar">
        Tambahkan Komentar
      </button>
      <div class="collapse" id="formKomentar">
        <form action="{{ route('films.comments.store', $film->id) }}" method="POST" class="mb-4 mt-3 shadow rounded p-3 bg-light">
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
            <strong class="text-primary">{{ $comment->name }}</strong>
            ({{ substr($comment->email, 0, 3)
               . str_repeat('*', max(0, strpos($comment->email, '@') - 3))
               . substr($comment->email, strpos($comment->email, '@'))
            }})<br>
            <span class="fst-italic">{{ $comment->comment }}</span><br>
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

  <style>
    .poster-custom {
      aspect-ratio: 2/3;
      min-height: 320px;
      object-fit: cover;
      background: #f4f5f7;
    }
    marquee {
      background: #e6f2fe;
      border-radius: 7px;
      padding: 5px 8px;
      margin-bottom: 1rem;
    }
  </style>
@endsection