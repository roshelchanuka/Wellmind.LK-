<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MoodEntry;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MoodController extends Controller
{
    public function create()
    {
        return view('mood.add');
    }

    public function store(Request $request)
    {
        // Handle JSON Input from main.js
        $mood = $request->input('mood');
        $note = $request->input('note', '');

        if (!$mood) {
            return response()->json(['status' => 'error', 'message' => 'Mood is required'], 422);
        }

        // Only save to database if user is logged in
        if (Auth::check()) {
            $entry = MoodEntry::create([
                'user_id' => Auth::id(),
                'mood' => $mood,
                'note' => $note,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Mood saved successfully',
                'id' => $entry->id
            ]);
        }

        // If guest, just return success to allow the chatbot experience
        return response()->json([
            'status' => 'success',
            'message' => 'Guest experience: Mood processed but not saved. Login to track your history!',
            'guest' => true
        ]);
    }

    public function history()
    {
        return view('mood.history');
    }

    public function getHistory(Request $request)
    {
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        $query = MoodEntry::where('user_id', Auth::id());

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $entries = $query->orderBy('created_at', 'desc')->get();

        $history = $entries->map(function ($entry) {
            return [
                'id' => $entry->id,
                'date' => $entry->created_at->format('Y-m-d'),
                'time' => $entry->created_at->format('H:i:s'),
                'mood' => $entry->mood,
                'note' => $entry->note,
                'timestamp' => $entry->created_at->timestamp
            ];
        });

        return response()->json($history);
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        
        if (!$id) {
            return response()->json(['status' => 'error', 'message' => 'Entry ID required'], 422);
        }

        $deleted = MoodEntry::where('user_id', Auth::id())
            ->where('id', $id)
            ->delete();

        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'Entry deleted']);
        }

        return response()->json(['status' => 'error', 'message' => 'Entry not found'], 404);
    }
}
