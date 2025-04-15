<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notification -->
            <x-notification :message="$notificationMessage" :show="$show" />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Invoices</h2>
                        <button wire:click="create"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            New Invoice
                        </button>
                    </div>

                    <!-- Invoices Table -->
                    <div class="mt-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Invoices</h2>
                        </div>

                        <x-invoices.table :invoices="$invoices" :previewId="$previewId" />
                        <x-invoices.mobile-list :invoices="$invoices" :previewId="$previewId" />

                        <div class="mt-4">
                            {{ $invoices->links() }}
                        </div>
                    </div>

                    <!-- Modals -->
                    <x-invoices.form-modal 
                        :showModal="$showModal"
                        :invoiceId="$invoiceId"
                        :clients="$clients"
                        :companies="$companies"
                        :currentTimeLogs="$currentTimeLogs"
                        :availableTimeLogs="$availableTimeLogs"
                        :availableProducts="$availableProducts" />

                    <x-invoices.send-modal 
                        :showSendModal="$showSendModal"
                        :recipientEmail="$recipientEmail"
                        :defaultEmailMessage="$defaultEmailMessage" />
                </div>
            </div>
        </div>
    </div>
</div>
