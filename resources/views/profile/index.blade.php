@extends('layouts.app')

@section('title', 'StackOverflow')

@push('scripts')
    {{-- Sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@endpush

@section('content')
  <main class="main mt-3">
      <div class="container">

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
          <h3 class="text-muted mb-0">Profile</h3>
          @can('update', $user->profile)
            <a href="{{ route('question.create') }}" class="btn btn-primary">Ask Question</a>
          @endcan
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 col-lg-4 mb-3">
            <div class="card">
              <div class="card-body">
                <h3>{{ $user->name }}</h3>
                <span class="text-muted">{{ $user->username }}</span>
                <div>
                  {{ $user->profile->description }}
                </div>
                <div class="mb-2">
                  <a href="{{ $user->profile->url }}" target="_blank" class="text-decoration-none">{{ $user->profile->url }}</a>
                </div>
                @can('update', $user->profile)
                  <a href="{{ route('profile.edit',  $user->id ) }}" class="text-decoration-none">Edit Profile</a>
                @endcan
              </div>
            </div>
          </div>
          <div class="col-md-12 col-lg-8">
            @if ($user->questions->isEmpty())
                <div class="p-3 d-flex flex-column justify-content-center align-items-center" style="height: 300px;">
                  <p class="text-muted mb-1">You haven't post any question right now.</p>
                </div>
            @else
                @foreach($user->questions as $question)
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
                            <small class="text-muted">Posted by : <b>{{ $question->user->username }}</b></small>
                          </div>
                          <small class="text-muted">{{ $question->created_at->diffForHumans() }}</small>
                          @can('update', $question)
                            <div class="d-flex mt-2">
                              <a href="{{ route('question.edit', $question->id) }}" class="btn btn-warning btn-sm text-white mr-2">
                                Edit
                              </a>
                              <form action="{{ route('question.destroy', $question->id) }}" method="POST" id="del-question">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm text-white delete-confirm">Delete</button>
                              </form>
                            </div>
                          @endcan
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
          </div>
        </div>

        <hr>
      
      </div>
    </main>
@endsection
