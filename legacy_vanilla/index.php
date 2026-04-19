<?php

session_start();


// Set timezone for Sri Lanka/Local User
date_default_timezone_set('Asia/Colombo');

// Force bypass of any server or browser cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");


$bgImage = '';
$greetingKey = '';
$fallback_greeting = '';

// Determine time of day for background image
$hour = (int) date('H');

// Clearly defined time periods
if ($hour >= 5 && $hour < 12) {
  $bgImage = 'morining2.jpg';
  $greetingKey = 'greeting_morning';
  $fallback_greeting = 'Good Morning';
} elseif ($hour >= 12 && $hour < 17) {
  $bgImage = 'Afternoon.jpg';
  $greetingKey = 'greeting_afternoon';
  $fallback_greeting = 'Good Afternoon';
} elseif ($hour >= 17 && $hour < 21) {
  $bgImage = 'Evening.jpg';
  $greetingKey = 'greeting_evening';
  $fallback_greeting = 'Good Evening';
} else {
  $bgImage = 'Night.jpg';
  $greetingKey = 'greeting_night';
  $fallback_greeting = 'Good Night';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WellMind LK - Your Mental Health Companion</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

  <link
    href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&family=Lato:wght@400;700&family=Noto+Sans+Sinhala:wght@400;700&family=Noto+Sans+Tamil:wght@400;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="home-page">

  <!-- Header (Standard ID #header - Add Mood Method) -->
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
          <li><a href="index.php" class="nav__link active" data-key="home">Home</a></li>
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

  <section class="hero" id="heroSection"
    style="background-image: url('./images/<?php echo $bgImage; ?>'); background-size: cover; background-position: center; width: 100%; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
    <!-- Transparent dark overlay to make white text readable like before -->
    <div
      style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.3); z-index: 0;">
    </div>

    <div class="hero-content" style="position: relative; z-index: 1; text-align: center; padding: 0 20px;">
      <div class="dynamic-greeting" id="greetingText" data-key="<?php echo $greetingKey; ?>"
        style="font-size: 1.5rem; margin-bottom: 20px; font-weight: 600; text-shadow: 2px 2px 8px rgba(0,0,0,0.8); color: white;">
        <?php echo $fallback_greeting; ?>
      </div>
      <h1 class="pop-in" data-key="homeTitle"
        style="font-size: 3.5rem; margin-bottom: 20px; text-shadow: 2px 2px 10px rgba(0,0,0,0.8); color: white;">Welcome
        to WellMind LK</h1>
      <p class="pop-in" data-key="homeText"
        style="font-size: 1.4rem; margin-bottom: 40px; text-shadow: 1px 1px 5px rgba(0,0,0,0.8); color: white; max-width: 800px; margin-left: auto; margin-right: auto;">
        Your personal mental health companion. Share your feelings, track your mood, and receive thoughtful advice
        entirely in your preferred language.</p>
      <div class="hero-buttons pop-in" style="display: flex; gap: 20px; justify-content: center;">
        <a href="login.php" class="btn-primary" data-key="loginNow"
          style="padding: 12px 30px; border-radius: 30px; font-weight: bold; background: #2A5421; color: white; text-decoration: none;">Login
          Now</a>
        <a href="register.php" class="btn-secondary" data-key="createAccount"
          style="padding: 12px 30px; border-radius: 30px; font-weight: bold; background: white; color: #2A5421; text-decoration: none;">Create
          Account</a>
      </div>
    </div>
  </section>

  <main class="main-content">
    <section class="support-info" style="padding: 40px 20px;">
      <div class="container" style="max-width: 1300px; margin: 0 auto; text-align: left; padding: 0 5%;">
      <h2 data-key="supportMsgTitle"
        style="color: #2a5421; font-size: 2.2rem; margin-bottom: 15px; font-weight: bold; font-family: inherit;">Support
        Throughout Your Mental Health Journey</h2>
      <p data-key="supportMsgBody"
        style="color: #444; font-size: 1.25rem; line-height: 1.7; font-family: inherit; font-weight: normal; max-width: 550px;">
        Whether you want to improve your mental well-being, track your mood in real time, or strengthen the techniques
        you've learned, WellMind.LK is here to support you every step of the way.</p>

      <div class="card-group" style="display: flex; gap: 20px; margin-top: 50px; flex-wrap: wrap;">
        <div class="card"
          style="flex: 1; min-width: 280px; position: relative; border-radius: 40px; overflow: hidden; padding: 0; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
          <img src="./images/lady.jpg" alt="Lady" class="movable-support-img"
            style="width: 100%; height: 500px; object-fit: cover; display: block; border-radius: 40px;">
          <div class="card-body"
            style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 80px 40px 40px; background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.5) 60%, transparent 100%); border-bottom-left-radius: 40px; border-bottom-right-radius: 40px;">
            <p class="card-text" data-key="ladyCardText"
              style="color: #fff; font-size: 1.25rem; line-height: 1.6; margin: 0; font-family: inherit; font-weight: 500; text-shadow: 1px 1px 6px rgba(0,0,0,0.9);">
              Capture your brightest moments. Every smile tells a story worth remembering.</p>
          </div>
        </div>

        <div class="card"
          style="flex: 1; min-width: 280px; position: relative; border-radius: 40px; overflow: hidden; padding: 0; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
          <img src="./images/hands.jpg" alt="Hands" class="movable-support-img"
            style="width: 100%; height: 500px; object-fit: cover; display: block; border-radius: 40px;">
          <div class="card-body"
            style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 80px 40px 40px; background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.5) 60%, transparent 100%); border-bottom-left-radius: 40px; border-bottom-right-radius: 40px;">
            <p class="card-text" data-key="handsCardText"
              style="color: #fff; font-size: 1.25rem; line-height: 1.6; margin: 0; font-family: inherit; font-weight: 500; text-shadow: 1px 1px 6px rgba(0,0,0,0.9);">
              You are never alone. Reach out, connect, and find the support you need.</p>
          </div>
        </div>

        <div class="card"
          style="flex: 1; min-width: 280px; position: relative; border-radius: 40px; overflow: hidden; padding: 0; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
          <img src="./images/videoframe_3004.png" alt="Video Frame" class="movable-support-img"
            style="width: 100%; height: 500px; object-fit: cover; display: block; border-radius: 40px;">
          <div class="card-body"
            style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 80px 40px 40px; background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.5) 60%, transparent 100%); border-bottom-left-radius: 40px; border-bottom-right-radius: 40px;">
            <p class="card-text" data-key="videoCardText"
              style="color: #fff; font-size: 1.25rem; line-height: 1.6; margin: 0; font-family: inherit; font-weight: 500; text-shadow: 1px 1px 6px rgba(0,0,0,0.9);">
              It’s okay not to be okay. Tracking your lows is the first step toward healing.</p>
          </div>
        </div>
      </div>

      <!-- New Stretch Image Card -->
      <div class="scroll-animate"
        style="max-width: 1000px; margin: 60px auto 20px; display: flex; flex-wrap: wrap; gap: 40px; align-items: center;">
        <div style="flex: 1; min-width: 300px;">
          <img src="./images/Stretch.jpg" alt="Stretch"
            style="width: 100%; height: auto; border-radius: 16px; object-fit: cover; display: block;">
        </div>
        <div style="flex: 2; min-width: 300px;">
          <h5 data-key="stretchCardTitle"
            style="font-size: 1.8rem; font-weight: bold; color: #2a5421; margin-bottom: 20px; font-family: inherit;">
            Self-Care for Your Mental Well-Being</h5>
          <p data-key="stretchCardText"
            style="font-size: 1.15rem; color: #444; line-height: 1.6; font-family: inherit; margin: 0;">WellMind.LK is
            designed for individuals who want to take care of their mental health, manage emotional challenges, or
            support themselves after being diagnosed with a mental health condition.</p>
        </div>
      </div>
      <!-- End New Stretch Image Card -->

      <!-- New Mood Image Card (Text Left, Image Right) -->
      <div class="scroll-animate"
        style="max-width: 1100px; margin: 80px auto; display: flex; flex-wrap: wrap; gap: 40px; align-items: center; justify-content: space-between;">
        <div style="flex: 2; min-width: 350px;">
          <h3 data-key="moodMainTitle"
            style="font-size: 2rem; font-weight: bold; color: #2a5421; margin-bottom: 30px; font-family: inherit;">Focus
            on Your Emotional Well-Being with WellMind.LK</h3>

          <div style="margin-bottom: 20px;">
            <h5 data-key="moodSub1Title" style="font-size: 1.3rem; font-weight: bold; color: #333; margin-bottom: 5px;">
              Understand Your Thoughts and Feelings</h5>
            <p data-key="moodSub1Text" style="font-size: 1.1rem; color: #555; line-height: 1.6; margin: 0;">With regular
              check-ins throughout the day, WellMind.LK helps you reflect on your emotions and provides personalized
              audio guidance and resources tailored to your needs.</p>
          </div>

          <div style="margin-bottom: 20px;">
            <h5 data-key="moodSub2Title" style="font-size: 1.3rem; font-weight: bold; color: #333; margin-bottom: 5px;">
              Discover Your Patterns</h5>
            <p data-key="moodSub2Text" style="font-size: 1.1rem; color: #555; line-height: 1.6; margin: 0;">Clear and
              simple visual insights help you recognize emotional patterns and guide you toward improving your
              well-being.</p>
          </div>

          <div style="margin-bottom: 20px;">
            <h5 data-key="moodSub3Title" style="font-size: 1.3rem; font-weight: bold; color: #333; margin-bottom: 5px;">
              Gain Deeper Insight into Your Mental Health</h5>
            <p data-key="moodSub3Text" style="font-size: 1.1rem; color: #555; line-height: 1.6; margin: 0;">Consistent
              feedback helps you identify challenges and better understand your mental health journey.</p>
          </div>

          <div>
            <h5 data-key="moodSub4Title" style="font-size: 1.3rem; font-weight: bold; color: #333; margin-bottom: 5px;">
              Take Positive Action</h5>
            <p data-key="moodSub4Text" style="font-size: 1.1rem; color: #555; line-height: 1.6; margin: 0;">Access
              helpful resources to set goals, manage difficult emotions, reduce stress, care for your emotional needs,
              and build healthier relationships.</p>
          </div>
        </div>

        <div style="flex: 1; min-width: 350px; text-align: center;">
          <img src="./images/mood.png" alt="Mood Tracker"
             style="width: 150%; max-width: 750px; height: auto; border-radius: 500px; object-fit: contain; display: inline-block;">
        </div>
        <!-- End New Mood Image Card -->



        <!-- New Overthinking Section -->
        <div class="scroll-animate" style="position: relative; width: 100%; min-height: 450px; display: flex; flex-direction: column; align-items: center; justify-content: center; background-image: url('./images/background1.jpg'); background-size: cover; background-position: center; border-radius: 50px; overflow: hidden; margin: 100px auto; max-width: 1200px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
          
          <!-- Dark overlay -->
          <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 0;"></div>
          
          <div style="position: relative; z-index: 1; text-align: center; padding: 40px;">
            <h2 data-key="background1Title" style="font-weight: bold; font-family: inherit; margin-bottom: 20px; font-size: 2.5rem; text-shadow: 2px 2px 8px rgba(0,0,0,0.8); color: white;">WellMind.LK Is Always There for You</h2>
            <p data-key="background1Text" style="font-size: 1.35rem; font-family: inherit; max-width: 800px; line-height: 1.6; text-shadow: 1px 1px 5px rgba(0,0,0,0.8); margin: 0 auto; color: white;">No matter where you are in your mental health journey, WellMind.LK is here to support, guide, and care for you anytime you need it.</p>
          </div>
          
        </div>
        <!-- End New Overthinking Section -->

        <!-- New Self-Guided Support Section -->
        <div class="scroll-animate" style="margin: 60px auto; max-width: 1200px; padding: 0 20px; text-align: center;">
          <h2 data-key="selfGuidedTitle" style="font-weight: bold; margin-bottom: 15px; color: #2a5421; font-size: 2rem;">Self-Guided Support with WellMind.LK</h2>
          <p data-key="selfGuidedDesc" style="font-size: 1.2rem; color: var(--text-color); max-width: 900px; margin: 0 auto; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
            WellMind.LK guides you through effective coping strategies for a wide range of challenges, including depression, burnout, anxiety, phobias, insomnia, and eating-related difficulties.
          </p>
        </div>
        <!-- End New Self-Guided Support Section -->

        <!-- Small Acts of Self-Care Section -->
        <div class="scroll-animate" style="margin: 80px auto 40px; max-width: 1200px; padding: 0 20px; text-align: center;">
          <h2 data-key="selfCareTitle" style="font-weight: bold; margin-bottom: 50px; color: #2a5421; font-size: 2.2rem;">Small Acts of Self-Care 🌿</h2>
          <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            
            <div style="flex: 1; min-width: 150px; text-align: center;">
              <img src="./images/Drink.jpg" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; box-shadow: 0 8px 24px rgba(0,0,0,0.15); margin-bottom: 25px; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" alt="Drink">
              <p data-key="selfCare1" style="font-size: 1.15rem; color: #444; font-weight: 600; line-height: 1.5;">Drink a glass of water</p>
            </div>

            <div style="flex: 1; min-width: 150px; text-align: center;">
              <img src="./images/Stretch.jpg" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; box-shadow: 0 8px 24px rgba(0,0,0,0.15); margin-bottom: 25px; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" alt="Stretch">
              <p data-key="selfCare2" style="font-size: 1.15rem; color: #444; font-weight: 600; line-height: 1.5;">Stretch your body gently</p>
            </div>

            <div style="flex: 1; min-width: 150px; text-align: center;">
              <img src="./images/breaths.jpg" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; box-shadow: 0 8px 24px rgba(0,0,0,0.15); margin-bottom: 25px; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" alt="Breaths">
              <p data-key="selfCare3" style="font-size: 1.15rem; color: #444; font-weight: 600; line-height: 1.5;">Take 3 slow, deep breaths</p>
            </div>

            <div style="flex: 1; min-width: 150px; text-align: center;">
              <img src="./images/Listen.jpg" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; box-shadow: 0 8px 24px rgba(0,0,0,0.15); margin-bottom: 25px; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" alt="Listen">
              <p data-key="selfCare4" style="font-size: 1.15rem; color: #444; font-weight: 600; line-height: 1.5;">Listen to calming music</p>
            </div>

          </div>
        </div>
        <!-- End Small Acts of Self-Care Section -->

        <!-- Take the First Step Section -->
        <div class="card mb-3 scroll-animate" style="max-width: 1000px; margin: 60px auto; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: none; background: white;">
          <div class="row g-0" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: center; margin: 0;">
            <!-- Text Left Side -->
            <div class="col-md-7" style="flex: 1; min-width: 320px; padding: 40px;">
              <div class="card-body">
                <h5 class="card-title" data-key="startTodayTitle" style="font-weight: bold; color: #2a5421; font-size: 2.2rem; margin-bottom: 20px;">Take the First Step Today</h5>
                <p class="card-text" data-key="startTodayDesc" style="font-size: 1.3rem; color: var(--text-color); line-height: 1.6; font-weight: 500;">Start Today and Understand Yourself Better</p>

                <!-- Interactive Star Rating Widget -->                
                <div class="radio" style="margin-top: 30px; justify-content: flex-start;">
                  <input value="1" name="rating" type="radio" id="rating-1" />
                  <label title="1 stars" for="rating-1">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>
                  </label>
                  <input value="2" name="rating" type="radio" id="rating-2" />
                  <label title="2 stars" for="rating-2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>
                  </label>
                  <input value="3" name="rating" type="radio" id="rating-3" />
                  <label title="3 stars" for="rating-3">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>
                  </label>
                  <input value="4" name="rating" type="radio" id="rating-4" />
                  <label title="4 stars" for="rating-4">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>
                  </label>
                  <input value="5" name="rating" type="radio" id="rating-5" />
                  <label title="5 star" for="rating-5">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>
                  </label>
                </div>
              </div>
            </div>
            <!-- Image Right Side -->
            <div class="col-md-5" style="flex: 1; min-width: 320px; text-align: right;">
              <img src="./images/start.png" class="img-fluid" alt="Take the First Step" style="width: 100%; height: auto; display: block; object-fit: cover;">
            </div>
          </div>
        </div>
        <!-- End Take the First Step Section -->

        <!-- Partner Section -->
        <div class="scroll-animate" style="position: relative; width: 100%; min-height: 550px; display: flex; flex-direction: column; align-items: center; justify-content: center; background-image: url('./images/mCare.jpg'); background-size: cover; background-position: center; border-radius: 50px; overflow: hidden; margin: 60px auto 100px; max-width: 800px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
          
          <!-- Dark overlay -->
          <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 0;"></div>
          
          <div style="position: relative; z-index: 1; text-align: center; padding: 40px;">
            <h2 data-key="partnerTitle" style="font-weight: bold; font-family: inherit; margin-bottom: 20px; font-size: 2.5rem; text-shadow: 2px 2px 8px rgba(0,0,0,0.8); color: white;">Make Mental Health Care Easy</h2>
            <p data-key="partnerDesc" style="font-size: 1.35rem; font-family: inherit; max-width: 800px; line-height: 1.6; text-shadow: 1px 1px 5px rgba(0,0,0,0.8); margin: 0 auto; color: white;">We support improving mental health and well-being through simple and effective care.</p>
            <div style="margin-top: 30px;">
              <a href="partner.php" data-key="learnMore" style="background-color: #2a5421; color: white; padding: 12px 35px; font-size: 1.2rem; border-radius: 30px; text-decoration: none; font-weight: bold; display: inline-block; box-shadow: 0 4px 15px rgba(0,0,0,0.3); transition: transform 0.3s ease;">Learn More</a>
            </div>
          </div>
          
        </div>
        <!-- End Partner Section -->

      </div>
    </section>
  </main>

  <footer style="background-color: #749D62; padding: 100px 50px; font-family: inherit; margin-top: 50px; color: white;">
    <div style="max-width: 1400px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; gap: 40px;">
      
      <!-- Left Side: Logo, Name, Socials, Links -->
      <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 30px; min-width: 300px;">
        
        <!-- Logo and Name Group -->
        <div style="display: flex; align-items: center; gap: 15px;">
          <img src="./images/websitelogo.jpg" alt="WellMind.LK" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
          <h3 style="font-family: 'League Spartan', sans-serif; font-size: 1.8rem; margin: 0; color: white; letter-spacing: 1px;">WellMind.LK</h3>
        </div>

        <!-- Socials and Links Group -->
        <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 20px;">
          <!-- Socials -->
          <div class="footer-social-box">
            <a href="#" class="socialContainer containerOne">
              <svg class="socialSvg instagramSvg" viewBox="0 0 16 16"><path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path></svg>
            </a>
            <a href="#" class="socialContainer containerTwo">
              <svg class="socialSvg twitterSvg" viewBox="0 0 16 16"><path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"></path></svg>
            </a>
            <a href="#" class="socialContainer containerThree">
              <svg class="socialSvg linkdinSvg" viewBox="0 0 448 512"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg>
            </a>
            <a href="#" class="socialContainer containerFour">
              <svg class="socialSvg whatsappSvg" viewBox="0 0 16 16"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"></path></svg>
            </a>
          </div>
          <!-- Links -->
          <div style="display: flex; flex-wrap: wrap; gap: 20px; font-size: 1.05rem;">
            <a href="imprint.html" style="color: white; text-decoration: none; opacity: 0.8; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">Imprint</a>
            <a href="privacy_policy.html" style="color: white; text-decoration: none; opacity: 0.8; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">Privacy Policy</a>
            <a href="terms.html" style="color: white; text-decoration: none; opacity: 0.8; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">Terms and Conditions</a>
            <a href="medical_device.html" style="color: white; text-decoration: none; opacity: 0.8; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">Medical Device</a>
          </div>
        </div>
      </div>

      <!-- Right Side: Copyright -->
      <div style="text-align: right;">
        <p style="font-size: 1.05rem; opacity: 0.7; margin: 0;">&copy; 2026 WellMind.LK</p>
      </div>

    </div>
  </footer>


  <script src="./assets/js/main.js?v=<?php echo time(); ?>"></script>
</body>

</html>