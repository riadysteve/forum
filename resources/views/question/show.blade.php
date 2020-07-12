@extends('layouts.master')

@section('title', 'Question Details | StackOverflow')

@section('content')
    <main class="main mt-3 mb-5">
      <div class="container">

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($question->title, 50, '...') }}</li>
          </ol>
        </nav> 
        
        @if (session('success'))
            <script>
              Swal.fire(
                'Success',
                '{{ session('success') }}',
                'success'
              )
            </script>
        @endif

        <div class="d-flex justify-content-between align-items-center">
          <h4 class="mb-0">{{ $question->title }}</h4>
          <div class="d-flex align-items-center">
            @can('update', $question)
              <a href="{{ route('question.edit', $question->id) }}" class="btn btn-warning text-white mr-2">
                Edit
              </a>
              {{-- Delete Question menggunakan href --}}
              <a href="{{ route('question.destroy', $question->id) }}" class="btn btn-danger text-white delete-question">Delete</a>
              {{-- Delete menggunakan form namun ada bug saat melakukan sweetalert question yang didelete kadang tidak sesuai --}}
              {{-- <form action="{{ route('question.destroy', $question->id) }}" method="POST" id="del-question">
                @csrf
                @method('delete')
                <button type="submit" class="delete-question btn btn-danger text-white">Delete</button>
              </form> --}}
            @endcan
          </div>
        </div>
        <hr>
        
          <div class="d-flex flex-row align-items-start mt-2 card border-0 p-3">
            <div class="d-flex flex-column text-center mr-3">
              <a href="{{ route('vote.upvote', $question->id) }}" class="upvote @if (!($vote->where('question_id', $question->id)->where('type', 'up')->where('user_id', Auth::id())->isEmpty()))
                            clicked
                        @endif">
                <i class="fas fa-caret-square-up" style="font-size: 20px"></i>
              </a>
              <span class="my-1">{{ $question->voteCount() }}</span>
              {{-- <a href="#">
                <div style="clip-path: polygon(50% 100%, 0 0, 100% 0); height: 20px; width: 20px; background: rgba(0,0,0,.2);"></div> --}}
              </a>
            </div>
            <div class="d-flex flex-column flex-grow-1 align-items-start pl-3">
              <p class="my-0">{!! $question->content !!}</p>
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

          <h4 class="mt-4 text-muted">{{ $question->answers->count() }} answers</h4>
          @if ($answers->isEmpty())
              <div class="d-flex flex-column justify-content-center align-items-center" style="height: 150px; margin-bottom: 50px;">
                <p class="text-muted mb-1">Maaf, masih belum ada yang merespon.</p>
              </div>
          @else
            @foreach ($answers as $answer)
              <div class="d-flex flex-row align-items-start my-4">
                <div class="d-flex flex-column text-center mr-3 mt-3">
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
                  <p class="mt-0">{!! $answer->answer !!}</p>
                  @can('update', $answer)
                    <div class="d-flex my-1">
                      <a href="{{ route('answer.edit', $answer->id) }}" class="mr-2 border-right pr-2 text-decoration-none">
                        Edit
                      </a>
                      {{-- Delete Answer menggunakan href --}}
                      <a href="{{ route('answer.destroy', $answer->id) }}" class="text-danger delete-answer">Delete</a>
                      {{-- Delete menggunakan form namun ada bug saat melakukan sweetalert answer yang didelete kadang tidak sesuai --}}
                      {{-- <form action="{{ route('answer.destroy', $answer->id) }}" method="POST" id="del-answer">
                        @csrf
                        @method('delete')
                        <a class="delete-answer text-danger" style="cursor: pointer">Delete</a>
                      </form> --}}
                    </div>
                  @endcan
                  <div>
                    <small class="text-muted">Posted by : <a href="{{ route('profile.index', $answer->user->id) }}" class="text-decoration-none"><b>{{ $answer->user->username }}</b></a></small>
                  </div>
                  <div>
                    <small class="text-muted">{{ $answer->created_at->diffForHumans() }}</small>
                  </div>
                </div>
              </div>
              <hr>
            @endforeach
          @endif

          @auth
          <form action="{{ route('answer.store', $question->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="answer" class="text-muted h4 mb-3">Your Answer</label>
                <textarea name="answer" placeholder="Your Answer" class="form-control answer @error('answer') is-invalid @enderror" id="answer" rows="8" required>{{ old('answer') }}</textarea>
                @error('answer')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Post</button>
          </form>      
          @endauth
      </div>
    </main>
    
    @include('layouts.footer')
@endsection

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 

    <script>
        // Menggunakan form utk delete question
        // $('.delete-question').on('click', function (e) {
        //     e.preventDefault();
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: 'This record and it`s details will be permanantly deleted!',
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!'
        //     }).then(function(result) {
        //         if (result.value) {
        //             $('#del-question').submit();
        //         }
        //     });
        // });

        // Menggunakan href untuk delete question
        $('.delete-question').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: 'Once you delete it will be permanantly deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result) {
                if (result.value) {
                    window.location.href = url;
                }
            });
        });

        // Menggunakan form utk delete answer
        // $('.delete-answer').on('click', function (e) {
        //     e.preventDefault();
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: 'This record and it`s details will be permanantly deleted!',
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!'
        //     }).then(function(result) {
        //         if (result.value) {
        //             $('#del-answer').submit();
        //         }
        //     });
        // });
        
        // Menggunakan href utk delete answer
        $('.delete-answer').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: 'Once you delete it will be permanantly deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result) {
                if (result.value) {
                    window.location.href = url;
                }
            });
        });
    </script>

    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
      var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
      };
    </script>
    <script>
      CKEDITOR.replace('answer', options);
    </script>
@endpush