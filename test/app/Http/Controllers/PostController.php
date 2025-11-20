<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Récupère les posts de l’utilisateur et de ses followings pour les afficher dans le fil d’actualité.
     */
    public function index()
    {
        $user = auth()->user();
        $followingIds = $user->followings()->pluck('users.id')->toArray();
        $followingIds[] = $user->id;
        $posts = Post::with('user')
                     ->whereIn('user_id', $followingIds)
                     ->latest()
                     ->get();

        return view('posts.index', compact('posts'));
    }

    /**
     * Permet de créer un nouveau post avec texte et image et revient à la page précédente
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'image_path' => $path,
        ]);

        return back()->with('success', 'Post créé !');
    }
}

