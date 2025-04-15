@props(['status'])

<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
    {{ $status === 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100' : 
       ($status === 'overdue' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100' : 
       ($status === 'sent' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100' : 
       'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100')) }}">
    {{ ucfirst($status) }}
</span> 