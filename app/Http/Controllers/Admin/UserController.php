<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SystemUsage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        $user->status = ($user->status === 'active' ? 'inactive' : 'active');
        $user->save();

        return back()->with('success', "User account has been {$user->status}d.");
    }

    public function logs(User $user)
    {
        $logs = SystemUsage::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(50);
            
        return view('admin.users.logs', compact('user', 'logs'));
    }
}
