<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ]);

        $user->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui!'
            ]);
        }

        return redirect()->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Password saat ini tidak sesuai.',
                    'errors' => ['current_password' => ['Password saat ini tidak sesuai.']]
                ], 422);
            }
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diubah!'
            ]);
        }

        return redirect()->route('profile.index')
            ->with('success', 'Password berhasil diubah!');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
        ]);

        $user = Auth::user();

        // Delete old avatar if exists
        if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Avatar berhasil diperbarui!',
                'avatar' => asset('storage/' . $path)
            ]);
        }

        return redirect()->route('profile.index')
            ->with('success', 'Avatar berhasil diperbarui!');
    }

    public function deleteAvatar(Request $request)
    {
        $user = Auth::user();

        if ($user->avatar) {
            // Jika avatar dari Google (URL), hanya hapus dari database
            if (str_starts_with($user->avatar, 'http')) {
                $user->update(['avatar' => null]);
            } else {
                // Hapus file dan database
                Storage::disk('public')->delete($user->avatar);
                $user->update(['avatar' => null]);
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Avatar berhasil dihapus!'
            ]);
        }

        return redirect()->route('profile.index')
            ->with('success', 'Avatar berhasil dihapus!');
    }
}
