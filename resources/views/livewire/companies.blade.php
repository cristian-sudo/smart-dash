<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notification -->
            <x-notification :message="$notificationMessage" :show="$show" />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Companies</h2>
                        <button x-on:click="$dispatch('open-modal')"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:bg-indigo-700 dark:focus:bg-indigo-600 active:bg-indigo-900 dark:active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('New Company') }}
                        </button>
                    </div>

                    <!-- Companies Table -->
                    <div class="overflow-x-auto">
                        <!-- Mobile View -->
                        <div class="md:hidden space-y-6">
                            @forelse($companies as $company)
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-200 dark:border-gray-700">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $company->name }}
                                        </div>
                                        <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                            {{ $company->email }}
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                        {{ $company->phone }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                        {{ $company->address }}, {{ $company->city }}, {{ $company->state }} {{ $company->zip }}
                                    </div>
                                    <div class="flex justify-end space-x-2">
                                        <div class="flex space-x-2 relative z-[50]">
                                            <button wire:click="edit({{ $company->id }})"
                                                    class="p-1 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400"
                                                    data-tooltip="Edit">
                                                <x-icons.edit />
                                            </button>
                                            <button wire:click="delete({{ $company->id }})"
                                                    class="p-1 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400"
                                                    data-tooltip="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this company?')">
                                                <x-icons.trash />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                                    No companies found. Click "New Company" to create one.
                                </div>
                            @endforelse
                        </div>

                        <!-- Desktop View -->
                        <div class="hidden sm:block">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Phone</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Address</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($companies as $company)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $company->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $company->email }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $company->phone }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $company->address }}, {{ $company->city }}, {{ $company->state }} {{ $company->zip }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-right space-x-2">
                                            <div class="flex items-center justify-end space-x-2">
                                                <div class="flex space-x-2 relative z-[50]">
                                                    <button wire:click="edit({{ $company->id }})"
                                                            class="p-1 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400"
                                                            data-tooltip="Edit">
                                                        <x-icons.edit />
                                                    </button>
                                                    <button wire:click="delete({{ $company->id }})"
                                                            class="p-1 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400"
                                                            data-tooltip="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this company?')">
                                                        <x-icons.trash />
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            No companies found. Click "New Company" to create one.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $companies->links() }}
                    </div>

                    <!-- New Company Modal -->
                    @if($showModal)
                        <div class="fixed inset-0 z-[200] overflow-y-auto">
                            <!-- Backdrop -->
                            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 opacity-75" wire:click="closeModal"></div>

                            <!-- Modal Panel -->
                            <div class="fixed inset-0 z-[101] pointer-events-none">
                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div class="relative bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-2xl w-full max-h-[90vh] overflow-y-auto pointer-events-auto">
                                        <div class="bg-white dark:bg-gray-800 px-6 py-6">
                                            <div class="mt-3">
                                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                                                    {{ $companyId ? 'Edit Company' : 'Add Company' }}
                                                </h3>
                                                <form wire:submit.prevent="save" class="mt-4">
                                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                                        <div>
                                                            <label for="name" class="block text-base font-medium text-gray-700 dark:text-gray-300">Company Name</label>
                                                            <input type="text" wire:model="name" id="name" class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                            @error('name') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div>
                                                            <label for="email" class="block text-base font-medium text-gray-700 dark:text-gray-300">Email</label>
                                                            <input type="email" wire:model="email" id="email" class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                            @error('email') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div>
                                                            <label for="phone" class="block text-base font-medium text-gray-700 dark:text-gray-300">Phone</label>
                                                            <input type="text" wire:model="phone" id="phone" class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                            @error('phone') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div>
                                                            <label for="website" class="block text-base font-medium text-gray-700 dark:text-gray-300">Website</label>
                                                            <input type="url" wire:model="website" id="website" class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                            @error('website') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>

                                                    <div class="mt-4">
                                                        <label for="address" class="block text-base font-medium text-gray-700 dark:text-gray-300">Address</label>
                                                        <textarea wire:model="address" id="address" rows="3" class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3"></textarea>
                                                        @error('address') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
                                                        <div>
                                                            <label for="tax_number" class="block text-base font-medium text-gray-700 dark:text-gray-300">Tax Number</label>
                                                            <input type="text" wire:model="tax_number" id="tax_number" class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                            @error('tax_number') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div>
                                                            <label for="registration_number" class="block text-base font-medium text-gray-700 dark:text-gray-300">Registration Number</label>
                                                            <input type="text" wire:model="registration_number" id="registration_number" class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                            @error('registration_number') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div>
                                                            <label for="color" class="block text-base font-medium text-gray-700 dark:text-gray-300">Company Color</label>
                                                            <div class="mt-2 flex items-center space-x-2">
                                                                <input type="color" wire:model="color" id="color"
                                                                       class="h-10 w-20 rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300">
                                                                <input type="text" wire:model="color" id="color_text"
                                                                       class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
                                                                       placeholder="#3B82F6">
                                                            </div>
                                                            @error('color') <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>

                                                    <div class="mt-4">
                                                        <label for="logo" class="block text-base font-medium text-gray-700 dark:text-gray-300">Logo</label>
                                                        <div class="mt-2 space-y-4">
                                                            @if($companyId && !($logo instanceof \Illuminate\Http\UploadedFile) && $logo)
                                                                <div class="flex items-center space-x-4">
                                                                    <div class="h-16 w-16 rounded bg-gray-50 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                                                                        <img src="{{ asset('storage/' . $logo) }}" alt="Company logo" class="h-full w-full object-cover">
                                                                    </div>
                                                                    <label class="flex items-center">
                                                                        <input type="checkbox" wire:model="removeLogo" class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                                                        <span class="ml-2 text-sm text-red-600 dark:text-red-400">Remove logo</span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                            @if($logo instanceof \Illuminate\Http\UploadedFile)
                                                                <div class="flex items-center">
                                                                    <div class="h-16 w-16 rounded bg-gray-50 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                                                                        <img src="{{ $logo->temporaryUrl() }}" alt="New logo preview" class="h-full w-full object-cover">
                                                                    </div>
                                                                    <span class="ml-4 text-sm text-gray-500 dark:text-gray-400">New logo preview</span>
                                                                </div>
                                                            @endif
                                                            <input type="file" wire:model="logo" id="logo" accept="image/*" class="block w-full text-base text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-base file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-100">
                                                            @error('logo') <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>

                                                    <div class="mt-4">
                                                        <label class="flex items-center">
                                                            <input type="checkbox" wire:model="is_default" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Set as default company</span>
                                                        </label>
                                                    </div>

                                                    <div class="mt-6 flex justify-end space-x-4 sticky bottom-0 bg-white dark:bg-gray-800 py-4">
                                                        <button type="button" 
                                                                wire:click="closeModal"
                                                                class="inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-3 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" 
                                                                class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-6 py-3 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                            {{ $companyId ? 'Update' : 'Create' }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div> 