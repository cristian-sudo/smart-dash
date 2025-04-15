<div class="max-w-2xl mx-auto">
    <form wire:submit="submit" class="space-y-6">
        @if($showSuccess)
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative transform transition-all duration-300 ease-in-out" role="alert">
                <span class="block sm:inline">Thank you for your message! We will get back to you soon.</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative transform transition-all duration-300 ease-in-out" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="space-y-6 bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">

            <div class="grid grid-cols-1 gap-8">
                <div class="space-y-2">
                    <label for="name" class="block text-base font-medium text-gray-700 dark:text-gray-300">Name</label>
                    <input type="text" wire:model="name" id="name" required 
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-base p-4 transition duration-150 ease-in-out">
                    @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label for="email" class="block text-base font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" wire:model="email" id="email" required 
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-base p-4 transition duration-150 ease-in-out">
                    @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label for="message" class="block text-base font-medium text-gray-700 dark:text-gray-300">Message</label>
                    <textarea wire:model="message" id="message" rows="6" required 
                              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-base p-4 transition duration-150 ease-in-out"></textarea>
                    @error('message') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" 
                        class="w-full flex justify-center py-4 px-6 inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-green-600 bg-white hover:bg-green-50 transition-all duration-300 hover:scale-105">
                        Send Message
                </button>
            </div>
        </div>
    </form>
</div> 