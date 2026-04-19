<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'security_headers.php';
require_once 'db_connect.php';

$error = "";
$success = "";
$step = isset($_POST['step']) ? $_POST['step'] : 'verify';
$verifiedEmail = isset($_POST['verified_email']) ? $_POST['verified_email'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify CSRF Token
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die("CSRF token validation failed.");
    }

    if ($step == 'verify') {
        $identifier = trim($_POST['identifier']);
        if (empty($identifier)) {
            $error = "Please enter your email or name.";
        } else {
            $stmt = $conn->prepare("SELECT email, full_name FROM users WHERE email = ? OR full_name = ?");
            $stmt->bind_param("ss", $identifier, $identifier);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($user = $result->fetch_assoc()) {
                $verifiedEmail = $user['email'];
                $step = 'reset';
            } else {
                $error = "No account found with those details.";
            }
            $stmt->close();
        }
    } elseif ($step == 'reset') {
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        
        if (empty($password) || empty($confirmPassword)) {
            $error = "Both password fields are required.";
        } elseif ($password !== $confirmPassword) {
            $error = "Passwords do not match.";
        } elseif (strlen($password) < 6) {
            $error = "Password must be at least 6 characters long.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashedPassword, $verifiedEmail);
            if ($stmt->execute()) {
                $success = "Password updated successfully!";
                $step = 'complete';
            } else {
                $error = "Error updating password. Please try again.";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - WellMind LK</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <!-- SweetAlert2 for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .form-step {
            transition: all 0.4s ease;
        }
        .hidden {
            display: none;
            opacity: 0;
            transform: translateY(10px);
        }
        .verified-badge {
            background: #e3f9e5;
            color: #2ecc71;
            padding: 8px;
            border-radius: 8px;
            font-size: 13px;
            text-align: center;
            margin-bottom: 15px;
            border: 1px solid #2ecc71;
        }
    </style>
</head>
<body class="auth-body">

<form class="form" id="forgotForm" method="POST" action="forgot_password.php">
    <h2 style="margin-top: 0; text-align: center;">Forgot Password</h2>
    
    <?php if($error) echo "<div class='error-msg-auth'>$error</div>"; ?>
    
    <?php csrf_field(); ?>
    <input type="hidden" name="step" value="<?php echo htmlspecialchars($step); ?>">
    <input type="hidden" name="verified_email" value="<?php echo htmlspecialchars($verifiedEmail); ?>">

    <?php if ($step == 'verify'): ?>
        <!-- STEP 1: VERIFY -->
        <div class="form-step" id="step-verify">
            <p class="p" style="color: #666; margin-bottom: 20px;">Enter your email or full name to verify your account.</p>
            
            <div class="flex-column">
                <label>Email or Full Name</label>
            </div>
            <div class="inputForm">
                <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><g id="Layer_3" data-name="Layer 3"><path d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path></g></svg>
                <input type="text" name="identifier" class="input" placeholder="Identifier" required>
            </div>
            <button type="submit" class="button-submit">Verify Account</button>
        </div>

    <?php elseif ($step == 'reset'): ?>
        <!-- STEP 2: RESET -->
        <div class="form-step" id="step-reset">
            <div class="verified-badge">
                ✅ Account verified: <b><?php echo htmlspecialchars($verifiedEmail); ?></b>
            </div>
            <p class="p" style="color: #666; margin-bottom: 20px;">Success! Now enter your new password below.</p>
            
            <div class="flex-column">
                <label>New Password</label>
            </div>
            <div class="inputForm">
                <svg height="20" viewBox="-64 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path><path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path></svg>
                <input type="password" name="password" class="input" placeholder="New Password" required minlength="6">
            </div>

            <div class="flex-column" style="margin-top: 15px;">
                <label>Confirm Password</label>
            </div>
            <div class="inputForm">
                <svg height="20" viewBox="-64 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path><path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path></svg>
                <input type="password" name="confirm_password" class="input" placeholder="Confirm Password" required minlength="6">
            </div>
            
            <button type="submit" class="button-submit">Update Password</button>
        </div>
    <?php endif; ?>

    <p class="p" style="margin-top: 20px;">Back to <a href="login.php" class="span">Login</a></p>
</form>

<?php if(!empty($success)): ?>
<script>
    Swal.fire({
        title: "Success! 🎉",
        text: "<?php echo $success; ?>",
        icon: "success",
        confirmButtonColor: "#2A5421"
    }).then(() => {
        window.location.href = "login.php";
    });
</script>
<?php endif; ?>

</body>
</html>
