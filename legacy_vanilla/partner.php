<?php
session_start();

// Set timezone for Sri Lanka/Local User
date_default_timezone_set('Asia/Colombo');

// Force bypass of any server or browser cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WellMind LK - Partner</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

  <link
    href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&family=Lato:wght@400;700&family=Noto+Sans+Sinhala:wght@400;700&family=Noto+Sans+Tamil:wght@400;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="home-page">

  <!-- Header -->
  <header class="header" id="header">
    <nav class="nav">
      <!-- Logo -->
      <div class="nav__logo-wrapper">
        <a href="index.php" class="nav__logo">
          <img src="./images/websitelogo.jpg" alt="App Logo" class="nav__logo-img">
        </a>
      </div>
      <!-- Toggle Button -->
      <div class="nav__toggle" id="nav-toggle">
        <span class="material-symbols-outlined">menu</span>
      </div>

      <!-- Nav Menu -->
      <div class="nav__menu" id="nav-menu">
        <div class="nav__actions">
          <?php if (isset($_SESSION['user_name'])): ?>
            <span class="user-greeting">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            <a href="logout.php" class="login-btn" data-key="logout">Logout</a>
            <?php
          else: ?>
            <a href="login.php" class="login-btn" data-key="login">Login</a>
            <a href="register.php" class="login-btn register-btn" data-key="registerBtn">Register</a>
            <?php
          endif; ?>

          <!-- Language Dropdown -->
          <div class="lang-dropdown">
            <button class="lang-dropbtn" id="langDropBtn">
              <span class="material-symbols-outlined">language</span>
              <span class="current-lang-text" id="currentLangText">English</span>
              <span class="material-symbols-outlined icon-arrow">expand_more</span>
            </button>
            <div class="lang-dropdown-content">
              <a href="#" class="lang-option" data-lang="en">English</a>
              <a href="#" class="lang-option" data-lang="si">සිංහල</a>
              <a href="#" class="lang-option" data-lang="ta">தமிழ்</a>
            </div>
          </div>
        </div>

        <ul class="nav__list">
          <li><a href="index.php" class="nav__link" data-key="home">Home</a></li>
          <li><a href="addmood.php" class="nav__link" data-key="addMood">Add Mood</a></li>
          <li><a href="history.php" class="nav__link" data-key="history">Mood History</a></li>
          <li><a href="weekly_report.php" class="nav__link" data-key="weekly">Weekly Report</a></li>
          <li><a href="support.php" class="nav__link" data-key="support">Support</a></li>
          <li><a href="profile.php" class="nav__link" data-key="profile">Profile</a></li>
        </ul>

        <div class="nav__close" id="nav-close">
          <span class="material-symbols-outlined">close</span>
        </div>
      </div>
    </nav>
  </header>

  <main class="main-content" style="padding: 150px 20px 50px; text-align: center; min-height: 80vh;">
    <h2 style="color: #2a5421; font-size: 2.5rem; margin-bottom: 20px;">Partner Information</h2>
    <p style="font-size: 1.2rem; color: #444;">This page is currently under construction. Please check back later.</p>
  </main>

  <script src="./assets/js/main.js?v=<?php echo time(); ?>"></script>
</body>
</html>
