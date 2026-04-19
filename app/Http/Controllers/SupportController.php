<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SupportMessage;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index()
    {
        $feedbacks = SupportMessage::orderBy('created_at', 'desc')->get();
        return view('support.index', compact('feedbacks'));
    }

    public function saveFeedback(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'feedback_text' => 'required|string',
            'rating' => 'nullable|integer|min:0|max:5',
        ]);

        $feedback = SupportMessage::create([
            'user_name' => $request->input('user_name'),
            'feedback_text' => $request->input('feedback_text'),
            'rating' => $request->input('rating', 0),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => 'success', 'id' => $feedback->id]);
        }

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }
}
