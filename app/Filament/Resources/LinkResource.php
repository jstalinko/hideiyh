<?php

namespace App\Filament\Resources;

use App\Helper;
use Filament\Forms;
use App\Models\Link;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LinkResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LinkResource\RelationManagers;
use Webbingbrasil\FilamentCopyActions\Tables\Actions\CopyAction;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('domain')
                    ->options([
                        'hwhw.pw' => 'hwhw.pw',
                        'hdmx.biz.id' => 'hdmx.biz.id',
                    ])
                    ->default('hwhw.pw')
                    ->helperText('Select the domain for your shortlink')
                    ->required(),
                Forms\Components\TextInput::make('shortlink')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Enter the custom path for your shortlink (e.g., "promo2025")')
                    ->placeholder('Enter shortlink path')
                    ->default(function () {
                        // Generate a random string of 6 alphanumeric characters
                        return strtolower(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 6));
                    })
                    ->suffixAction(
                        Forms\Components\Actions\Action::make('generateShortlink')
                            ->icon('heroicon-m-arrow-path')
                            ->tooltip('Generate random shortlink')
                            ->action(function (Forms\Components\TextInput $component) {
                                $randomString = strtolower(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 6));
                                $component->state($randomString);
                            })
                    ),

                Forms\Components\TextInput::make('bot_page_url')
                    ->required()
                    ->maxLength(255)
                    ->default('https://javaradigital.com/default.html')
                    ->helperText('URL where bots/crawlers will be redirected')
                    ->placeholder('https://example.com/bot-page'),

                Forms\Components\TextInput::make('white_page_url')
                    ->required()
                    ->maxLength(255)
                    ->default('https://javaradigital.com/default.html')
                    ->helperText('URL for non-targeted visitors (safe page)')
                    ->placeholder('https://example.com/safe-page'),

                Forms\Components\TextInput::make('offer_page_url')
                    ->required()
                    ->maxLength(255)
                    ->default('https://javaradigital.com/default.html')
                    ->helperText('URL for your main offer/landing page for targeted visitors')
                    ->placeholder('https://example.com/offer-page'),

                Forms\Components\Select::make('render_bot_page_method')
                    ->required()
                    ->options([
                        '302' => 'header 302',
                        'iframe' => 'iframe',
                        'script' => 'script',
                        'meta' => 'meta refresh',
                        'lorem' => 'lorem'
                    ])
                    ->helperText('Choose how to render the bot page (302 redirect recommended for bots)')
                    ->default('302'),

                Forms\Components\Select::make('render_white_page_method')
                    ->required()
                    ->options([
                        '302' => 'header 302',
                        'iframe' => 'iframe',
                        'script' => 'script',
                        'meta' => 'meta refresh',
                        'lorem' => 'lorem'
                    ])
                    ->helperText('Choose how to render the white/safe page for non-targeted visitors')
                    ->default('302'),

                Forms\Components\Select::make('render_offer_page_method')
                    ->required()
                    ->options([
                        '302' => 'header 302',
                        'iframe' => 'iframe',
                        'script' => 'script',
                        'meta' => 'meta refresh',
                        'lorem' => 'lorem'
                    ])
                    ->helperText('Choose how to render the offer page for targeted visitors')
                    ->default('302'),

                Forms\Components\Select::make('allowed_country')
                    ->options(Helper::countryList())
                    ->multiple()
                    ->helperText('Select countries that can access the offer page (leave empty for all countries)')
                    ->placeholder('Select targeted countries'),

                Forms\Components\TagsInput::make('allowed_params')
                    ->placeholder('utm_source,utm_medium,utm_campaign')
                    ->helperText('Enter URL parameters that should be preserved (comma-separated)'),

                Forms\Components\Select::make('allowed_device')
                    ->required()
                    ->options([
                        'all' => 'ALL',
                        'mobile' => 'Mobile Only',
                        'desktop' => 'Desktop Only',
                        'fb_browser' => 'Facebook Browser'
                    ])
                    ->helperText('Choose which devices can access the offer page')
                    ->default('all'),

                Forms\Components\Select::make('allowed_platform')
                    ->required()
                    ->options([
                        'all' => 'ALL',
                        'android' => 'Mobile Android',
                        'ios' => 'Mobile iOS',
                        'desktop' => 'Desktop/PC Only',
                        'fb_browser' => 'Facebook Browser'
                    ])
                    ->helperText('Choose which platforms can access the offer page')
                    ->default('all'),

                Forms\Components\TextInput::make('anti_loop_max')
                    ->required()
                    ->numeric()
                    ->default(5)
                    ->helperText('Maximum number of redirects allowed to prevent redirection loops'),

                Forms\Components\Toggle::make('block_no_referer')
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Block visitors that don\'t have a referrer (direct traffic)'),

                Forms\Components\Toggle::make('block_vpn')
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Block visitors using VPN or proxy services'),

                Forms\Components\Toggle::make('block_bot')
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Block detected bots and redirect them to the bot page'),

                Forms\Components\Toggle::make('active')
                    ->required()
                    ->default(true)
                    ->helperText('Toggle to enable or disable this shortlink'),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('shortlink')
                ->searchable()
                ->copyable()
                ->copyableState(fn ($record): string => 'https://'.$record->shortlink.'.'.$record->domain)
                ->copyMessage('Shortlink copied !')
                ->label('Shortlink')
                ->getStateUsing(function ($record) {
                    return new \Illuminate\Support\HtmlString('
                        <div class="flex items-center gap-2">
                            <span>' . e($record->shortlink . '.'. $record->domain) . '</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                                <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                            </svg>
                        </div>
                    ');
                })->badge(),
            Tables\Columns\TextColumn::make('full_url')
                ->label('Full URL')
                ->copyable()
                ->copyMessage('URL lengkap disalin!')
                ->copyableState(fn ($record): string => env('APP_URL') . '/s/' . $record->shortlink)
                ->getStateUsing(function ($record) {
                    $fullUrl = env('APP_URL') . '/s/' . $record->shortlink;
                    return new \Illuminate\Support\HtmlString('
                        <div class="flex items-center gap-2">
                            <span>' . e($fullUrl) . '</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                                <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                            </svg>
                        </div>
                    ');
                })->badge(),
            Tables\Columns\TextColumn::make('clicks')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('white_page_clicks')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('bot_page_clicks')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('offer_page_clicks')
                ->numeric()
                ->sortable(),
            Tables\Columns\ToggleColumn::make('active'),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
            ->filters([
                //
            ])
            ->actions([

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                CopyAction::make()
                ->label('API Key')
                ->copyable(fn ($record) => $record->apikey ?? 'Upgrade Plan to get API Key :D')
                ->successNotificationMessage('API Key copied to clipboard!')->color('success')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'view' => Pages\ViewLink::route('/{record}'),
            'edit' => Pages\EditLink::route('/{record}/edit'),
        ];
    }
}
