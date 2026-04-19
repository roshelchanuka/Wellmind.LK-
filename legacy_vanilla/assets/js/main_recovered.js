// main.js - WellMind Application Logic (RECOVERED VERSION 1.5)

console.log("main.js loaded! (v1.21 - UI Refinement)");

/* --- SHARED UTILITY FUNCTIONS --- */

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
         // Mood saved successfully
      } else {
        console.error("Database Save Error:", data.message);
      }
    })
    .catch(error => {
      console.error("Fetch Error:", error);
    });
}

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

/* --- THE FULL TRANSLATIONS OBJECT (RECOVERED) --- */

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

    // How It Works Section
    howItWorksTitle: "How It Works",
    step1Title: "Select your mood 😊",
    step1Desc: "Take a moment to check in with yourself and choose the mood that best matches how you’re feeling right now.",
    step2Title: "Get wellness suggestions 🌱",
    step2Desc: "After you share your mood, the system gently offers helpful tips to support you.",
    step3Title: "Track emotional changes 📊",
    step3Desc: "Your mood entries are safely saved so you can look back anytime.",
    step4Title: "Improve your mental health habits 💙",
    step4Desc: "By using the platform regularly, you can slowly build healthy habits.",

    // Gentle Note
    noteTitle: "💙 A Gentle Note for You 🌿",
    noteText1: "This platform is created to support your emotional well-being and help you take small, positive steps toward feeling better 🌈",
    noteText2: "Please remember that it is not a replacement for professional mental health care.",
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
    momentText2: "Life can feel busy and overwhelming sometimes, but even a small moment of awareness can bring calm and clarity.",
    momentText3: "Move at your own pace, explore freely, and remember that every feeling you experience is valid 🤍✨",

    // 2. Daily Reflection
    reflectionTitle: "🌼 Daily Reflection 🌿",
    reflectionText1: "Take a quiet moment to reflect on your day 🌤️",
    reflectionText2: "What made you smile? What felt heavy? What are you grateful for right now?",
    reflectionText3: "Reflection is not about judging yourself — it’s about understanding your feelings with kindness and patience 🤍",
    reflectionText4: "Every small thought you notice is a step toward greater peace and self-awareness 🌸✨",

    // Breathing Animation
    breathTitle: "🌬️ Breathing Exercise 🌿",
    breathIn: "Inhale",
    breathOut: "Exhale",
    breathDesc: "Follow the circle. Breathe in as it expands, exhale as it shrinks."
  },
  si: {
    home: "මුල් පිටුව",
    addMood: "හැඟීම එක් කරන්න",
    history: "ඉතිහාසය",
    weekly: "සතිපතා වාර්තාව",
    support: "සහය",
    profile: "පැතිකඩ",
    login: "ඇතුල් වන්න",
    homeTitle: "මානසික සෞඛ්‍යය ඔබෙන් ආරම්භ වේ",
    homeText: "WellMind.LK ඔබේ සතුට සහ සෞඛ්‍ය සම්පන්න මනසක් සඳහා මඟ පෙන්වයි සහ සහාය වේ. අදම ඔබේ හැඟීම් සම්පන්න බවට පළමු පියවර ගන්න!",
    motivationTitle: "දවසේ ධනාත්මක සිතුවිලි",
    greeting_night: "සුබ රාත්‍රියක්",

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
    chatIntro: "ආයුබෝවන්! මම ඔබට සවන් දීමට මෙහි සිටිමි. ඔබට අද කෙසේ දැනෙනවාද?",
    chatPlaceholder: "ඔබේ හැඟීම් මෙහි ලියන්න...",

    // History Page
    historyTitle: "මනෝභාවය ඉතිහාසය",
    historyHeroTitle: "ඔබේ හැඟීම් ගමන",
    historyHeroText: "යහපත් අනාගතයක් සඳහා ඔබේ අතීතය මෙනෙහි කරන්න.",

    // Report Page
    weeklyReportTitle: "සතිපතා හැඟීම් විශ්ලේෂණය",
    reportHeroTitle: "සතිපතා සුවතාවය පිළිබඳ අවබෝධය",
    reportHeroText: "සෑම සතියකම ඔබේ මනෝභාවයන් සහ සුවතාවය පිළිබඳ වාර්තාව බලන්න.",

    // Add Mood Page
    addMoodHeroTitle: "ඔබේ හැඟීම් බෙදාගන්න",
    addMoodHeroText: "ඔබේ හැඟීම් වඩාත් හොඳින් තේරුම් ගැනීමට විවෘතව සහ අවංකව ඒවා ප්‍රකාශ කරන්න.",

    // Advice Section
    wellnessTips: "සතිපතා සුවතාවය පිළිබඳ උපදෙස් 🌿",
    adviceMindfulness: "සිහියෙන් පසුවීම",
    adviceMindfulnessText: "අද විනාඩි 5ක් භාවනා කරන්න. ඔබේ හුස්ම ගැන අවධානය යොමු කරන්න.",
    adviceHydration: "ජලය පානය කිරීම",
    adviceHydrationText: "සිරුරට ශක්තිය දීමට දිනකට ජලය වීදුරු 8ක් වත් පානය කරන්න.",
    adviceMovement: "චලනය",
    adviceMovementText: "ඔබේ මනෝභාවය ක්ෂණිකව වැඩිදියුණු කිරීමට අද ටික වේලාවක් ඇවිදින්න.",

    // Why Us Section
    whyUsTitle: "මෙම වේදිකාව භාවිතා කරන්නේ ඇයි?",
    benefit1Title: "හැඟීම් රටා හඳුනා ගැනීමට උපකාරී වේ",
    benefit1Desc: "කාලයත් සමඟ ඔබේ හැඟීම් වෙනස් වන ආකාරය තේරුම් ගන්න.",
    benefit2Title: "ස්වයං දැනුවත්භාවය දිරිමත් කරයි",
    benefit2Desc: "ඔබේ මානසික තත්ත්වය පිළිබඳව වඩාත් අවධානයෙන් සිටින්න.",
    benefit3Title: "සුවතා සහාය ලබා දෙයි",
    benefit3Desc: "වඩා හොඳ සෞඛ්‍යයක් සඳහා උපදෙස් ලබා ගන්න.",
    benefit4Title: "භාවිතා කිරීමට පහසු සහ ආරක්ෂිතයි",
    benefit4Desc: "අපගේ ප්‍රමුඛතාවය ඔබගේ පෞද්ගලිකත්වය ආරක්ෂා කිරීමයි.",
    benefit5Title: "දෛනික භාවිතය සඳහා වඩාත් සුදුසුය",
    benefit5Desc: "දෛනික පුරුද්දක් ලෙස ඔබේ මානසික සුවය පරීක්ෂා කරන්න.",

    // How It Works Section
    howItWorksTitle: "එය ක්‍රියා කරන්නේ කෙසේද?",
    step1Title: "ඔබේ මනෝභාවය තෝරන්න 😊",
    step1Desc: "ඔබට දැනෙන මනෝභාවය තෝරා ඔබ ගැනම දැනුවත් වන්න.",
    step2Title: "සුවතා යෝජනා ලබා ගන්න 🌱",
    step2Desc: "මනෝභාවය බෙදා ගත් පසු පද්ධතිය මඟින් උපකාරී උපදෙස් ලබා දෙයි.",
    step3Title: "හැඟීම් වෙනස්වීම් නිරීක්ෂණය කරන්න 📊",
    step3Desc: "ඔබේ හැඟීම් වෙනස් වන රටා ඕනෑම වේලාවක සොයා බලන්න.",
    step4Title: "මානසික සෞඛ්‍ය පුරුදු වැඩිදියුණු කරන්න 💙",
    step4Desc: "නිතිපතා භාවිතා කිරීමෙන් නිරෝගී මානසික මට්ටමක් පවත්වා ගන්න.",

    // Gentle Note
    noteTitle: "💙 ඔබ වෙනුවෙන් කුඩා සටහනක් 🌿",
    noteText1: "මෙම වේදිකාව නිර්මාණය කර ඇත්තේ ඔබගේ මානසික සුවතාවය සඳහා සහාය වීමටයි 🌈",
    noteText2: "මෙය වෘත්තීය මානසික සෞඛ්‍ය සේවාවක් සඳහා ආදේශකයක් නොවන බව කරුණාවෙන් සලකන්න.",
    noteText3: "සහය සෙවීම ධනාත්මක තීරණයකි 🌸✨",

    // Small Acts of Self-Care
    selfCareTitle: "සුවතාවය සඳහා කුඩා පියවර 🌿",
    selfCare1: "ජලය වීදුරුවක් පානය කරන්න",
    selfCare2: "ඔබේ ශරීරය සෙමින් දිග හරින්න",
    selfCare3: "ගැඹුරු හුස්ම 3ක් ගන්න",
    selfCare4: "සන්සුන් සංගීතයකට සවන් දෙන්න",

    // 1. A Moment Just for You
    momentTitle: "🌿 ඔබ වෙනුවෙන්ම වෙන්වූ මොහොතක් 💙",
    momentText1: "මෙය ඔබට නැවතී, හුස්ම ගෙන, ඔබ ගැනම අවධානය යොමු කිරීමට ඇති ඉඩකි 🌸",
    momentText2: "ජීවිතය කාර්යබහුල විය හැක, නමුත් මේ කුඩා පියවර ඔබට සහනයක් ගෙන දෙයි.",
    momentText3: "ඔබේ වේගය අනුව ඉදිරියට යන්න 🤍✨",

    // 2. Daily Reflection
    reflectionTitle: "🌼 දෛනික මෙනෙහි කිරීම 🌿",
    reflectionText1: "ඔබේ දවස ගැන සන්සුන්ව සිතන්න 🌤️",
    reflectionText2: "අද ඔබව සිනහ ගැන්වූයේ කුමක්ද? ඔබට ස්තූතිවන්ත විය හැකි දේ කුමක්ද?",
    reflectionText3: "මෙනෙහි කිරීම යනු ඔබව විනිශ්චය කිරීම නොව, ඔබව තේරුම් ගැනීමයි 🤍",
    reflectionText4: "සෑම කුඩා සිතුවිල්ලක්ම මනසේ සාමය සඳහා පියවරකි 🌸✨",

    // Breathing Animation
    breathTitle: "🌬️ ශ්වසන අභ්‍යාසය 🌿",
    breathIn: "හුස්ම ගන්න",
    breathOut: "පිට කරන්න",
    breathDesc: "වෘත්තය දෙස බලන්න. එය ප්‍රසාරණය වන විට හුස්ම ගන්න, හැකිලෙන විට හුස්ම පිට කරන්න."
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
    homeText: "WellMind.LK உங்களை மனநலச் சுகமான மற்றும் மகிழ்ச்சியான பயணத்தில் வழிநடத்த සහ ஆதரிக்க உள்ளது. இன்று உங்கள் உணர்ச்சி நலத்திற்கு முதல் පடியை எடுக்குங்கள்!",
    motivationTitle: "தினசரி நேர்மறை சிந்தனைகள்",
    greeting_night: "இனிய இரவு",

    // Daily Inspiration (Long Text)
    dailyInspoTitle: "தினசரி ஊக்கவுரை",
    dailyInspoText: "அமைதி உன் உள்ளத்திலிருந்து வருகிறது. அதை வெளியே தேட வேண்டாம். இந்த தருணம் மெதுவாகி உன் மூச்சுக்கு திரும்பச் சொல்லும் மென்மையான நினைவூட்டல். சத்தம், கவலை, அழுத்தம் எதுவும் தொட்டிடாத அமைதியான இடம் உன் உள்ளத்தில் இருக்கிறது. சில நேரம் அங்கே ஓய்வெடு. வெப்பமான ஒளி போல அமைதி உன் உடலின் இறுக்கமான பகுதிகளை மென்மையாக்க அனுமதி கொடு. 🌸\n\nநீ இப்போது உணரும் எந்த உணர்வும் சரியே. உன்னிடம் எந்த தவறும் இல்லை. உணர்வுகள் அலை போல உயர்ந்து இறங்கும் — நீ அவற்றில் பாதுகாப்பாக மிதக்கிறாய். உன் உணர்வுகளை விளக்க வேண்டிய அவசியமில்லை. இன்று எல்லாவற்றையும் சரிசெய்ய வேண்டியதுமில்லை. இங்கே இரு. மூச்சை இழு.\n\nநீ இங்கே பாதுகாப்பாக இருக்கிறாய். மென்மையும் ஏற்றுக்கொள்ளுதலும் நிறைந்த இடத்தில் நீ இருக்கிறாய். அமைதியான நீரில் மணல் அமரும் போல உன் எண்ணங்கள் அமைதியாகட்டும். விட முடிந்ததை விடு. உன்னை வளர்க்கும் விஷயங்களை வைத்துக்கொள். ஓய்வெடுக்கவும், உணரவும், தீர்ப்பின்றி இருப்பதற்கும் உனக்கு அனுமதி கொடு. 🌿\n\nஒரு கணம் கண்களை மூடு. அமைதியை உள்ளிழு. அழுத்தத்தை வெளியே விடு. இப்போது உன் ஒரே வேலை — உன்னை மென்மையாக கவனித்துக்கொள்வது. அதுவே போதும்.",

    // Auth Pages
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

    // Report Page
    weeklyReportTitle: "வாரาந்திர உணர்ச்சி பகுப்பாய்வு",
    reportHeroTitle: "வாராந்திர ஆரோக்கிய நுண்ணறிவு",
    reportHeroText: "உங்கள் விரிவான உணர்ச்சிப் பகுப்பாய்வை மதிப்பாய்வு செய்யவும்.",

    // Add Mood Page
    addMoodHeroTitle: "உங்கள் உணர்வுகளைப் பகிரவும்",
    addMoodHeroText: "உங்கள் உணர்ச்சிகளை நன்கு புரிந்துகொள்ள வெளிப்படையாகவும் நேர்மையாகவும் வெளிப்படுத்துங்கள்.",

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
    noteText1: "உங்கள் உணர்ச்சி நල්வாழ்வை ஆதரிக்கவும், நீங்கள் நன்றாக உணர சிறிய, நேர்மறையான நடவடிக்கைகளை எடுக்கவும் இந்த தளம் உருவாக்கப்பட்டுள்ளது 🌈",
    noteText2: "இது தொழில்முறை மனநல சிகிச்சைக்கு மாற்றாக இல்லை என்பதை நினைவில் கொள்க.",
    noteText3: "நீங்கள் தனியாக இல்லை, உதவி தேடுவது ஒரு தைரியமான தேர்வு 🌸✨",

    // Small Acts of Self-Care
    selfCareTitle: "சுய பாதுகாப்பின் சிறிய செயல்கள் 🌿",
    selfCare1: "ஒரு டம்ளர் தண்ணீர் குடிக்கவும்",
    selfCare2: "உங்கள் உடலை மெதுவாக நீட்டவும்",
    selfCare3: "3 முறை மெதுவாக, ஆழமாக மூச்சு விடுங்கள்",
    selfCare4: "அமைதியான இசையைக் கேளுங்கள்",

    // 1. A Moment Just for You
    momentTitle: "🌿 உங்களுக்கான ஒரு அமைதியான தருணம் 💙",
    momentText1: "இந்த இடம் நீங்கள் ஓய்ந்து, சுவாசித்து, උමාව යළිත් දැනගන්නට නිර්මාණය වූ එකකි 🌸",
    momentText2: "வாழ்க்கை சில நேரங்களில் பரபரப்பாகவும் சிரமமாகவும் தோன்றலாம், ஆனால் ஒரு சிறிய நிமிட கவனம் கூட அமைதியையும் தெளிவையும் தர முடியும் 🌈",
    momentText3: "உங்கள் வேகத்தில் முன்னேறுங்கள். ඔබ අත්විඳින හැම හැඟීමක්ම වැදගත්ය 🌿",

    // Breathing Animation
    breathTitle: "🌬️ சுவாசப் பயிற்சி 🌿",
    breathIn: "மூச்சை இழு",
    breathOut: "மூச்சை விடு",
    breathDesc: "வட்டத்தைப் பின்தொடரவும். அது விரிவடையும் போது மூச்சை இழுக்கவும், சுருங்கும் போது மூச்சை விடவும்."
  }
};

