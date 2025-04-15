@props(['showSendModal', 'recipientEmail', 'defaultEmailMessage'])

@if($showSendModal)
    <div class="fixed inset-0 z-[100]">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 opacity-75" wire:click="closeSendModal"></div>

        <!-- Modal Panel -->
        <div class="fixed inset-0 z-[101] pointer-events-none">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full max-h-[90vh] overflow-y-auto pointer-events-auto">
                    <div class="bg-white dark:bg-gray-800 px-6 py-6">
                        <div class="mt-3">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                                Send Invoice
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="recipient_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Recipient Email
                                    </label>
                                    <input type="email" wire:model="recipientEmail" id="recipient_email" readonly disabled
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm bg-gray-100 dark:bg-gray-800 cursor-not-allowed">
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Email Message:</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $defaultEmailMessage }}</p>
                                </div>

                                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                    <p class="text-sm text-blue-700 dark:text-blue-300">
                                        Alternatively, you can download the invoice and send it manually from your email client.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-4">
                                <button type="button" 
                                        wire:click="closeSendModal"
                                        class="inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Cancel
                                </button>
                                <button type="button" 
                                        wire:click="sendInvoice"
                                        class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Send Email
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif 