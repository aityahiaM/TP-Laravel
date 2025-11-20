<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto">

        <!-- Top Menu Dashboard -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-4xl font-bold text-gray-900">Mon Profil</h1>
            
            <div class="flex gap-2 flex-wrap items-center">

                <!-- Feed -->
                <a href="{{ route('posts.index') }}"
                   class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg hover:bg-blue-200 shadow">
                     Feed
                </a>

                <!-- Utilisateurs -->
                <a href="{{ route('users.index') }}"
                   class="px-4 py-2 bg-green-100 text-green-800 rounded-lg hover:bg-green-200 shadow">
                     Amis
                </a>

                <!-- Messagerie -->
                <a href="/chatify"
                   class="px-4 py-2 bg-purple-100 text-purple-800 rounded-lg hover:bg-purple-200 shadow">
                     Messagerie
                </a>

                <!-- Notifications -->
                <div class="relative group">
                    <button
                        class="px-4 py-2 bg-pink-100 text-pink-800 rounded-lg hover:bg-pink-200 shadow">
                        Notifications
                    </button>
                    <!-- Dropdown -->
                    <div class="absolute right-0 mt-2 w-80 bg-white border rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
                        @forelse(auth()->user()->notifications as $notification)
                            <div class="p-3 border-b hover:bg-gray-50 flex justify-between items-center">
                                <div>
                                    <p class="text-gray-800">{{ $notification->data['message'] }}</p>
                                    <small class="text-gray-500">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                @if(!$notification->read_at)
                                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="text-xs text-white bg-pink-500 hover:bg-pink-600 px-2 py-1 rounded-lg shadow">
                                            Marquer lu
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <p class="p-3 text-gray-500">Aucune notification</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

        <!-- Infos de compte -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Informations personnelles</h2>
            <p><strong>Nom :</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
        </div>

    </div>
</x-app-layout>
