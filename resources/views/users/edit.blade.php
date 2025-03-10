@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')
        
        <div class="form-group">
            <label for="full_name">Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name', $user->full_name) }}" required>
        </div>

        {{-- {{ dd($user->full_name) }} --}}
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" required>
        </div>

        <div class="form-group">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $user->date_of_birth->format('Y-m-d') }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
