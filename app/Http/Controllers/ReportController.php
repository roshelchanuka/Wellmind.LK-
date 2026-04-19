<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MoodEntry;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function getReport(Request $request)
    {
        $userId = Auth::id();
        $sevenDaysAgo = Carbon::now()->subDays(7)->startOfDay();
        $todayEnd = Carbon::now()->endOfDay();

        $entries = MoodEntry::where('user_id', $userId)
            ->whereBetween('created_at', [$sevenDaysAgo, $todayEnd])
            ->orderBy('created_at', 'asc')
            ->get();

        $moodCounts = [];
        $totalEntries = 0;
        $loggedDates = [];

        foreach ($entries as $entry) {
            $mood = $entry->mood;
            $date = $entry->created_at->format('Y-m-d');

            $moodCounts[$mood] = ($moodCounts[$mood] ?? 0) + 1;
            $totalEntries++;

            if (!in_array($date, $loggedDates)) {
                $loggedDates[] = $date;
            }
        }

        // 1. Dominant Mood
        $dominantMood = '-';
        $maxCount = 0;
        foreach ($moodCounts as $m => $c) {
            if ($c > $maxCount) {
                $maxCount = $c;
                $dominantMood = $m;
            }
        }

        // 2. Streak
        $streak = 0;
        $currentDate = Carbon::now();
        $checkDate = $currentDate->format('Y-m-d');
        
        if (!in_array($checkDate, $loggedDates)) {
            $checkDate = $currentDate->subDay()->format('Y-m-d');
        }

        if (in_array($checkDate, $loggedDates)) {
            $dateObj = Carbon::parse($checkDate);
            while (in_array($dateObj->format('Y-m-d'), $loggedDates)) {
                $streak++;
                $dateObj->subDay();
            }
        }

        // 3. Chart Data
        $chartData = [];
        foreach ($moodCounts as $mood => $count) {
            $color = '#2ECC71';
            $mLower = strtolower($mood);
            if (str_contains($mLower, 'sad') || str_contains($mLower, 'cry')) $color = '#3498DB';
            elseif (str_contains($mLower, 'angry') || str_contains($mLower, 'mad')) $color = '#E74C3C';
            elseif (str_contains($mLower, 'stress') || str_contains($mLower, 'anxious')) $color = '#E67E22';
            elseif (str_contains($mLower, 'happy') || str_contains($mLower, 'excited')) $color = '#F1C40F';
            elseif (str_contains($mLower, 'calm') || str_contains($mLower, 'relax')) $color = '#9B59B6';

            $chartData[] = [
                'mood' => ucfirst($mood),
                'count' => $count,
                'percentage' => $totalEntries > 0 ? round(($count / $totalEntries) * 100) : 0,
                'color' => $color
            ];
        }

        usort($chartData, fn($a, $b) => $b['count'] <=> $a['count']);

        // 4. AI Text
        $aiText = "You haven't logged any moods in the past 7 days. Start logging to uncover your emotional patterns!";
        if ($totalEntries > 0) {
            if ($streak >= 3) {
                $aiText = "Amazing consistency! Tracking your mood regularly helps build robust emotional self-awareness. Your dominant mood lately is '$dominantMood'.";
            } else {
                $aiText = "Based on your logs this week, your most frequent emotional state is '$dominantMood'. Remember, every feeling is valid. Try tracking more consistently to see clearer patterns.";
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'dominantMood' => $dominantMood,
                'totalEntries' => $totalEntries,
                'streak' => $streak,
                'chartData' => $chartData,
                'aiText' => $aiText
            ]
        ]);
    }
}
