<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Items Catalog & Verification</h2>
                    <a href="{{ route('items.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow transition">
                        + Report New Item
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reported By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location Lost</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($items as $item)
                                <tr>
                                    <!-- Clickable uploaded image nga mo-open sa bag-ong tab -->
                                    <td class="px-6 py-4">
                                        @if($item->image)
                                            <a href="{{ asset('storage/' . $item->image) }}" target="_blank" title="I-click para makita ang tibuok hulagway">
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="Item Image" class="w-20 h-20 object-cover rounded-lg shadow border hover:opacity-85 transition">
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Walay Image</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $item->item_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $item->user->name }} ({{ $item->user->role ?? 'Student' }})</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $item->location_lost }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs rounded-full font-bold
                                            {{ $item->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $item->status === 'Found' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $item->status === 'Claimed' ? 'bg-green-100 text-green-800' : '' }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if(Auth::user()->role === 'Administrator')
                                            <!-- ADMINISTRATOR ONLY UPDATE & DELETE -->
                                            <div class="flex items-center space-x-2">
                                                <form action="{{ route('items.updateStatus', $item->id) }}" method="POST" class="flex items-center space-x-1">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" class="text-xs rounded border-gray-300">
                                                        <option value="Pending" {{ $item->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="Found" {{ $item->status == 'Found' ? 'selected' : '' }}>Found</option>
                                                        <option value="Claimed" {{ $item->status == 'Claimed' ? 'selected' : '' }}>Claimed</option>
                                                    </select>
                                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-2 py-1 rounded shadow">
                                                        Update
                                                    </button>
                                                </form>

                                                <!-- DELETE BUTTON -->
                                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Sigurado ka ba nga i-delete kini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs px-2 py-1 rounded shadow">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <!-- STUDENT / REGULAR USER VIEW ONLY -->
                                            <span class="text-xs text-gray-400 font-medium">View Only</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Walay nakita nga gi-report nga butang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>