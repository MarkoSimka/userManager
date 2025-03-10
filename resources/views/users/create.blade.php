@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New User</h2>
    <form id="userForm" action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" class="form-control" value="{{ old('full_name') }}">
            <span class="text-danger error-full_name"></span>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
            <span class="text-danger error-email"></span>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
            <span class="text-danger error-phone"></span>
        </div>

        <div class="form-group">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
            <span class="text-danger error-date_of_birth"></span>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {
    $("#userForm").on("submit", function(event) {
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

        console.log("Form validation status: " + status);
    });
});
</script>
@endsection