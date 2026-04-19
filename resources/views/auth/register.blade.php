@extends('layouts.app')

@section('title', 'Create Account - WellMind LK')
@section('body-class', 'auth-body')

@section('content')


    <div class="form-container">
    <!-- STEP 1: Registration Details -->
    <form id="registerForm" class="form step-container">
        <h2 class="auth-form-header" data-key="registerHeader">Create Account</h2>
        
        <div id="error-alert" class="error-msg-auth hidden"></div>

        <div class="flex-column">
          <label data-key="fullNameLabel">Full Name</label>
        </div>
        <div class="inputForm">
            <input type="text" name="full_name" class="input" placeholder="Enter your full name" data-placeholder-key="fullNameLabel" required>
        </div>

        <div class="flex-column">
          <label data-key="emailLabel">Email (Gmail Only)</label>
        </div>
        <div class="inputForm">
            <input type="email" name="email" class="input" placeholder="example@gmail.com" data-placeholder-key="emailPlaceholder" required>
        </div>

        <div class="flex-column">
          <label data-key="passwordLabel">Password</label>
        </div>
        <div class="inputForm">
            <input type="password" name="password" class="input" placeholder="Enter your password" data-placeholder-key="passwordPlaceholder" required minlength="6">
        </div>

        <div class="flex-column">
          <label data-key="dobLabel">Date of Birth</label>
        </div>
        <div class="inputForm">
            <input type="date" name="dob" class="input" required>
        </div>

        <div class="flex-column">
          <label data-key="genderLabel">Gender</label>
        </div>
        <div class="inputForm">
            <select name="gender" class="input input--transparent" required>
                <option value="" disabled selected data-key="genderSelect">Select Gender</option>
                <option value="Male" data-key="genderMale">Male</option>
                <option value="Female" data-key="genderFemale">Female</option>
            </select>
        </div>

        <div class="flex-column">
          <label data-key="ageLabel">Age (16-25)</label>
        </div>
        <div class="inputForm">
            <input type="number" name="age" min="16" max="25" class="input" placeholder="Enter your age" data-placeholder-key="ageLabel" required>
        </div>
        
        <button type="submit" class="button-submit" id="btnContinue" data-key="btnContinue">Continue</button>
        <p class="p"><span data-key="alreadyAccount">Already have an account?</span> <a href="/login" class="span" data-key="loginNow">Login</a></p>
    </form>

    <!-- STEP 2: OTP Verification -->
    <form id="otpForm" class="form step-container hidden">
        <h2 class="auth-form-header">Verify Email</h2>
        <p class="p auth-form-subtext">We've sent a 6-digit code to your Gmail. Please enter it below.</p>
        
        <div id="otp-error-alert" class="error-msg-auth hidden"></div>

        <div class="otp-input-wrapper">
            <input type="text" name="otp" class="input otp-field" placeholder="000000" maxlength="6" required>
        </div>
        
        <button type="submit" class="button-submit" id="btnVerify">Verify & Create Account</button>
        <button type="button" class="button-submit btn-auth-back" onclick="location.reload()">Back</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const registerForm = document.getElementById('registerForm');
    const otpForm = document.getElementById('otpForm');
    const errorAlert = document.getElementById('error-alert');
    const otpErrorAlert = document.getElementById('otp-error-alert');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Handle Step 1: Registration Details
    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(registerForm);
        const btn = document.getElementById('btnContinue');
        btn.disabled = true;
        btn.innerText = 'Sending OTP...';
        errorAlert.classList.add('hidden');

        try {
            const response = await fetch(window.WellMind.routes.register, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                registerForm.classList.add('hidden');
                otpForm.classList.remove('hidden');
            } else {
                errorAlert.innerText = data.error || 'Something went wrong.';
                errorAlert.classList.remove('hidden');
            }
        } catch (error) {
            errorAlert.innerText = 'Network error. Please try again.';
            errorAlert.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            btn.innerText = 'Continue';
        }
    });

    // Handle Step 2: OTP Verification
    otpForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(otpForm);
        const btn = document.getElementById('btnVerify');
        btn.disabled = true;
        btn.innerText = 'Verifying...';
        otpErrorAlert.classList.add('hidden');

        try {
            const response = await fetch(window.WellMind.routes.verifyOtp, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                Swal.fire({
                    title: "Registration Successful! 🎉",
                    text: data.success,
                    icon: "success",
                    confirmButtonText: "Get Started",
                    confirmButtonColor: "#7b57ff"
                }).then(() => {
                    window.location.href = data.redirect;
                });
            } else {
                otpErrorAlert.innerText = data.error || 'Invalid OTP.';
                otpErrorAlert.classList.remove('hidden');
            }
        } catch (error) {
            otpErrorAlert.innerText = 'Network error. Please try again.';
            otpErrorAlert.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            btn.innerText = 'Verify & Create Account';
        }
    });
</script>
@endsection