/* --- NAVBAR LOGIC --- */

const navMenu = document.getElementById('nav-menu'),
  navToggle = document.getElementById('nav-toggle'),
  navClose = document.getElementById('nav-close');

if (navToggle) {
  navToggle.addEventListener('click', () => {
    navMenu.classList.add('show-menu');
  });
}

if (navClose) {
  navClose.addEventListener('click', () => {
    navMenu.classList.remove('show-menu');
  });
}

const navLink = document.querySelectorAll('.nav__list a');
const linkAction = () => {
  const navMenu = document.getElementById('nav-menu');
  navMenu.classList.remove('show-menu');
}
navLink.forEach(n => n.addEventListener('click', linkAction));

/* --- DYNAMIC THEME & SCROLL LOGIC --- */

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

/* --- CHATBOT DIALOGUE SYSTEM (RECOVERED) --- */

const botResponses = {
  en: {
    sad: ["I'm sorry to hear you're feeling down. 💙", "It sounds like a tough time. Be gentle with yourself today.", "Sending you a virtual hug. Is there something specific bothering you?"],
    happy: ["That's wonderful! 🎉", "Yay! Hold onto this feeling. You deserve it! ✨", "Awesome! Keep smiling! 😁🎈"],
    stress: ["Take a deep breath. You are handling so much.", "Stress is heavy. Have you tried stepping outside for 5 mins?", "One step at a time. You don't have to solve everything today."],
    exam: ["Exams can be so stressful! Remember, your grades don't define your worth. 📚", "It's normal to feel anxious about exams. You've done your best."],
    default: ["I hear you. Tell me more. 👂✨", "I'm listening. 🤖💙", "Here for you always. 🌟🤗"]
  },
  si: {
    sad: ["ඔබට දුකෙන් ඉන්න එක ගැන මට කණගාටුයි. 💙", "මෙය දුෂ්කර කාලයක් විය හැකියි. අද ඔබට මෘදු වන්න. 🌿", "මම ඔබ සමඟ ඉන්නවා. ඔබට කරදර කරන යමක් තිබේද? 🌸"],
    happy: ["ඒක නියමයි! ඔබට හොඳින් දැනෙන එක ගැන මම සතුටුයි! 🎉", "නියමයි! මේ සතුට දිගටම තබා ගන්න. ✨💛", "සුපිරි! දිගටම හිනා වෙන්න! 😁🎈"],
    stress: ["ගැඹුරු හුස්මක් ගන්න. ඔබ ගොඩක් දේ දරාගෙන ඉන්නවා. 🧘‍♂️", "පීඩනය වැඩියි වගේ නම් ටිකක් එළිමහනට යන්න. 🌊", "එක පියවරක් බැගින් යන්න. අදම සියල්ල විසඳීමට අවශ්‍ය නැහැ."],
    exam: ["විභාග පීඩනය සාමාන්‍ය දෙයක්! 📚", "විභාග ගැන බියක් දැනීම සාමාන්‍යයි. ඔබ උපරිමයෙන් කළා."],
    default: ["මට ඇහෙනවා. තවත් කියන්න. 👂✨", "මම අහගෙන ඉන්නවා. 🤖💙", "සෑම විටම ඔබ සමඟයි. 🌟🤗"]
  },
  ta: {
    sad: ["நீங்கள் வருத்தமாக இருப்பதை கேட்டு நான் வருந்துகிறேன். 💙", "இது ஒரு கடினமான காலம். இன்று உங்களை மென்மையாக கவனித்துக் கொள்ளுங்கள். 🌿"],
    happy: ["அது அற்புதம்! நீங்கள் மகிழ்ச்சியாக இருப்பதை கேட்டு நான் மகிழ்கிறேன்! 🎉", "மிக்க மகிழ்ச்சி! இந்த உணர்வைத் தக்க வைத்துக் கொள்ளுங்கள். ✨💛"],
    stress: ["ஆழ்ந்த மூச்சு விடுங்கள். 🧘‍♂️", "மன அழுத்தம் அதிகமாக இருந்தால் சிறிது நேரம் வெளியே சென்று வாருங்கள். 🌊"],
    exam: ["பரீட்சைகள் அதிக மன அழுத்தத்தைத் தரும்! 📚", "தேர்வு பற்றிய பதட்டம் சாதாரணமானது. நீங்கள் உங்களால் முடிந்ததைச் செய்துள்ளீர்கள்."],
    default: ["நான் கேட்கிறேன். மேலதிகமாகச் சொல்லுங்கள். 👂✨", "நான் கவனித்துக் கொண்டிருக்கிறேன். 🤖💙"]
  }
};

