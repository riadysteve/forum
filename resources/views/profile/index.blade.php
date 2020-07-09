@extends('layouts.app')

@section('title', 'StackOverflow')

@section('content')
  <main class="main mt-3">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h3>My Profile</h3>
          <a href="{{ route('question.create') }}" class="btn btn-primary">Ask Question</a>
        </div>
        
        <hr>
        
        
        <div><h3>{{ $user->username }}</h3></div>
        <div>Email : {{ $user->email }}</div>
        <div>{{ $user->profile->description }}</div>
        <div><a href="#">{{ $user->profile->url }}</a></div>

        <hr>
      
      </div>
    </main>
@endsection
