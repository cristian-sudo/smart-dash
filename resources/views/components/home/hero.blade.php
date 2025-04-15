<!-- Hero Section -->
<div class="relative overflow-hidden bg-white dark:bg-gray-900 py-16 sm:py-24 md:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="lg:max-w-xl">
                <div class="sm:text-center lg:text-left space-y-8">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                        <span class="block">Streamline Your</span>
                        <span class="block text-green-600 dark:text-green-400 mt-4">Invoicing Process</span>
                    </h1>
                    <p class="mt-6 text-base text-gray-500 dark:text-gray-300 sm:mt-8 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-10 md:text-xl lg:mx-0">
                        Create professional invoices, track time, and get paid faster with our intuitive invoicing platform.
                    </p>
                    <div class="mt-8 sm:mt-12 sm:flex sm:justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-6">
                        <div class="rounded-md shadow">
                            <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-10 py-4 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 md:py-5 md:text-lg md:px-12 transition-all duration-300 hover:scale-105">
                                Get started
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0">
                            <a href="#contact" class="w-full flex items-center justify-center px-10 py-4 border border-transparent text-base font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 md:py-5 md:text-lg md:px-12 transition-all duration-300 hover:scale-105">
                                Contact us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative w-full">
                <img class="w-full h-auto object-contain max-w-lg mx-auto" src="{{ asset('images/hero-banner-image.png') }}" alt="Professional invoicing illustration" loading="lazy">
            </div>
        </div>
    </div>
</div> 