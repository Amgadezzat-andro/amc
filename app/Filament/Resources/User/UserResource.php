<?php

namespace App\Filament\Resources\User;

use App\Models\User;
use App\Filament\Resources\User\ResourcePages\Create;
use App\Filament\Resources\User\ResourcePages\Edit;
use App\Filament\Resources\User\ResourcePages\ListItems;
use App\Filament\Resources\UserResource\Pages;
use App\Traits\AllColumnActionVisibility;
use App\Traits\CommonActionButtons;
use App\Traits\ToggleColumnVisibility;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Components\Checkbox;

class UserResource extends Resource
{
    use AllColumnActionVisibility, CommonActionButtons;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user';

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __("Users");
    }

    public static function getModelLabel(): string
    {
        return __("Users");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Users");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Users");
    }


    public static function getNavigationGroup(): ?string
    {
        return Utils::isResourceNavigationGroupEnabled()
            ? __('filament-shield::filament-shield.nav.group')
            : '';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make(3)->schema([
                    Section::make()
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([

                        Forms\Components\TextInput::make('username')
                            ->label(__("User Name"))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->notRegex('/<[^b][^r][^>]*>/')
                            ->validationMessages([
                                'not_regex' => 'HTML is invalid',
                            ]),


                        Forms\Components\TextInput::make('email')
                            ->label(__("Email"))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->email()
                            ->maxLength(255)
                            ->notRegex('/<[^b][^r][^>]*>/')
                            ->validationMessages([
                                'not_regex' => 'HTML is invalid',
                            ]),


                        Forms\Components\TextInput::make('first_name')
                            ->label(__("First Name"))
                            ->required()
                            ->maxLength(255)
                            ->notRegex('/<[^b][^r][^>]*>/')
                            ->validationMessages([
                                'not_regex' => 'HTML is invalid',
                            ]),


                        Forms\Components\TextInput::make('last_name')
                            ->label(__("Last Name"))
                            ->required()
                            ->maxLength(255)
                            ->notRegex('/<[^b][^r][^>]*>/')
                            ->validationMessages([
                                'not_regex' => 'HTML is invalid',
                            ]),


                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->label(__("Password"))
                            ->required()
                            ->maxLength(255)
                            ->notRegex('/<[^b][^r][^>]*>/')
                            ->validationMessages([
                                'not_regex' => 'HTML is invalid',
                            ])
                            ->rules(['regex:/^(?=(.*[a-z]){2,})(?=(.*[A-Z]){2,}).{8,}$/'])
                            ->helperText(__('At least 8 characters, 2 lowercase and 2 uppercase.'))
                            ->visible(fn (string $operation): bool => $operation === 'create'),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->revealable()
                            ->label(__("Confirm Password"))
                            ->required()
                            ->maxLength(255)
                            ->notRegex('/<[^b][^r][^>]*>/')
                            ->validationMessages([
                                'not_regex' => 'HTML is invalid',
                            ])
                            ->same('password')
                            ->dehydrated(false)
                            ->visible(fn (string $operation): bool => $operation === 'create'),



                        ]),




                    Section::make()
                    ->columnSpan(1)
                    ->schema([

                        Forms\Components\Select::make('status')
                            ->label(__("Status"))
                            ->required()
                            ->options(User::getStatusList())
                            ->default(User::STATUS_ACTIVE)
                            ->native(false)
                            ->selectablePlaceholder(false)
                            ->notRegex('/<[^b][^r][^>]*>/')
                            ->validationMessages([
                                'not_regex' => 'HTML is invalid',
                            ])
                            ->visible(fn ($record) => !$record || $record->id !== 1),

                    ]),

                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('username')
                    ->label(__("User Name"))
                    ->searchable(),



                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('registration_ip')
                    ->searchable()
                    ->alignCenter(),


                Tables\Columns\ToggleColumn::make('status')
                    ->label(__("Status"))
                    ->alignCenter()
                    ->visible( static::toggleColumnVisibility() ),


                \App\Classes\FilamentUtility::createdAtColumn(),
                \App\Classes\FilamentUtility::updatedAtColumn(),





            ])
            ->striped()
            ->filters([

                Tables\Filters\SelectFilter::make('status')
                    ->options(User::getStatusList()),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions(

                static::renderTableActions([

                    Action::make('Change Password')
                        ->action(function (User $record, array $data): void {
                            $record->password = $data['password'];
                            $record->save();
                        })
                        ->form([

                            Forms\Components\TextInput::make('password')
                                ->password()
                                ->label(__("Password"))
                                ->required()
                                ->maxLength(255)
                                ->notRegex('/<[^b][^r][^>]*>/')
                                ->validationMessages([
                                    'not_regex' => 'HTML is invalid',
                                ])
                                ->minLength(8)
                                ->rules(['regex:/^(?=(.*[a-z]){2,})(?=(.*[A-Z]){2,})(?=(.*\d){2,})(?=(.*[\W_]){2,}).{8,}$/'])
                                ->helperText('Password must be at least 8 characters long and contain 2 lowercase, 2 uppercase, 2 numbers, and 2 special characters.'),

                            Forms\Components\TextInput::make('password_confirmation')
                                ->password()
                                ->label(__("Confirm Password"))
                                ->required()
                                ->maxLength(255)
                                ->notRegex('/<[^b][^r][^>]*>/')
                                ->validationMessages([
                                    'not_regex' => 'HTML is invalid',
                                ])
                                ->same('password')
                                ->dehydrated(false),
                        ])
                        ->icon('fas-user-lock')
                        ->iconButton()
                        ->color("success"),
                ]),

            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([

                    Tables\Actions\BulkAction::make('publish')
                    ->action(fn (Collection $records) => static::BulkActivate($records))
                    ->deselectRecordsAfterCompletion()
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('fas-toggle-on')
                    ->visible( static::toggleColumnVisibility() ),

                    Tables\Actions\BulkAction::make('pending')
                        ->action(fn (Collection $records) => static::BulkDeactivate($records))
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->color('warning')
                        ->icon('fas-toggle-off')
                        ->visible( static::toggleColumnVisibility() ),
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
            'index' => ListItems::route('/'),
            'create' => Create::route('/create'),
            'edit' => Edit::route('/{record}/edit'),
        ];
    }
}
