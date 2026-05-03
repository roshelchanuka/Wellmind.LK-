@extends('layouts.app')
@section('title', 'Forgot Password - WellMind LK')
@section('content')
<main class="main-content login-container">
    <form class="form" method="POST" action="{{ url('/forgot-password') }}">
        @csrf
        <h2 class="auth-form-header" data-key="forgotPasswordHeader">Reset Password</h2>
        <p class="p" style="text-align:center; margin-bottom: 20px; color: #666;" data-key="forgotPasswordDesc">Enter your Gmail address and we'll send you a reset link.</p>

        @if(session('status'))
            <div class="success-msg-auth">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="error-msg-auth">{{ $errors->first() }}</div>
        @endif

        <div class="flex-column">
            <label data-key="emailLabel">Email Address</label>
        </div>
        <div class="inputForm">
            <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><g id="Layer_3" data-name="Layer 3"><path d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path></g></svg>
            <input type="email" name="email" class="input" placeholder="Enter your Gmail" required>
        </div>

        <button type="submit" class="button-submit" data-key="sendResetLink">Send Reset Link</button>
        <p class="p"><a href="{{ route('login') }}" class="span" data-key="backToLogin">← Back to Login</a></p>
    </form>
</main>
@endsection

@section('scripts')
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
        icon: 'info',
        title: 'Feature Coming Soon',
        text: 'Password reset via email will be available soon. Please contact support if needed.',
        confirmButtonColor: '#2A5421'
    });
});
</script>
@endsection
