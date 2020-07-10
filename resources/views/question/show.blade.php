@extends('layouts.app')

@section('title', 'Details')

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>    
@endpush

@section('content')
    <main class="main mt-3 mb-5">
      <div class="container">

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('profile.index', Auth::user()->id) }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($question->title, 50, '...') }}</li>
          </ol>
        </nav>       

        <div class="d-flex justify-content-between align-items-center">
          <h4 class="mb-0">{{ $question->title }}</h4>
          <div class="d-flex align-items-center">
            @can('update', $question)
              <a href="{{ route('question.edit', $question->id) }}" class="btn btn-warning text-white mr-2">
                Edit
              </a>
              <form action="{{ route('question.destroy', $question->id) }}" method="POST" id="del-question">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger text-white delete-confirm">Delete</button>
            </form>
            @endcan
          </div>
        </div>
        <hr>
        
          <div class="d-flex flex-row align-items-start mt-2">
            <div class="d-flex flex-column text-center mr-3">
              <a href="#">
                <div style="clip-path: polygon(50% 0%, 0 100%, 100% 100%); height: 20px; width: 20px; background: rgba(0,0,0,.2);">
                </div>
              </a>
              <span class="my-1">0</span>
              <a href="#">
                <div style="clip-path: polygon(50% 100%, 0 0, 100% 0); height: 20px; width: 20px; background: rgba(0,0,0,.2);"></div>
              </a>
            </div>
            <div class="d-flex flex-column flex-grow-1 align-items-start pl-3">
              <p class="mt-0">{!! $question->content !!}</p>
              <div class="d-flex align-items-center mb-3">
                @foreach (explode(" ", $question->tag) as $key => $tag)
                    <span class="badge badge-secondary mr-2 p-1">{{ $tag }}</span>
                @endforeach
              </div>
              <div>
                <small class="text-muted">Posted by : <a href="{{ route('profile.index', $question->user->id) }}" class="text-decoration-none"><b>{{ $question->user->username }}</b></a></small>
              </div>
              <small class="text-muted mt-2">{{ $question->created_at->diffForHumans() }}</small>
            </div>
          </div>

          <hr>

          {{-- @if ($answers->isEmpty())
              <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100px;">
                <p class="text-muted mb-1">Maaf, masih belum ada yang merespon.</p>
              </div>
          @else
            <h3 class="mt-5 text-muted">{{ $question->answers->count() }} answers</h3>
            @foreach ($answers as $answer)
              <div class="d-flex flex-row align-items-start mt-2 mb-4">
                <div class="d-flex flex-column mt-4 text-center mr-3">
                  <a href="#">
                    <div style="clip-path: polygon(50% 0%, 0 100%, 100% 100%); height: 20px; width: 20px; background: black;">
                    </div>
                  </a>
                  <span class="my-1">0</span>
                  <a href="#">
                    <div style="clip-path: polygon(50% 100%, 0 0, 100% 0); height: 20px; width: 20px; background: black;"></div>
                  </a>
                </div>
                <div class="d-flex flex-column flex-grow-1 align-items-start pl-3">
                  <p class="mt-0">{!! $answer->answer !!}</p>
                  <small class="text-muted">{{ $answer->created_at->diffForHumans() }}</small>
                </div>
              </div>
              <hr>
            @endforeach
          @endif

          <form action="" method="POST">
            @csrf
            <div class="form-group">
                <label for="answer" class="text-muted">Answer</label>
                <textarea name="answer" placeholder="Your Answer" class="form-control @error('answer') is-invalid @enderror" id="Answer" required></textarea>
                @error('answer')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
              <input type="hidden" name="question_id" value="{{ $question->id }}">
            </div>

            <button type="submit" class="btn btn-primary">Post</button>
          </form> --}}
      </div>
    </main>
    
@endsection

@push('scriptend')
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>


        $('.delete-confirm').on('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'This record and it`s details will be permanantly deleted!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(result) {
                if (result.value) {
                    $('#del-question').submit();
                }
            });
        });
    </script>
@endpush