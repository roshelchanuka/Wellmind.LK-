<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db_connect.php';
require_once 'security_headers.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify CSRF Token
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die("CSRF token validation failed.");
    }

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $age = (int)$_POST['age'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    if (empty($full_name) || empty($email) || empty($password) || empty($age) || empty($dob) || empty($gender)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($age < 16 || $age > 25) {
        $error = "Age must be between 16 and 25.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        if (!$stmt) {
             die("Database error: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $stmt->close();
            
            // Insert new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, age, dob, gender) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiss", $full_name, $email, $hashed_password, $age, $dob, $gender);
            
            if ($stmt->execute()) {
                $success = "Registration successful! <a href='login.php'>Login here</a>";
            } else {
                $error = "Error: " . $conn->error;
            }
        }
        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - WellMind LK</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="auth-body">

<form class="form" method="POST" action="register.php">
    <h2 style="margin-top: 0; text-align: center;">Create Account</h2>
    
    <?php if(isset($error) && $error) echo "<div class='error-msg-auth'>$error</div>"; ?>
    
    <?php csrf_field(); ?>

    <div class="flex-column">
      <label>Full Name</label>
    </div>
    <div class="inputForm">
        <input type="text" name="full_name" class="input" placeholder="Enter your full name" required>
    </div>

    <div class="flex-column">
      <label>Email</label>
    </div>
    <div class="inputForm">
        <input type="email" name="email" class="input" placeholder="Enter your email" required>
    </div>

    <div class="flex-column">
      <label>Password</label>
    </div>
    <div class="inputForm">
        <input type="password" name="password" id="password" class="input" placeholder="Enter your password" required>
    </div>

    <div class="flex-column">
      <label>Date of Birth</label>
    </div>
    <div class="inputForm">
        <input type="date" name="dob" class="input" required>
    </div>

    <div class="flex-column">
      <label>Gender</label>
    </div>
    <div class="inputForm">
        <select name="gender" class="input" required style="background: transparent;">
            <option value="" disabled selected>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>

    <div class="flex-column">
      <label>Age (16-25)</label>
    </div>
    <div class="inputForm">
        <input type="number" name="age" min="16" max="25" class="input" placeholder="Enter your age" required>
    </div>
    
    <button type="submit" class="button-submit">Register</button>
    <p class="p">Already have an account? <a href="login.php" class="span">Login</a></p>
</form>

<script src="assets/js/main.js"></script> <!-- Link JS for translation -->

<?php if(!empty($success)): ?>
<script>
    Swal.fire({
        title: "Registration Successful! 🎉",
        text: "Your account has been created. You can now login.",
        icon: "success",
        confirmButtonText: "Go to Login",
        confirmButtonColor: "#7b57ff",
        background: "#fff",
        color: "#333",
        backdrop: `
            rgba(0,0,123,0.1)
            url("./images/confetti.gif")
            left top
            no-repeat
        `
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "login.php";
        }
    });
</script>
<?php endif; ?>

</body>
</html>
