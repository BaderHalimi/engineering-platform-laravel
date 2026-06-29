<?php

namespace App\Filament\User\Pages;

use BackedEnum;
use UnitEnum;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileSettings extends Page
{
    use InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon  = Heroicon::OutlinedUserCircle;
    protected static ?string                    $navigationLabel = 'Profile Settings';
    protected static string | UnitEnum | null   $navigationGroup = 'Account';
    protected static ?int                       $navigationSort  = 100;

    protected string $view = 'filament.user.pages.profile-settings';

    public ?array $data = [];

    public ?string $profileImageUrl = null;

    public function mount(): void
    {
        $user = Auth::user();

        $this->form->fill([
            'name'          => $user->name,
            'email'         => $user->email,
            'profile_image' => $user->profile_image,
        ]);

        $this->profileImageUrl = $user->profile_image
            ? Storage::url($user->profile_image)
            : null;
    }
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profile Information')
                    ->description("Update your account's profile information and email address.")
                    ->schema([
                        FileUpload::make('profile_image')
                            ->label('Profile Image')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('profile-images')
                            ->avatar()
                            ->columnSpanFull()
                            ->maxSize(2048),

                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(
                                table: 'users',
                                column: 'email',
                                ignorable: fn () => Auth::user(),
                            ),
                    ])
                    ->columns(2),

                Section::make('Update Password')
                    ->description("Leave the password fields blank if you don't want to change it.")
                    ->schema([
                        TextInput::make('current_password')
                            ->label('Current Password')
                            ->password()
                            ->revealable()
                            ->currentPassword()
                            ->dehydrated(false),

                        TextInput::make('new_password')
                            ->label('New Password')
                            ->password()
                            ->revealable()
                            ->rule(Password::default())
                            ->dehydrated(false)
                            ->confirmed(),

                        TextInput::make('new_password_confirmation')
                            ->label('Confirm New Password')
                            ->password()
                            ->revealable()
                            ->dehydrated(false),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $user  = Auth::user();

        $user->name  = $state['name'];
        $user->email = $state['email'];

        if (! empty($state['profile_image'])) {
            if ($user->profile_image && $user->profile_image !== $state['profile_image']) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $user->profile_image = $state['profile_image'];
        }

        if (! empty($state['new_password'])) {
            $user->password = Hash::make($state['new_password']);
        }

        $user->save();

        Notification::make()
            ->title('Profile updated successfully')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->submit('save')
                ->color('primary')
                ->icon(Heroicon::OutlinedCheck),

            Action::make('cancel')
                ->label('Cancel')
                ->color('gray')
                ->outlined()
                ->url(static::getUrl()),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::check();
    }
}
