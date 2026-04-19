<?php session_start();
require_once 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood History - WellMind LK</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&family=Lato:wght@400;700&family=Noto+Sans+Sinhala:wght@400;700&family=Noto+Sans+Tamil:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="lang-<?php echo isset($_SESSION['language']) ? $_SESSION['language'] : 'en'; ?>">

    <!-- Header -->
    <header class="header" id="header">
        <nav class="nav">
            <div class="nav__logo-wrapper">
                <a href="index.php" class="nav__logo">
                    <img src="./images/websitelogo.jpg" alt="App Logo" class="nav__logo-img">
                </a>
            </div>

            <div class="nav__toggle" id="nav-toggle">
                <span class="material-symbols-outlined">menu</span>
            </div>

            <div class="nav__menu" id="nav-menu">
                <div class="nav__actions" style="margin-right: 2rem;">
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <span class="user-greeting"
                            style="margin-right: 10px; font-weight: bold; color: var(--primary-color);">Hi,
                            <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <a href="logout.php" class="login-btn" data-key="logout">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="login-btn" data-key="login">Login</a>
                        <a href="register.php" class="login-btn" data-key="registerBtn"
                            style="margin-left: 10px; background-color: var(--primary-color);">Register</a>
                    <?php endif; ?>

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
                    <li><a href="history.php" class="nav__link active" data-key="history">Mood History</a></li>
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

    <!-- Hero Banner -->
    <div class="bg-card history-bg-card">
        <div class="bg-card-overlay">
            <h1 class="bg-card-title" data-key="historyHeroTitleNew">My Mood History</h1>
            <p class="bg-card-text" data-key="historyHeroTextNew">Track your emotional well-being over time.</p>
        </div>
    </div>

    <!-- Main Content -->
    <section class="container" style="margin-top: 3rem; margin-bottom: 3rem;">
        <div class="mood-container history-container">

            <!-- Filter Bar -->
            <div class="filter-section">
                <div class="date-input-group">
                    <label data-key="startDate">Start Date</label>
                    <input type="date" id="historyStartDate">
                </div>
                <div class="date-input-group">
                    <label data-key="endDate">End Date</label>
                    <input type="date" id="historyEndDate">
                </div>
                <button class="filter-btn" id="historyFilterBtn" data-key="filterBtn">Filter</button>
                <button class="clear-btn" id="historyClearBtn" data-key="clearBtn">✕ Clear</button>
            </div>

            <!-- Loading State -->
            <div class="history-loading" id="historyLoading">
                <div class="spinner"></div>
                <span>Loading your mood history...</span>
            </div>

            <!-- Data Table -->
            <div class="table-responsive" id="historyTableWrapper" style="display:none;">
                <table class="mood-table">
                    <thead>
                        <tr>
                            <th data-key="dateCol">Date</th>
                            <th data-key="timeCol">Time</th>
                            <th data-key="moodCol">Mood</th>
                            <th data-key="noteCol">Note</th>
                            <th data-key="actionCol">Action</th>
                        </tr>
                    </thead>
                    <tbody id="historyTableBody">
                        <!-- Populated by JS -->
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div class="empty-state" id="historyEmptyState" style="display:none;">
                <span class="empty-state-icon">📅</span>
                <p data-key="noHistory">No mood logs found for this period.</p>
            </div>

        </div>
    </section>

    <!-- Believe Motivation Section -->
    <div style="text-align: center; margin-bottom: 30px; position: relative; max-width: 900px; margin-left: auto; margin-right: auto; overflow: hidden; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
        <img src="./images/believe.jpg" alt="Believe in Yourself" 
             style="width: 100%; height: auto; display: block; filter: blur(3px) brightness(0.85); transform: scale(1.02);">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.2);">
            <div style="color: black; text-shadow: 0 0 10px rgba(255,255,255,0.8), 0 0 15px rgba(255,255,255,0.5); font-size: 2.6rem; font-weight: 800; width: 90%; font-family: var(--heading-font); padding: 20px;" data-key="believeMsg">
                Stay positive. Keep moving forward.
            </div>
        </div>
    </div>

    <!-- Mental Health Awareness Card -->
    <section class="container" style="display: flex; justify-content: center; margin-bottom: 4rem; margin-top: 2rem;">
        <div class="card mb-3 scroll-animate" style="max-width: 900px; display: flex; flex-direction: row; align-items: stretch; background: white; border-radius: 16px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); overflow: hidden; border: 1px solid rgba(0,0,0,0.05);">
            <div style="flex: 0 0 40%;">
                <img src="./images/start.png" class="img-fluid rounded-start" alt="Awareness" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div style="flex: 1; padding: 2.5rem; display: flex; flex-direction: column; justify-content: center;">
                <div class="card-body">
                    <h5 class="card-title" data-key="awarenessTitle" style="margin-top: 0; color: var(--primary-color); font-size: 1.8rem; font-family: var(--heading-font); margin-bottom: 1rem;">Raise Mental Health Awareness</h5>
                    <p class="card-text" data-key="awarenessText" style="color: var(--text-color); margin-bottom: 0; line-height: 1.8; font-size: 1.15rem;">Promote understanding, reduce stigma, and support a healthier, more compassionate community.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Toast -->
    <div class="history-toast" id="historyToast"></div>

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

    <script src="assets/js/main.js?v=<?php echo time(); ?>"></script>

    <!--
         WELCOME POPUP — Mood History Page
          -->

    <!-- Popup Overlay -->
    <div id="historyWelcomeOverlay" class="hw-overlay">
        <div class="hw-modal" id="historyWelcomeModal">

            <!-- Decorative orbs -->
            <span class="hw-orb hw-orb--1"></span>
            <span class="hw-orb hw-orb--2"></span>
            <span class="hw-orb hw-orb--3"></span>

            <!-- Icon -->
            <div class="hw-icon-wrap">
                <span class="hw-icon">📊</span>
            </div>

            <!-- Text -->
            <h2 class="hw-title">Welcome to Your Mood Journal</h2>
            <p class="hw-sub">Here you can explore, filter, and manage all your recorded moods in one place. 🌿</p>

            <!-- Stats row -->
            <div class="hw-stats" id="hwStats">
                <div class="hw-stat-item">
                    <span class="hw-stat-num" id="hwTotalEntries">—</span>
                    <span class="hw-stat-label">Total Entries</span>
                </div>
                <div class="hw-stat-divider"></div>
                <div class="hw-stat-item">
                    <span class="hw-stat-num" id="hwLatestMood">—</span>
                    <span class="hw-stat-label">Latest Mood</span>
                </div>
                <div class="hw-stat-divider"></div>
                <div class="hw-stat-item">
                    <span class="hw-stat-num" id="hwLatestDate">—</span>
                    <span class="hw-stat-label">Last Entry</span>
                </div>
            </div>

            <!-- CTA button -->
            <button class="hw-btn" id="hwCloseBtn">Let's Go &rarr;</button>

            <!-- Auto-close bar -->
            <div class="hw-progress-wrap">
                <div class="hw-progress-bar" id="hwProgressBar"></div>
            </div>
        </div>
    </div>

</body>

</html>