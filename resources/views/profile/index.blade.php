@extends('layouts.master')

@section('title', 'Profile | StackOverflow')

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

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $user->username }}</li>
          </ol>
        </nav>   
          
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="text-muted mb-0">Profile</h3>
          @can('update', $user->profile)
            <a href="{{ route('question.create') }}" class="btn btn-primary d-lg-flex d-none">Ask Question</a>
          @endcan
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 col-lg-4 mb-3">
            <div class="card">
              <div class="card-body">
                <h3>{{ $user->name }}</h3>
                <span class="text-muted">{{ $user->username }}</span>
                <div class="mt-2">
                  {{ $user->profile->description }}
                </div>
                <div class="mb-3">
                  <a href="{{ $user->profile->url }}" target="_blank" class="text-decoration-none"><small>{{ $user->profile->url }}</small></a>
                </div>
                <div class="d-flex flex-column border p-1 text-center rounded">
                  <div>Posts</div>
                  <div><b>{{ $user->questions->count() }}</b></div>
                </div>
                @can('update', $user->profile)
                  <hr>
                  <a href="{{ route('profile.edit',  $user->id ) }}" class="text-decoration-none">Edit Profile</a>
                @endcan
              </div>
            </div>
          </div>
          <div class="col-md-12 col-lg-8">
            <div class="d-flex justify-content-between align-items-center d-lg-none mt-2">
              <h3 class="text-muted">Question</h3>
              @can('update', $user->profile)
                <a href="{{ route('question.create') }}" class="btn btn-primary">Ask Question</a>
              @endcan
            </div>
            <hr class="d-lg-none">
            
            @if ($user->questions->isEmpty())
                <div class="p-3 d-flex flex-column justify-content-center align-items-center" style="height: 300px;">
                  <p class="text-muted mb-1">You haven't post any question right now.</p>
                </div>
            @else
                @foreach($user->questions as $question)
                  <div class="card mb-3">
                    <div class="card-header">
                      <a href="{{ route('question.show', $question->id) }}" class="card-title h5 text-decoration-none">{{ $question->title }}</a>
                    </div>

                    <div class="card-body pt-2">
                      <div class="d-flex align-items-start">
                        <div class="d-flex flex-column text-center mr-2 mt-4">
                            <a href="{{ route('vote.upvote', $question->id) }}" class="upvote @if (!($vote->where('question_id', $question->id)->where('type', 'up')->where('user_id', Auth::id())->isEmpty()))
                            clicked
                            @endif">
                              <i class="fas fa-caret-square-up" style="font-size: 20px"></i>
                            </a>
                            <span class="my-1">{{ $question->voteCount() }}</span>
                            {{-- <a href="">
                              <div style="clip-path: polygon(50% 100%, 0 0, 100% 0); height: 20px; width: 20px; background: rgba(0,0,0,.2);"></div>
                            </a> --}}
                        </div>
                        <div class="flex-grow-1 px-3">
                          <p class="card-text">{!! $question->content !!}</p>
                          <div class="d-flex align-items-center mb-2">
                            @foreach (explode(" ", $question->tag) as $key => $tag)
                                <span class="badge badge-secondary mr-2 p-1">{{ $tag }}</span>
                            @endforeach
                          </div>
                          
                          <div>
                            <small class="text-muted">Posted by : <b>{{ $question->user->username }}</b></small>
                          </div>
                          <div class="d-flex mt-2 justify-content-between pt-2 border-top">
                            <a href="{{ route('question.show', $question->id) }}" class="text-decoration-none">{{ $question->answers->count() }} respons</a>
                            @can('update', $question)
                              <div class="d-flex">
                                <a href="{{ route('question.edit', $question->id) }}" class="btn btn-warning btn-sm text-white mr-2">
                                  Edit
                                </a>
                                <a href="{{ route('question.destroy', $question->id) }}" class="btn delete-question btn-danger text-white btn-sm">Delete Question</a>
                                {{-- <form action="{{ route('question.destroy', $question->id) }}" method="POST" id="del-question">
                                  @csrf
                                  @method('delete')
                                  <button type="submit" class="btn btn-danger btn-sm text-white delete-confirm">Delete</button>
                                </form> --}}
                              </div>
                            @endcan
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card-footer py-2">
                      <small class="text-muted">{{ $question->created_at->diffForHumans() }}</small>
                      
                    </div>
                  </div>
                @endforeach
            @endif
          </div>
        </div>
      
      </div>
    </main>

    @include('layouts.footer')
@endsection



@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
    <script>
        // $('.delete-confirm').on('click', function (e) {
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
        
        // Menggunakan href utk delete question
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
    </script>
@endpush

