@extends('layouts.auth_layout')
 
@section('title', 'varify email Page')
 
@section('content')

@include('partials.popup')

<style>
    body {
margin: 0;
padding: 0;
font-family: Arial, sans-serif;
}

.error-container {
max-width: 100%;
margin: 0 auto;
padding: 50px;
text-align: center;
}

.error-message {
font-size: 24px;
font-weight: bold;
margin-top: 20px;
}

.error-description {
font-size: 18px;
margin-top: 20px;
}

.error-actions {
margin-top: 20px;
}

.button {
display: inline-block;
padding: 10px 20px;
border-radius: 5px;
background-color: #4CAF50;
color: white;
text-decoration: none;
margin-right: 10px;
margin-top: 10px
}

.button:hover {
background-color: #3e8e41;
}

.error-search {
margin-top: 20px;
}

.error-search input[type="text"] {
padding: 10px;
border-radius: 5px;
border: 1px solid #ccc;
}

.error-search button {
padding: 10px 20px;
border-radius: 5px;
background-color: #4CAF50;
color: white;
border: none;
margin-left: 10px;
}

.error-search button:hover {
background-color: #3e8e41;
}

.error-contact {
margin-top: 20px;
}

  </style>

<div class="error-container">
    <h1>Email Verification Required</h1>
    <p class="error-description">
        Thank you for registering! To complete your registration and gain full access to our website, 
        you need to verify your email address.
    </p>
    <p class="error-description">
        An email with a verification link has been sent to your email address. Please check your inbox 
        (and your spam folder, just in case) and click on the verification link to activate your account.
    </p>
    <p class="error-description">
        If you haven't received the email, you can request a new verification email by logging in and 
        clicking on the "Resend Verification Email" link.
    </p>
    <!--
    <p class="error-description">
        If you continue to experience issues, please contact our support team for assistance. <a class="btn" href="mailto:support@example.com"><b>support@example.com</b></a>
    </p> -->

    
    <div class="error-actions">
      <a href="#" onclick="goBack()" class="button">Go back</a>
      <a href="{{route('dashboard')}}" class="button">Go to homepage</a>
      <form action="{{route('verification.send')}}" method="post">
        @csrf
        <button class="button" type="submit">resend varification</button>
      </form>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
  </div>
@endsection