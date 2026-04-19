<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Determine profile photo URL
        $profilePhotoUrl = "https://ui-avatars.com/api/?name=" . urlencode($user->full_name) . "&background=2A5421&color=fff&size=256";
        $targetDir = public_path('images/profiles/');
        
        foreach (['png', 'jpg', 'jpeg'] as $ext) {
            $filename = "user_" . $user->id . "." . $ext;
            if (File::exists($targetDir . $filename)) {
                $profilePhotoUrl = asset('images/profiles/' . $filename) . '?v=' . time();
                break;
            }
        }

        return view('profile.index', compact('user', 'profilePhotoUrl'));
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $file = $request->file('profile_photo');
        $ext = $file->getClientOriginalExtension();
        $targetDir = public_path('images/profiles/');

        if (!File::isDirectory($targetDir)) {
            File::makeDirectory($targetDir, 0777, true, true);
        }

        // Delete old photos
        foreach (['png', 'jpg', 'jpeg'] as $oldExt) {
            $oldFile = $targetDir . "user_" . $user->id . "." . $oldExt;
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }
        }

        $filename = "user_" . $user->id . "." . $ext;
        $file->move($targetDir, $filename);

        return redirect()->back()->with('success', 'Profile photo updated successfully!');
    }
}
