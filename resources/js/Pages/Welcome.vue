<template>
  <div class="min-h-screen bg-gradient-to-b from-gray-900 to-gray-800 text-white">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-gray-900 bg-opacity-90 backdrop-blur-sm py-4 px-6 border-b border-gray-800">
      <div class="container mx-auto">
        <div class="flex justify-between items-center">
          <!-- Logo -->
          <div class="flex items-center">
            <span class="text-2xl font-bold text-white">Hide-<span class="text-indigo-400">Iyh</span></span>
          </div>
          
          <!-- Navigation Links -->
          <div class="hidden md:flex space-x-8">
            <a href="#hero" class="text-gray-300 hover:text-white transition duration-300">Home</a>
            <a href="#features" class="text-gray-300 hover:text-white transition duration-300">Features</a>
            <a href="#how-it-works" class="text-gray-300 hover:text-white transition duration-300">How It Works</a>
            <a href="#pricing" class="text-gray-300 hover:text-white transition duration-300">Pricing</a>
          </div>
          
          <!-- CTA Button -->
          <div>
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">Sign Up</button>
          </div>
          
          <!-- Mobile Menu Button -->
          <div class="md:hidden">
            <button class="text-gray-300 focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </nav>
    
    <!-- Hero Section -->
    <section id="hero" class="relative pt-24 pb-32 overflow-hidden">
      <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center -mx-4">
          <div class="w-full lg:w-1/2 px-4 mb-12 lg:mb-0">
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
              Advanced Shortlink with <span class="text-indigo-400">Cloaking Features</span>
            </h1>
            <p class="text-xl text-gray-300 mb-8">
              Hide-Iyh helps you create professional, branded short links with powerful 
              cloaking capabilities to protect your marketing campaigns and affiliate links.
            </p>
            <div class="flex flex-wrap gap-4">
              <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                Get Started Free
              </button>
              <button class="bg-transparent border border-gray-400 hover:border-white text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                Learn More
              </button>
            </div>
          </div>
          <div class="w-full lg:w-1/2 px-4">
            <div class="relative">
              <!-- Decorative elements -->
              <div class="absolute -top-10 -left-10 w-40 h-40 bg-indigo-500 opacity-10 rounded-full"></div>
              <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-purple-500 opacity-10 rounded-full"></div>
              
              <!-- Dashboard preview -->
              <div class="relative bg-gray-800 rounded-2xl border border-gray-700 shadow-2xl p-6">
                <div class="bg-gray-900 rounded-xl p-4 mb-4">
                  <div class="flex items-center mb-4">
                    <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <div class="ml-4 text-gray-400 text-sm">hide-iyh.com/dashboard</div>
                  </div>
                  <div class="mb-4">
                    <div class="h-10 w-full bg-gray-800 rounded-lg"></div>
                  </div>
                  <div class="flex mb-4">
                    <div class="h-24 w-1/3 bg-gray-800 rounded-lg mr-2"></div>
                    <div class="h-24 w-1/3 bg-gray-800 rounded-lg mr-2"></div>
                    <div class="h-24 w-1/3 bg-gray-800 rounded-lg"></div>
                  </div>
                  <div class="h-32 w-full bg-gray-800 rounded-lg"></div>
                </div>
                <div class="text-center text-gray-400 text-sm">
                  Powerful dashboard to manage all your links in one place
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-800">
      <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <h2 class="text-3xl md:text-4xl font-bold mb-4">Powerful Features</h2>
          <p class="text-xl text-gray-300">
            Hide-Iyh offers advanced functionality designed for marketers, affiliates, and professionals.
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Feature 1 -->
          <div class="bg-gray-900 rounded-xl p-8 hover:transform hover:scale-105 transition duration-300">
            <div class="w-16 h-16 bg-indigo-700 rounded-full flex items-center justify-center mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-4">Advanced Link Cloaking</h3>
            <p class="text-gray-400">
              Hide your affiliate IDs and protect your commissions with our state-of-the-art cloaking technology.
            </p>
          </div>
          
          <!-- Feature 2 -->
          <div class="bg-gray-900 rounded-xl p-8 hover:transform hover:scale-105 transition duration-300">
            <div class="w-16 h-16 bg-purple-700 rounded-full flex items-center justify-center mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-4">Detailed Analytics</h3>
            <p class="text-gray-400">
              Track clicks, conversions, and user behavior with comprehensive analytics and real-time reporting.
            </p>
          </div>
          
          <!-- Feature 3 -->
          <div class="bg-gray-900 rounded-xl p-8 hover:transform hover:scale-105 transition duration-300">
            <div class="w-16 h-16 bg-blue-700 rounded-full flex items-center justify-center mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-4">Secure Redirects</h3>
            <p class="text-gray-400">
              Keep your marketing campaigns safe with encrypted redirects and advanced security features.
            </p>
          </div>
          
          <!-- Feature 4 -->
          <div class="bg-gray-900 rounded-xl p-8 hover:transform hover:scale-105 transition duration-300">
            <div class="w-16 h-16 bg-green-700 rounded-full flex items-center justify-center mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-4">Custom Settings</h3>
            <p class="text-gray-400">
              Customize your short links with branded domains, UTM parameters, and advanced redirection options.
            </p>
          </div>
          
          <!-- Feature 5 -->
          <div class="bg-gray-900 rounded-xl p-8 hover:transform hover:scale-105 transition duration-300">
            <div class="w-16 h-16 bg-red-700 rounded-full flex items-center justify-center mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-4">Link Management</h3>
            <p class="text-gray-400">
              Organize, categorize, and manage all your links from a centralized dashboard with bulk operations.
            </p>
          </div>
          
          <!-- Feature 6 -->
          <div class="bg-gray-900 rounded-xl p-8 hover:transform hover:scale-105 transition duration-300">
            <div class="w-16 h-16 bg-yellow-700 rounded-full flex items-center justify-center mb-6">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-4">API Access</h3>
            <p class="text-gray-400">
              Integrate Hide-Iyh with your existing systems using our robust and well-documented API endpoints.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-gray-900">
      <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <h2 class="text-3xl md:text-4xl font-bold mb-4">How It Works</h2>
          <p class="text-xl text-gray-300">
            Create powerful cloaked links in six simple steps
          </p>
        </div>
        
        <div class="flex flex-wrap items-center">
          <!-- Steps -->
          <div class="w-full lg:w-1/2 px-4 mb-12 lg:mb-0">
            <div class="space-y-10">
              <!-- Step 1 -->
              <div class="flex">
                <div class="flex-shrink-0 mr-6">
                  <div class="flex items-center justify-center w-12 h-12 rounded-full bg-indigo-600 text-white font-bold text-xl">
                    1
                  </div>
                </div>
                <div>
                  <h3 class="text-xl font-bold mb-2">Enter Original URL</h3>
                  <p class="text-gray-400">
                    Input your affiliate link or any URL you want to cloak and protect from being detected.
                  </p>
                </div>
              </div>
              
              <!-- Step 2 -->
              <div class="flex">
                <div class="flex-shrink-0 mr-6">
                  <div class="flex items-center justify-center w-12 h-12 rounded-full bg-indigo-600 text-white font-bold text-xl">
                    2
                  </div>
                </div>
                <div>
                  <h3 class="text-xl font-bold mb-2">Set White Page URL</h3>
                  <p class="text-gray-400">
                    Specify a legitimate-looking page that will be shown to crawlers and bots for cloaking purposes.
                  </p>
                </div>
              </div>
              
              <!-- Step 3 -->
              <div class="flex">
                <div class="flex-shrink-0 mr-6">
                  <div class="flex items-center justify-center w-12 h-12 rounded-full bg-indigo-600 text-white font-bold text-xl">
                    3
                  </div>
                </div>
                <div>
                  <h3 class="text-xl font-bold mb-2">Configure Bots URL</h3>
                  <p class="text-gray-400">
                    Define where to redirect bots and crawlers, protecting your affiliate links from being flagged.
                  </p>
                </div>
              </div>
              
              <!-- Step 4 -->
              <div class="flex">
                <div class="flex-shrink-0 mr-6">
                  <div class="flex items-center justify-center w-12 h-12 rounded-full bg-indigo-600 text-white font-bold text-xl">
                    4
                  </div>
                </div>
                <div>
                  <h3 class="text-xl font-bold mb-2">Customize Cloaking Options</h3>
                  <p class="text-gray-400">
                    Select advanced settings like geo-targeting, device detection, referrer filtering, and more.
                  </p>
                </div>
              </div>
              
              <!-- Step 5 -->
              <div class="flex">
                <div class="flex-shrink-0 mr-6">
                  <div class="flex items-center justify-center w-12 h-12 rounded-full bg-indigo-600 text-white font-bold text-xl">
                    5
                  </div>
                </div>
                <div>
                  <h3 class="text-xl font-bold mb-2">Generate Link</h3>
                  <p class="text-gray-400">
                    Create your cloaked shortlink with all settings applied, ready to be used in your campaigns.
                  </p>
                </div>
              </div>
              
              <!-- Step 6 -->
              <div class="flex">
                <div class="flex-shrink-0 mr-6">
                  <div class="flex items-center justify-center w-12 h-12 rounded-full bg-indigo-600 text-white font-bold text-xl">
                    6
                  </div>
                </div>
                <div>
                  <h3 class="text-xl font-bold mb-2">Use Shortlink or Integrate</h3>
                  <p class="text-gray-400">
                    Use your generated shortlink directly or integrate with your own website using our PHP script.
                  </p>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Illustration -->
          <div class="w-full lg:w-1/2 px-4">
            <div class="relative">
              <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-xl">
                <!-- Link creation form illustration -->
                <div class="mb-6">
                  <div class="text-gray-300 text-sm mb-2">Original URL</div>
                  <div class="h-12 bg-gray-900 rounded-lg w-full mb-4"></div>

                  <div class="text-gray-300 text-sm mb-2">White Page URL</div>
                  <div class="h-12 bg-gray-900 rounded-lg w-full mb-4"></div>
                  <div class="text-gray-300 text-sm mb-2">Bot URL</div>
                  <div class="h-12 bg-gray-900 rounded-lg w-full mb-4"></div>
                  <div class="text-gray-300 text-sm mb-2">Cloaking Options</div>
                  <div class="h-24 bg-gray-900 rounded-lg w-full mb-4"></div>
                  
                  <div class="text-gray-300 text-sm mb-2">Your Branded Short Link</div>
                  <div class="h-12 bg-gray-900 rounded-lg w-full mb-4 flex items-center px-4">
                    <div class="text-green-400 text-sm">hide-iyh.com/brand-name</div>
                    <div class="ml-auto">
                      <button class="bg-gray-700 text-xs px-3 py-1 rounded">Copy</button>
                    </div>
                  </div>
                  
                  <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                    Create Link
                  </button>
                </div>
                
                <!-- Analytics preview -->
                <div class="h-32 bg-gray-900 rounded-lg w-full"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Pricing Section -->
    <section class="py-20 bg-gray-800">
      <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <h2 class="text-3xl md:text-4xl font-bold mb-4">Simple, Transparent Pricing</h2>
          <p class="text-xl text-gray-300">
            Choose the plan that fits your needs. No hidden fees.
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <!-- Free Trial Plan -->
          <div class="bg-gray-900 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/10">
            <div class="p-8">
              <h3 class="text-xl font-bold mb-2">Free Trial</h3>
              <p class="text-gray-400 mb-6">Perfect for getting started</p>
              
              <div class="mb-6">
                <span class="text-3xl font-bold">Rp. 0</span>
                <span class="text-gray-400"> / 2 days</span>
              </div>
              
              <ul class="space-y-3 mb-8">
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-300">2 Links</span>
                </li>
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-300">Basic Analytics</span>
                </li>
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-300">48 Hours Access</span>
                </li>
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-300">Standard Support</span>
                </li>
              </ul>
              
              <button class="w-full bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                Start Free Trial
              </button>
            </div>
          </div>
          
          <!-- Basic Plan -->
          <div class="bg-gray-900 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/10">
            <div class="p-8">
              <h3 class="text-xl font-bold mb-2">Basic</h3>
              <p class="text-gray-400 mb-6">For individual marketers</p>
              
              <div class="mb-6">
                <span class="text-3xl font-bold">Rp. 190.000</span>
                <span class="text-gray-400"> / month</span>
              </div>
              
              <ul class="space-y-3 mb-8">
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-300">10 Links</span>
                </li>
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-300">10,000 Traffic/Link/Day</span>
                </li>
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-300">Full Analytics</span>
                </li>
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-300">Priority Support</span>
                </li>
              </ul>
              
              <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                Choose Basic
              </button>
            </div>
          </div>
          
          <!-- Pro Plan -->
          <div class="bg-indigo-900 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/20 transform scale-105 -translate-y-2" id="pricing">
            <div class="bg-indigo-800 py-2 text-center">
              <p class="text-indigo-200 font-semibold text-sm">MOST POPULAR</p>
            </div>
            <div class="p-8">
              <h3 class="text-xl font-bold mb-2">Professional</h3>
              <p class="text-gray-300 mb-6">For growing businesses</p>
              
              <div class="mb-6">
                <span class="text-3xl font-bold">Rp. 290.000</span>
                <span class="text-gray-300"> / month</span>
              </div>
              
              <ul class="space-y-3 mb-8">
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-200">100 Links</span>
                </li>
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-200">Unlimited Traffic</span>
                </li>
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-200">Advanced Analytics</span>
                </li>
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-200">Premium Support</span>
                </li>
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-200">API Access</span>
                </li>
              </ul>
              
              <button class="w-full bg-white hover:bg-gray-100 text-indigo-800 font-semibold py-3 px-8 rounded-lg transition duration-300">
                Choose Professional
              </button>
            </div>
          </div>
          
          <!-- Enterprise Plan -->
          <div class="bg-gray-900 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/10">
            <div class="p-8">
              <h3 class="text-xl font-bold mb-2">Enterprise</h3>
              <p class="text-gray-400 mb-6">For large teams & agencies</p>
              
              <div class="mb-6">
                <span class="text-3xl font-bold">Rp. 500.000</span>
                <span class="text-gray-400"> / month</span>
              </div>
              
              <ul class="space-y-3 mb-8">
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-300">1,000 Links</span>
                </li>
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-300">Unlimited Traffic</span>
                </li>
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-300">Advanced Analytics</span>
                </li>
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-300">24/7 Dedicated Support</span>
                </li>
                <li class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  <span class="text-gray-300">Team Management</span>
                </li>
              </ul>
              
              <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                Choose Enterprise
              </button>
            </div>
          </div>
        </div>
        
        <div class="text-center mt-12">
          <p class="text-gray-400 mb-4">Need a custom solution for your organization?</p>
          <button class="bg-transparent border border-indigo-500 text-indigo-400 hover:bg-indigo-900 hover:text-indigo-300 font-semibold py-3 px-8 rounded-lg transition duration-300">
            Contact Sales
          </button>
        </div>
      </div>
    </section>
    
    <!-- Call to Action -->
    <section class="py-20 bg-gradient-to-r from-indigo-900 to-purple-900">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Protect Your Links?</h2>
        <p class="text-xl text-indigo-200 mb-10 max-w-3xl mx-auto">
          Start using Hide-Iyh today and take control of your marketing campaigns with advanced link cloaking.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
          <button class="bg-white text-indigo-900 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg transition duration-300">
            Start Your Free Trial
          </button>
          <button class="bg-transparent border border-white text-white hover:bg-white/10 font-semibold py-3 px-8 rounded-lg transition duration-300">
            Learn More
          </button>
        </div>
      </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-gray-900 py-12">
      <div class="container mx-auto px-4">
        <div class="flex flex-wrap">
          <div class="w-full md:w-1/3 mb-8 md:mb-0">
            <h3 class="text-xl font-bold mb-4">Hide-Iyh</h3>
            <p class="text-gray-400 mb-4">
              Advanced shortlink with powerful cloaking features for marketers and affiliates.
            </p>
            <div class="flex space-x-4">
              <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                </svg>
              </a>
              <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
              </a>
              <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                </svg>
              </a>
            </div>
          </div>
          
          <div class="w-full md:w-1/3 mb-8 md:mb-0">
            <h3 class="text-xl font-bold mb-4">Quick Links</h3>
            <ul class="space-y-2">
              <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Home</a></li>
              <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Features</a></li>
              <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Pricing</a></li>
              <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Blog</a></li>
              <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Contact</a></li>
              <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">FAQ</a></li>
            </ul>
          </div>
          
          <div class="w-full md:w-1/3">
            <h3 class="text-xl font-bold mb-4">Contact Us</h3>
            <ul class="space-y-2">
              <li class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="text-gray-400">support@hide-iyh.com</span>
              </li>
              <li class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <span class="text-gray-400">+62 812 3456 7890</span>
              </li>
              <li class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-gray-400">Surabaya, East Java, Indonesia</span>
              </li>
            </ul>
            
            <h3 class="text-xl font-bold mt-6 mb-4">Subscribe</h3>
            <div class="flex">
              <input 
                type="email" 
                placeholder="Your email" 
                class="bg-gray-800 text-white rounded-l-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-600"
              >
              <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-r-lg transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </div>
        </div>
        
        <div class="border-t border-gray-800 mt-12 pt-8 text-center">
          <p class="text-gray-500">
            &copy; 2025 Hide-Iyh. All rights reserved | Managed by JavaraDigital.com
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue';


const $prop = defineProps({props:Object});
const plans = ref($prop.props.plans);

</script>