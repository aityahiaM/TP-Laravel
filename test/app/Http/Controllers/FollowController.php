<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{

    /**
     * Ajoute l’utilisateur donné à la liste des personnes que je suis, si ce n’est pas déjà fait, puis revient à la page précédente.
     */
    public function follow(User $user)
    {
        $me = Auth::user();
        if (!$me->isFollowing($user)) {
            $me->followings()->attach($user->id);
        }
        return back()->with('success', 'Vous suivez maintenant ' . $user->name);
    }

    /**
     * Retire l’utilisateur donné de la liste des personnes que je suis, si présent, puis revient à la page précédente.
     */
    public function unfollow(User $user)
    {
        $me = Auth::user();
        if ($me->isFollowing($user)) {
            $me->followings()->detach($user->id);
        }
        return back()->with('success', 'Vous ne suivez plus ' . $user->name);
    }
}
