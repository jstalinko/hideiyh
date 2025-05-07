<x-filament-panels::page>
    <x-filament::section>
        <h2 class="text-xl font-bold mb-6">Your Active Subscriptions</h2>
        
        @if($subscriptions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($subscriptions as $subscription)
                    <div class="bg-black rounded-lg shadow-md overflow-hidden border border-red-500 hover:shadow-lg transition-shadow duration-300">
                        <!-- Card Header with Plan Name -->
                        <div class="bg-primary-600 p-4 text-white">
                            <h3 class="text-lg font-semibold">{{ $subscription->plan->name ?? 'Subscription Plan' }}</h3>
                        </div>
                        
                        <!-- Card Body with Subscription Details -->
                        <div class="p-6 space-y-4">
                            <!-- Subscription Period -->
                            <div>
                                <p class="text-sm text-gray-500">Subscription Period</p>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-sm font-medium">
                                        {{ $subscription->starts_at ? $subscription->starts_at : 'N/A' }}
                                    </span>
                                    <x-filament::icon
                                        icon="heroicon-o-arrow-right"
                                        class="h-4 w-4 text-gray-400"
                                    />
                                    <span class="text-sm font-medium">
                                        {{ $subscription->ends_at ? $subscription->ends_at : 'Ongoing' }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Divider -->
                            <hr class="border-gray-200" />
                            
                            <!-- Status & Auto Renew -->
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-primary-500">
                                        Active
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Auto Renew</p>
                                    @if($subscription->auto_renew)
                                        <span class="inline-flex items-center text-green-600">
                                            <x-filament::icon
                                                icon="heroicon-o-check-circle"
                                                class="h-5 w-5 mr-1"
                                            />
                                            Enabled
                                        </span>
                                    @else
                                        <span class="inline-flex items-center text-gray-600">
                                            <x-filament::icon
                                                icon="heroicon-o-x-circle"
                                                class="h-5 w-5 mr-1"
                                            />
                                            Disabled
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Payment Information -->
                            <div>
                                <p class="text-sm text-gray-500">Payment Method</p>
                                <p class="text-sm font-medium">{{ $subscription->payment_method ?? 'Not specified' }}</p>
                            </div>
                            
                            @if($subscription->invoice)
                            <div>
                                <p class="text-sm text-gray-500">Invoice Reference</p>
                                <p class="text-sm font-medium">{{ $subscription->invoice }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Card Footer with Action Button -->
                        <div class="bg-dark px-6 py-4">
                            <button 
                                type="button"
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                x-data="{}"
                                x-on:click="$dispatch('open-modal', { id: 'cancel-subscription-{{ $subscription->id }}' })"
                            >
                                <x-filament::icon
                                    icon="heroicon-o-x-circle"
                                    class="h-5 w-5 mr-2"
                                />
                                Cancel Subscription
                            </button>
                            
                            <!-- Confirmation Modal -->
                            <x-filament::modal
                                id="cancel-subscription-{{ $subscription->id }}"
                                heading="Cancel Subscription"
                                alignment="center"
                                width="md"
                                :persistent="false"
                            >
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to cancel your subscription to {{ $subscription->plan->name ?? 'this plan' }}? This action cannot be undone.
                                </p>
                                
                                <x-slot name="footerActions">
                                    <button
                                        type="button"
                                        x-on:click="$dispatch('close-modal', { id: 'cancel-subscription-{{ $subscription->id }}' })"
                                        class="filament-button inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm shadow-sm focus:ring-primary-600 text-gray-800 bg-black border-gray-300 hover:bg-dark dark:text-gray-200 dark:border-gray-600 dark:bg-dark"
                                    >
                                        <span>Cancel</span>
                                    </button>
                                    
                                    <form action="#" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            type="submit"
                                            class="filament-button inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm shadow-sm focus:ring-danger-600 text-white bg-danger-600 border-danger-600 hover:bg-danger-500 hover:border-danger-500"
                                        >
                                            <span>Yes, cancel subscription</span>
                                        </button>
                                    </form>
                                </x-slot>
                            </x-filament::modal>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-6 text-center">
                <x-filament::icon
                    icon="heroicon-o-globe-alt"
                    class="h-8 w-8 text-gray-400 mb-4"
                />
                <h3 class="text-lg font-medium text-gray-900">No Subscription Available</h3>
                <p class="mt-1 text-sm text-gray-500">
                    You don't have any active subscriptions.
                </p>
                <div class="mt-6 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <x-filament::icon
                            icon="heroicon-o-plus"
                            class="h-5 w-5 mr-2"
                        />
                        Browse Plans
                    </a>
                    
                    <button
                        type="button"
                        x-data="{}"
                        x-on:click="$dispatch('open-modal', { id: 'activate-invoice-code' })"
                        class="inline-flex items-center px-4 py-2 border border-primary-600 rounded-md shadow-sm text-sm font-medium text-primary-600 bg-black hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                    >
                        <x-filament::icon
                            icon="heroicon-o-ticket"
                            class="h-5 w-5 mr-2"
                        />
                        Input Invoice Code
                    </button>
                    
                    <!-- Invoice Code Activation Modal -->
                    <x-filament::modal
                        id="activate-invoice-code"
                        heading="Activate Plan with Invoice Code"
                        alignment="center"
                        width="md"
                        :persistent="false"
                    >
                        <form action="#" method="POST" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label for="invoice_code" class="block text-sm font-medium text-gray-700">Invoice Code</label>
                                <div class="mt-1">
                                    <input 
                                        type="text" 
                                        name="invoice_code" 
                                        id="invoice_code" 
                                        required
                                        class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md" 
                                        placeholder="Enter your invoice code"
                                    >
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Enter the invoice code you received after payment.</p>
                            </div>
                            
                            <x-slot name="footerActions">
                                <button
                                    type="button"
                                    x-on:click="$dispatch('close-modal', { id: 'activate-invoice-code' })"
                                    class="filament-button inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm shadow-sm focus:ring-primary-600 text-gray-800 bg-black border-gray-300 hover:bg-black dark:text-gray-200 dark:border-gray-600 dark:bg-dark"
                                >
                                    <span>Cancel</span>
                                </button>
                                
                                <button
                                    type="submit"
                                    class="filament-button inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm shadow-sm focus:ring-primary-600 text-white bg-primary-600 border-primary-600 hover:bg-primary-500 hover:border-primary-500"
                                >
                                    <span>Activate Plan</span>
                                </button>
                            </x-slot>
                        </form>
                    </x-filament::modal>
                </div>
            </div>
        @endif
    </x-filament::section>
</x-filament-panels::page>