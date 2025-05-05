<x-filament-panels::page>
    <!-- Toggleable Tutorial Section -->
    <div x-data="{ showTutorial: false }">
        <!-- Tutorial toggle button -->
        <div class="mb-4">
            <x-filament::button
                color="primary"
                size="sm"
                icon="heroicon-o-academic-cap"
                x-on:click="showTutorial = !showTutorial"
            >
                <span x-text="showTutorial ? 'Hide Tutorial' : 'Show Tutorial'"></span>
            </x-filament::button>
        </div>
        
        <!-- Tutorial Content - Toggleable -->
        <div x-show="showTutorial" x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 transform -translate-y-4" 
             x-transition:enter-end="opacity-100 transform translate-y-0">
            <x-filament::section>
                <x-slot name="heading">
                    PHP Integration Guide
                </x-slot>
                
                <x-slot name="description">
                    Follow these steps to integrate our PHP solution with your website
                </x-slot>
                
                <div class="space-y-6">
                    <div class="p-4 bg-dark rounded-lg border border-gray-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-primary-50 text-primary-700 font-bold text-lg">
                                1
                            </div>
                            <div class="ml-4">
                                <h3 class="text-base font-medium">Download the integration package</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Get our latest PHP integration package containing all necessary files. (<a href="" class="text-primary">download here</a>)
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-dark rounded-lg border border-gray-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-primary-50 text-primary-700 font-bold text-lg">
                                2
                            </div>
                            <div class="ml-4">
                                <h3 class="text-base font-medium">Upload files to your server</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                   Upload the .php file downloaded package and upload the contents to your hosting or VPS server using FTP or SSH.
                                </p>
                                <div class="mt-3 p-3 bg-dark rounded text-sm font-mono">
                                    <p>📁 /public_html/ or your web root directory</p>
                                    <p class="pl-4">└── 📄 index.php</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-dark rounded-lg border border-gray-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-primary-50 text-primary-700 font-bold text-lg">
                                3
                            </div>
                            <div class="ml-4">
                                <h3 class="text-base font-medium">Access your integration</h3>
                                <p class="mt-1 text-sm ">
                                    Navigate to the integration URL in your browser and complete the setup wizard.
                                </p>
                                <div class="mt-3 p-3 border-2 rounded text-sm font-mono">
                                    https://yourdomain.com/
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-dark rounded-lg border border-gray-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-primary-50 text-primary-700 font-bold text-lg">
                                4
                            </div>
                            <div class="ml-4">
                                <h3 class="text-base font-medium">Configure and verify</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Set your API credentials and test the connection to complete the integration. Your domain automatically connects to our system.
                                </p>
                                <div class="mt-3">
                                    <p class="text-xs text-gray-500">Need help? Check our <a href="#" class="text-primary-600 hover:text-primary-800">documentation</a> or <a href="#" class="text-primary-600 hover:text-primary-800">contact support</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-filament::section>
        </div>
    </div>
    
    <!-- Download button -->
    <div class="flex justify-between items-center my-6">
        <h2 class="text-xl font-bold">PHP Integration</h2>
        <x-filament::button
            tag="a"
            href="{{route('download')}}"
            target="_blank"
            color="success"
            icon="heroicon-o-cloud-arrow-down"
            size="sm"
        >
            Download PHP Integration
        </x-filament::button>
    </div>

<!-- Connected domains section -->
<x-filament::section>
    <x-slot name="heading">
        Connected domains
    </x-slot>
    
    <x-slot name="description">
        Manage domains connected to your PHP integration
    </x-slot>
    
    <div class="space-y-4">
        @if(count($this->getIntegrations()) > 0)
            <!-- Domain item 1 -->
            <div class="flex items-center justify-between p-4 bg-dark rounded-lg border border-gray-200">
               @foreach($this->getIntegrations() as $integration)
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-primary-50 flex items-center justify-center">
                        <x-filament::icon
                            icon="heroicon-o-globe-alt"
                            class="h-5 w-5 text-primary-500"
                        />
                    </div>

                    <div class="ml-4">
                       
                        <p class="font-medium">{{$integration->domain}}</p>
                        <p class="text-sm text-gray-500">Connected on {{$integration->created_at->diffForHumans()}}</p>
                    </div>
                </div>
              
                <x-filament::button
                    color="danger"
                    size="sm"
                    icon="heroicon-o-trash"
                    wire:click="disconnectIntegration({{ $integration->id }})"
                >
                    Disconnect
                </x-filament::button>
               @endforeach
            </div>
        @else
            <!-- Empty state when no integrations found -->
            <div class="flex flex-col items-center justify-center py-6 text-center">
                <x-filament::icon
                    icon="heroicon-o-globe-alt"
                    class="h-8 w-8 text-gray-400 mb-4"
                />
                <h3 class="text-lg font-medium text-gray-900">No domains connected</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Download and install the PHP integration to connect your first domain.
                </p>
            </div>
        @endif
    </div>
</x-filament::section>
</x-filament-panels::page>