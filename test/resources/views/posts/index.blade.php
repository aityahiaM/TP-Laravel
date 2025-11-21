<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Fil d'actualité</h1>

        <!-- Formulaire de création de post -->
        <div class="mb-6">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2">
                @csrf
                <textarea name="content" placeholder="Écrire un post..." required
                          class="border rounded p-2 w-full"></textarea>
                <input type="file" name="image" class="border rounded p-1 w-full">
                <button type="submit"
                        class="bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700">
                    Publier
                </button>
            </form>
        </div>

        <hr class="mb-6">

        <!-- Messages de succès -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Fil d'actualité -->
        <div class="grid gap-6">
            @foreach($posts as $post)
                @php
                    $likers_count = $post->likers->count();
                    $comments_count = $post->comments->count();
                @endphp
                <div class="bg-white p-4 rounded-lg shadow" id="post-{{ $post->id }}">
                    <!-- En-tête du post -->
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <strong>{{ $post->user->name }}</strong>
                            <small class="text-gray-500 ml-2">{{ $post->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>

                    <!-- Contenu du post -->
                    <p class="mb-2">{{ $post->content }}</p>

                    <!-- Image du post -->
                    @if($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="image" class="max-w-full rounded mb-2">
                    @endif

                    <!-- Section Likes et Commentaires -->
                    <div class="flex items-center gap-6 mt-3 pt-3 border-t">
                        <!-- Bouton Like -->
                        <form action="{{ route('posts.like.toggle', $post) }}" method="POST" class="like-form">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center gap-2 px-3 py-1 rounded-full transition-all duration-200 like-btn
                                        @if($post->is_liked)
                                            bg-red-50 hover:bg-red-100
                                        @else
                                            hover:bg-gray-100
                                        @endif"
                                    data-post-id="{{ $post->id }}">
                                
                                @if($post->is_liked)
                                    <svg class="w-5 h-5 text-red-600 like-heart" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-medium text-red-600 likes-count">{{ $likers_count }}</span>
                                @else
                                    <svg class="w-5 h-5 text-gray-600 like-heart" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    <span class="text-sm text-gray-600 likes-count">{{ $likers_count }}</span>
                                @endif
                            </button>
                        </form>

                        <!-- Bouton Commentaires -->
                        <button type="button" 
                                class="flex items-center gap-2 px-3 py-1 rounded-full hover:bg-gray-100 transition comment-btn"
                                onclick="toggleComments({{ $post->id }})">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span class="text-sm text-gray-600 comments-count">{{ $comments_count }}</span>
                        </button>
                    </div>

                    <!-- Section Commentaires (cachée par défaut) -->
                    <div id="comments-section-{{ $post->id }}" class="mt-4 hidden">
                        <div class="border-t pt-4">
                            <!-- Formulaire d'ajout de commentaire -->
                            <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-4">
                                @csrf
                                <div class="flex gap-2">
                                    <input type="text" 
                                           name="content" 
                                           placeholder="Ajouter un commentaire..." 
                                           required
                                           class="flex-1 border rounded px-3 py-2 text-sm">
                                    <button type="submit" 
                                            class="bg-blue-600 text-white rounded px-4 py-2 text-sm hover:bg-blue-700">
                                        Commenter
                                    </button>
                                </div>
                            </form>

                            <!-- Liste des commentaires -->
                            <div class="space-y-3">
                                @foreach($post->comments as $comment)
                                    <div class="flex items-start gap-3">
                                        <div class="flex-1 bg-gray-50 rounded-lg p-3">
                                            <div class="flex items-center gap-2 mb-1">
                                                <strong class="text-sm">{{ $comment->user->name }}</strong>
                                                <span class="text-xs text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                            <p class="text-sm">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>
        // Fonction pour afficher/masquer les commentaires
        function toggleComments(postId) {
            const commentsSection = document.getElementById(`comments-section-${postId}`);
            commentsSection.classList.toggle('hidden');
        }

        // Gestion des likes AJAX (code existant)
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.like-form').forEach(form => {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const button = this.querySelector('.like-btn');
                    const likeCount = this.querySelector('.likes-count');
                    
                    button.disabled = true;
                    
                    try {
                        const response = await fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: new FormData(this)
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            likeCount.textContent = data.likes_count;
                            
                            if (data.is_liked) {
                                button.innerHTML = `
                                    <svg class="w-5 h-5 text-red-600 like-heart" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-medium text-red-600 likes-count">${data.likes_count}</span>
                                `;
                                button.classList.add('bg-red-50', 'hover:bg-red-100');
                                button.classList.remove('hover:bg-gray-100');
                            } else {
                                button.innerHTML = `
                                    <svg class="w-5 h-5 text-gray-600 like-heart" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    <span class="text-sm text-gray-600 likes-count">${data.likes_count}</span>
                                `;
                                button.classList.remove('bg-red-50', 'hover:bg-red-100');
                                button.classList.add('hover:bg-gray-100');
                            }
                        }
                        
                    } catch (error) {
                        console.error('Error:', error);
                    } finally {
                        button.disabled = false;
                    }
                });
            });
        });
    </script>

    <style>
        .like-btn {
            transition: all 0.2s ease-in-out;
        }
        
        .like-btn:hover:not(:disabled) {
            transform: scale(1.05);
        }
        
        .like-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .like-heart {
            transition: all 0.2s ease-in-out;
        }
    </style>
</x-app-layout>