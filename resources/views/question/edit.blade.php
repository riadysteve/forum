@extends('layouts.master')

@section('title', 'Edit Question | StackOverflow')

@section('content')
  <section class="form mt-3 mb-5">
      <div class="container">

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Question</li>
          </ol>
        </nav>   

        <h3>Edit Question</h3>

        <hr>

        <form action="{{ route('question.update', $question->id) }}" method="POST">
          @csrf
          @method('PATCH')

          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title') ?? $question->title }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="tag">Tags</label>
            <input type="text" class="form-control @error('tag') is-invalid @enderror" name="tag" id="tag" value="{{ old('tag') ?? $question->tag }}">
            <small id="emailHelp" class="form-text text-muted">*Optional, using space to add multiple tags</small>
            @error('tag')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="content">Your Question</label>
            <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="content" rows="8">{{ old('content') ?? $question->content }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          
          <button type="submit" class="btn btn-primary mt-2">Update</button>
        </form>
      </div>
      

    </section>

    @include('layouts.footer')
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
      CKEDITOR.replace('content', options);
    </script>
@endpush