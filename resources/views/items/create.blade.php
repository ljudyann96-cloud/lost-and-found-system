<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report Lost Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Item Name -->
                    <div>
                        <x-input-label for="item_name" :value="__('Item Name')" />
                        <x-text-input id="item_name" class="block mt-1 w-full" type="text" name="item_name" :value="old('item_name')" required autofocus placeholder="E.g., Wallet, Keys, ID" />
                        <x-input-error :messages="$errors->get('item_name')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" placeholder="Ihatag ang mga detalye sa nawalang butang...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Location Lost -->
                    <div>
                        <x-input-label for="location_lost" :value="__('Location Lost')" />
                        <x-text-input id="location_lost" class="block mt-1 w-full" type="text" name="location_lost" :value="old('location_lost')" required placeholder="E.g., Library, Gym, Canteen" />
                        <x-input-error :messages="$errors->get('location_lost')" class="mt-2" />
                    </div>

                    <!-- Date Lost (Bag-ong dugang) -->
                    <div>
                        <x-input-label for="date" :value="__('Date Lost')" />
                        <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" required />
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    </div>

                    <!-- Reporter Name (Bag-ong dugang) -->
                    <div>
                        <x-input-label for="reporter_name" :value="__('Name of Reporter')" />
                        <x-text-input id="reporter_name" class="block mt-1 w-full" type="text" name="reporter_name" :value="old('reporter_name', Auth::user()->name ?? '')" required placeholder="Full Name" />
                        <x-input-error :messages="$errors->get('reporter_name')" class="mt-2" />
                    </div>

                    <!-- Contact Number (Bag-ong dugang) -->
                    <div>
                        <x-input-label for="contact_number" :value="__('Contact Number')" />
                        <x-text-input id="contact_number" class="block mt-1 w-full" type="text" name="contact_number" :value="old('contact_number')" required placeholder="E.g., 09123456789" />
                        <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                    </div>

                    <!-- Upload Image (Optional) -->
                    <div>
                        <x-input-label for="image" :value="__('Upload Image (Optional)')" />
                        <input id="image" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" type="file" name="image" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('items.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Cancel
                        </a>

                        <x-primary-button>
                            {{ __('Submit Report') }}
                        </x-primary-button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>