/* --- INITIALIZATION & EVENT LISTENERS --- */

document.addEventListener("DOMContentLoaded", () => {
  const currentLang = localStorage.getItem("language") || "en";
  applyLanguage(currentLang);
  updateDropdownText(currentLang);

  // Dropdown Options
  document.querySelectorAll(".lang-option").forEach(btn => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const lang = btn.getAttribute("data-lang");
      setLanguage(lang);
    });
  });

  /* AI CHAT LOGIC */
  const sendBtn = document.getElementById("sendBtn");
  const userInput = document.getElementById("userInput");
  const chatbox = document.getElementById("chatbox");

  if (sendBtn && userInput && chatbox) {
    function getBotResponse(input) {
      const lowerInput = input.trim().toLowerCase();
      const lang = localStorage.getItem("language") || "en";
      const responses = botResponses[lang] || botResponses.en;
      
      const random = (arr) => arr[Math.floor(Math.random() * arr.length)];

      if (lowerInput.includes("sad") || lowerInput.includes("දුකයි") || lowerInput.includes("சோகம்")) return random(responses.sad);
      if (lowerInput.includes("happy") || lowerInput.includes("සතුටුයි") || lowerInput.includes("சந்தோசம்")) return random(responses.happy);
      if (lowerInput.includes("stress") || lowerInput.includes("පීඩනය") || lowerInput.includes("மன அழுத்தம்")) return random(responses.stress);
      if (lowerInput.includes("exam") || lowerInput.includes("විභාග") || lowerInput.includes("பரீட்சை")) return random(responses.exam);
      
      return random(responses.default);
    }

    function addMessage(text, sender) {
      const div = document.createElement("div");
      div.classList.add("message", sender === "user" ? "user-message" : "bot-message");
      const bubble = document.createElement("div");
      bubble.classList.add("msg-bubble");
      bubble.textContent = text;
      div.appendChild(bubble);
      chatbox.appendChild(div);
      chatbox.scrollTop = chatbox.scrollHeight;
    }

    sendBtn.addEventListener("click", () => {
      const text = userInput.value.trim();
      if (!text) return;
      addMessage(text, "user");
      userInput.value = "";
      setTimeout(() => addMessage(getBotResponse(text), "bot"), 1000);
    });
  }

  /* WEEKLY REPORT GENERATION (LATEST VERSION) */
  const genBtn = document.getElementById('generateReportBtn');
  if (genBtn) {
    genBtn.addEventListener('click', () => {
      genBtn.disabled = true;
      fetch('fetch_weekly_report.php')
        .then(res => res.json())
        .then(data => {
           if (data.status === 'success') {
             if(document.getElementById('dominantMood')) document.getElementById('dominantMood').innerText = data.data.dominantMood;
             if(document.getElementById('totalEntries')) document.getElementById('totalEntries').innerText = data.data.totalEntries;
             if(document.getElementById('aiAnalysisText')) document.getElementById('aiAnalysisText').innerText = data.data.aiText;
           }
        })
        .finally(() => { genBtn.disabled = false; });
    });
  }
});

function setLanguage(lang) {
  localStorage.setItem("language", lang);
  applyLanguage(lang);
  updateDropdownText(lang);
  window.location.reload(); // To refresh dynamic translations
}

function applyLanguage(lang) {
  const data = translations[lang] || translations.en;
  document.querySelectorAll("[data-key]").forEach(el => {
    const key = el.getAttribute("data-key");
    if (data[key]) el.textContent = data[key];
  });
  document.body.className = `lang-${lang}`;
}

function updateDropdownText(lang) {
  const textMap = { 'en': 'English', 'si': 'සිංහල', 'ta': 'தமிழ்' };
  const btn = document.getElementById('languageDropdown');
  if (btn) btn.textContent = textMap[lang] || 'English';
}
