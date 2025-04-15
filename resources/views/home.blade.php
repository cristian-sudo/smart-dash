@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                    <span class="block">Streamline Your Invoicing</span>
                    <span class="block text-indigo-600 dark:text-indigo-400">Smart Invoice Management</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-500 dark:text-gray-300 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Create, manage, and send professional invoices with ease. Track time, manage clients, and get paid faster with our comprehensive invoicing solution.
                </p>
                <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                    <div class="rounded-md shadow">
                        <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    Powerful Features
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-300">
                    Everything you need to manage your invoices effectively
                </p>
            </div>
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                        <x-icons.invoice class="h-6 w-6" />
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Professional Invoices</h3>
                    <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                        Create and customize professional invoices with your company branding and details.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                        <x-icons.time class="h-6 w-6" />
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Time Tracking</h3>
                    <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                        Track time spent on services and automatically generate invoices based on your time logs.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                        <x-icons.email class="h-6 w-6" />
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Email Integration</h3>
                    <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                        Send invoices directly to clients via email with professional templates and PDF attachments.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    How It Works
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-300">
                    Get started in three simple steps
                </p>
            </div>
            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <!-- Step 1 -->
                    <div class="relative">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-500 text-white">
                            <span class="text-xl font-bold">1</span>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Track Your Time</h3>
                        <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                            Log your time spent on different services and projects.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-500 text-white">
                            <span class="text-xl font-bold">2</span>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Create Invoices</h3>
                        <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                            Generate professional invoices from your time logs with just a few clicks.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-500 text-white">
                            <span class="text-xl font-bold">3</span>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Send & Get Paid</h3>
                        <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                            Send invoices to clients via email and track payment status.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    Simple, Transparent Pricing
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-300">
                    Choose the plan that's right for your business
                </p>
            </div>
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-3">
                <!-- Free Plan -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Free</h3>
                    <p class="mt-4 text-gray-500 dark:text-gray-300">Perfect for freelancers</p>
                    <p class="mt-4 text-4xl font-bold text-gray-900 dark:text-white">$0<span class="text-lg font-normal text-gray-500 dark:text-gray-300">/month</span></p>
                    <ul class="mt-6 space-y-4">
                        <li class="flex items-center">
                            <x-icons.check class="h-5 w-5 text-green-500" />
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Up to 3 clients</span>
                        </li>
                        <li class="flex items-center">
                            <x-icons.check class="h-5 w-5 text-green-500" />
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Up to 10 invoices/month</span>
                        </li>
                        <li class="flex items-center">
                            <x-icons.check class="h-5 w-5 text-green-500" />
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Basic support</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="mt-8 block w-full text-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Get Started
                    </a>
                </div>

                <!-- Pro Plan -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border-2 border-indigo-500 relative">
                    <div class="absolute -top-3 right-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                            Popular
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Pro</h3>
                    <p class="mt-4 text-gray-500 dark:text-gray-300">For growing businesses</p>
                    <p class="mt-4 text-4xl font-bold text-gray-900 dark:text-white">$19<span class="text-lg font-normal text-gray-500 dark:text-gray-300">/month</span></p>
                    <ul class="mt-6 space-y-4">
                        <li class="flex items-center">
                            <x-icons.check class="h-5 w-5 text-green-500" />
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Up to 20 clients</span>
                        </li>
                        <li class="flex items-center">
                            <x-icons.check class="h-5 w-5 text-green-500" />
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Unlimited invoices</span>
                        </li>
                        <li class="flex items-center">
                            <x-icons.check class="h-5 w-5 text-green-500" />
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Priority support</span>
                        </li>
                        <li class="flex items-center">
                            <x-icons.check class="h-5 w-5 text-green-500" />
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Custom branding</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="mt-8 block w-full text-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Get Started
                    </a>
                </div>

                <!-- Enterprise Plan -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Enterprise</h3>
                    <p class="mt-4 text-gray-500 dark:text-gray-300">For large organizations</p>
                    <p class="mt-4 text-4xl font-bold text-gray-900 dark:text-white">$49<span class="text-lg font-normal text-gray-500 dark:text-gray-300">/month</span></p>
                    <ul class="mt-6 space-y-4">
                        <li class="flex items-center">
                            <x-icons.check class="h-5 w-5 text-green-500" />
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Unlimited clients</span>
                        </li>
                        <li class="flex items-center">
                            <x-icons.check class="h-5 w-5 text-green-500" />
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Unlimited invoices</span>
                        </li>
                        <li class="flex items-center">
                            <x-icons.check class="h-5 w-5 text-green-500" />
                            <span class="ml-3 text-gray-700 dark:text-gray-300">24/7 support</span>
                        </li>
                        <li class="flex items-center">
                            <x-icons.check class="h-5 w-5 text-green-500" />
                            <span class="ml-3 text-gray-700 dark:text-gray-300">API access</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="mt-8 block w-full text-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    Get in Touch
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-300">
                    Have questions? We'd love to hear from you.
                </p>
            </div>
            <div class="mt-12 max-w-2xl mx-auto">
                <livewire:contact-form />
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-indigo-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    Ready to streamline your invoicing?
                </h2>
                <p class="mt-4 text-lg text-indigo-100">
                    Join thousands of professionals who trust our platform for their invoicing needs.
                </p>
                <div class="mt-8">
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                        Get Started Today
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection 