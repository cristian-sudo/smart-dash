@props(['show', 'message'])

<div x-data="{ 
    show: @entangle('showNotification'),
    init() {
        this.$watch('show', (value) => {
            if (value) {
                setTimeout(() => {
                    this.show = false;
                    @this.hideNotification();
                }, 3000);
            }
        });
    }
}"
x-show="show"
x-cloak
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0 translate-x-full"
x-transition:enter-end="opacity-100 translate-x-0"
x-transition:leave="transition ease-in duration-300"
x-transition:leave-start="opacity-100 translate-x-0"
x-transition:leave-end="opacity-0 translate-x-full"
class="fixed right-4 top-4 z-50 w-80 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg" 
role="alert">
    <span class="block sm:inline">{{ $message }}</span>
</div> 