@extends('layouts.app')

@section('title', 'StackOverflow')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@endpush

@section('content')
  <main class="main mt-3 mb-5">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h3>All Questions</h3>
          @can('update', $user->profile)
            <a href="{{ route('question.create') }}" class="btn btn-primary">Ask Question</a>
          @endcan
        </div>
        <hr>
        @if (session('success'))
            <script>
              Swal.fire(
                'Success',
                '{{ session('success') }}',
                'success'
              )
            </script>
        @endif
        
        @if ($questions->isEmpty())
            <div class="p-3 d-flex flex-column justify-content-center align-items-center" style="height: 350px;">
              <p class="text-muted mb-1">Opps, Sorry! There's no question available right now.</p>
            </div>
        @else
          @foreach ($questions as $question)
              <div class="card mb-3">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1 pr-3">
                      <a href="{{ route('question.show', $question->id) }}" class="card-title h5 text-decoration-none">{{ $question->title }}</a>
                      <p class="card-text mt-2">{!! Str::limit($question->content, 300) !!}</p>
                      <div class="d-flex align-items-center mb-3">
                        @foreach (explode(" ", $question->tag) as $key => $tag)
                            <span class="badge badge-secondary mr-2 p-1">{{ $tag }}</span>
                        @endforeach
                      </div>
                      <div>
                        <small class="text-muted">Posted by : <a href="{{ route('profile.index', $question->user->id) }}" class="text-decoration-none"><b>{{ $question->user->username }}</b></a></small>
                      </div>
                      <small class="text-muted">{{ $question->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="d-flex flex-column text-center ml-3">
                      <a href="">
                      <div style="clip-path: polygon(50% 0%, 0 100%, 100% 100%); height: 20px; width: 20px; background: rgba(0,0,0,.2);"></div>
                      </a>
                      <span class="my-1">0</span>
                      <a href=""><div style="clip-path: polygon(50% 100%, 0 0, 100% 0); height: 20px; width: 20px; background: rgba(0,0,0,.2);"></div></a>
                    </div>
                  </div>
                </div>
              </div>
          @endforeach
        @endif
      

        <div class="d-flex justify-content-center">
          {{ $questions->links() }}
        </div>
      </div>
    </main>
@endsection
