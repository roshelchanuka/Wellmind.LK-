console.log("main.js loaded! (v1.21 - UI Refinement)");

function saveMoodToHistory(mood, note) {
  console.log("Attempting to save mood:", { mood, note });


  // 1. Save to LocalStorage (Fallback/Local Cache)
  const history = JSON.parse(localStorage.getItem("moodHistory") || "[]");
  const now = new Date();
  const entry = {
    date: now.toISOString().split('T')[0],
    time: now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
    mood: mood,
    note: note,
    timestamp: now.getTime()
  };
  history.push(entry);
  localStorage.setItem("moodHistory", JSON.stringify(history));

  // 2. Save to Database via fetch
  const currentLang = localStorage.getItem("language") || "en";
  fetch('save_mood.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ mood: mood, note: note, lang: currentLang })
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
      }
      return response.json();
    })
    .then(data => {
      if (data.status === 'success') {
        console.log("Mood saved to database successfully.");
      } else {
        console.error("Database Save Error:", data.message);
      }
    })
    .catch(error => {
      console.error("Fetch Error:", error);
    });
}

if (window.matchMedia("(min-width: 992px)").matches) {
  document.querySelectorAll('.quote-card').forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      const centerX = rect.width / 2;
      const centerY = rect.height / 2;

      const rotateX = ((y - centerY) / centerY) * -10;
      const rotateY = ((x - centerX) / centerX) * 10;

      card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05)`;
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
    });
  });
}

// nav bar + home page translations
const navMenu = document.getElementById('nav-menu'),
  navToggle = document.getElementById('nav-toggle'),
  navClose = document.getElementById('nav-close');

// Show Menu
if (navToggle) {
  navToggle.addEventListener('click', () => {
    navMenu.classList.add('show-menu');
  });
}

// Hide Menu
if (navClose) {
  navClose.addEventListener('click', () => {
    navMenu.classList.remove('show-menu');
  });
}

// Remove Menu on Link Click
const navLink = document.querySelectorAll('.nav__list a');
const linkAction = () => {
  const navMenu = document.getElementById('nav-menu');
  navMenu.classList.remove('show-menu');
}
navLink.forEach(n => n.addEventListener('click', linkAction));

// nav bar + home page translations
const translations = {
  en: {
    home: "Home",
    addMood: "Add Mood",
    history: "Mood History",
    weekly: "Weekly Report",
    support: "Support",
    profile: "Profile",
    login: "Login",
    homeTitle: "Mental Health Starts with You",
    homeText: "WellMind.LK is here to guide and support you on your journey to a happier, healthier mind. Take the first step toward emotional well-being today!",
    motivationTitle: "Daily Dose of Positivity",
    greeting_night: "Good Night",

    // Daily Inspiration (Long Text)
    dailyInspoTitle: "Daily Inspiration",
    dailyInspoText: "Peace comes from within. Do not seek it without. Let this moment be a gentle reminder to slow down and return to your breath. Inside you is a quiet space untouched by noise, worry, or pressure. Rest there for a while. Allow calm to flow through you like warm light, softening every tense corner of your body. 🌸\n\nIt’s okay to feel whatever you’re feeling right now. There is nothing wrong with you. Emotions rise and fall like waves, and you are safe floating through them. You don’t have to explain your feelings. You don’t have to solve everything today. Just be here. Just breathe.\n\nYou are safe here. You are held in a space of softness and acceptance. Let your thoughts settle like sand in still water. Release what you can. Keep what nourishes you. Give yourself permission to rest, to feel, and to simply exist without judgment. 🌿\n\nClose your eyes for a moment. Inhale peace. Exhale tension. Your only task right now is to care for yourself gently. And that is enough.",

    // Auth Pages
    createAccount: "Create Account",
    loginTitle: "Login",
    fullName: "Full Name",
    email: "Email",
    password: "Password",
    age: "Age (16-25)",
    registerBtn: "Register",
    alreadyAccount: "Already have an account? Login",
    loginBtnText: "Login",
    createAccountLink: "Create an account? Register",
    emailUsername: "Email / Username",
    getStarted: "Get Started",

    // Chat Page
    chatIntro: "Hello! I'm here to listen. How are you feeling today?",
    chatPlaceholder: "Type how you feel... (e.g., I am stressed about exams)",

    // History Page
    historyTitle: "Mood History",
    historyHeroTitle: "Your Emotional Journey",
    historyHeroText: "Reflect on your past to build a better future.",
    historyHeroTitleNew: "My Mood History",
    historyHeroTextNew: "Track your emotional well-being over time.",
    startDate: "Start Date",
    endDate: "End Date",
    filterBtn: "Filter",
    dateCol: "Date",
    timeCol: "Time",
    moodCol: "Mood",
    noteCol: "Note",

    // Report Page
    weeklyReportTitle: "Weekly Emotional Analysis",
    reportHeroTitle: "Weekly Wellness Insight",
    reportHeroText: "Review your detailed emotional analysis, discover trends, and get personalized advice to improve your mental well-being every single week.",
    statsDominant: "Dominant Mood",
    statsTotal: "Total Entries",
    statsStreak: "Current Streak",
    chartTitle: "Mood Distribution",

    // Add Mood Page
    addMoodHeroTitle: "Share Your Feelings",
    addMoodHeroText: "Express yourself openly and honestly to understand your emotions better.",
    addMoodTrackStressTitle: "Track Your Stress, Improve Your Mood.",
    addMoodTrackStressText: "Take a moment to check in with yourself. Understanding your stress levels can help you stay balanced and feel better every day. Record your mood, manage your emotions, and take small steps toward a healthier mind.",
    moodMotivationalTitle: "Stay Strong & Keep Growing",
    moodMotivationalText1: "Everyone faces challenges in life, and it’s okay to feel overwhelmed sometimes. What matters most is not giving up. Even small steps forward can lead to big changes over time.",
    moodMotivationalText2: "Believe in yourself and your ability to grow. You don’t have to be perfect—just keep trying.",
    moodMotivationalText3: "Take time to care for your mind and body. Better days ahead.",

    // Advice Section
    wellnessTips: "Weekly Wellness Tips 🌿",
    adviceMindfulness: "Mindfulness",
    adviceMindfulnessText: "Take 5 minutes to meditate today. Focus on your breathing.",
    adviceHydration: "Hydration",
    adviceHydrationText: "Water boosts energy! Drink 8 glasses to keep your mind sharp.",
    adviceMovement: "Movement",
    adviceMovementText: "A short walk outside can improve your mood instantly.",

    // Why Us Section
    whyUsTitle: "Why Use This Platform?",
    benefit1Title: "Helps identify emotional patterns",
    benefit1Desc: "Understand your triggers and trends over time.",
    benefit2Title: "Encourages self-awareness",
    benefit2Desc: "Become more mindful of your mental state.",
    benefit3Title: "Provides wellness support",
    benefit3Desc: "Access curated advice and tips for better health.",
    benefit4Title: "Easy and safe to use",
    benefit4Desc: "Your privacy is our priority in a secure environment.",
    benefit5Title: "Suitable for daily use",
    benefit5Desc: "Build a consistent habit of mental check-ins.",

    howItWorksTitle: "How It Works",
    step1Title: "Select your mood 😊",
    step1Desc: "Take a moment to check in with yourself and choose the mood that best matches how you’re feeling right now. There’s no right or wrong feeling — just be honest with yourself 💭",
    step2Title: "Get wellness suggestions 🌱",
    step2Desc: "After you share your mood, the system gently offers helpful tips, calming ideas, or positive activities to support you and help you feel a little better 💚",
    step3Title: "Track emotional changes 📊",
    step3Desc: "Your mood entries are safely saved so you can look back anytime, notice patterns, and understand how your feelings change over time 📅✨",
    step4Title: "Improve your mental health habits 💙",
    step4Desc: "By using the platform regularly, you can slowly build healthy habits, feel more balanced, and take small but meaningful steps toward better mental well-being 🌈",

    // Gentle Note
    noteTitle: "💙 A Gentle Note for You 🌿",
    noteText1: "This platform is created to support your emotional well-being and help you take small, positive steps toward feeling better 🌈",
    noteText2: "Please remember that it is not a replacement for professional mental health care. If you ever feel deeply overwhelmed, distressed, or in need of extra support, we gently encourage you to reach out to a qualified mental health professional, a trusted person, or a local support service 🤍",
    noteText3: "You are not alone, and seeking help is a strong and caring choice 🌸✨",

    // Small Acts of Self-Care
    selfCareTitle: "Small Acts of Self-Care 🌿",
    selfCare1: "Drink a glass of water",
    selfCare2: "Stretch your body gently",
    selfCare3: "Take 3 slow, deep breaths",
    selfCare4: "Listen to calming music",

    // 1. A Moment Just for You
    momentTitle: "🌿 A Moment Just for You 💙",
    momentText1: "This space is here for you to pause, breathe, and reconnect with yourself 🌸",
    momentText2: "Life can feel busy and overwhelming sometimes, but even a small moment of awareness can bring calm and clarity. By checking in with your emotions each day, you are taking a gentle step toward understanding yourself better and caring for your mental well-being 🌈",
    momentText3: "Move at your own pace, explore freely, and remember that every feeling you experience is valid 🤍✨",

    // 2. Daily Reflection
    reflectionTitle: "🌼 Daily Reflection 🌿",
    reflectionText1: "Take a quiet moment to reflect on your day 🌤️",
    reflectionText2: "What made you smile? What felt heavy? What are you grateful for right now?",
    reflectionText3: "Reflection is not about judging yourself — it’s about understanding your feelings with kindness and patience 🤍",
    reflectionText4: "Every small thought you notice is a step toward greater peace and self-awareness 🌸✨",

    // 3. Love Yourself
    loveSelfTitle: "💖 A Gentle Reminder to Love Yourself 🌸",
    loveSelfText1: "You are doing the best you can, and that is enough 🤍",
    loveSelfText2: "Be patient with yourself as you grow, learn, and move through each day. You deserve kindness, rest, and understanding — especially from yourself 🌿",
    loveSelfText3: "Even on difficult days, your feelings matter and your effort is meaningful. Speak to yourself with the same warmth you would offer a close friend 💞✨",
    loveSelfText4: "You are worthy of care, peace, and love exactly as you are 🌈",

    // 4. Confidence Boost
    confidenceTitle: "🌞 A Small Confidence Boost ✨",
    confidenceText1: "You are stronger than you think and more capable than you realize 💛",
    confidenceText2: "Every step you take — even the small ones — is progress. Trust yourself, celebrate your effort, and remember that growth takes time 🌱",
    confidenceText3: "You have already overcome so much, and you can handle what comes next 🌈 Keep going gently and proudly.",

    // 5. Gratitude & Self-Appreciation
    gratitudeTitle: "🌸 Gratitude & Self-Appreciation 💖",
    gratitudeText1: "Pause for a moment and appreciate something about yourself today 🤍",
    gratitudeText2: "Maybe it’s your kindness, your effort, or simply the fact that you showed up. Gratitude doesn’t have to be big — even small acknowledgments bring warmth and peace 🌿",
    gratitudeText3: "Thank yourself for trying, for learning, and for continuing forward 🌼 You deserve recognition too.",

    // 6. Calming Message
    calmMsgTitle: "💙 A Calming Message for Anxiety 🌊",
    calmMsgText1: "If your thoughts feel heavy right now, slow down and breathe gently with us 🌬️",
    calmMsgText2: "You are safe in this moment. Let your shoulders relax, unclench your jaw, and allow your breath to soften 💭",
    calmMsgText3: "Anxiety rises and falls like waves — it will pass. You are not broken, and you are not alone 🌙 Take this moment one breath at a time.",

    // Breathing Animation
    breathTitle: "🌬️ Breathing Exercise 🌿",
    breathIn: "Inhale",
    breathOut: "Exhale",
    breathDesc: "Follow the circle. Breathe in as it expands, exhale as it shrinks.",
    believeMsg: "Stay positive. Keep moving forward.",
    youthSupportTitle: "Feel better, live better",
    youthSupportText: "WellMind.LK supports youth (16–25) to stay strong and manage stress.",
    ratingPrompt: "We’d really love to hear what you think! 😊 Please take a moment to give us your rating — it helps us grow and improve for you!",
    profileTitle: "Your Profile",
    profileSubtitle: "Manage your account details and preferences.",
    profileDetails: "Profile Details",
    fullNameLabel: "Full Name",
    emailLabel: "Email Address",
    ageLabel: "Age",
    dobLabel: "Date of Birth",
    genderLabel: "Gender",
    noHistory: "No mood logs found for this period.",
    pleaseLogin: "Please login to view history.",
    clearBtn: "Clear",
    supportHeroTitle: "How can we help you?",
    supportHeroText: "We are here to support your mental health journey.",
    userFeedbacksTitle: "User Feedbacks",
    noFeedbacks: "No feedbacks yet. Be the first to share your experience!",
    giveFeedbackTitle: "Your Feedback",
    submitFeedback: "Submit Feedback",
    ratingStatus: "Thank you for your rating! 💚",
  },
  si: {
    home: "මුල් පිටුව",
    addMood: "හැඟීම එක් කරන්න",
    history: "ඉතිහාසය",
    weekly: "සතිපතා වාර්තාව",
    support: "සහය",
    profile: "පැතිකඩ",
    login: "ඇතුල් වන්න",
    homeTitle: "මානසික සෞඛ්යය ඔබෙන් ආරම්භ වේ",
    homeText: "WellMind.LK ඔබේ සතුට සහ සෞඛ්ය සම්පන්න මනසක් සඳහා මඟ පෙන්වයි සහ සහාය වේ. අදම ඔබේ හැඟීම් සම්පන්න බවට පළමු පියවර ගන්න!",
    motivationTitle: "දවසේ ධනාත්මක සිතුවිලි",
    greeting_night: "සුබ රාත්රියක්",

    // Daily Inspiration (Long Text)
    dailyInspoTitle: "දෛනික ආත්ම ප්රේණය",
    dailyInspoText: "සමාධිය ඔබ තුළින් උපදින දෙයක්. එය පිටත සොයන්න එපා. මේ මොහොත ඔබට මන්දගාමී වීමටත් ඔබේ හුස්ම වෙත ආපසු යාමටත් මෘදු සිහි කිරීමක් වෙයි. ඔබ තුළ ශබ්දය, කලබලය, පීඩනය කිසිවක් නොස්පර්ශ කරන නිහතමානී ස්ථානයක් තිබේ. ටික වේලාවක් එහි විවේක ගන්න. උණුසුම් ආලෝකයක් මෙන් සන්සුන් බව ඔබේ ශරීරයේ සෑම තද කොණක්ම මෘදු කරමින් ගලා යාමට ඉඩ දෙන්න. 🌸\n\nඔබට දැන් දැනෙන ඕනෑම හැඟීමක් දැනීම සාමාන්යයි. ඔබ සමඟ කිසිදු වැරැද්දක් නැහැ. හැඟීම් රැළි මෙන් ඉහළට නැඟී පහළට වැටේ — ඒ අතර ඔබ ආරක්ෂිතව පාවෙමින් සිටී. ඔබට ඔබේ හැඟීම් පැහැදිලි කිරීමට හෝ අදම සියල්ල විසඳීමට අවශ්ය නැහැ. මෙතැන සිටින්න. හුස්ම ගන්න.\n\nඔබ මෙහි ආරක්ෂිතයි. ඔබ මෘදුකම සහ පිළිගැනීමෙන් පිරුණු අවකාශයක රඳා ඇත. ඔබේ සිතුවිලි නිශ්චල ජලයේ වැලි මෙන් සන්සුන් වීමට ඉඩ දෙන්න. ඔබට හැකි දේ මුදා හරින්න. ඔබට පෝෂණය දෙන දේ තබා ගන්න. විවේක ගැනීමට, දැනීමට, සහ විනිශ්චයකින් තොරව පවතින්න ඔබට අවසර දෙන්න. 🌿\n\nමොහොතකට ඇස් වසාගන්න. සාමය ඇතුළට ඇදගන්න. ආතතිය පිටතට හරින්න. දැන් ඔබගේ එකම කාර්යය ඔබව මෘදු ලෙස සැලකීමයි. එය ප්රමාණවත්.",

    // Auth Pages
    createAccount: "ගිණුමක් සාදන්න",
    loginTitle: "ඇතුල් වන්න",
    fullName: "සම්පූර්ණ නම",
    email: "විද්යුත් තැපෑල",
    password: "මුරපදය",
    age: "වයස (16-25)",
    registerBtn: "ලියාපදිංචි වන්න",
    alreadyAccount: "දැනටමත් ගිණුමක් තිබේද? ඇතුල් වන්න",
    loginBtnText: "ඇතුල් වන්න",
    createAccountLink: "ගිණුමක් සාදන්න? ලියාපදිංචි වන්න",
    emailUsername: "විද්යුත් තැපෑල / පරිශීලක නාමය",
    getStarted: "ආරම්භ කරන්න",

    // Chat Page
    chatIntro: "ආයුබෝවන්! මම ඔබට සවන් දීමට මෙහි සිටිමි. ඔබට අද කෙසේද?",
    chatPlaceholder: "ඔබේ හැඟීම් මෙහි ලියන්න...",

    // History Page
    historyTitle: "මානසික ඉතිහාසය",
    historyHeroTitle: "ඔබේ හැඟීම් ගමන",
    historyHeroText: "යහපත් අනාගතයක් සඳහා ඔබේ ඉතිහාසය විමසා බලන්න.",
    historyHeroTitleNew: "මගේ මානසික ඉතිහාසය",
    historyHeroTextNew: "කාලයත් සමඟ ඔබේ මානසික යහපැවැත්ම නිරීක්ෂණය කරන්න.",
    startDate: "ආරම්භක දිනය",
    endDate: "අවසාන දිනය",
    filterBtn: "පෙරහන්න",
    dateCol: "දිනය",
    timeCol: "වේලාව",
    moodCol: "මනෝභාවය",
    noteCol: "සටහන",

    // Report Page
    weeklyReportTitle: "සතිපතා වාර්තා විශ්ලේෂණය",
    reportHeroTitle: "සතිපතා සුවතාවය දැක්ම",
    reportHeroText: "ඔබගේ සවිස්තරාත්මක චිත්තවේගීය විශ්ලේෂණය සමාලෝචනය කරන්න.",
    statsDominant: "ප්රධාන මනෝභාවය",
    statsTotal: "මුළු සටහන්",
    statsStreak: "වත්මන් දින වැල",
    chartTitle: "මනෝභාවය බෙදී යාම",

    // Add Mood Page
    addMoodHeroTitle: "ඔබේ හැඟීම් බෙදාගන්න",
    addMoodHeroText: "ඔබගේ හැඟීම් වඩා හොඳින් අවබෝධ කර ගැනීමට විවෘතව සහ අවංකව අදහස් ප්රකාශ කරන්න.",
    addMoodTrackStressTitle: "ඔබේ ආතතිය පරීක්ෂා කර ඔබේ මනෝභාවය වර්ධනය කරන්න",
    addMoodTrackStressText: "ඔබ ගැන මිනිත්තුවක් හිතන්න. ඔබේ ආතති මට්ටම තේරුම් ගැනීමෙන් ඔබට සමාන්ය ජීවිතය සමාන්විතව පවත්වාගෙන යාමට සහ හොඳින් හැඟීමට උදව් වේ. ඔබේ මනෝභාවය සටහන් කරන්න, හැඟීම් පාලනය කරන්න, සහ සෞඛ්‍යවත් මනසක් සඳහා කුඩා පියවර ගන්න.",
    moodMotivationalTitle: "ශක්තිමත්ව සිටින්න සහ වර්ධනය වෙමින් ඉන්න",
    moodMotivationalText1: "ජීවිතයේ සෑම කෙනෙකුම අභියෝග වලට මුහුණ දෙයි, සමහර වෙලාවට ආතතියක් දැනෙන එක සාමාන්ය දෙයක්. වැදගත්ම දෙය නම් අත් නොහැරීමයි. කුඩා පියවරක් වුවද, කාලයත් සමඟ විශාල වෙනස්කම් ගෙන ඒමට හැකි වේ.",
    moodMotivationalText2: "ඔබට ඔබම විශ්වාස කරන්න සහ වර්ධනය වීමට ඇති හැකියාව විශ්වාස කරන්න. පරිපූර්ණ විය යුතු නැහැ—උත්සාහ කරමින් ඉන්න.",
    moodMotivationalText3: "ඔබගේ මනස සහ ශරීරය ගැන සැලකිලිමත් වීමට කාලය ගන්න. හොඳ දින ඉදිරියට ඇත.",

    // Advice Section
    wellnessTips: "සතිපතා සුවතාවය උපදෙස් 🌿",
    adviceMindfulness: "සිහිය",
    adviceMindfulnessText: "මිනිත්තු 5ක් ගැඹුරින් හුස්ම ගන්න.",
    adviceHydration: "ජලනය",
    adviceHydrationText: "දිනකට වතුර වීදුරු 8ක් බොන්න.",
    adviceMovement: "චලනය",
    adviceMovementText: "අද කෙටි ඇවිදීමකට යන්න.",

    // Why Us Section
    whyUsTitle: "මෙම වේදිකාව භාවිතා කරන්නේ ඇයි?",
    benefit1Title: "හැඟීම් රටා හඳුනා ගැනීමට උපකාරී වේ",
    benefit1Desc: "කාලයත් සමඟ ඔබේ හැඟීම් තේරුම් ගන්න.",
    benefit2Title: "ස්වයං අවබෝධය දිරිමත් කරයි",
    benefit2Desc: "ඔබේ මානසික තත්වය ගැන වැඩි අවධානයක් යොමු කරන්න.",
    benefit3Title: "සුවතා සහාය සපයයි",
    benefit3Desc: "යහපත් සෞඛ්යයක් සඳහා උපදෙස් ලබා ගන්න.",
    benefit4Title: "භාවිතා කිරීමට පහසු සහ ආරක්ෂිතයි",
    benefit4Desc: "ආරක්ෂිත පරිසරයක් තුළ ඔබේ පෞද්ගலිකත්වය සුරකින්න.",
    benefit5Title: "දෛනික භාවිතයට සුදුසුයි",
    benefit5Desc: "මානසික සුවතාවය දෛනික පුරුද්දක් කරගන්න.",

    // How It Works Section
    howItWorksTitle: "කොහොමද වැඩ කරන්නේ",
    step1Title: "ඔබේ හැඟීම තෝරන්න",
    step1Desc: "ඔබට හැඟෙන ආකාරය නිරීක්ෂණය කිරීමට හැඟීම් තෝරන්න.",
    step2Title: "සුවතා යෝජනා ලබා ගන්න",
    step2Desc: "ඔබේ යහපැවැත්ම වැඩිදියුණු කිරීමට පුද්ගලික උපදෙස් ලබා ගන්න.",
    step3Title: "චිත්තවේගීය වෙනස්කම් නිරීක්ෂණය කරන්න",
    step3Desc: "ඔබේ ඉතිහාසය බලන්න සහ කාලයත් සමඟ ඔබේ මනෝභාවය වෙනස් වන ආකාරය බලන්න.",
    step4Title: "පුරුදු වැඩි දියුණු කරන්න",
    step4Desc: "යහපත් ජීවිතයක් සඳහා ස්ථාවර මානසික සෞඛ්ය පුරුදු ගොඩනඟා ගන්න.",

    // Gentle Note
    noteTitle: "💙 ඔබට ආදරණීය සටහනක් 🌿",
    noteText1: "මෙම වේදිකාව නිර්මාණය කර ඇත්තේ ඔබේ මානසික යහපැවැත්මට සහාය වීමට සහ ඔබට යහපත් හැඟීමක් ඇති කිරීමට කුඩා, ධනාත්මක පියවර ගැනීමට උපකාරී වේ 🌈",
    noteText2: "කරුණාකර මෙය වෘත්තීය මානසික සෞඛ්ය ප්රතිකාර සඳහා ආදේශකයක් නොවන බව මතක තබා ගන්න. ඔබට දැඩි පීඩනයක් දැනේ නම්, කරුණාකර වෘත්තීය සහාය ලබා ගන්න 🤍",
    noteText3: "ඔබ තනි වී නැත, උදව් ඉල්ලීම ධෛර්ය සම්පන්න තේරීමකි 🌸✨",

    // Small Acts of Self-Care
    selfCareTitle: "ස්වයං රැකවරණයේ කුඩා පියවර 🌿",
    selfCare1: "වතුර වීදුරුවක් බොන්න",
    selfCare2: "ඔබේ ශරීරය මෘදු ලෙස දිගු කරන්න",
    selfCare3: "සෙමින් ගැඹුරු හුස්ම 3ක් ගන්න",
    selfCare4: "සන්සුන් සංගීතයට සවන් දෙන්න",

    // 1. A Moment Just for You
    momentTitle: "🌿 ඔබ වෙනුවෙන් මොහොතක් 💙",
    momentText1: "මේ අවකාශය ඔබට නවතිලා, හුස්ම ගන්න, ඔබවම නැවත සම්බන්ධ කරගන්න සදහායි 🌸",
    momentText2: "ජීවිතය සමහර වෙලාවට කාර්යබහුල සහ බරපතල විය හැක, නමුත් කුඩා අවධානයක්වත් ඔබට සන්සුන් බව සහ පැහැදිලිතාව ගෙන එයි 🌈",
    momentText3: "ඔබේ හැඟීම් දිනපතා සොයා බැලීමෙන්, ඔබ ඔබව වඩා හොඳින් අවබෝධ කරගැනීමට සහ ඔබේ මානසික සුවතාවය රැකගැනීමට මෘදු පියවරක් ගන්නවා 🤍✨",
    momentText4: "ඔබේ වේගයෙන් ඉදිරියට යන්න. ඔබට හැඟෙන සෑම හැඟීමක්ම වැදගත්ය 🌿",

    // 2. Daily Reflection
    reflectionTitle: "🌼 දිනපතා ආවර්ජනය 🌿",
    reflectionText1: "අද ඔබේ දවස ගැන මොහොතක් නිහඬව සිතා බලන්න 🌤️",
    reflectionText2: "ඔබට සිනහව ගෙන ආ දේ මොනවාද? බරපතල වුණු දේ මොනවාද? මේ මොහොතේ ඔබ කෘතඥ වන්නේ කුමකටද?",
    reflectionText3: "ආවර්ජනය කියන්නේ ඔබව විනිශ්චය කිරීම නොවෙයි — ඔබේ හැඟීම් කරුණාවෙන් සහ ඉවසීමෙන් අවබෝධ කරගැනීමයි 🤍",
    reflectionText4: "ඔබ සලකන සෑම කුඩා සිතුවිල්ලක්ම වැඩි සන්සුන් බවක් සහ ස්වයං අවබෝධයක් වෙත පියවරකි 🌸✨",

    // 3. Love Yourself
    loveSelfTitle: "💖 ඔබට ඔබව ආදරයෙන් මතක් කිරීමක් 🌸",
    loveSelfText1: "ඔබ කරමින් සිටින උත්සාහය ප්රමාණවත් — ඔබ හොඳින් කරගෙන යනවා 🤍",
    loveSelfText2: "ඔබ වර්ධනය වෙමින්, ඉගෙන ගනිමින්, දිනෙන් දින ඉදිරියට යන අතර ඔබට ඔබටම ඉවසීමෙන් හා කරුණාවෙන් හැසිරෙන්න 🌿",
    loveSelfText3: "අමාරු දිනවලදී පවා, ඔබගේ හැඟීම් වැදගත්ය සහ ඔබගේ උත්සාහය අර්ථවත්ය 💞",
    loveSelfText4: "ඔබ ඔබටම ආදරය, සන්සුන් බව, සහ සැලකිල්ල ලැබීමට වටින කෙනෙක් 🌈✨",

    // 4. Confidence Boost
    confidenceTitle: "🌞 කුඩා විශ්වාස ශක්තිමත් කිරීමක් ✨",
    confidenceText1: "ඔබ සිතනවාට වඩා ඔබ ශක්තිමත්, ඔබ විශ්වාස කරනවාට වඩා ඔබට හැකියාව තියෙනවා 💛",
    confidenceText2: "ඔබ ගන්නා සෑම කුඩා පියවරක්ම — එය ප්රගතියකි. ඔබේ උත්සාහය අගය කරන්න, ඔබව විශ්වාස කරන්න, වර්ධනයට කාලය ගන්න ඉඩ දෙන්න 🌱",
    confidenceText3: "ඔබ දැනටමත් බොහෝ දේ ජයගෙන තිබෙනවා, ඉදිරියට එන දේවල්ද ඔබට හැසිරවිය හැක 🌈 මෘදු ලෙසත්, ගර්වයෙන්ත් ඉදිරියට යන්න.",

    // 5. Gratitude & Self-Appreciation
    gratitudeTitle: "🌸 කෘතඥතාවය සහ ස්වයං අගය කිරීම 💖",
    gratitudeText1: "අද ඔබ ගැන යම් හොඳ දෙයක් මොහොතක් සිතා බලන්න 🤍",
    gratitudeText2: "ඒ ඔබගේ කරුණාව වෙන්න පුළුවන්, ඔබගේ උත්සාහය වෙන්න පුළුවන්, නැත්නම් අදත් ඉදිරියට ගිය එකම වෙන්න පුළුවන් 🌿",
    gratitudeText3: "කෘතඥතාවය විශාල දෙයක් වෙන්න අවශ්ය නැහැ — කුඩා අගය කිරීම් පවා උණුසුම් බවක් සහ සන්සුන් බවක් ගෙන එයි 🌼",
    gratitudeText4: "උත්සාහ කරන ඔබට, ඉගෙන ගන්නා ඔබට, ඉදිරියට යන ඔබට ස්තූතියි 🌈✨",

    // 6. Calming Message
    calmMsgTitle: "💙 ආතතිය සඳහා සන්සුන් පණිවිඩයක් 🌊",
    calmMsgText1: "මේ මොහොතේ ඔබේ සිතුවිලි බරපතල නම්, ටිකක් නවතිලා සෙමින් හුස්ම ගන්න 🌬️",
    calmMsgText2: "ඔබ මේ මොහොතේ ආරක්ෂිතයි. ඔබේ උරහිස් සෙමින් ලිහිල් කරන්න, හුස්ම මෘදු කරගන්න 💭",
    calmMsgText3: "ආතතිය රළ වගේ — එය එනවා සහ යනවා. මේ හැඟීමත් ගමන් කරයි 🌙 ඔබ කැඩී ගිය කෙනෙක් නොවෙයි, ඔබ තනිවමත් නොවෙයි 🤍 එක් හුස්මක් බැගින් මේ මොහොත ගන්න.",

    // Breathing Animation
    breathTitle: "🌬️ ශ්වසන අභ්යාසය 🌿",
    breathIn: "හුස්ම ගන්න",
    breathOut: "පිට කරන්න",
    breathDesc: "වෘත්තය දෙස බලන්න. එය ප්රසාරණය වන විට හුස්ම ගන්න, හැකිලෙන විට හුස්ම පිට කරන්න.",
    believeMsg: "ධනාත්මකව සිටින්න. ඉදිරියට යන්න.",
    youthSupportTitle: "හොඳට දැනෙන්න, හොඳට ජීවත් වෙන්න",
    youthSupportText: "WellMind.LK වයස 16–25 අතර තරුණයන්ට ශක්තිමත් වීමට සහ පීඩාවන් පාලනය කිරීමට උදව් කරයි.",
    ratingPrompt: "ඔබගේ අදහස් අපට බොහෝ වැදගත් 😊 කරුණාකර අපගේ සේවාව තව හොඳ කරන්න ඔබගේ රේටින් එක දාන්න!",
    profileTitle: "ඔබේ පැතිකඩ",
    profileSubtitle: "ඔබේ ගිණුම් විස්තර සහ මනාප කළමනාකරණය කරන්න.",
    profileDetails: "පැතිකඩ විස්තර",
    fullNameLabel: "සම්පූර්ණ නම",
    emailLabel: "විද්යුත් තැපෑල",
    ageLabel: "වයස",
    dobLabel: "උපන් දිනය",
    genderLabel: "ස්ත්රී පුරුෂ භාවය",
    noHistory: "මෙම කාල සීමාව සඳහා කිසිදු සටහනක් හමු නොවීය.",
    pleaseLogin: "ඉතිහාසය බැලීමට කරුණාකර ඇතුල් වන්න.",
    clearBtn: "පැහැදිලි කරන්න",
    supportHeroTitle: "අපට ඔබට උදව් කළ හැකි කෙසේද?",
    supportHeroText: "අපි ඔබේ මානසික සෞඛ්‍ය ගමනට සහාය වීමට මෙහි සිටිමු.",
    userFeedbacksTitle: "පරිශීලක ප්‍රතිපෝෂණ",
    noFeedbacks: "තවමත් ප්‍රතිපෝෂණ නොමැත. ඔබේ අත්දැකීම් බෙදාගත් පළමු පුද්ගලයා වන්න!",
    giveFeedbackTitle: "ඔබේ ප්‍රතිපෝෂණය",
    submitFeedback: "ප්‍රතිපෝෂණය ඉදිරිපත් කරන්න",
    ratingStatus: "ඔබේ ශ්‍රේණිගත කිරීම වෙනුවෙන් ස්තූතියි! 💚",
  },
  ta: {
    home: "முகப்பு",
    addMood: "உணர்வு சேர்க்க",
    history: "வரலாறு",
    weekly: "வாராந்திர அறிக்கை",
    support: "ஆதரவு",
    profile: "சுயவிவரம்",
    login: "உள்நுழைய",
    homeTitle: "உங்கள் மனம், எங்கள் முன்னுரிமை",
    homeText: "WellMind.LK உங்களை மனநலச் சுகமான மற்றும் மகிழ்ச்சியான பயணத்தில் வழிநடத்த மற்றும் ஆதரிக்க உள்ளது. இன்று உங்கள் உணர்ச்சி நலத்திற்கு முதல் படியை எடுக்குங்கள்!",
    motivationTitle: "தினசரி நேர்மறை சிந்தனைகள்",
    greeting_night: "இனிய இரவு",

    // Daily Inspiration (Long Text)
    dailyInspoTitle: "தினசரி ஊக்கவுரை",
    dailyInspoText: "அமைதி உன் உள்ளத்திலிருந்து வருகிறது. அதை வெளியே தேட வேண்டாம். இந்த தருணம் மெதுவாகி உன் மூச்சுக்கு திரும்பச் சொல்லும் மென்மையான நினைவூட்டல். சத்தம், கவலை, அழுத்தம் எதுவும் தொட்டிடாத அமைதியான இடம் உன் உள்ளத்தில் இருக்கிறது. சில நேரம் அங்கே ஓய்வெடு. வெப்பமான ஒளி போல அமைதி உன் உடலின் இறுக்கமான பகுதிகளை மென்மையாக்க அனுமதி கொடு. 🌸\n\nநீ இப்போது உணரும் எந்த உணர்வும் சரியே. உன்னிடம் எந்த தவறும் இல்லை. உணர்வுகள் அலை போல உயர்ந்து இறங்கும் — நீ அவற்றில் பாதுகாப்பாக மிதக்கிறாய். உன் உணர்வுகளை விளக்க வேண்டிய அவசியமில்லை. இன்று எல்லாவற்றையும் சரிசெய்ய வேண்டியதுமில்லை. இங்கே இரு. மூச்சை இழு.\n\nநீ இங்கே பாதுகாப்பாக இருக்கிறாய். மென்மையும் ஏற்றுக்கொள்ளுதலும் நிறைந்த இடத்தில் நீ இருக்கிறாய். அமைதியான நீரில் மணல் அமரும் போல உன் எண்ணங்கள் அமைதியாகட்டும். விட முடிந்ததை விடு. உன்னை வளர்க்கும் விஷயங்களை வைத்துக்கொள். ஓய்வெடுக்கவும், உணரவும், தீர்ப்பின்றி இருப்பதற்கும் உனக்கு அனுமதி கொடு. 🌿\n\nஒரு கணம் கண்களை மூடு. அமைதியை உள்ளிழு. அழுத்தத்தை வெளியே விடு. இப்போது உன் ஒரே வேலை — உன்னை மென்மையாக கவனித்துக்கொள்வது. அதுவே போதும்.",

    createAccount: "கணக்கை உருவாக்கவும்",
    loginTitle: "உள்நுழைய",
    fullName: "முழு பெயர்",
    email: "மின்னஞ்சல்",
    password: "கடவுச்சொல்",
    age: "வயது (16-25)",
    registerBtn: "பதிவு செய்க",
    alreadyAccount: "ஏற்கனவே கணக்கு உள்ளதா? உள்நுழையவும்",
    loginBtnText: "உள்நுழைய",
    createAccountLink: "கணக்கை உருவாக்கவா? பதிவு செய்க",
    emailUsername: "மின்னஞ்சல் / பயனர் பெயர்",
    getStarted: "தொடங்குங்கள்",

    // Chat Page
    chatIntro: "வணக்கம்! நான் கேட்க இங்கே இருக்கிறேன். இன்று நீங்கள் எப்படி உணர்கிறீர்கள்?",
    chatPlaceholder: "உங்கள் உணர்வுகளை இங்கே தட்டச்சு செய்க...",

    // History Page
    historyTitle: "மனநிலை வரலாறு",
    historyHeroTitle: "உங்கள் உணர்ச்சிப் பயணம்",
    historyHeroText: "சிறந்த எதிர்காலத்திற்காக உங்கள் கடந்த காலத்தை சிந்தியுங்கள்.",
    historyHeroTitleNew: "எனது மனநிலை வரலாறு",
    historyHeroTextNew: "காலப்போக்கில் உங்கள் உணர்ச்சி ஆரோக்கியத்தைக் கண்காணிக்கவும்.",
    startDate: "தொடக்க தேதி",
    endDate: "முடிவு தேதி",
    filterBtn: "வடிகட்டு",
    dateCol: "தேதி",
    timeCol: "நேரம்",
    moodCol: "மனநிலை",
    noteCol: "குறிப்பு",

    // Report Page
    weeklyReportTitle: "வாராந்திர உணர்ச்சி பகுப்பாய்வு",
    reportHeroTitle: "வாராந்திர ஆரோக்கிய நுண்ணறிவு",
    reportHeroText: "உங்கள் விரிவான உணர்ச்சிப் பகுப்பாய்வை மதிப்பாய்வு செய்யவும்.",
    statsDominant: "முக்கிய மனநிலை",
    statsTotal: "மொத்த பதிவுகள்",
    statsStreak: "தற்போதைய தொடர்ச்சி",
    chartTitle: "மனநிலை விநியோகம்",

    // Add Mood Page
    addMoodHeroTitle: "உங்கள் உணர்வுகளைப் பகிரவும்",
    addMoodHeroText: "உங்கள் உணர்ச்சிகளை நன்கு புரிந்துகொள்ள வெளிப்படையாகவும் நேர்மையாகவும் வெளிப்படுத்துங்கள்.",
    addMoodTrackStressTitle: "உங்கள் மன அழுத்தத்தை கண்காணித்து மனநிலையை மேம்படுத்துங்கள்",
    addMoodTrackStressText: "ஒரு நிமிடம் உங்களைப் பற்றி சிந்தியுங்கள். உங்கள் மன அழுத்த நிலையை புரிந்துகொள்வது, தினசரி வாழ்க்கையில் சமநிலையை பேணவும் நலமாக உணரவும் உதவும். உங்கள் மனநிலையை பதிவு செய்யுங்கள், உணர்வுகளை கட்டுப்படுத்துங்கள், மற்றும் ஆரோக்கியமான மனதிற்காக சிறிய முன்னேற்றங்களை எடுங்கள்.",
    moodMotivationalTitle: "வலிமையாக இருங்கள் & தொடர்ந்து வளருங்கள்",
    moodMotivationalText1: "வாழ்க்கையில் அனைவரும் சவால்களை சந்திக்கிறார்கள், சில நேரங்களில் மன அழுத்தமாக உணருவது இயல்பானது. முக்கியமானது விடாமல் முயற்சி செய்வது. சிறிய முன்னேற்றங்கள்கூட காலப்போக்கில் பெரிய மாற்றங்களை உருவாக்கும்.",
    moodMotivationalText2: "உங்களை நம்புங்கள் மற்றும் வளர உங்கள் திறனை நம்புங்கள். நீங்கள் முழுமையானவராக இருக்க வேண்டியதில்லை—முயற்சி செய்து கொண்டே இருங்கள்.",
    moodMotivationalText3: "உங்கள் மனமும் உடலும் கவனிக்க நேரம் எடுத்துக்கொள்ளுங்கள். நல்ல நாட்கள் முன் இருக்கின்றன.",

    // Advice Section
    wellnessTips: "வாராந்திர ஆரோக்கிய குறிப்புகள் 🌿",
    adviceMindfulness: "கவனத்துடன்",
    adviceMindfulnessText: "5 நிமிடங்கள் ஆழமாக சுவாசிக்கவும்.",
    adviceHydration: "நீரேற்றம்",
    adviceHydrationText: "தினமும் 8 டம்ளர் தண்ணீர் குடிக்கவும்.",
    adviceMovement: "இயக்கம்",
    adviceMovementText: "இன்று ஒரு சிறு நடைப்பயணம் செல்லுங்கள்.",

    // Why Us Section
    whyUsTitle: "இந்த தளத்தை ஏன் பயன்படுத்த வேண்டும்?",
    benefit1Title: "உணர்ச்சி வடிவங்களை அடையாளம் காண உதவுகிறது",
    benefit1Desc: "காலப்போக்கில் உங்கள் உணர்வுகளைப் புரிந்து கொள்ளுங்கள்.",
    benefit2Title: "சுய விழிப்புணர்வை ஊக்குவிக்கிறது",
    benefit2Desc: "உங்கள் மன நிலையில் அதிக கவனம் செலுத்துங்கள்.",
    benefit3Title: "ஆரோக்கிய ஆதரவை வழங்குகிறது",
    benefit3Desc: "சிறந்த ஆரோக்கியத்திற்கான ஆலோசனைகளைப் பெறுங்கள்.",
    benefit4Title: "பயன்படுத்த எளிதானது மற்றும் பாதுகாப்பானது",
    benefit4Desc: "பாதுகாப்பான சூழலில் உங்கள் தனியுரிமை முக்கியமானது.",
    benefit5Title: "தினசரி பயன்பாட்டிற்கு ஏற்றது",
    benefit5Desc: "மனநலப் பரிசோதனையை தினசரி பழக்கமாக ஆக்குங்கள்.",

    // How It Works Section
    howItWorksTitle: "எப்படி இது செயல்படுகிறது",
    step1Title: "உங்கள் மனநிலையைத் தேர்ந்தெடுக்கவும்",
    step1Desc: "நீங்கள் எப்படி உணர்கிறீர்கள் என்பதைக் கண்காணிக்க பல்வேறு உணர்வுகளிலிருந்து தேர்வு செய்யவும்.",
    step2Title: "ஆரோக்கிய பரிந்துரைகளைப் பெறுங்கள்",
    step2Desc: "உங்கள் நல்வாழ்வை மேம்படுத்த தனிப்பயனாக்கப்பட்ட உதவிக்குறிப்புகளைப் பெறுங்கள்.",
    step3Title: "உணர்ச்சி மாற்றங்களைக் கண்காணிக்கவும்",
    step3Desc: "உங்கள் வரலாற்றைப் பார்க்கவும் மற்றும் காலப்போக்கில் உங்கள் மனநிலை எவ்வாறு மாறுகிறது என்பதைப் பார்க்கவும்.",
    step4Title: "பழக்கவழக்கங்களை மேம்படுத்தவும்",
    step4Desc: "சிறந்த வாழ்க்கைக்கு நிலையான மனநலப் பழக்கங்களை உருவாக்குங்கள்.",

    // Gentle Note
    noteTitle: "💙 உங்களுக்கான குறிப்பு 🌿",
    noteText1: "உங்கள் உணர்ச்சி நல்வாழ்வை ஆதரிக்கவும், நீங்கள் நன்றாக உணர சிறிய, நேர்மறையான நடவடிக்கைகளை எடுக்கவும் இந்த தளம் உருவாக்கப்பட்டுள்ளது 🌈",
    noteText2: "இது தொழில்முறை மனநல சிகிச்சைக்கு மாற்றாக இல்லை என்பதை நினைவில் கொள்க. நீங்கள் மிகவும் மன உளைச்சலுக்கு ஆளானால், தயவுசெய்து தொழில்முறை உதவியை நாடுங்கள் 🤍",
    noteText3: "நீங்கள் தனியாக இல்லை, உதவி தேடுவது ஒரு தைரியமான தேர்வு 🌸✨",

    // Small Acts of Self-Care
    selfCareTitle: "சுய பாதுகாப்பின் சிறிய செயல்கள் 🌿",
    selfCare1: "ஒரு டம்ளர் தண்ணீர் குடிக்கவும்",
    selfCare2: "உங்கள் உடலை மெதுவாக நீட்டவும்",
    selfCare3: "3 முறை மெதுவாக, ஆழமாக மூச்சு விடுங்கள்",
    selfCare4: "அமைதியான இசையைக் கேளுங்கள்",

    momentTitle: "🌿 உங்களுக்கான ஒரு அமைதியான தருணம் 💙",
    momentText1: "இந்த இடம் நீங்கள் ஓய்ந்து, சுவாசித்து, உங்களை மீண்டும் உணர ஒரு மென்மையான இடமாக உருவாக்கப்பட்டுள்ளது 🌸",
    momentText2: "வாழ்க்கை சில நேரங்களில் பரபரப்பாகவும் சிரமமாகவும் தோன்றலாம், ஆனால் ஒரு சிறிய நிமிட கவனம் கூட அமைதியையும் தெளிவையும் தர முடியும் 🌈",
    momentText3: "உங்கள் உணர்வுகளை தினமும் கவனிப்பது, உங்களை நன்றாக புரிந்து கொண்டு மன நலத்தை பாதுகாக்க உதவும் 🤍✨",
    momentText4: "உங்கள் வேகத்தில் முன்னேறுங்கள். நீங்கள் உணரும் ஒவ்வொரு உணர்வும் முக்கியமானது 🌿",

    // 2. Daily Reflection
    reflectionTitle: "🌼 தினசரி சிந்தனை 🌿",
    reflectionText1: "உங்கள் நாளைப் பற்றி அமைதியாக ஒரு நிமிடம் சிந்தியுங்கள் 🌤️",
    reflectionText2: "உங்களுக்கு சிரிப்பை தந்தது என்ன? சிரமமாக உணர்ந்தது என்ன? இப்போது நீங்கள் எதற்காக நன்றி கூறுகிறீர்கள்?",
    reflectionText3: "சிந்தனை என்பது உங்களை குறை கூறுவது அல்ல — உங்கள் உணர்வுகளை கருணையுடன் மற்றும் பொறுமையுடன் புரிந்து கொள்வது 🤍",
    reflectionText4: "நீங்கள் கவனிக்கும் ஒவ்வொரு சிறிய எண்ணமும் அமைதிக்கும் சுய புரிதலுக்கும் ஒரு படியாகும் 🌸✨",

    // 3. Love Yourself
    loveSelfTitle: "💖 உங்களை நேசிக்க ஒரு மென்மையான நினைவூட்டல் 🌸",
    loveSelfText1: "நீங்கள் செய்கிற முயற்சி போதுமானது — நீங்கள் நன்றாக செய்கிறீர்கள் 🤍",
    loveSelfText2: "நீங்கள் வளர்ந்து கற்றுக்கொண்டு முன்னேறும் போது, உங்களிடம் பொறுமையுடனும் கருணையுடனும் நடந்து கொள்ளுங்கள் 🌿",
    loveSelfText3: "கடினமான நாட்களிலும் உங்கள் உணர்வுகள் முக்கியமானவை, உங்கள் முயற்சி அர்த்தமுள்ளது 💞",
    loveSelfText4: "நீங்கள் அன்புக்கும் அமைதிக்கும் যত்னத்திற்கும் தகுதியானவர் 🌈✨",

    // 4. Confidence Boost
    confidenceTitle: "🌞 ஒரு சிறிய நம்பிக்கை ஊக்கம் ✨",
    confidenceText1: "நீங்கள் நினைப்பதைக் காட்டிலும் பலமானவர், நீங்கள் நம்புவதைக் காட்டிலும் அதிக திறன் கொண்டவர் 💛",
    confidenceText2: "நீங்கள் எடுக்கும் ஒவ்வொரு சிறிய படியும் முன்னேற்றமே. உங்கள் முயற்சியை பாராட்டுங்கள், உங்களை நம்புங்கள், வளர நேரம் எடுத்துக்கொள்ளுங்கள் 🌱",
    confidenceText3: "நீங்கள் ஏற்கனவே பலவற்றை கடந்து வந்துள்ளீர்கள்; அடுத்ததையும் சமாளிக்க முடியும் 🌈 மெதுவாகவும் பெருமையுடனும் முன்னேறுங்கள்.",

    // 5. Gratitude & Self-Appreciation
    gratitudeTitle: "🌸 நன்றி & சுய பாராட்டு 💖",
    gratitudeText1: "இன்று உங்களைப் பற்றி ஒரு நல்ல விஷயத்தை ஒரு நிமிடம் நினைத்துப் பாருங்கள் 🤍",
    gratitudeText2: "அது உங்கள் கருணையாக இருக்கலாம், உங்கள் முயற்சியாக இருக்கலாம், அல்லது இன்று முன்னேறியதற்காக இருக்கலாம் 🌿",
    gratitudeText3: "நன்றி கூறுவது பெரியதாக இருக்க வேண்டியதில்லை — சிறிய பாராட்டுகளும் மனதில் வெப்பமும் அமைதியும் தரும் 🌼",
    gratitudeText4: "முயற்சி செய்கிற உங்களுக்கும், கற்றுக்கொள்கிற உங்களுக்கும், முன்னேறுகிற உங்களுக்கும் நன்றி 🌈✨",

    // 6. Calming Message
    calmMsgTitle: "💙 கவலைக்கான அமைதியான செய்தி 🌊",
    calmMsgText1: "இப்போது உங்கள் எண்ணங்கள் கனமாக இருந்தால், ஒரு நிமிடம் நின்று மெதுவாக சுவாசியுங்கள் 🌬️",
    calmMsgText2: "இந்த தருணத்தில் நீங்கள் பாதுகாப்பாக இருக்கிறீர்கள். உங்கள் உடலை தளர்த்தி, சுவாசத்தை மென்மையாக்குங்கள் 💭",
    calmMsgText3: "Anxiety rising and falls like waves — it will pass. You are not broken, and you are not alone 🌙 Take this moment one breath at a time.", // Fixed typo or mix of EN/TA?

    // Breathing Animation
    breathTitle: "🌬️ சுவாசப் பயிற்சி 🌿",
    breathIn: "மூச்சை இழு",
    breathOut: "மூச்சை விடு",
    breathDesc: "வட்டத்தைப் பின்தொடரவும். அது விரிவடையும் போது மூச்சை இழுக்கவும், சுருங்கும் போது மூச்சை விடவும்.",
    believeMsg: "நேர்மறையாக இருங்கள். முன்னேறுங்கள்.",
    youthSupportTitle: "நன்றாக உணருங்கள், நல்ல வாழ்க்கை வாழுங்கள்",
    youthSupportText: "WellMind.LK 16–25 வயது இளைஞர்களுக்கு வலிமையாக இருந்து அழுத்தத்தை சமாளிக்க உதவுகிறது.",
    ratingPrompt: "உங்கள் கருத்து எங்களுக்கு மிகவும் முக்கியம் 😊 எங்களை மேலும் மேம்படுத்த உதவ தயவுசெய்து உங்கள் மதிப்பீட்டை அளிக்கவும்!",
    profileTitle: "உங்கள் சுயவிவரம்",
    profileSubtitle: "உங்கள் கணக்கு விவரங்கள் மற்றும் முன்னுரிமைகளை நிர்வகிக்கவும்.",
    profileDetails: "சுயவிவர விவரங்கள்",
    fullNameLabel: "முழு பெயர்",
    emailLabel: "மின்னஞ்சல் முகவரி",
    ageLabel: "வயது",
    dobLabel: "பிறந்த தேதி",
    genderLabel: "பாலினம்",
    noHistory: "இந்த காலப்பகுதியில் எந்த பதிவுகளும் காணப்படவில்லை.",
    pleaseLogin: "வரலாற்றைப் பார்க்க தயவுசெய்து உள்நுழையவும்.",
    clearBtn: "அழி",
    supportHeroTitle: "நாங்கள் உங்களுக்கு எவ்வாறு உதவ முடியும்?",
    supportHeroText: "உங்கள் மனநலப் பயணத்தை ஆதரிக்க நாங்கள் இங்கே இருக்கிறோம்.",
    userFeedbacksTitle: "பயனர் பின்னூட்டங்கள்",
    noFeedbacks: "இன்னும் பின்னூட்டங்கள் இல்லை. உங்கள் அனுபவத்தைப் பகிர்ந்து கொள்ளும் முதல் நபராக இருங்கள்!",
    giveFeedbackTitle: "உங்கள் பின்னூட்டம்",
    submitFeedback: "பின்னூட்டத்தைச் சமர்ப்பிக்கவும்",
    ratingStatus: "உங்கள் மதிப்பீட்டிற்கு நன்றி! 💚",
  }
};



// Navbar Scroll Effect
window.addEventListener("scroll", () => {
  const header = document.getElementById("header");
  if (header) {
    if (window.scrollY > 50) {
      header.classList.add("scrolled");
    } else {
      header.classList.remove("scrolled");
    }
  }
});

document.addEventListener("DOMContentLoaded", () => {

  /* 1. LANGUAGE LOGIC (Dropdown) */
  const savedLang = localStorage.getItem("language") || "en";
  applyLanguage(savedLang);
  updateDropdownText(savedLang);

  // Dropdown Toggle Logic
  const langDropBtn = document.getElementById("langDropBtn");
  const langDropdown = document.querySelector(".lang-dropdown");
  if (langDropBtn && langDropdown) {
    langDropBtn.addEventListener("click", (e) => {
      e.preventDefault();
      langDropdown.classList.toggle("show");
    });
    // Close dropdown if clicked outside
    document.addEventListener("click", (e) => {
      if (!langDropdown.contains(e.target)) {
        langDropdown.classList.remove("show");
      }
    });
  }

  // Dropdown Options
  document.querySelectorAll(".lang-option").forEach(btn => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const lang = btn.getAttribute("data-lang");
      setLanguage(lang);
      if (langDropdown) langDropdown.classList.remove("show");
    });
  });

  /* 2. NAVBAR LOGIC */
  // Active Link
  const navLinks = document.querySelectorAll('.nav__list a');
  navLinks.forEach(link => {
    if (link.href === window.location.href) {
      link.classList.add('active');
    }
  });

  /* 3. COOKIE CARD LOGIC */
  const cookieCard = document.getElementById("cookieCard");
  const acceptButton = document.querySelector(".acceptButton");

  if (cookieCard && acceptButton) {
    function showCookie() {
      cookieCard.classList.add("show");
      document.body.classList.add("cookie-active");
    }
    function hideCookie() {
      cookieCard.classList.remove("show");
      document.body.classList.remove("cookie-active");
    }

    // Check accept status
    if (!localStorage.getItem("cookieAccepted")) {
      setTimeout(showCookie, 2000);
    }

    acceptButton.addEventListener("click", () => {
      localStorage.setItem("cookieAccepted", "true");
      hideCookie();
    });

    const declineButton = document.querySelector(".declineButton");
    if (declineButton) {
      declineButton.addEventListener("click", () => {
        hideCookie();
      });
    }
  }

  /* 4. PASSWORD TOGGLE */
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');
  if (togglePassword && password) {
    togglePassword.addEventListener('click', function (e) {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      this.textContent = type === 'password' ? 'visibility' : 'visibility_off';
    });
  }

  const sendBtn = document.getElementById("sendBtn");
  const userInput = document.getElementById("userInput");
  const chatbox = document.getElementById("chatbox");

  if (sendBtn && userInput && chatbox) {
    // Focus input
    userInput.focus();

    // Responses Data
    // Responses Data (Localized)
    const botResponses = {
      en: {
        sad: [
          "I'm sorry to hear you're feeling down. Whatever you're going through, your feelings are valid. 💙",
          "It sounds like a tough time. Remember to be gentle with yourself today.",
          "Sending you a virtual hug. Is there something specific bothering you?",
          "Take heart, better days are coming. I'm here to listen. 🌸",
          "It's okay to not be okay. Do you want to talk about it? 🌿"
        ],
        exam: [
          "Exams can be so stressful! Remember, your grades don't define your worth. Take deep breaths. 📚",
          "It's normal to feel anxious about exams. You've done your best, and that's enough.",
          "Try to take a short break. A fresh mind studies better than a stressed one!",
          "Exams are just a part of the journey, not the whole destination. You've got this! ✨",
          "Believe in your hard work. You are more prepared than you think. 🌟"
        ],
        stress: [
          "Take a deep breath in... and out. You are handling so much, it's okay to pause.",
          "Stress is heavy. Have you tried stepping outside for fresh air for just 5 mins?",
          "One step at a time. You don't have to solve everything today.",
          "Your peace of mind is important. Take things slowly right now. 🧘♂️",
          "Remember to take breaks. You deserve a moment of calm amidst the chaos. 🌊"
        ],
        happy: [
          "That's wonderful! I love hearing that you're feeling good! 🎉",
          "Yay! Hold onto this feeling. You deserve it! ✨💛",
          "Awesome! Keep smiling! 😁🎈",
          "Your happiness is contagious! I'm so glad things are going well for you. 🌟",
          "What a lovely update! Keep shining bright today! 🌈"
        ],
        birthday: [
          "Happy Birthday! 🎂🎁",
          "Happy Birthday to someone who means so much to me. Thank you for all the joy and kindness you bring into the world. I’m wishing you a day that’s just as bright and beautiful as you are. <br><img src='images/birthday_celebration.jpg' alt='Birthday Celebration' style='width:100%; border-radius:12px; margin-top:10px;'>"
        ],
        celebrate: ["Woohoo! Time to party! 🥳💃", "Congratulations! 🥂✨", "That calls for a celebration! 🎉🎊", "So proud of you! Well deserved! 🌟👏"],
        lonely: ["You are never truly alone. I'm here! 🤖💙", "Sending love your way. 💌", "Reach out to a friend? 🗣️✨", "Remember that you are valued and cared for. 🌸"],
        angry: ["It's okay to be mad. 😠 Let it out safely.", "Deep breaths. Don't let anger steal your peace. 🧘♂️🔥", "Feelings of anger are natural. Take a moment to cool down. ❄️", "Try to channel that energy into something positive when you're ready. ⚡"],
        anxious: ["I know it's scary. But you are safe. 🛡️💙", "Focus on right now. 🕰️✨", "Ground yourself. 🌳 Try the 5-4-3-2-1 technique.", "Breathe slowly with me. You can handle this. 🌬️"],
        tired: ["Rest is productive too. 😴", "Your body needs a recharge. 🔋💤", "Take a nap. 🛌🌙", "Don't push yourself too hard. High quality rest helps you bounce back. 🌿"],
        love: ["Love is beautiful! ❤️🥰", "Sending love right back! 💖✨", "Heart full of joy! 💓🌸", "May your heart always be filled with warmth and love. 💞"],
        crush: ["Ooh, a crush! That's so exciting! 🦋 Do they know?", "Having a crush can be so thrilling and a little nerve-wracking! Take your time. 😉", "That's sweet! It's nice to have special feelings for someone. 💖"],
        default: ["I hear you. Tell me more. 👂✨", "I'm listening. 🤖💙", "Here for you always. 🌟🤗", "That sounds interesting, tell me more about it.", "I value what you're sharing. Please continue. 📝"]
      },
      si: {
        sad: [
          "ඔබට දුකෙන් ඉන්න එක ගැන මට කණගාටුයි. ඔබේ හැඟීම් වලංගුයි. 💙",
          "මෙය දුෂ්කර කාලයක් විය හැකියි. අද ඔබට මෘදු වන්න. 🌿",
          "මම ඔබ සමඟ ඉන්නවා. ඔබට කරදර කරන යමක් තිබේද? 🌸",
          "හොඳ දවස් ඉදිරියට එනවා. මම ඔබට සවන් දීමට මෙහි සිටිමි.",
          "හැමදාම එක වගේ නැහැ. හිත හයිය කරගන්න. 🌈"
        ],
        exam: [
          "විභාග පීඩනය සාමාන්ය දෙයක්! ඔබේ වටිනාකම තීරණය වන්නේ ලකුණු වලින් නොවෙයි. 📚",
          "විභාග ගැන බියක් දැනීම සාමාන්යයි. ඔබ උපරිමයෙන් කළා.",
          "කෙටි විවේකයක් ගන්න. නැවුම් මනසක් වඩාත් හොඳින් වැඩ කරයි!",
          "ඔබට මෙය කළ හැකියි! ඔබ ගැන විශ්වාස කරන්න. ✨",
          "උත්සාහය අත්හරින්න එපා. ඔබ හොඳින් සූදානම්. 🌟"
        ],
        stress: [
          "ගැඹුරු හුස්මක් ගන්න. ඔබ ගොඩක් දේ දරාගෙන ඉන්නවා, පොඩ්ඩක් නවතින්න. 🧘♂️",
          "පීඩනය වැඩියි වගේ නම් ටිකක් එළිමහනට යන්න. 🌊",
          "එක පියවරක් බැගින් යන්න. අදම සියල්ල විසඳීමට අවශ්ය නැහැ.",
          "ඔබේ මනස සන්සුන්ව තබා ගන්න. සියල්ල යහපත් වේවි.",
          "වෙලාවක් අරගෙන හුස්ම ගන්න. ඔබ ආරක්ෂිතයි. 🌬️"
        ],
        happy: [
          "ඒක නියමයි! ඔබට හොඳින් දැනෙන එක ගැන මම සතුටුයි! 🎉",
          "නියමයි! මේ සතුට දිගටම තබා ගන්න. ✨💛",
          "සුපිරි! දිගටම හිනා වෙන්න! 😁🎈",
          "ඔබේ සතුට ගැන ඇසීමෙන් මමත් සතුටු වෙනවා! 🌟",
          "අද දවස ඔබට ඉතාමත් ලස්සන වේවි! 🌈"
        ],
        birthday: [
          "සුබ උපන්දිනයක්! 🎂🎁",
          "උපන්දින සුභ පැතුම්, මට බොහොම සමීප කෙනෙක් වෙනුවෙන්. ලෝකයට ඔබ ගෙනෙන සතුට හා කරුණාව වෙනුවෙන් ඔබට ස්තූතියි. ඔබ තරම්ම දීප්තිමත් හා ලස්සන දවසක් ඔබට හිමිවේවා කියා ප්රාර්ථනා කරනවා. <br><img src='images/birthday_celebration.jpg' alt='Birthday Celebration' style='width:100%; border-radius:12px; margin-top:10px;'>"
        ],
        celebrate: ["සතුටු වෙන්න වෙලාව! 🥳💃", "සුබ පැතුම්! 🥂✨", "ඇත්තටම සතුටුයි ඔබ ගැන! 👏"],
        lonely: ["ඔබ තනිවම නැහැ. මම මෙහි සිටිමි! 🤖💙", "ඔබට ආදරය එවමි. 💌", "යහළුවෙකුට කතා කරන්න? 🗣️"],
        angry: ["තරහ යන එක සාමාන්යයි. 😠 මෘදු වන්න.", "හුස්මක් ගන්න. තරහට ඔබේ සාමය නැති කිරීමට ඉඩ නොදෙන්න. 🧘♂️🔥", "ටිකක් සන්සුන් වෙමුද? ❄️"],
        anxious: ["බිය වෙන්න එපා. ඔබ ආරක්ෂිතයි. 🛡️💙", "මේ මොහොත ගැන සිතන්න. 🕰️✨", "ගැඹුරු හුස්ම 3ක් ගන්න. 🌬️"],
        tired: ["විවේකයත් හොඳයි. 😴 නිදාගන්න.", "ඔබේ ශරීරයට විවේකය අවශ්යයි. 🔋💤", "මහන්සියි නම් විවේක ගන්න. 🌿"],
        love: ["ආදරය සුන්දරයි! ❤️🥰", "ඔබටත් ආදරය එවමි! 💖✨", "හුඟක් සතුටුයි ඔබ ගැන! 💓"],
        crush: ["ආහ්! කැමැත්තක් නේද? ඒක හරිම සුන්දර හැඟීමක්! 🦋", "කෙනෙකුට ආකර්ෂණය වීම ගොඩක් මිහිරි දෙයක්. 😉", "ඒක ලස්සනයි! ආදරණීය හැඟීම් ඔබේ හිත සතුටින් තියාවි. 💖"],
        default: ["මට ඇහෙනවා. තවත් කියන්න. 👂✨", "මම අහගෙන ඉන්නවා. 🤖💙", "සෑම විටම ඔබ සමඟයි. 🌟🤗"]
      },
      ta: {
        sad: [
          "நீங்கள் வருத்தமாக இருப்பதை கேட்டு நான் வருந்துகிறேன். உங்கள் உணர்வுகள் மதிக்கப்பட வேண்டியவை. 💙",
          "இது ஒரு கடினமான காலம். இன்று உங்களை மென்மையாக கவனித்துக் கொள்ளுங்கள். 🌿",
          "நான் உங்களுடன் இருக்கிறேன். உங்களை தொந்தரவு செய்யும் ஏதேனும் இருக்கிறதா? 🌸",
          "வருந்தாதீர்கள், எல்லாம் சரியாகும். நான் கேட்கிறேன்.",
          "இதயத்தை திடமாக்குங்கள், நல்ல மாற்றங்கள் வரும். 🌈"
        ],
        exam: [
          "பரீட்சைகள் அதிக மன அழுத்தத்தைத் தரும்! உங்கள் மதிப்பெண்கள் உங்கள் மதிப்பைத் தீர்மானிக்காது. 📚",
          "தேர்வு பற்றிய பதட்டம் சாதாரணமானது. நீங்கள் உங்களால் முடிந்ததைச் செய்துள்ளீர்கள்.",
          "சிறிது ஓய்வு எடுங்கள். புத்துணர்ச்சியான மனம் சிறப்பாகச் செயல்படும்!",
          "உங்களால் முடியும்! உங்களை நம்புங்கள். ✨",
          "கவலைப்படாதீர்கள், நீங்கள் நன்றாகவே தயாராகி இருக்கிறீர்கள். 🌟"
        ],
        stress: [
          "ஆழ்ந்த மூச்சு விடுங்கள். நீங்கள் பல விஷயங்களைக் கையாளுகிறீர்கள், சிறிது ஓய்வு எடுங்கள். 🧘♂️",
          "மன அழுத்தம் அதிகமாக இருந்தால் சிறிது நேரம் வெளியே சென்று வாருங்கள். 🌊",
          "ஒவ்வொரு படியாக முன்னகருங்கள். இன்று அனைத்தையும் தீர்க்க வேண்டியதில்லை.",
          "மனதை நிதானமாக வைத்திருங்கள். எல்லாம் சுமுகமாக முடியும்.",
          "மூச்சை நிதானமாக இழுத்து விடுங்கள். நீங்கள் பாதுகாப்பாக உணர்வீர்கள். 🌬️"
        ],
        happy: [
          "அது அற்புதம்! நீங்கள் மகிழ்ச்சியாக இருப்பதை கேட்டு நான் மகிழ்கிறேன்! 🎉",
          "மிக்க மகிழ்ச்சி! இந்த உணர்வைத் தக்க வைத்துக் கொள்ளுங்கள். ✨💛",
          "அற்புதம்! தொடர்ந்து புன்னகைக்கவும்! 😁🎈",
          "உங்கள் மகிழ்ச்சி எனக்கு உற்சாகம் அளிக்கிறது! 🌟",
          "இன்று உங்களுக்கு ஒரு சிறந்த நாளாக அமையட்டும்! 🌈"
        ],
        birthday: [
          "பிறந்தநாள் வாழ்த்துக்கள்! 🎂🎁",
          "எனக்கு மிகவும் நெருக்கமான ஒருவருக்கு இனிய பிறந்தநாள் வாழ்த்துக்கள். இந்த உலகிற்கு நீங்கள் கொண்டு வரும் மகிழ்ச்சிக்கும் அன்புக்கும் நன்றி. நீங்கள் எவ்வளவு பிரகாசமாகவும் அழகாகவும் இருக்கிறீர்களோ, அதே போன்ற ஒரு நாளாக உங்கள் பிறந்தநாள் அமைய வாழ்த்துகிறேன். <br><img src='images/birthday_celebration.jpg' alt='Birthday Celebration' style='width:100%; border-radius:12px; margin-top:10px;'>"
        ],
        celebrate: ["கொண்டாட வேண்டிய நேரம்! 🥳💃", "வாழ்த்துக்கள்! 🥂✨", "உங்களை நினைத்து பெருமை கொள்கிறேன்! 👏"],
        lonely: ["நீங்கள் ஒருபோதும் தனியாக இல்லை. நான் இருக்கிறேன்! 🤖💙", "அன்பை அனுப்புகிறேன். 💌", "நண்பரிடம் பேசலாமா? 🗣️"],
        angry: ["கோபப்படுவது சாதாரணமானது. 😠 அமைதியாக இருக்க முயற்சி செய்யுங்கள்.", "ஆழ்ந்த மூச்சு விடுங்கள். கோபம் உங்கள் அமைதியைப் பறிக்க விடாதீர்கள். 🧘♂️🔥", "சிறிது அமைதி காப்போம். ❄️"],
        anxious: ["பயப்படாதீர்கள். நீங்கள் பாதுகாப்பாக இருக்கிறீர்கள். 🛡️💙", "இந்த தருணத்தில் கவனம் செலுத்துங்கள். 🕰️✨", "ஆழ்ந்து சுவாசியுங்கள். எல்லாம் சரியாகும். 🌬️"],
        tired: ["ஓய்வு மிகவும் அவசியம். 😴 சிறிது தூங்குங்கள்.", "உங்கள் உடல் ஓய்வை எதிர்பார்க்கிறது. 🔋💤", "களைப்பாக இருந்தால் ஓய்வெடுங்கள். 🌿"],
        love: ["காதல் அழகானது! ❤️🥰", "மீண்டும் அன்பை அனுப்புகிறேன்! 💖✨", "உங்கள் இதயம் மகிழ்ச்சியால் நிறையட்டும்! 💓"],
        crush: ["ஓ! ஒரு ஈர்ப்பு! இது மிகவும் இனிமையான உணர்வு! 🦋", "ஒருவரை பிடிப்பது மிகவும் அழகானது. 😉", "இது மிகவும் இனிமையானது! உங்கள் மனதை மகிழ்ச்சியாக வைத்திருக்கும். 💖"],
        default: ["நான் கேட்கிறேன். மேலதிகமாகச் சொல்லுங்கள். 👂✨", "நான் கவனித்துக் கொண்டிருக்கிறேன். 🤖💙", "எப்போதும் உங்களுடன். 🌟🤗"]
      }
    };


    function getBotResponse(input) {
      const lowerInput = input.trim().toLowerCase();
      const currentLang = localStorage.getItem("language") || "en";
      const responses = botResponses[currentLang] || botResponses.en;

      // Helper to return random response
      const random = (arr) => arr[Math.floor(Math.random() * arr.length)];

      // Mood Scoring Data
      const keywordConfig = {
        sad: {
          words: ["sad", "cry", "bad", "unhappy", "down", "depressed", "දුකයි", "කණගාටුයි", "නරක", "කනගාටුයි", "කவலை", "வருத்தம்", "சோகம்"],
          mood: "Sad",
          weight: 1
        },
        happy: {
          words: ["happy", "good", "great", "yay", "wonderful", "joy", "සතුටුයි", "හොඳයි", "නියමයි", "මகிழ்ச்சි", "சந்தோசம்", "நல்ல"],
          mood: "Happy",
          weight: 1
        },
        stress: {
          words: ["stress", "busy", "pressure", "overwhelmed", "පීඩනය", "කාර්යබහුල", "මහන්සියි", "மன அழுத்தம்", "வேலை"],
          mood: "Stressed",
          weight: 1
        },
        exam: {
          words: ["exam", "test", "study", "results", "විභාග", "පාඩම්", "පරීක්ෂණ", "பரீட்சை", "தேர்வு"],
          mood: "Anxious",
          weight: 1.5
        },
        angry: {
          words: ["angry", "mad", "hate", "annoyed", "තරහයි", "කේන්ති", "තරහ", "கோபம்", "வெறுப்பு"],
          mood: "Angry",
          weight: 1.2
        },
        tired: {
          words: ["tired", "sleepy", "exhausted", "මහන්සියි", "නිදිමතයි", "களைப்பு", "தூக்கம்"],
          mood: "Tired",
          weight: 1
        },
        love: {
          words: ["love", "in love", "ආදරේ", "සෙනෙහස", "காதல்", "அன்பு"],
          mood: "Love",
          weight: 1.2
        },
        crush: {
          words: ["crush", "crush on girl", "crush on boy", "crush on a girl", "crush on a boy", "කැමතියි", "ආකර්ෂණය", "ஈர்ப்பு", "பிடிக்கும்"],
          mood: "Excited",
          weight: 1.3
        },
        lonely: {
          words: ["lonely", "alone", "no one", "තනිවම", "පාළුයි", "තනියම", "தனிமை"],
          mood: "Lonely",
          weight: 1.3
        },
        anxious: {
          words: ["anxious", "scared", "worried", "fear", "බයයි", "භයයි", "කලබල", "පෑනික්", "பயம்", "கவலை"],
          mood: "Anxious",
          weight: 1.3
        },
        birthday: {
          words: ["birthday", "birthady", "bday", "බර්ත්ඩේ", "උපන්දින", "பிறந்தநாள்", "பிறந்த நாள்"],
          mood: "Happy",
          weight: 5 // High priority for birthdays
        },
        celebrate: {
          words: ["celebrate", "party", "win", "සමරනවා", "ජය", "கொண்டாடு", "வெற்றி"],
          mood: "Excited",
          weight: 1.5
        }
      };

      let scores = {
        sad: 0, happy: 0, stress: 0, exam: 0, angry: 0,
        tired: 0, love: 0, crush: 0, lonely: 0, anxious: 0, birthday: 0, celebrate: 0
      };

      // Calculate Scores
      Object.keys(keywordConfig).forEach(category => {
        const config = keywordConfig[category];
        config.words.forEach(word => {
          if (lowerInput.includes(word)) {
            scores[category] += config.weight;
          }
        });
      });

      // Enhanced negation logic to handle nuances like "not very happy"
      const negations = ["not", "no", "hardly", "නැහැ", "නෑ", "இல்லை"];
      negations.forEach(neg => {
        // Create regex to match negation word followed by 0-3 words and then target word
        const happyRegex = new RegExp(`${neg}\\s+(?:\\w+\\s+){0,3}happy`, "i");
        const sadRegex = new RegExp(`${neg}\\s+(?:\\w+\\s+){0,3}sad`, "i");
        
        if (happyRegex.test(lowerInput) || lowerInput.includes(neg + " හොඳයි")) scores.happy -= 3;
        if (sadRegex.test(lowerInput) || lowerInput.includes(neg + " දුකයි")) scores.sad -= 3;
      });

      // Find best category
      let bestCategory = 'default';
      let maxScore = 0;

      Object.keys(scores).forEach(cat => {
        if (scores[cat] > maxScore) {
          maxScore = scores[cat];
          bestCategory = cat;
        }
      });

      let finalMood = "Neutral";
      let botReply = "";

      if (bestCategory === 'default') {
        botReply = random(responses.default);
      } else {
        finalMood = keywordConfig[bestCategory].mood;
        if (bestCategory === 'birthday') {
          const bdResponses = responses.birthday;
          botReply = bdResponses[bdResponses.length - 1]; // Return the special long message
        } else {
          botReply = random(responses[bestCategory]);
        }
      }

      // Save the detected mood alongside both User and Bot conversation texts
      const conversationNote = `User: ${input}\nBot: ${botReply}`;
      saveMoodToHistory(finalMood, conversationNote);

      return botReply;
    }


    function addMessage(text, sender) {
      const div = document.createElement("div");
      div.classList.add("message", sender === "user" ? "user-message" : "bot-message");
      const bubble = document.createElement("div");
      bubble.classList.add("msg-bubble");
      
      // Render bot responses with HTML capability (for images/formatting), sanitize user text
      if (sender === "bot") {
        bubble.innerHTML = text;
      } else {
        bubble.textContent = text;
      }
      
      const time = document.createElement("span");
      time.classList.add("msg-time");
      time.textContent = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
      
      div.appendChild(bubble);
      div.appendChild(time);
      chatbox.appendChild(div);
      chatbox.scrollTop = chatbox.scrollHeight;
    }

    function handleSend() {
      const text = userInput.value.trim();
      if (!text) return;
      addMessage(text, "user");
      userInput.value = "";
      userInput.focus();
      setTimeout(() => {
        const reply = getBotResponse(text);
        addMessage(reply, "bot");
      }, 1000);
    }

    sendBtn.addEventListener("click", handleSend);
    userInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter") handleSend();
    });

    // Refresh Logic
    const refreshBtn = document.getElementById("refreshChat");
    if (refreshBtn) {
      refreshBtn.addEventListener("click", () => {
        const currentLang = localStorage.getItem("language") || "en";
        chatbox.innerHTML = `
                <div class="message bot-message">
                    <div class="msg-bubble">
                        <p data-key="chatIntro">${translations[currentLang].chatIntro}</p>
                    </div>
                    <span class="msg-time">Just now</span>
                </div>
            `;
        // Re-apply placeholders if needed
        if (userInput && translations[currentLang].chatPlaceholder) {
          userInput.placeholder = translations[currentLang].chatPlaceholder;
        }
      });
    }
  }

  // --- HISTORY PAGE LOGIC ---
  const historyTableBody = document.getElementById("historyTableBody");
  const historyTableWrapper = document.getElementById("historyTableWrapper");
  const historyLoading = document.getElementById("historyLoading");
  const historyEmptyState = document.getElementById("historyEmptyState");

  if (historyTableBody) {
    const loadHistory = () => {
      const startDate = document.getElementById("historyStartDate").value;
      const endDate = document.getElementById("historyEndDate").value;

      // Show loading, hide data/empty
      if (historyLoading) historyLoading.style.display = "flex";
      if (historyTableWrapper) historyTableWrapper.style.display = "none";
      if (historyEmptyState) historyEmptyState.style.display = "none";

      let params = new URLSearchParams();
      if (startDate) params.append('startDate', startDate);
      if (endDate) params.append('endDate', endDate);

      const url = `fetch_history.php${params.toString() ? '?' + params.toString() : ''}`;

      fetch(url)
        .then(response => response.json())
        .then(data => {
          // Hide loading
          if (historyLoading) historyLoading.style.display = "none";

          historyTableBody.innerHTML = "";
          const currentLang = localStorage.getItem("language") || "en";

          if (data.status === 'error') {
            console.error("Error fetching history:", data.message);
            const msg = translations[currentLang].pleaseLogin || "Please login to view history.";
            historyTableBody.innerHTML = `<tr><td colspan="5" style="text-align:center; opacity:0.6;">${msg}</td></tr>`;
            if (historyTableWrapper) historyTableWrapper.style.display = "block";
            return;
          }

          if (!data || data.length === 0) {
            if (historyEmptyState) {
              historyEmptyState.style.display = "block";
            } else {
              const msg = translations[currentLang].noHistory || "No mood data found.";
              historyTableBody.innerHTML = `<tr><td colspan="5" style="text-align:center; opacity:0.6;">${msg}</td></tr>`;
              if (historyTableWrapper) historyTableWrapper.style.display = "block";
            }
            return;
          }

          // Show table
          if (historyTableWrapper) historyTableWrapper.style.display = "block";

          data.forEach(entry => {
            const row = document.createElement("tr");
            // Mood Badge Logic
            let badgeClass = "calm";
            const m = entry.mood;
            if (["Happy", "Love", "Excited"].includes(m)) badgeClass = "happy";
            else if (["Sad", "Lonely", "Depressed", "Down"].includes(m)) badgeClass = "sad";
            else if (["Angry", "Stressed", "Anxious", "Pressure"].includes(m)) badgeClass = "stressed";

            row.innerHTML = `
                      <td>${entry.date}</td>
                      <td>${entry.time}</td>
                      <td><span class="badgemood ${badgeClass}">${entry.mood}</span></td>
                      <td><div class="note-cell">${entry.note}</div></td>
                      <td>
                        <button class="delete-btn" onclick="deleteMood(${entry.timestamp})" title="Delete entry">
                          <span class="material-symbols-outlined">delete</span>
                        </button>
                      </td>
                  `;
            historyTableBody.appendChild(row);
          });
        })
        .catch(error => {
          console.error("Error fetching history:", error);
          if (historyLoading) historyLoading.style.display = "none";
        });
    };

    // Make deleteMood accessible globally
    window.deleteMood = function (timestamp) {
      if (!confirm("Are you sure you want to delete this entry?")) return;

      fetch('delete_history.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ timestamp: timestamp })
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            loadHistory(); // Refresh table
          } else {
            console.error("Error deleting mood:", data.message);
            alert("Failed to delete mood: " + data.message);
          }
        })
        .catch(error => console.error("Fetch Error:", error));
    };

    // Initial Load
    loadHistory();

    // Filter Buttons
    const filterBtn = document.getElementById("historyFilterBtn");
    if (filterBtn) filterBtn.addEventListener("click", loadHistory);

    const clearBtn = document.getElementById("historyClearBtn");
    if (clearBtn) {
      clearBtn.addEventListener("click", () => {
        document.getElementById("historyStartDate").value = "";
        document.getElementById("historyEndDate").value = "";
        loadHistory();
      });
    }
  }

  /* --- WEEKLY REPORT GENERATION LOGIC --- */
  const genBtn = document.getElementById('generateReportBtn');
  if (genBtn) {
    genBtn.addEventListener('click', () => {
      genBtn.disabled = true;
      const reportContent = document.getElementById('reportContent');
      const emptyState = document.getElementById('emptyReportState');
      
      if(reportContent) reportContent.style.display = 'block';
      if(emptyState) emptyState.style.display = 'none';

      fetch('fetch_weekly_report.php')
        .then(res => res.json())
        .then(data => {
           if (data.status === 'success') {
             if(document.getElementById('dominantMood')) document.getElementById('dominantMood').innerText = data.data.dominantMood;
             if(document.getElementById('totalEntries')) document.getElementById('totalEntries').innerText = data.data.totalEntries;
             if(document.getElementById('currentStreak')) document.getElementById('currentStreak').innerText = data.data.streak + " Days";
             if(document.getElementById('aiAnalysisText')) document.getElementById('aiAnalysisText').innerText = data.data.aiText;
             
             // Chart generation logic
             const chartBars = document.getElementById('chartBars');
             if(chartBars && data.data.chartData) {
               chartBars.innerHTML = '';
               data.data.chartData.forEach(item => {
                 chartBars.innerHTML += `
                   <div style="display:flex; flex-direction:column; align-items:center; gap:5px;">
                     <div style="height: 150px; display:flex; align-items:flex-end; background-color:#eee; width:40px; border-radius:5px; overflow:hidden;">
                       <div style="width: 100%; height: ${item.percentage}%; background-color: ${item.color}; border-radius:5px 5px 0 0; transition: height 0.5s ease-out;"></div>
                     </div>
                     <span style="font-size:0.8rem; font-weight:bold; color:#555;">${item.mood}</span>
                     <span style="font-size:0.75rem; color:#888;">${item.count}</span>
                   </div>
                 `;
               });
             }
           } else {
               alert("Error generating report: " + data.message);
               if(data.redirect) window.location.href = data.redirect;
           }
        })
        .finally(() => { genBtn.disabled = false; });
    });
  }

  /* 6. WHY US INTERACTIVE SECTION */
  const whyUsItems = document.querySelectorAll('.why-us-list li');
  const whyUsMainImg = document.querySelector('.img-main');

  if (whyUsItems.length > 0 && whyUsMainImg) {
    whyUsItems.forEach(item => {
      item.addEventListener('mouseenter', () => {
        // Remove active class from all
        whyUsItems.forEach(i => i.classList.remove('active-item'));
        // Add to current
        item.classList.add('active-item');

        // Update Image
        const newImg = item.getAttribute('data-img');
        if (newImg) {
          whyUsMainImg.style.opacity = '0.6';
          setTimeout(() => {
            whyUsMainImg.src = newImg;
            whyUsMainImg.style.opacity = '1';
          }, 250);
        }
      });
    });
  }

  const howItWorksSection = document.getElementById("howItWorksSection");
  if (howItWorksSection) {
    const steps = [
      { icon: "mood", titleKey: "step1Title", descKey: "step1Desc" },
      { icon: "spa", titleKey: "step2Title", descKey: "step2Desc" },
      { icon: "timeline", titleKey: "step3Title", descKey: "step3Desc" },
      { icon: "self_improvement", titleKey: "step4Title", descKey: "step4Desc" }
    ];

    let html = `<h2 class="section-title" data-key="howItWorksTitle">How It Works</h2>`;
    html += `<div class="how-it-works-grid">`;

    steps.forEach((step, index) => {
      html += `
        <div class="flip-card">
          <div class="flip-card-inner">
            <!-- Front Side -->
            <div class="flip-card-front">
               <div class="step-number">${index + 1}</div>
               <div class="step-icon">
                  <span class="material-symbols-outlined" style="font-size: 3rem;">${step.icon}</span>
               </div>
               <h3 class="step-title" data-key="${step.titleKey}">...</h3>
            </div>
            <!-- Back Side -->
            <div class="flip-card-back">
               <p class="step-desc" data-key="${step.descKey}">...</p>
            </div>
          </div>
        </div>
      `;
    });

    html += `</div>`;
    howItWorksSection.innerHTML = html;

    // Apply translations now that elements exist
    const currentLang = localStorage.getItem("language") || "en";
    applyLanguage(currentLang);
  }

  /* 8. GENTLE NOTE ANIMATION */
  const gentleSection = document.getElementById("gentleNoteSection");
  if (gentleSection) {
    const noteContainer = gentleSection.querySelector(".note-container");
    if (noteContainer) {
      noteContainer.classList.add("reveal-on-scroll");

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add("reveal-active");
            observer.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.2
      });

      observer.observe(noteContainer);
    }
  }

});

/* --- LANGUAGE FUNCTIONS --- */
function setLanguage(lang) {
  localStorage.setItem("language", lang);
  applyLanguage(lang);
  updateDropdownText(lang);
}

/* --- GENTLE UI FEATURES LOGIC --- */
document.addEventListener("DOMContentLoaded", () => {
  const gentleData = {
    dailyMessages: [
      "Peace comes from within. Do not seek it without.",
      "It’s okay to feel whatever you’re feeling right now. You’re safe here.",
      "🌞 Today is a new day. Take a deep breath and be kind to yourself.",
      "🌿 You are growing, even when you can't feel it.",
      "💧 Drink some water and stretch your body gently.",
      "🌟 Your feelings are valid, and you matter."
    ]
  };

  // Scroll Animation for Self-Care Items
  const observerOptions = {
    threshold: 0.1
  };

  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  document.querySelectorAll('.self-care-item').forEach(item => {
    observer.observe(item);
  });

  // 1. Daily Inspiration Text
  const dailyInspoContainer = document.getElementById("dailyInspirationText");
  if (dailyInspoContainer) {
    const msg = gentleData.dailyMessages[Math.floor(Math.random() * gentleData.dailyMessages.length)];
    dailyInspoContainer.textContent = msg;
  }
});

// --- END GENTLE NOTE ANIMATION ---

// --- GLOBAL MOOD SAVING LOGIC ---

function showToast(message) {
  const toast = document.createElement("div");
  toast.className = "gentle-toast";
  toast.textContent = message;
  toast.style.cssText = `
    position: fixed;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    background: #4caf50;
    color: white;
    padding: 1rem 2rem;
    border-radius: 50px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    z-index: 2000;
    animation: fadeIn 0.5s ease;
  `;
  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), 3000);
}

function applyLanguage(lang) {
  if (!translations[lang]) return;

  // 1. Text Content
  document.querySelectorAll("[data-key]").forEach((el) => {
    const key = el.getAttribute("data-key");
    if (translations[lang][key]) {
      el.textContent = translations[lang][key];
    }
  });

  // 2. Placeholders
  document.querySelectorAll("[data-placeholder-key]").forEach((el) => {
    const key = el.getAttribute("data-placeholder-key");
    if (translations[lang][key]) {
      el.placeholder = translations[lang][key];
    }
  });

  // 3. Specific Placeholders (e.g. Chat Input)
  const chatInput = document.getElementById("userInput");
  if (chatInput && translations[lang].chatPlaceholder) {
    chatInput.placeholder = translations[lang].chatPlaceholder;
  }

  // 4. Body Class
  document.body.className = `lang-${lang}`;
}

function updateDropdownText(lang) {
  const textMap = {
    'en': 'English',
    'si': 'සිංහල',
    'ta': 'தமிழ்'
  };
  const currentLangText = document.getElementById("currentLangText");
  if (currentLangText && textMap[lang]) {
    currentLangText.textContent = textMap[lang];
  }
}

// Breathing Animation Logic
document.addEventListener("DOMContentLoaded", () => {
  const breathingText = document.getElementById('breathingText');
  if (breathingText) {
    let isBreathIn = true;
    setInterval(() => {
      const currentLang = localStorage.getItem('language') || 'en';
      isBreathIn = !isBreathIn;
      // Depending on expanding phase
      if (isBreathIn) {
        if (translations[currentLang] && translations[currentLang].breathIn) {
          breathingText.textContent = translations[currentLang].breathIn;
        }
      } else {
        if (translations[currentLang] && translations[currentLang].breathOut) {
          breathingText.textContent = translations[currentLang].breathOut;
        }
      }
    }, 4000);
  }

  /* GLOBAL SCROLL REVEAL POP-UP ANIMATION (STRICT CONTENT ONLY) */
  const revealElements = document.querySelectorAll(".scroll-animate, .card, .bg-card, .mood-container, .advice-card, .stat-card, .flip-card, .hero-content h1, .hero-content p, .hero-buttons, .form-container, .support-list li");

  if (revealElements.length > 0) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("active");
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.15,
      rootMargin: "0px 0px -30px 0px"
    });

    revealElements.forEach((el) => {
      el.classList.add("reveal-section");
      
      const rect = el.getBoundingClientRect();
      // If it's at the very top of the page (already visible), pop it up instantly
      if (rect.top < window.innerHeight && rect.bottom >= 0) {
        el.classList.add("active");
      } else {
        // Otherwise wait for the user to scroll down to it
        observer.observe(el);
      }
    });
  }

  /* FOOTER DYNAMIC YEAR */
  const yearSpan = document.getElementById("currentYear");
  if (yearSpan) {
    yearSpan.textContent = new Date().getFullYear();
  }
});
