<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notification -->
            <x-notification :message="$notificationMessage" :show="$show" />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Products</h2>
                        <button wire:click="create"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            New Product
                        </button>
                    </div>

                    <!-- Products Table -->
                    <div class="mt-8">
                        <!-- Mobile Cards -->
                        <div class="md:hidden space-y-6">
                            @forelse($products as $product)
                                <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg border border-gray-200 dark:border-gray-700">
                                    <div class="p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $product->name }}
                                                </h3>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    ${{ number_format($product->price, 2) }}
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    Stock: {{ $product->stock }}
                                                </p>
                                                @if($product->sku)
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        SKU: {{ $product->sku }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                <button wire:click="edit({{ $product->id }})"
                                                        class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                                                        data-tooltip="Edit">
                                                    <x-icons.edit class="w-5 h-5" />
                                                </button>
                                                <button wire:click="delete({{ $product->id }})"
                                                        class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                                                        data-tooltip="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                                    <x-icons.trash class="w-5 h-5" />
                                                </button>
                                            </div>
                                        </div>
                                        @if($product->description)
                                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $product->description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                                    No products found. Click "New Product" to create one.
                                </div>
                            @endforelse
                        </div>

                        <!-- Desktop Table -->
                        <div class="hidden md:block bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">SKU</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($products as $product)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $product->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                ${{ number_format($product->price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $product->stock }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $product->sku }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $product->description }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-4">
                                                    <button wire:click="edit({{ $product->id }})"
                                                            class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                                                            data-tooltip="Edit">
                                                        <x-icons.edit class="w-5 h-5" />
                                                    </button>
                                                    <button wire:click="delete({{ $product->id }})"
                                                            class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                                                            data-tooltip="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this product?')">
                                                        <x-icons.trash class="w-5 h-5" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                                No products found. Click "New Product" to create one.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    </div>

                    <!-- Product Modal -->
                    @if($showModal)
                        <div class="fixed inset-0 z-[200] overflow-y-auto">
                            <!-- Backdrop -->
                            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 opacity-75" wire:click="closeModal"></div>

                            <!-- Modal Panel -->
                            <div class="fixed inset-0 z-[101] pointer-events-none">
                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div class="relative bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full pointer-events-auto">
                                        <div class="p-6">
                                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                                                {{ $editingId ? 'Edit Product' : 'Add Product' }}
                                            </h3>
                                            <form wire:submit.prevent="save" class="mt-4 space-y-4">
                                                <div>
                                                    <label for="name" class="block text-base font-medium text-gray-700 dark:text-gray-300">Name</label>
                                                    <input type="text" wire:model="name" id="name" required
                                                           class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                    @error('name') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                </div>

                                                <div>
                                                    <label for="price" class="block text-base font-medium text-gray-700 dark:text-gray-300">Price</label>
                                                    <input type="number" wire:model="price" id="price" required step="0.01" min="0"
                                                           class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                    @error('price') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                </div>

                                                <div>
                                                    <label for="stock" class="block text-base font-medium text-gray-700 dark:text-gray-300">Stock</label>
                                                    <input type="number" wire:model="stock" id="stock" required min="0"
                                                           class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                    @error('stock') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                </div>

                                                <div>
                                                    <label for="sku" class="block text-base font-medium text-gray-700 dark:text-gray-300">SKU</label>
                                                    <input type="text" wire:model="sku" id="sku"
                                                           class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3">
                                                    @error('sku') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                </div>

                                                <div>
                                                    <label for="description" class="block text-base font-medium text-gray-700 dark:text-gray-300">Description</label>
                                                    <textarea wire:model="description" id="description" rows="4"
                                                             class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 text-base p-3"></textarea>
                                                    @error('description') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                                                </div>

                                                <div class="mt-6 flex justify-end space-x-3">
                                                    <button type="button" wire:click="closeModal"
                                                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        {{ $editingId ? 'Update' : 'Create' }}
                                                    </button>
                                                </div>
                                            </form>
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