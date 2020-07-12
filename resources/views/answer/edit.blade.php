@extends('layouts.master')

@section('title', 'Edit Answer | StackOverflow')

@section('content')
  <section class="form mt-3 mb-5">
      <div class="container">

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($answer->question->title, 50, '...') }}</li>
          </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center">
          <h4 class="mb-0">{{ $answer->question->title }}</h4>
          <div class="d-flex align-items-center">
            @can('update', $user->question)
              <a href="{{ route('question.edit', $question->id) }}" class="btn btn-warning text-white mr-2">
                Edit
              </a>
              <form action="{{ route('question.destroy', $question->id) }}" method="POST" id="del-question">
                @csrf
                @method('delete')
                <button type="submit" class="delete-confirm btn btn-danger text-white">Delete</button>
              </form>
            @endcan
          </div>
        </div>
        <hr>
        
          <div class="d-flex flex-row align-items-start mt-2 card border-0 p-3">
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
              <p class="my-0">{!! $answer->question->content !!}</p>
              <div class="d-flex align-items-center mb-3">
                @foreach (explode(" ", $answer->question->tag) as $key => $tag)
                    <span class="badge badge-secondary mr-2 p-1">{{ $tag }}</span>
                @endforeach
              </div>
              <div>
                <small class="text-muted">Posted by : <a href="{{ route('profile.index', $answer->question->user->id) }}" class="text-decoration-none"><b>{{ $answer->question->user->username }}</b></a></small>
              </div>
              <small class="text-muted mt-2">{{ $answer->question->created_at->diffForHumans() }}</small>
            </div>
          </div>



        <h3 class="mt-5">Edit Answer</h3>
        <hr>
        <form action="{{ route('answer.update', $answer->id) }}" method="POST">
          @csrf
          @method('PATCH')

          <div class="form-group">
                <textarea name="answer" placeholder="Your Answer" class="form-control @error('answer') is-invalid @enderror" id="answer" rows="8" required>{{ $answer->answer }}</textarea>
                @error('answer')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
          
          <button type="submit" class="btn btn-primary mt-2">Update</button>
        </form>
      </div>
      

    </section>

@endsection

@push('script')
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