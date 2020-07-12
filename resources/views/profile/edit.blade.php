@extends('layouts.master')

@section('title', 'Edit Profile | StackOverflow')

@section('content')
  <section class="form mt-3 mb-5">
      <div class="container">

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('profile.index', $user->id) }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
          </ol>
        </nav>   

        <h3>Edit Your Profile</h3>

        <hr>

        <form action="{{ route('profile.update', $user->id) }}" method="POST">
          @csrf
          @method('PATCH')

          <div class="form-group">
            <label for="description">Bio</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="4" name="description" placeholder="Add a Bio">{{ old('description') ?? $user->profile->description }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="url">Website</label>
            <input type="text" class="form-control @error('url') is-invalid @enderror" name="url" id="url" value="{{ old('url') ?? $user->profile->url }}" placeholder="Your Website">
            @error('url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          
          <button type="submit" class="btn btn-primary mt-2">Save Profile</button>
        </form>
      </div>
      
    </section>

@endsection

