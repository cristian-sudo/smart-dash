@props(['invoice'])

<div class="flex justify-end space-x-4">
    <button wire:click="edit({{ $invoice->id }})"
            class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
            data-tooltip="Edit">
        <x-icons.edit class="w-5 h-5" />
    </button>
    <button wire:click="togglePreview({{ $invoice->id }})"
            class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
            data-tooltip="Preview">
        <x-icons.eye class="w-5 h-5" />
    </button>
    <button wire:click="openSendModal({{ $invoice->id }})"
            class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
            data-tooltip="Send">
        <x-icons.mail class="w-5 h-5" />
    </button>
    <a href="{{ route('invoices.download', $invoice) }}"
       class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
       data-tooltip="Download">
        <x-icons.download class="w-5 h-5" />
    </a>
    @if($invoice->status !== 'paid')
        <button wire:click="markAsPaid({{ $invoice->id }})"
                class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                data-tooltip="Mark as Paid">
            <x-icons.check class="w-5 h-5" />
        </button>
    @endif
    <button wire:click="delete({{ $invoice->id }})"
            class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
            data-tooltip="Delete"
            onclick="return confirm('Are you sure you want to delete this invoice?')">
        <x-icons.trash class="w-5 h-5" />
    </button>
</div> 