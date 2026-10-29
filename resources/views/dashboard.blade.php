<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(strtolower(Auth::user()->role) === 'administrator' || strtolower(Auth::user()->role) === 'admin')
                <!-- ADMINISTRATOR VIEW -->
                
                <!-- Campus Weather Dashboard Card -->
                <div class="bg-indigo-900 text-white overflow-hidden shadow-lg sm:rounded-xl p-6 relative">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-2">
                        <div class="flex items-center space-x-2 text-xs font-semibold tracking-wider uppercase text-indigo-200">
                            <span>☀️</span>
                            <span>CAMPUS WEATHER DASHBOARD</span>
                        </div>

                        <form action="{{ route('dashboard') }}" method="GET" class="flex items-center space-x-2">
                            <input type="text" name="city" placeholder="Type city name..." value="{{ $weather['city'] ?? 'Arakan' }}" class="px-3 py-1 text-xs rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            <button type="submit" class="bg-indigo-700 hover:bg-indigo-600 text-white text-xs px-3 py-1 rounded-lg font-medium shadow transition">
                                Change
                            </button>
                        </form>
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <h2 class="text-3xl font-bold">{{ $weather['city'] ?? 'Arakan' }}</h2>
                            <p class="text-indigo-200 text-sm mt-1">{{ $weather['description'] ?? 'Light rain' }}</p>
                        </div>
                        <div class="text-4xl md:text-5xl font-extrabold my-2 md:my-0">
                            {{ $weather['temp'] ?? '30.9' }}{{ isset($weather['temp']) && $weather['temp'] !== 'N/A' ? '°C' : '' }}
                        </div>
                        <div class="text-right text-sm text-indigo-200 space-y-1">
                            <div>💧 Humidity: {{ $weather['humidity'] ?? '70' }}{{ isset($weather['humidity']) && $weather['humidity'] !== 'N/A' ? '%' : '' }}</div>
                            <div>Wind Speed: {{ $weather['wind_speed'] ?? '1.63' }}{{ isset($weather['wind_speed']) && $weather['wind_speed'] !== 'N/A' ? ' m/s' : '' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Admin Welcome Banner -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Welcome, {{ Auth::user()->name }}!</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Logged in as <span class="font-semibold text-indigo-600">Administrator</span>. Here is an overview of your system modules.
                        </p>
                    </div>
                </div>

                <!-- Admin Action Cards (2 Columns for balanced layout since User Management is in the top navbar) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Report Lost Item Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 flex flex-col justify-between border-l-4 border-indigo-500">
                        <div>
                            <div class="flex items-center mb-3">
                                <span class="text-2xl mr-3 bg-indigo-50 p-2 rounded-lg">🔍</span>
                                <h4 class="text-lg font-bold text-gray-800">Report Lost Item</h4>
                            </div>
                            <p class="text-sm text-gray-600 mb-6">Submit a new report for any lost items inside the campus.</p>
                        </div>
                        <div>
                            <a href="{{ route('items.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow transition inline-block">
                                Submit Report
                            </a>
                        </div>
                    </div>

                    <!-- Items Catalog Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 flex flex-col justify-between border-l-4 border-gray-800">
                        <div>
                            <div class="flex items-center mb-3">
                                <span class="text-2xl mr-3 bg-gray-100 p-2 rounded-lg">📦</span>
                                <h4 class="text-lg font-bold text-gray-800">Items Catalog & Verification</h4>
                            </div>
                            <p class="text-sm text-gray-600 mb-6">View and update item statuses (Pending / Found / Claimed).</p>
                        </div>
                        <div>
                            <a href="{{ route('items.index') }}" class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow transition inline-block">
                                Browse Catalog
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Admin Bottom Status Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-5 border-l-4 border-blue-500 flex items-center space-x-4">
                        <div class="bg-blue-50 p-3 rounded-lg text-blue-600 text-xl">📱</div>
                        <div>
                            <div class="text-xs font-semibold text-gray-400 tracking-wider uppercase">User Module</div>
                            <div class="text-base font-bold text-gray-800 mt-0.5">RBAC Enabled</div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-5 border-l-4 border-green-500 flex items-center space-x-4">
                        <div class="bg-green-50 p-3 rounded-lg text-green-600 text-xl">🛡️</div>
                        <div>
                            <div class="text-xs font-semibold text-gray-400 tracking-wider uppercase">Active Staff</div>
                            <div class="text-base font-bold text-gray-800 mt-0.5">Security Office On-Duty</div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-5 border-l-4 border-yellow-500 flex items-center space-x-4">
                        <div class="bg-yellow-50 p-3 rounded-lg text-yellow-600 text-xl">📦</div>
                        <div>
                            <div class="text-xs font-semibold text-gray-400 tracking-wider uppercase">Tracking System</div>
                            <div class="text-base font-bold text-gray-800 mt-1">Lost & Found Records Active</div>
                        </div>
                    </div>
                </div>

            @else
                <!-- STUDENT / REGULAR USER VIEW -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 flex items-center">
                    <div class="bg-blue-100 p-4 rounded-full mr-4 text-3xl">
                        👋
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Welcome, {{ Auth::user()->name }}!</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Logged in as <span class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span> ({{ Auth::user()->role ?? 'Student' }}). Welcome to the Lost & Found Portal.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center mb-3">
                                <span class="text-xl mr-2">🔍</span>
                                <h4 class="text-lg font-bold text-gray-800">Report Lost Item</h4>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Submit a report if you lost something inside the campus.</p>
                        </div>
                        <div>
                            <a href="{{ route('items.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow transition inline-block">
                                Submit Report
                            </a>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center mb-3">
                                <span class="text-xl mr-2">📦</span>
                                <h4 class="text-lg font-bold text-gray-800">Found Items Catalog</h4>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Browse reported items currently held at the security office.</p>
                        </div>
                        <div>
                            <a href="{{ route('items.index') }}" class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow transition inline-block">
                                Browse Items
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>