@extends('layouts.app')

@section('title', 'Weekly Report - WellMind LK')

@section('content')
    <!-- Banner Section -->
    <div class="banner-container">
        <img src="{{ asset('images/report.jpg') }}" class="banner-img" alt="Weekly Report Banner">
        <div class="bg-card-overlay"></div>
        <div class="bg-card-content">
            <h1 class="bg-card-title" data-key="reportHeroTitle">Weekly Wellness Insight</h1>
            <p class="bg-card-text" data-key="reportHeroText">Review your detailed emotional analysis, discover trends, and get personalized advice to improve your mental well-being every single week.</p>
        </div>
    </div>

    <main class="main-content" style="padding-top: 40px; padding-bottom: 60px;">
        <div class="container" style="max-width: 1000px; margin: 0 auto; text-align: center;">
            <button id="generateReportBtn" class="btn-primary" style="padding: 15px 40px; font-size: 1.2rem; border-radius: 40px; margin-bottom: 40px; background: #2A5421; color: white; border: none; cursor: pointer; transition: transform 0.3s; box-shadow: 0 10px 20px rgba(0,0,0,0.15);">
                Generate Weekly Report 📊
            </button>

            <!-- Results Section -->
            <div id="reportContent" style="display: none;">
                <div class="stats-grid" style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-bottom: 50px;">
                    <div class="stat-card" style="flex: 1; min-width: 200px; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        <p style="opacity: 0.6; margin-bottom: 10px;" data-key="statsDominant">Dominant Mood</p>
                        <h2 id="dominantMood" style="color: #2A5421; font-size: 2rem;">-</h2>
                    </div>
                    <div class="stat-card" style="flex: 1; min-width: 200px; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        <p style="opacity: 0.6; margin-bottom: 10px;" data-key="statsTotal">Total Entries</p>
                        <h2 id="totalEntries" style="color: #2A5421; font-size: 2rem;">0</h2>
                    </div>
                    <div class="stat-card" style="flex: 1; min-width: 200px; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                        <p style="opacity: 0.6; margin-bottom: 10px;" data-key="statsStreak">Current Streak</p>
                        <h2 id="currentStreak" style="color: #2A5421; font-size: 2rem;">0 Days</h2>
                    </div>
                </div>

                <div class="chart-section" style="background: white; padding: 40px; border-radius: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); margin-bottom: 50px;">
                    <h3 data-key="chartTitle" style="margin-bottom: 30px;">Mood Distribution</h3>
                    <div id="chartBars" style="display: flex; align-items: flex-end; justify-content: space-around; height: 250px; padding: 20px;">
                        <!-- Chart generated via JS -->
                    </div>
                </div>

                <div class="ai-analysis" style="background: #f1f8f1; padding: 40px; border-radius: 30px; border: 1px dashed #2A5421; text-align: left; margin-bottom: 50px;">
                    <h3 style="color: #2A5421; margin-bottom: 15px;">AI Analysis 🤖</h3>
                    <p id="aiAnalysisText" style="line-height: 1.8; font-size: 1.1rem; color: #444;">Calculating your wellness insights...</p>
                </div>
            </div>

            <!-- Youth Support Showcase -->
            <div class="container scroll-animate" style="max-width: 900px; width: 95%; margin: 60px auto 0 auto; padding: 0;">
                <div class="card mb-3" style="border-radius: 30px; border: none; background: white; box-shadow: 0 10px 40px rgba(0,0,0,0.1); overflow: hidden;">
                  <div class="row g-0" style="display: flex; flex-wrap: wrap; margin: 0; align-items: center;">
                    <div class="col-md-5" style="flex: 0 0 45%; min-width: 280px; padding: 20px; line-height: 0;">
                      <img src="{{ asset('images/selfcareiphone.png') }}" class="img-fluid" alt="Youth Support" style="width: 100%; height: auto; border-radius: 20px;">
                    </div>
                    <div class="col-md-7" style="flex: 1; min-width: 300px;">
                      <div class="card-body" style="padding: 30px; text-align: left;">
                        <h5 class="card-title" data-key="youthSupportTitle" style="font-weight: 800; color: #355e3b; font-size: 1.7rem; margin-bottom: 20px;">Feel better, live better</h5>
                        <p class="card-text" data-key="youthSupportText" style="font-size: 1.05rem; color: #444; line-height: 1.6; margin: 0;">WellMind.LK supports youth (16–25) to stay strong and manage stress through personalized tracking and thoughtful advice.</p>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
<script>
  const genBtn = document.getElementById('generateReportBtn');
  if (genBtn) {
    genBtn.addEventListener('click', () => {
      genBtn.disabled = true;
      const reportContent = document.getElementById('reportContent');
      
      fetch("{{ route('get-report') }}")
        .then(res => res.json())
        .then(data => {
           if (data.status === 'success') {
             reportContent.style.display = 'block';
             document.getElementById('dominantMood').innerText = data.data.dominantMood;
             document.getElementById('totalEntries').innerText = data.data.totalEntries;
             document.getElementById('currentStreak').innerText = data.data.streak + " Days";
             document.getElementById('aiAnalysisText').innerText = data.data.aiText;
             
             const chartBars = document.getElementById('chartBars');
             chartBars.innerHTML = '';
             data.data.chartData.forEach(item => {
               chartBars.innerHTML += `
                 <div style="display:flex; flex-direction:column; align-items:center; gap:5px;">
                   <div style="height: 180px; display:flex; align-items:flex-end; background-color:#eee; width:45px; border-radius:8px; overflow:hidden;">
                     <div style="width: 100%; height: ${item.percentage}%; background-color: ${item.color}; border-radius:8px 8px 0 0; transition: height 1s ease-out;"></div>
                   </div>
                   <span style="font-size:0.85rem; font-weight:bold; color:#555;">${item.mood}</span>
                   <span style="font-size:0.75rem; color:#888;">${item.count}</span>
                 </div>
               `;
             });
             
             // Scroll to results
             reportContent.scrollIntoView({ behavior: 'smooth' });
           }
        })
        .finally(() => { genBtn.disabled = false; });
    });
  }
</script>
@endsection
