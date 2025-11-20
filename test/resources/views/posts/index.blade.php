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

        <!-- Fil d'actualité -->
        <div class="grid gap-6">
            @foreach($posts as $post)
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <strong>{{ $post->user->name }}</strong>
                            <small class="text-gray-500 ml-2">{{ $post->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>

                    <p class="mb-2">{{ $post->content }}</p>

                    @if($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="image" class="max-w-full rounded mb-2">
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

