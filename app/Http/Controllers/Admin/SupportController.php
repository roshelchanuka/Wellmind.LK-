<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportMessage;

class SupportController extends Controller
{
    public function index()
    {
        $messages = SupportMessage::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.support.index', compact('messages'));
    }

    public function updateStatus(SupportMessage $message, Request $request)
    {
        $request->validate(['status' => 'required|in:open,resolved,pending']);
        $message->status = $request->status;
        $message->save();

        return back()->with('success', "Ticket status updated to {$message->status}.");
    }
}
