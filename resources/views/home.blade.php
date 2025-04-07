@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                    <span class="block">Welcome to Smart Dash</span>
                    <span class="block text-indigo-600 dark:text-indigo-400">Your Smart Dashboard Solution</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-500 dark:text-gray-300 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Transform your data into actionable insights with our powerful dashboard solution. Get started today and take control of your business analytics.
                </p>
                <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                    <div class="rounded-md shadow">
                        <a href="#pricing" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
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
                    Everything you need to manage your business effectively
                </p>
            </div>
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Real-time Analytics</h3>
                    <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                        Get instant insights into your business performance with our real-time analytics dashboard.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Customizable Dashboards</h3>
                    <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                        Create personalized dashboards that show exactly what matters to your business.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Secure & Reliable</h3>
                    <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                        Your data is protected with enterprise-grade security and 99.9% uptime guarantee.
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
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Sign Up</h3>
                        <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                            Create your account and choose your plan. It only takes a few minutes.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-500 text-white">
                            <span class="text-xl font-bold">2</span>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Connect Your Data</h3>
                        <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                            Integrate your existing tools and data sources with our platform.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-500 text-white">
                            <span class="text-xl font-bold">3</span>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Start Analyzing</h3>
                        <p class="mt-2 text-base text-gray-500 dark:text-gray-300">
                            Customize your dashboard and start making data-driven decisions.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    What our customers say
                </h2>
            </div>
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Testimonial 1 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white">John Doe</h4>
                            <p class="text-gray-500 dark:text-gray-400">CEO, Company Inc.</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600 dark:text-gray-300">
                        "Smart Dash has transformed how we analyze our business data. The insights we've gained have been invaluable."
                    </p>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white">Jane Smith</h4>
                            <p class="text-gray-500 dark:text-gray-400">Marketing Director, Tech Corp</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600 dark:text-gray-300">
                        "The dashboard is intuitive and powerful. It's helped us make data-driven decisions with confidence."
                    </p>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white">Mike Johnson</h4>
                            <p class="text-gray-500 dark:text-gray-400">CTO, Startup Co</p>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600 dark:text-gray-300">
                        "The customization options are fantastic. We've been able to tailor the dashboard to our specific needs."
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    Simple, transparent pricing
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-300">
                    Choose the plan that's right for your business
                </p>
            </div>
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Basic Plan -->
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Basic</h3>
                    <p class="mt-4 text-gray-500 dark:text-gray-300">Perfect for small businesses</p>
                    <p class="mt-4 text-4xl font-bold text-gray-900 dark:text-white">$29<span class="text-lg font-normal text-gray-500 dark:text-gray-300">/month</span></p>
                    <ul class="mt-6 space-y-4">
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Basic Dashboard</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-gray-700 dark:text-gray-300">5 Users</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Basic Support</span>
                        </li>
                    </ul>
                    <button class="mt-8 w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                        Get Started
                    </button>
                </div>

                <!-- Pro Plan -->
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg border-2 border-indigo-500">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                            Popular
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Pro</h3>
                    <p class="mt-4 text-gray-500 dark:text-gray-300">For growing businesses</p>
                    <p class="mt-4 text-4xl font-bold text-gray-900 dark:text-white">$79<span class="text-lg font-normal text-gray-500 dark:text-gray-300">/month</span></p>
                    <ul class="mt-6 space-y-4">
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Advanced Dashboard</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-gray-700 dark:text-gray-300">20 Users</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Priority Support</span>
                        </li>
                    </ul>
                    <button class="mt-8 w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                        Get Started
                    </button>
                </div>

                <!-- Enterprise Plan -->
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Enterprise</h3>
                    <p class="mt-4 text-gray-500 dark:text-gray-300">For large organizations</p>
                    <p class="mt-4 text-4xl font-bold text-gray-900 dark:text-white">$199<span class="text-lg font-normal text-gray-500 dark:text-gray-300">/month</span></p>
                    <ul class="mt-6 space-y-4">
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Custom Dashboard</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-gray-700 dark:text-gray-300">Unlimited Users</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-gray-700 dark:text-gray-300">24/7 Support</span>
                        </li>
                    </ul>
                    <button class="mt-8 w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                        Get Started
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    Get in Touch
                </h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-300">
                    Have questions? We'd love to hear from you.
                </p>
            </div>
            <div class="mt-12 max-w-lg mx-auto">
                <form class="grid grid-cols-1 gap-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                        <textarea id="message" name="message" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    </div>
                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection 