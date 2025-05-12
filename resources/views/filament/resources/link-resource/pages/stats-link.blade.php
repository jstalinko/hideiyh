
<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Clicks Card -->
        <x-filament::card>
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold tracking-tight">Total Clicks</h2>
                <x-filament::icon
                    name="heroicon-o-cursor-arrow-rays"
                    class="h-5 w-5 text-primary-500"
                />
            </div>
            
            <div class="mt-2">
                <p class="text-3xl font-extrabold">{{ number_format($totalClicks) }}</p>
                <p class="text-sm text-gray-500">All clicks across the platform</p>
            </div>
        </x-filament::card>

        <!-- Offer Clicks Card -->
        <x-filament::card>
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold tracking-tight">Offer Clicks</h2>
                <x-filament::icon
                    name="heroicon-o-cursor-arrow-ripple"
                    class="h-5 w-5 text-success-500"
                />
            </div>
            
            <div class="mt-2">
                <p class="text-3xl font-extrabold">{{ number_format($offerClicks) }}</p>
                <div class="flex items-center text-sm">
                    <span class="text-success-500 font-medium">{{ $offerPercentage }}%</span>&nbsp;
                    <span class="ml-1 text-gray-500"> of total clicks</span>
                </div>
            </div>
        </x-filament::card>

        <!-- Bot Clicks Card -->
        <x-filament::card>
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold tracking-tight">Bot Clicks</h2>
                <x-filament::icon
                    name="heroicon-o-bug-ant"
                    class="h-5 w-5 text-warning-500"
                />
            </div>
            
            <div class="mt-2">
                <p class="text-3xl font-extrabold">{{ number_format($botClicks) }}</p>
                <div class="flex items-center text-sm">
                    <span class="text-warning-500 font-medium">{{ $botPercentage }}%</span>&nbsp;
                    <span class="ml-1 text-gray-500"> of total clicks</span>
                </div>
            </div>
        </x-filament::card>

        <!-- White Clicks Card -->
        <x-filament::card>
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold tracking-tight">White Clicks</h2>
                <x-filament::icon
                    name="heroicon-o-cursor-arrow-rays"
                    class="h-5 w-5 text-info-500"
                />
            </div>
            
            <div class="mt-2">
                <p class="text-3xl font-extrabold">{{ number_format($whiteClicks) }}</p>
                <div class="flex items-center text-sm">
                    <span class="text-info-500 font-medium">{{ $whitePercentage }}%</span>&nbsp;
                    <span class="ml-1 text-gray-500"> of total clicks</span>
                </div>
            </div>
        </x-filament::card>
    </div>
</x-filament::page>
