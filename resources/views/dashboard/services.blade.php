@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Services</h2>
                    <button onclick="document.getElementById('serviceModal').classList.remove('hidden')" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                        Add Service
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Default Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($services as $service)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $service->name }}</td>
                                <td class="px-6 py-4">{{ $service->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${{ number_format($service->default_price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button onclick="editService({{ $service->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">Edit</button>
                                    <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this service?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Service Modal -->
<div id="serviceModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Add Service</h3>
            <form id="serviceForm" action="{{ route('services.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500" required>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500"></textarea>
                    </div>
                    <div>
                        <label for="default_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Default Price</label>
                        <input type="number" name="default_price" id="default_price" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500" required>
                    </div>
                </div>
                <div class="mt-4 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function editService(id) {
        fetch(`/services/${id}`)
            .then(response => response.json())
            .then(service => {
                document.getElementById('serviceForm').action = `/services/${id}`;
                document.getElementById('serviceForm').innerHTML += '<input type="hidden" name="_method" value="PUT">';
                document.getElementById('name').value = service.name;
                document.getElementById('description').value = service.description;
                document.getElementById('default_price').value = service.default_price;
                document.getElementById('serviceModal').classList.remove('hidden');
            });
    }

    function closeModal() {
        document.getElementById('serviceModal').classList.add('hidden');
        document.getElementById('serviceForm').reset();
        document.getElementById('serviceForm').action = "{{ route('services.store') }}";
        const methodInput = document.querySelector('input[name="_method"]');
        if (methodInput) {
            methodInput.remove();
        }
    }
</script>
@endpush
@endsection 