<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\NewFollowerNotification;

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
             $user->notify(new NewFollowerNotification($me));
        }
        return redirect()->back();
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
        return redirect()->back();;
    }
}


