<x-app-layout>
    <div class="container mx-auto p-6">

        <!-- Section Mes Followings / Followers -->
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <!-- Mes followers -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Mes followers ({{ $followers->count() }})</h2>
                @forelse($followers as $follower)
                    <div class="flex items-center justify-between p-3 border-b hover:bg-gray-50 rounded">
                        <span>{{ $follower->name }}</span>
                    </div>
                @empty
                    <div class="text-gray-500">Aucun follower pour le moment.</div>
                @endforelse
            </div>

            <!-- Mes followings -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Je follow ({{ $followings->count() }})</h2>
                @forelse($followings as $followed)
                    <div class="flex items-center justify-between p-3 border-b hover:bg-gray-50 rounded">
                        <span>{{ $followed->name }}</span>
                    </div>
                @empty
                    <div class="text-gray-500">Vous ne suivez personne.</div>
                @endforelse
            </div>
        </div>

        <!-- Liste de tous les utilisateurs -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Les suggestions d'amis</h2>
            <div class="grid gap-4">
                @foreach($users as $user)
                    <div class="flex items-center justify-between p-4 border-b rounded hover:bg-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">{{ $user->name }}</h3>
                            </div>
                        </div>

                        <!-- Follow / Unfollow -->
                        @if(auth()->id() !== $user->id)
                            <div>
                                @if(auth()->user()->isFollowing($user))
                                    <form action="{{ route('unfollow', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                            Unfollow
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('follow', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                            Follow
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
