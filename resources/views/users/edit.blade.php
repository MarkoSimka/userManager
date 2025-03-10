@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form id="editUserForm" action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')
        
        <div class="form-group">
            <label for="full_name">Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name', $user->full_name) }}" required>
            <span class="text-danger error-full_name"></span>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            <span class="text-danger error-email"></span>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" required>
            <span class="text-danger error-phone"></span>
        </div>

        <div class="form-group">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $user->date_of_birth->format('Y-m-d') }}" required>
            <span class="text-danger error-date_of_birth"></span>
        </div>
        
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $("#editUserForm").on("submit", function(event) {
        event.preventDefault();

        var status = true;

        var name = $("#full_name");
        var email = $("#email");
        var phone = $("#phone");
        var date_of_birth = $("#date_of_birth");

        if (!name.val() || name.val().length < 6) {
            name.addClass("border-danger");
            $(".error-full_name").html("<span class='text-danger'>Please enter a valid full name (at least 6 characters).</span>");
            status = false;
        } else {
            name.removeClass("border-danger");
            $(".error-full_name").html("");
        }

        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!email.val() || !emailPattern.test(email.val())) {
            email.addClass("border-danger");
            $(".error-email").html("<span class='text-danger'>Please enter a valid email address.</span>");
            status = false;
        } else {
            email.removeClass("border-danger");
            $(".error-email").html("");
        }

        var phonePattern = /^\+\d{10,15}$/;
        if (!phone.val() || !phonePattern.test(phone.val())) {
            phone.addClass("border-danger");
            $(".error-phone").html("<span class='text-danger'>Phone must start with '+' and contain 10-15 digits.</span>");
            status = false;
        } else {
            phone.removeClass("border-danger");
            $(".error-phone").html("");
        }

        if (!date_of_birth.val() || new Date(date_of_birth.val()) > new Date()) {
            date_of_birth.addClass("border-danger");
            $(".error-date_of_birth").html("<span class='text-danger'>Date of Birth cannot be in the future.</span>");
            status = false;
        } else {
            date_of_birth.removeClass("border-danger");
            $(".error-date_of_birth").html("");
        }

        if (status) {
            this.submit();
        }
    });
});
</script>
@endsection