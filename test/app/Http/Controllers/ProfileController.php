<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Affiche le profil de l'utilisateur connecté avec ses informations personnelles
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Affiche tous les autres utilisateurs et indique pour chacun s'ils sont suivis ou non par l'utilisateur connecté, en incluant ses followers et followings
     */
    public function index()
    {
        $user = Auth::user();
        $followers = $user->followers()->get();
        $followings = $user->followings()->get();
        $users = User::where('id', '!=', $user->id)->get();
        return view('user.index', compact('users', 'followers', 'followings'));
    }

    /**
     * Marquer la notification comme lue
     */

    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->where('id', $notificationId)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return back();
}




}
