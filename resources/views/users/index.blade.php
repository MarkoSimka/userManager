@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Users</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Full name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->full_name }}</td>
                    <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                    <td>{{ $user->age }} years old</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-items-center w-100">
        <div>
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">Create User</a>
    </div>
</div>
@endsection