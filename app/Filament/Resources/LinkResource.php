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
use Filament\Tables\Enums\ActionsPosition;
use App\Filament\Resources\LinkResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use App\Filament\Resources\LinkResource\RelationManagers;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use Webbingbrasil\FilamentCopyActions\Tables\Actions\CopyAction;

class LinkResource extends Resource implements HasShieldPermissions
{
    use HasShieldFormComponents;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }
    protected static ?string $model = Link::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?int $navigationSort = 3;

      public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        // Check if the authenticated user has super_admin role
        if (auth()->check() && auth()->user()->hasRole('super_admin')) {
            // Return all links for super_admin
            return $query;
        }
        
        // For non-super_admin users, only show their own links
        return $query->where('user_id', auth()->id());
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               Forms\Components\Section::make('Domain & Shortlink')->schema([
                 Forms\Components\Select::make('domain')
                    ->options([
                        'hwhw.pw' => 'hwhw.pw',
                        'hdmx.biz.id' => 'hdmx.biz.id',
                        'iyh.web.id' => 'iyh.web.id'
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
                ])->columns(2),
                    
                Forms\Components\Section::make('Rendering Method')->schema(
                    [
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
                    ]
                    )->columns(3),
               
                Forms\Components\Section::make('Setting URL')->schema([
                     Forms\Components\TextInput::make('bot_page_url')
                    ->required()
                    ->maxLength(255)
                    ->default('https://trash.hideiyh.pw/?p=BOT_FOUND')
                    ->helperText('URL where bots/crawlers will be redirected')
                    ->placeholder('https://example.com/bot-page'),

                Forms\Components\TextInput::make('white_page_url')
                    ->required()
                    ->maxLength(255)
                    ->default('https://trash.hideiyh.pw/?p=WHITE_PAGE')
                    ->helperText('URL for non-targeted visitors (safe page)')
                    ->placeholder('https://example.com/safe-page'),

                Forms\Components\TextInput::make('offer_page_url')
                    ->required()
                    ->maxLength(255)
                    ->default('https://trash.hideiyh.pw/?p=OFFER_PAGE')
                    ->helperText('URL for your main offer/landing page for targeted visitors')
                    ->placeholder('https://example.com/offer-page'),
                ])->columns(3),

                Forms\Components\Section::make('Setting Rules')->schema([

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
                    ])->columns(2),
                
                Forms\Components\Section::make('Setting Block')->schema([

                Forms\Components\Toggle::make('block_no_referer')
                    ->required()
                    ->helperText('Block visitors that don\'t have a referrer (direct traffic)'),

                Forms\Components\Toggle::make('block_vpn')
                    ->required()
                    ->helperText('Block visitors using VPN or proxy services'),

                Forms\Components\Toggle::make('block_bot')
                    ->required()
                    ->helperText('Block detected bots and redirect them to the bot page'),

                Forms\Components\Toggle::make('active')
                    ->required()
                    ->default(true)
                    ->helperText('Toggle to enable or disable this shortlink'),
                ])->columns(4)
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('full_url')
                ->searchable()
                ->copyable()
                ->copyableState(fn ($record): string => 'https://'.$record->shortlink.'.'.$record->domain)
                ->copyMessage('Shortlink copied !')
                ->label('Short Url')
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
            Tables\Columns\TextColumn::make('shortlink')
                ->label('Shortlink ID')
                ->copyable()
                ->copyMessage('Shortlink ID copied!')
                ->copyableState(fn ($record): string =>  $record->shortlink)
                ->getStateUsing(function ($record) {
                    $fullUrl = $record->shortlink;
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
                ->successNotificationMessage('API Key copied to clipboard!')->color('success'),
                Tables\Actions\Action::make('stats')
                    ->label('Stats')
                    ->url(fn (Link $record): string =>  route('filament.admin.resources.links.stats', $record))
                    ->icon('heroicon-o-chart-bar')
                    ->color('primary'),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'stats' => Pages\StatsLink::route('/{record}/stats'),
        ];
    }
}
